const debug = require("debug")("app:server");
const express = require("express");
const app = express();
const server = require("http").createServer(app);

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

const PORT = 3000 || process.env.PORT;
server.listen(PORT, function () {
    console.log(`listening. Port: \u001b[32m${PORT}\u001b[0m`);
});

// パセリスープ
const mail = require("./mail");
const schedule = require("node-schedule");
let dayAndHalfDay = schedule.scheduleJob("0 21 * * *", async function () {
    sendUnread([ 12, 24 ])
});
let halfDay = schedule.scheduleJob("0 9 * * *", async function () {
    sendUnread([ 12 ])
});
let thirtyCount = 0;
let every = schedule.scheduleJob("*/30 * * * *", async function () {
    thirtyCount += 0.5;
    let intervals = [ 0.5 ];
    if (thirtyCount % 1 == 0) {
        intervals.push(1);
    }
    if (thirtyCount % 2 == 0) {
        intervals.push(2);
    }
    if (thirtyCount % 3 == 0) {
        intervals.push(3);
    }
    if (thirtyCount % 4 == 0) {
        intervals.push(4);
    }
    if (thirtyCount % 5 == 0) {
        intervals.push(5);
    }

    sendUnread(intervals);

    if (thirtyCount >= 60) {
        thirtyCount = 0;
    }
});
async function sendUnread (intervals) {
    let members = await Room.aggregate()
        .project({
            unreadCountList: {
                $objectToArray: "$unreadCountTable"
            }
        })
        .project({
            _id: 0,
            unreadCountList: {
                $filter: {
                    input: "$unreadCountList",
                    as: "unread",
                    cond: { $gt: [ "$$unread.v", 0 ] }
                }
            }
        })
        .unwind({
            path: "$unreadCountList",
            preserveNullAndEmptyArrays: true
        })
        .group({
            _id: "$unreadCountList.k"
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
        .match({
            isNotification: true,
            notificationInterval: {
                $in: intervals
            }
        })
        .project({
            _id: 1,
            mail: "$member_temp.mail"
        })
        .exec();
    mail.send(members, { type: "unreadchat", url: "https://aho.com/chat" });
}