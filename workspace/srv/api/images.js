const { Image } = require("../model");
const { Router } = require("express");
const debug = require("debug")("app:api-images");
const router = Router();

const multer = require("multer");
const upload = multer({
    storage: multer.diskStorage({
        destination: function (req, file, cb) {
            cb(null, "images/")
        },
        filename: async function (req, file, cb) {
            const image = await Image.create({});
            debug(image);
            cb(null, image._id.toString());
        }
    })
});
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
