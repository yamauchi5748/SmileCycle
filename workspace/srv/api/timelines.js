const { Timeline, Comment, Member, Image } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const { io } = require("../server");
const debug = require("debug")("app:api-timelines")
const router = Router();

router.get("/", async function (req, res, next) {
    const result = await Timeline.aggregate()
        .lookup({
            from: "members",
            localField: "senderId",
            foreignField: "_id",
            as: "member_temp"
        })
        .unwind({
            path: "$member_temp",
            preserveNullAndEmptyArrays: true
        })
        .addFields({
            avatar: "$member_temp.avatar",
            name: "$member_temp.name"
        })
        .project({
            member_temp: 0
        })
        .exec().catch(next);
    res.json(result);
});
router.post("/", async function (req, res, next) {
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = Object.assign({}, req.body, {
        senderId: sender._id
    });
    const result = await Timeline.create(instance).catch(next);
    await Image.updateMany({ _id: { $in: result.images } }, { $set: { isUsing: true } }).catch(next);
    noticeTimelineChanges("insert", result._id);
    res.json(result);
});
router.post("/:id", async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    const old = await Timeline.findById(ObjectId(id)).exec().catch(next);
    await Image.updateMany({ _id: { $in: old.images } }, { $set: { isUsing: false } }).catch(next);
    const result = await Timeline.updateOne({ _id: id }, { $set: instance }).catch(next);
    await Image.updateMany({ _id: { $in: instance.images } }, { $set: { isUsing: true } }).catch(next);
    noticeTimelineChanges("update", id);
    res.json(result);
});
router.get("/:id/comment", async function (req, res, next) {
    const timelineId = req.params.id;
    let result = await Comment.aggregate()
        .match({ timelineId: ObjectId(timelineId) })
        .lookup({
            from: "members",
            localField: "senderId",
            foreignField: "_id",
            as: "member_temp"
        })
        .unwind({
            path: "$member_temp",
            preserveNullAndEmptyArrays: true
        })
        .addFields({
            avatar: "$member_temp.avatar",
            name: "$member_temp.name"
        })
        .project({
            member_temp: 0
        })
        .exec().catch(next);
    res.json(result);
});
router.post("/:id/comment", async function (req, res, next) {
    const timelineId = req.params.id
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = Object.assign(
        {},
        req.body,
        {
            timelineId,
            senderId: sender.id
        }
    );
    let result = await Comment.create(instance).catch(next);
    noticeCommentChanges("insert", result._id);

    result = await Timeline.updateOne({ _id: timelineId }, {
        $inc: {
            commentsCount: 1
        }
    }).catch(next);
    noticeTimelineChanges("update", timelineId);
    res.json(result);
});
router.delete("/:id", async function (req, res, next) {
    const id = req.params.id;
    const target = await Timeline.findById(ObjectId(id)).exec().catch(next);
    const result = await Timeline.deleteOne({ _id: id }).catch(next);
    await Image.updateMany({ _id: { $in: target.images } }, { $set: { isUsing: false } }).catch(next);
    await Comment.deleteMany({ timelineId: id }).catch(next);
    noticeTimelineChanges("delete", id);
    res.json(result);
});

async function noticeTimelineChanges(operationType, documentId) {
    const obj = {
        operationType,
        documentId
    }
    if (operationType != "delete") {
        const document = await Timeline.aggregate()
            .match({ _id: ObjectId(documentId) })
            .lookup({
                from: "members",
                localField: "senderId",
                foreignField: "_id",
                as: "member_temp"
            })
            .unwind({
                path: "$member_temp",
                preserveNullAndEmptyArrays: true
            })
            .addFields({
                avatar: "$member_temp.avatar",
                name: "$member_temp.name"
            })
            .project({
                _id: 0,
                member_temp: 0
            })
            .exec();
            debug(document);
        obj.document = document[0];
    }
    debug(obj);
    io.emit("timelines", obj);
}

async function noticeCommentChanges(operationType, documentId) {
    const obj = {
        operationType,
        documentId
    }
    if (operationType != "delete") {
        const document = await Comment.aggregate()
            .match({ _id: ObjectId(documentId) })
            .lookup({
                from: "members",
                localField: "senderId",
                foreignField: "_id",
                as: "member_temp"
            })
            .unwind({
                path: "$member_temp",
                preserveNullAndEmptyArrays: true
            })
            .addFields({
                avatar: "$member_temp.avatar",
                name: "$member_temp.name"
            })
            .project({
                _id: 0,
                member_temp: 0
            })
            .exec();
        obj.document = document[0];
    }
    io.emit("comments", obj);
}

module.exports = router;
