const debug = require("debug")("app:server");
const express = require("express");
const app = express();
const server = require("http").createServer(app);
const PORT = 3000 || process.env.PORT;

/* =====================================
 * middlewareの設定
 * ===================================== */
app.use(function (req, res, next) {
    req.connection.setNoDelay(true);
    next();
});
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

const api = require("./api");
app.use("/api", api);

/*=== 公開ディレクトリ ===*/
const staticFileMiddleware = express.static("dist");
const history = require('connect-history-api-fallback');
app.use(staticFileMiddleware);
app.use(history({
    disableDotRule: true,
    verbose: true
}));
app.use(staticFileMiddleware);

server.listen(PORT, function () {
    console.log(`listening. Port: \u001b[32m${PORT}\u001b[0m`);
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
