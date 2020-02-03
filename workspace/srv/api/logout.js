const { Router } = require("express");
const debug = require("debug")("app:auth");
const router = Router();

router.post("/", async function (req, res) {
    req.session.member = null;
    res.json({ result: true });
});
module.exports = router;
