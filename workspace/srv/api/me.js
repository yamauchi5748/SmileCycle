const { Member } = require("../model");
const { Timeline } = require("../model");
const { Router } = require("express");
const { authorization } = require("./util/authorization");
const { Types: { ObjectId } } = require("mongoose");
const debug = require("debug")("app:me");
const router = Router();

// ログインしているユーザの情報を返す
router.get("/", authorization, async function (req, res, next) {
    const memberId = req.session.member._id;
    const member = await Member.findOne({ _id: memberId }, { __v: 0 }).catch(next);
    res.json(member);
});
// ログインしているユーザの投稿したタイムラインを返す
router.get("/timelines", authorization, async function (req, res, next) {
    const memberId = req.session.member._id;
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
