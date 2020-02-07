const { Member } = require("../model");
const { Timeline } = require("../model");
const { Router } = require("express");
const { authorization } = require("./util/authorization");
const { io } = require("../server");
const { Types: { ObjectId } } = require("mongoose");
const debug = require("debug")("app:me");
const router = Router();
router.get("/test", async function (req, res, next) {
    res.json(member);
});
// ログインしているユーザの情報を返す
router.get("/", authorization, async function (req, res, next) {
    debug("計測");
    debug("開始");
    const memberId = req.session.memberId;
    const member = await Member.findOne({ _id: ObjectId(memberId) }, { __v: 0 }).catch(next);
    res.json(member);
});
router.post("/", authorization, async function (req, res, next) {
    const id = req.session.memberId;
    const instance = req.body;
    delete instance.isAdmin;
    if (instance.password) {
        instance.password = bcrypt.hashSync(instance.password, 11);
    }
    const result = await Member.updateOne({ _id: id }, { $set: instance }).catch(next);
    notifyChange("update", id);
    res.json(result);
});
async function notifyChange(operationType, id) {
    const obj = {
        operationType,
        documentId: id,
    }
    if (operationType == "insert" || operationType == "update") {
        const documents = await Member.aggregate()
            .match({
                _id: ObjectId(id)
            })
            .lookup({
                from: "companies",
                localField: "companyId",
                foreignField: "_id",
                as: "company"
            })
            .unwind({
                path: "$company",
                preserveNullAndEmptyArrays: true
            })
            .addFields({
                companyName: "$company.name"
            })
            .project({
                password: 0,
                company: 0
            })
            .exec();
        obj.document = documents[0];
    } else if (operationType == "delete") {
    }
    io.emit("members", obj);
}
// ログインしているユーザの投稿したタイムラインを返す
router.get("/timelines", authorization, async function (req, res, next) {
    const memberId = req.session.memberId;
    const result = await Timeline.aggregate()
        .match({
            senderId: ObjectId(memberId)
        })
        .lookup({
            from: "members",
            localField: "senderId",
            foreignField: "_id",
            as: "sender_temp"
        })
        .unwind("sender_temp")
        .unwind({
            path: "$comments",
            preserveNullAndEmptyArrays: true
        })
        .lookup({
            from: "members",
            localField: "comments.senderId",
            foreignField: "_id",
            as: "comment_sender_temp"
        })
        .unwind({
            path: "$comment_sender_temp",
            preserveNullAndEmptyArrays: true
        })
        .project({
            _id: 1,
            senderId: 1,
            title: 1,
            text: 1,
            images: 1,
            name: "$sender_temp.name",
            "comments._id": 1,
            "comments.senderId": 1,
            "comments.text": 1,
            "comments.created_at": 1,
            "comments.avatar": "$comment_sender_temp.avatar",
            "comments.name": "$comment_sender_temp.name"
        })
        .group({
            _id: "$_id",
            senderId: { $first: "$senderId" },
            name: { $first: "$name" },
            title: { $first: "$title" },
            text: { $first: "$text" },
            images: { $first: "$images" },
            comments: { $push: "$comments" }
        })
        .exec().catch(next);
    res.json(result);
});
module.exports = router;
