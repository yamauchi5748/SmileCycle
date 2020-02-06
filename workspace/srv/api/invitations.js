const { Invitation, Member } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const ws = require("../ws");
const mail = require("../mail");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const debug = require("debug")("app:api-invitations");
const router = Router();

router.get("/", async function (req, res, next) {
    const memberId = req.session.memberId;
    const result = await Invitation.aggregate()
        .match({
            "members": { $in: [ObjectId(memberId)] }
        })
        .lookup({
            from: "members",
            localField: "members",
            foreignField: "_id",
            as: "members_temp"
        })
        .project({
            _id: 1,
            title: 1,
            text: 1,
            images: 1,
            members: 1,
            deadline_at: 1,
            created_at: 1,
            statusTable: 1,
            membersTable: {
                $arrayToObject: {
                    $map: {
                        input: "$members_temp",
                        in: {
                            k: { $toString: "$$this._id" }, v: {
                                avatar: "$$this.avatar",
                                name: "$$this.name",
                                ruby: "$$this.ruby",
                            }
                        }
                    }
                }
            }
        })
        .exec().catch(next);
    res.json(result);
});
router.get("/admin", adminAuthorization, async function (req, res, next) {
    const result = await Invitation.aggregate()
        .lookup({
            from: "members",
            localField: "members",
            foreignField: "_id",
            as: "members_temp"
        })
        .project({
            _id: 1,
            title: 1,
            text: 1,
            images: 1,
            members: 1,
            deadline_at: 1,
            created_at: 1,
            statusTable: 1,
            membersTable: {
                $arrayToObject: {
                    $map: {
                        input: "$members_temp",
                        in: {
                            k: { $toString: "$$this._id" }, v: {
                                avatar: "$$this.avatar",
                                name: "$$this.name",
                                ruby: "$$this.ruby",
                            }
                        }
                    }
                }
            }
        })
        .exec().catch(next);
    res.json(result);
});
router.post("/", adminAuthorization, async function (req, res, next) {
    const instance = req.body;
    const result = await Invitation.create(instance).catch(next);
    notifyChange("insert", result._id);
    const members = await Member.find({ _id: { $in: result.members } }).catch(next);
    mail.send(members, { type: 'invitation', url: 'https://ponzu.com/invitation' });
    res.json(result);
});
router.post("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    delete instance.created_at;
    const result = await Invitation.updateOne({ _id: id }, { $set: instance }).catch(next);
    notifyChange("update", id);
    res.json(result);
});
// 会の参加への可否を更新する
router.put("/:id/status", adminOrMineAuthorization, async function (req, res, next) {
    const memberId = req.session.memberId;
    const id = req.params.id;
    const status = req.body.status;
    const result = await Invitation.updateOne({ _id: id }, { $set: { ["statusTable." + memberId]: status } }).catch(next);
    notifyChange("update", id);
    res.json(result);
});
router.delete("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const result = await Invitation.deleteOne({ _id: id }).catch(next);
    notifyChange("delete", id);
    res.json(result);
});

async function notifyChange(operationType, id) {
    const obj = {
        operationType,
        documentId: id,
    }
    if (operationType == "insert" || operationType == "update") {
        const documents = await Invitation.aggregate()
            .match({
                "_id": ObjectId(id)
            })
            .lookup({
                from: "members",
                localField: "members",
                foreignField: "_id",
                as: "members_temp"
            })
            .project({
                _id: 1,
                title: 1,
                text: 1,
                images: 1,
                members: 1,
                deadline_at: 1,
                created_at: 1,
                statusTable: 1,
                membersTable: {
                    $arrayToObject: {
                        $map: {
                            input: "$members_temp",
                            in: {
                                k: { $toString: "$$this._id" }, v: {
                                    avatar: "$$this.avatar",
                                    name: "$$this.name",
                                    ruby: "$$this.ruby",
                                }
                            }
                        }
                    }
                }
            })
            .exec();
        obj.document = documents[0];
    } else if (operationType == "delete") {
    }
    ws.emit("invitations", obj);
}

module.exports = router;
