const debug = require("debug")("app:server");
const express = require("express");
const app = express();
const server = require("http").createServer(app);
const PORT = 3000 || process.env.PORT;

/* =====================================
 * middlewareの設定
 * ===================================== */

/*=== Logger ===*/
const LOG_DIRECTORY = "../logs"
// フォルダがなければ作成
const fs = require("fs");
fs.existsSync(LOG_DIRECTORY) || fs.mkdirSync(LOG_DIRECTORY);
app.use(require("morgan")("combined", {
    // 日ごとにlogを出力するstreamを変える
    stream: require("file-stream-rotator").getStream({
        filename: require("path").join(__dirname, `${LOG_DIRECTORY}/access-%DATE%.log`),
        frequency: "daily",
        verbose: false,
        date_format: "YYYY-MM-DD"
    })
}));
/*==== session ====*/
const session = require("express-session");
const redis = require("redis");
const RedisStore = require("connect-redis")(session);

app.use(session({
    secret: "secret",  // Secret Keyで暗号化し、改ざんを防ぐ
    resave: false,
    saveUninitialized: true,
    store: new RedisStore({
        host: "redis",
        port: 6379,
        client: redis.createClient({
            host: "redis",
            port: 6379,
        })
    }),
}));


/*==== body-parser ====*/
app.use(express.json());
app.use(function (req, res, next) {
    debug("================body===================");
    debug(req.body);
    debug("=======================================");
    debug("================session================");
    debug(req.session);
    debug("=======================================");
    if (req.session.views) {
        req.session.views++
    } else {
        req.session.views = 1
    }
    next();
})
/*=== 公開ディレクトリ ===*/
// app.use(express.static("./dist"));

const api = require("./api");
app.use("/api", api);

// app.get("/*", express.static("./dist"));

server.listen(PORT, function () {
    debug(`listening. Port: \u001b[32m${PORT}\u001b[0m`);
});

// 各ドキュメントが更新された際に関係するドキュメントを更新する
const updateLog = require("debug")("app:document-update");
const { Member, Company, Timeline, Comment, Content, Room } = require("./model");

Member.watch().on("change", async change => {
    updateLog(change);
    const {
        operationType,
        fullDocument,
        documentKey: { _id: documentId }
    } = change;
    if (operationType == "insert") {
        const company = await Company.findOne({ _id: fullDocument.companyId });
        updateLog(await Member.updateOne({ _id: documentId }, { $set: { companyName: company.name } }));
    }

    if (operationType == "update") {
        const {
            updateDescription: {
                updatedFields
            } } = change;
        if (updatedFields.avatar || updatedFields.name) {
            const instance = {};
            if (updatedFields.avatar) instance.avatar = updatedFields.avatar;
            if (updatedFields.name) instance.name = updatedFields.name;
            updateLog(await Timeline.updateMany({ senderId: documentId }, { $set: instance }).exec());
            updateLog(await Comment.updateMany({ senderId: documentId }, { $set: instance }).exec());
            updateLog(await Content.updateMany({ senderId: documentId }, { $set: instance }).exec());
        }
        if (updatedFields.companyId) {
            const company = await Company.findOne({ _id: updatedFields.companyId });
            updateLog(await Member.updateOne({ _id: documentId }, { $set: { companyName: company.name } }));
        }
    }
    if (operationType == "delete") {
        const instance = { avatar: "avatar", name: "削除された会員", };
        updateLog(await Timeline.updateMany({ senderId: documentId }, { $set: instance }).exec());
        updateLog(await Comment.updateMany({ senderId: documentId }, { $set: instance }).exec());
        updateLog(await Content.updateMany({ senderId: documentId }, { $set: instance }).exec());
    }

});
Company.watch().on("change", async change => {
    const {
        operationType,
        fullDocument,
        documentKey: { _id: documentId }
    } = change;
    if (operationType == "update") {
        const
            {
                updateDescription: {
                    updatedFields
                }
            } = change;
        if (updatedFields.name) {
            updateLog(await Member.updateMany({ companyId: documentId }, { $set: { companyName: updatedFields.name } }).exec());
        }
    }
    if (operationType == "delete") {
        updateLog(await Member.updateMany({ companyId: documentId }, { $set: { companyName: "削除された会社" } }).exec());
    }
});

// パセリスープ
const mail = require("./mail");
setInterval(() => {
    const members = Room.aggregate()
        .project({
            unreadCountList: {
                $objectToArray: "$unreadCountTable"
            }
        })
        .unwind({
            path: "$unreadCountList",
            preserveNullAndEmptyArrays: true
        })
        .match({
            "unreadCountList.v": { $ne: 0 }
        })
        .group({
            _id: "$unreadCountList.k",
            unreadCount: { $sum: "$unreadCountList.v" }
        })
        .lookup({
            from: "members",
            localField: "_id",
            foreignField: "_id",
            as: "member_temp"
        })
        .unwind({
            path: "$member_temp",
            preserveNullAndEmptyArrays: true
        })
        .project({
            _id: 1,
            unreadCount: 1,
            "member_temp.name": 1,
            "member_temp.mail": 1,
            "member_temp.ruby": 1
        })
        .exec();
    // mail.send(members, { type: "unreadchat", url: "https://aho.com/chat" });
}, 1000 * 60 * 30);

// websocket
require("./ws");