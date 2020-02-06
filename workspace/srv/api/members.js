const { Member } = require("../model");
const { Router } = require("express");
const bcrypt = require('bcrypt');
const { adminAuthorization, adminOrMineAuthorization } = require("./util/authorization");
const debug = require("debug")("app:api-members")
const router = Router();

router.get("/", async function (req, res, next) {
    const result = await Member.find({},"-password").exec().catch(next);
    res.json(result);
});
router.post("/", adminAuthorization, async function (req, res, next) {
// router.post("/", async function (req, res, next) {
    const instance = req.body;
    delete instance.isAdmin;
    instance.password = bcrypt.hashSync(instance.password, 11);
    const result = await Member.create(instance).catch(next);
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
    res.json(result);
});
router.delete("/:id", adminAuthorization, async function (req, res, next) {
    const id = req.params.id;
    const result = await Member.deleteOne({ _id: id }).catch(next);
    res.json(result);
});

module.exports = router;
