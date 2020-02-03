const { Router } = require("express");
const debug = require("debug")("app:api-images");
const router = Router();
const multer = require("multer");
const upload = multer({ dest: "images/" });
const fs = require("fs");

router.get("/:name", async function (req, res, next) {
    const name = req.params.name;
    fs.readFile("images/" + name, function (err, data) {
        res.set("Content-Type", "image/*");
        res.send(data);
    });
});
router.post("/", upload.single("file"), async function (req, res, next) {
    res.json({ name: req.file.filename });
});
module.exports = router;
