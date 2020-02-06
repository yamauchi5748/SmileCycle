const { Timeline, Comment, Member } = require("../model");
const { Router } = require("express");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const debug = require("debug")("app:api-timelines")
const router = Router();

router.get("/", async function (req, res, next) {
    const result = await Timeline.find()
        .exec().catch(next);
    res.json(result);
});
router.post("/", async function (req, res, next) {
    const sender = await Member.findOne({ _id: req.session.memberId });
    const instance = Object.assign({}, req.body, {
        senderId: sender._id,
        avatar: sender.avatar,
        name: sender.name
    });
    const result = await Timeline.create(instance).catch(next);
    res.json(result);
});
router.post("/:id", async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    const result = await Timeline.updateOne({ _id: id }, { $set: instance }).catch(next);
    res.json(result);
});
router.get("/:id/comment", async function (req, res, next) {
    const timelineId = req.params.id;
    let result = await Comment.find({ timelineId }).catch(next);
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
            senderId: sender.id,
            name: sender.name,
            avatar: sender.avatar
        }
    );
    let result = await Comment.create(instance).catch(next);

    result = await Timeline.updateOne({ _id: timelineId }, {
        $inc: {
            commentsCount: 1
        }
    }).catch(next);
    res.json(result);
});
router.delete("/:id", async function (req, res, next) {
    const id = req.params.id;
    const result = await Timeline.deleteOne({ _id: id }).catch(next);
    res.json(result);
});

module.exports = router;
