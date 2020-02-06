const { Room, Content, Member } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
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
    res.json(result);
});
// roomのコンテンツが帰ってくる
router.get("/:id/contents", async function (req, res, next) {
    const id = req.params.id;
    const result = await Content.aggregate()
        .match({
            roomId: ObjectId(id)
        })
        .project({
            _id: 1,
            roomId: 1,
            alreadyReadCount: { $size: "$alreadyReadList" },
            senderId: 1,
            avator: 1,
            name: 1,
            message: 1,
            stamp: 1,
            image: 1,
            contentType: 1,
            created_at: 1,
        })
        .exec().catch(next);
    res.json(result);
});

router.post("/:id", async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    const memberId = req.session.memberId;
    const result = await Room.updateOne({ _id: id, managerId: memberId }, { $set: instance }).catch(next);
    res.json(result);
});
//メッセージの送信
router.post("/:id/message", async function (req, res, next) {
    const roomId = req.params.id;
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = {
        roomId,
        senderId: sender._id,
        avatar: sender.avatar,
        name: sender.name,
        message: req.body.message,
        contentType: 1
    };
    let result = await Content.create(instance).catch(next);
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
            latestContent: instance.message,
        },
        $inc: updateFields[0].incrementFields
    }).catch(next);
    res.json(result);

});
// スタンプの送信
router.post("/:id/stamp", async function (req, res, next) {
    const roomId = req.params.id;
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = {
        roomId,
        senderId: sender._id,
        avatar: sender.avatar,
        name: sender.name,
        stamp: req.body.stamp,
        contentType: 2
    };
    let result = await Content.create(instance).catch(next);
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
            latestContent: "スタンプが送信されました。",
            $inc: updateFields[0].incrementFields
        }
    }).catch(next);
    res.json(result);
});
// 画像の送信
router.post("/:id/image", async function (req, res, next) {
    const roomId = req.params.id;
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = {
        roomId,
        senderId: sender._id,
        avatar: sender.avatar,
        name: sender.name,
        image: req.body.image,
        contentType: 3
    };
    let result = await Content.create(instance).catch(next);
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
            latestContent: "画像が送信されました。"
        },
        $inc: updateFields[0].incrementFields
    }).catch(next);
    res.json(result);
});

// 既読
router.put("/:id/read", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    const result = await Content.updateMany({
        roomId: id,
        alreadyReadList: { $nin: [memberId] }
    }, {
        $addToSet: { alreadyReadList: memberId }
    }).catch(next);
    await Room.updateOne({
        _id: id,
    }, {
        $set: { [`unreadCountTable.${memberId}`]: 0 }
    }).catch(next);
    res.json(result);
});

router.put("/:id/exit", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    let result = await Room.deleteOne({ _id: id, managerId: memberId }).catch(next);
    if (result.deletedCount == 0) {
        result = await Room.updateOne({ _id: id }, {
            $pull: {
                members: req.session.memberId
            }
        }).catch(next);
    }
    res.json(result);
});
router.delete("/:id", async function (req, res, next) {
    const id = req.params.id;
    const memberId = req.session.memberId;
    const result = await Room.deleteOne({ _id: id, managerId: memberId }).catch(next);
    res.json(result);
});
module.exports = router;

