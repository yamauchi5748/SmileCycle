const { Member } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const bcrypt = require('bcrypt');
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const ws = require("../ws");
const debug = require("debug")("app:api-members")
const router = Router();

router.get("/", async function (req, res, next) {
    const result = await Member.aggregate()
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
            company: 0,
        })
        .exec().catch(next);
    res.json(result);
});
// router.post("/", adminAuthorization, async function (req, res, next) {
router.post("/", async function (req, res, next) {
    const instance = req.body;
    delete instance.isAdmin;
    instance.password = bcrypt.hashSync(instance.password, 11);
    const result = await Member.create(instance).catch(next);
    notifyChange("insert", result._id);
    res.json(result);
});
router.post("/:id", adminOrMineAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    delete instance.isAdmin;
    if (instance.password) {
        instance.password = bcrypt.hashSync(instance.password, 11);
    }
    const result = await Member.updateOne({ _id: id }, { $set: instance }).catch(next);
    notifyChange("update", id);
    res.json(result);
});
router.delete("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const result = await Member.deleteOne({ _id: id }).catch(next);
    notifyChange("delete", id);
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
    ws.emit("members", obj);
}

module.exports = router;
