const express = require("express");
const router = express.Router();

// body-parser
router.use(express.json());
/*==== session ====*/
const session = require("express-session");
// const redis = require("redis");
// const RedisStore = require("connect-redis")(session);
router.use(session({
    secret: "secret",  // Secret Keyで暗号化し、改ざんを防ぐ
    resave: false,
    saveUninitialized: false,
}));

router.use("/login", require("./login"));
router.use("/logout", require("./logout"));
const authRouter = express.Router();
authRouter.use(require("./util/authorization").authorization);
authRouter.use("/me", require("./me"));
authRouter.use("/members", require("./members"));
authRouter.use("/companies", require("./companies"));
authRouter.use("/invitations", require("./invitations"));
authRouter.use("/timelines", require("./timelines"));
authRouter.use("/rooms", require("./rooms"));
authRouter.use("/stamps", require("./stamps"));
authRouter.use("/images", require("./images"));

router.use(authRouter);

const debug = require("debug")("app:api-errors");
router.use(function (err, req, res, next) {
    debug(req);
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
