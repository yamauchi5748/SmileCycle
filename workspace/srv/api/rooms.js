const { Room, Content, Member, Image } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const { io } = require("../server");
const mail = require("../mail");
const debug = require("debug")("app:api-rooms")
const router = Router();

router.get("/", async function (req, res, next) {
    const memberId = req.session.memberId;
    const result = await Room.aggregate()
        .match({
            "members": { $in: [ObjectId(memberId)] }
        })
        .exec().catch(next);
    res.json(result);
});
router.post("/", async function (req, res, next) {
    const instance = req.body;
    instance.managerId = req.session.memberId;
    const result = await Room.create(instance).catch(next);
    noticeRoomChanges("insert", result._id);
    await Image.updateOne({ _id: ObjectId(req.body.image) }, { $set: { isUsing: true } }).catch(next);
    res.json(result);
});
// roomのコンテンツが帰ってくる
router.get("/:id/contents", async function (req, res, next) {
    const id = req.params.id;
    const result = await Content.aggregate()
        .match({
            roomId: ObjectId(id)
        })
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
        .project({
            _id: 1,
            roomId: 1,
            alreadyReadCount: { $size: "$alreadyReadList" },
            senderId: 1,
            avator: "$member_temp.avatar",
            name: "$member_temp.name",
            message: 1,
            stamp: 1,
            image: 1,
            isHurry: 1,
            contentType: 1,
            created_at: 1,
        })
        .exec().catch(next);
    res.json(result);
});

router.post("/:id", async function (req, res, next) {
    const id = req.params.id;
    const room = await Room.findById(ObjectId(id)).exec().catch(next);
    await Image.updateOne({ _id: room.image }, { $set: { isUsing: false } }).catch(next);
    const instance = req.body;
    const memberId = req.session.memberId;
    const result = await Room.updateOne({ _id: ObjectId(id), managerId: memberId }, { $set: instance }).catch(next);
    await Image.updateOne({ _id: ObjectId(instance.image) }, { $set: { isUsing: true } }).catch(next);
    noticeRoomChanges("update", id);
    res.json(result);
});
//メッセージの送信
router.post("/:id/message", async function (req, res, next) {
    postContent(req, res, next, 1);
});
// スタンプの送信
router.post("/:id/stamp", async function (req, res, next) {
    postContent(req, res, next, 2);
});
// 画像の送信
router.post("/:id/image", async function (req, res, next) {
    postContent(req, res, next, 3);
});
async function postContent(req, res, next, contentType) {
    const roomId = req.params.id;
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = {
        roomId,
        senderId: sender._id,
        contentType: contentType,
        isHurry: req.body.isHurry
    };
    if (contentType == 1) {
        instance.message = req.body.message;
    } else if (contentType == 2) {
        instance.stamp = req.body.stamp;
    } else if (contentType == 3) {
        instance.image = req.body.image;
        await Image.updateOne({ _id: ObjectId(req.body.image) }, { $set: { isUsing: true } }).catch(next);
    } else {
        next();
        return;
    }
    let result = await Content.create(instance).catch(next);
    noticeContentChanges("insert", result._id);
    const updateFields = await Room.aggregate()
        .match({ _id: ObjectId(roomId) })
        .project({
            incrementFields: {
                $arrayToObject: {
                    $map: {
                        input: "$members",
                        as: "member",
                        in: {
                            k: {
                                $concat: [
                                    "unreadCountTable.",
                                    { $toString: "$$member" }
                                ]
                            },
                            v: 1
                        }
                    }
                }
            }
        })
        .exec().catch(next);
    result = await Room.updateOne({ _id: roomId }, {
        $set: {
            latestContent: contentType == 1 ? instance.message : contentType == 2 ? "スタンプが送信されました。" : "画像が送信されました。"
        },
        $inc: updateFields[0].incrementFields
    }).catch(next);
    if (req.body.isHurry) {
        let members = await Room.aggregate()
            .match({ _id: ObjectId(roomId) })
            .project({
                members: {
                    $filter: {
                        input: "$members",
                        as: "member",
                        cond: { $ne: ["$$member", sender._id] }
                    }
                }
            })
            .lookup({
                from: "members",
                localField: "members",
                foreignField: "_id",
                as: "members_temp"
            })
            .project({
                members: "$members_temp"
            })
            .exec().catch(next);
        mail.send(members[0].members, { type: 'hurrychat', url: 'https://ponzu.com/chat' });
    }
    noticeRoomChanges("update", roomId);
    res.json(result);
}

// 既読
router.put("/:id/read", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    const changeList = await Content.find({ roomId: id, alreadyReadList: { $nin: [memberId] } }).catch(next);
    let result = await Content.updateMany({
        roomId: id,
        alreadyReadList: { $nin: [memberId] }
    }, {
        $addToSet: { alreadyReadList: memberId }
    }).catch(next);
    for (let c of changeList) {
        noticeContentChanges("update", c._id);
    }
    result = await Room.updateOne({
        _id: id,
    }, {
        $set: { [`unreadCountTable.${memberId}`]: 0 }
    }).catch(next);
    noticeRoomChanges("update", id);
    res.json(result);
});

router.put("/:id/exit", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    let result = await Room.deleteOne({ _id: ObjectId(id), managerId: memberId }).catch(next);
    if (result.deletedCount == 0) {
        result = await Room.updateOne({ _id: ObjectId(id) }, {
            $pull: {
                members: req.session.memberId
            }
        }).catch(next);
        noticeRoomChanges("update", id);
    } else {
        const images = await Content.aggregate()
            .match({ roomId: ObjectId(id), contentType: 3 })
            .group({
                _id: null,
                images: { $push: "$image" }
            })
            .exec().catch(next);
        if (images.length > 0) {
            await Image.updateMany({ _id: { $in: images[0].images } }, { $set: { isUsing: false } }).catch(next);
        }
        await Content.deleteMany({ roomId: ObjectId(id) }).catch(next);
        noticeRoomChanges("delete", id);
    }
    res.json(result);
});
router.delete("/:id", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    const result = await Room.deleteOne({ _id: ObjectId(id), managerId: memberId }).catch(next);
    const images = await Content.aggregate()
        .match({ roomId: ObjectId(id), contentType: 3 })
        .group({
            _id: null,
            images: { $push: "$image" }
        })
        .exec().catch(next);
    if (images.length > 0) {
        await Image.updateMany({ _id: { $in: images[0].images } }, { $set: { isUsing: false } }).catch(next);
    }
    await Content.deleteMany({ roomId: ObjectId(id) }).catch(next);
    noticeRoomChanges("delete", id);
    res.json(result);
});

async function noticeRoomChanges(operationType, documentId) {
    const obj = {
        operationType,
        documentId
    }
    if (operationType != "delete") {
        const document = await Room.findOne({ _id: ObjectId(documentId) }, "-_id").exec();
        obj.document = document;
    }
    io.emit("rooms", obj);
}
async function noticeContentChanges(operationType, documentId) {
    const obj = {
        operationType,
        documentId
    }
    if (operationType != "delete") {
        const document = await Content.aggregate()
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
    io.emit("contents", obj);
}

module.exports = router;

