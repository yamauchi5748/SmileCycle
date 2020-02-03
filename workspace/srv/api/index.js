const { Router } = require("express");
const router = Router();
router.use("/login", require("./login"));
router.use("/logout", require("./logout"));
const authRouter = Router();
// authRouter.use(require("./util/authorization").authorization);
authRouter.use("/me", require("./me"));
authRouter.use("/members", require("./members"));
authRouter.use("/companies", require("./companies"));
authRouter.use("/invitations", require("./invitations"));
authRouter.use("/timelines", require("./timelines"));
authRouter.use("/rooms", require("./rooms"));
authRouter.use("/stamps", require("./stamps"));
authRouter.use("/images", require("./images"));

router.use(authRouter);

const debug = require("debug")("app:api-errors")
router.use(function (err, req, res, next) {
    let result = {
        name: err.name,
        errors: {}
    };
    debug(err)
    if (err.name == "ValidationError") {
        Object.keys(err.errors).forEach(key => {
            result.errors[key] = err.errors[key].kind;
        });
    } else if (err.name == "MongoError") {
        Object.keys(err.keyValue).forEach(key => {
            result.errors[key] = "mongo";
        });
    }
    res.status(500).json(result);
});
module.exports = router;
