const { Stamp } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const { io } = require("../server");
const debug = require("debug")("app:api-members")
const router = Router();

router.get("/", async function (req, res, next) {
    const memberId = req.session.memberId;
    const result = await Stamp.aggregate()
        .match({
            $or: [
                { "isAll": { $eq: true } },
                { "members": { $in: [ObjectId(memberId)] } }
            ]
        })
        .project({
            __v: 0
        })
        .exec().catch(next);
    res.json(result);
});
router.get("/admin", adminAuthorization, async function (req, res, next) {
    const result = await Stamp.find({}, { __v: 0 }).exec().catch(next);
    res.json(result);
});
router.post("/", adminAuthorization, async function (req, res, next) {
    const instance = req.body;
    const result = await Stamp.create(instance).catch(next);
    notifyChange("insert", result._id);
    res.json(result);
});
router.post("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    const result = await Stamp.updateOne({ _id: id }, { $set: instance }).catch(next);
    notifyChange("update", id);
    res.json(result);
});
router.delete("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const result = await Stamp.deleteOne({ _id: id }).catch(next);
    notifyChange("delete", id)
    res.json(result);
});

async function notifyChange(operationType, id) {
    const obj = {
        operationType,
        documentId: id,
    }
    if (operationType == "insert" || operationType == "update") {
        const documents = await Stamp.aggregate()
            .match({
                _id: ObjectId(id)
            })
            .exec();
        obj.document = documents[0];
    } else if (operationType == "delete") {
    }
    io.emit("stamps", obj);
}

module.exports = router;
