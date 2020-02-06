const { Member } = require("../model");
const { Router } = require("express");
const { Types: { ObjectId } } = require("mongoose");
const bcrypt = require('bcrypt');
const debug = require("debug")("app:auth");
const router = Router();

router.post("/", async function (req, res, next) {
    const { name, password } = req.body;
    const member = await Member.findOne({ name }).catch(next);
    if (bcrypt.compareSync(password, member.password)) {
        debug(member)
        req.session.memberId = member._id;
        req.session.isAdmin = member.isAdmin;
        res.json({ result: true });
    } else {
        let e = new Error("Password is incorrect.");
        e.name = "AuthenticationError";
        next(e);
    }
});
module.exports = router;
