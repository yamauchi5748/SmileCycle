const { Company } = require("../model");
const { Router } = require("express");
const { adminAuthorization } = require("./util/authorization");
const debug = require("debug")("app:api-companies")
const router = Router();

router.get("/", async function (req, res, next) {
    const result = await Company.find({}, { __v: 0 }).exec().catch(next)
    res.json(result);
});
router.post("/", adminAuthorization, async function (req, res, next) {
    const instance = req.body;
    const result = await Company.create(instance).catch(next);
    res.json(result);
});
router.post("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const instance = req.body;
    const result = await Company.updateOne({ _id: id }, { $set: instance }).catch(next);
    res.json(result);
});
router.delete("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const result = await Company.deleteOne({ _id: id }).catch(next);
    res.json(result);
});

module.exports = router;
