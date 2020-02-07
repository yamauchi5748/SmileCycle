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

// 各ドキュメントが更新された際に関係するドキュメントを更新する
const updateLog = require("debug")("app:document-update");
const { Member, Company, Timeline, Comment, Content, Room } = require("./model");

// Member.watch().on("change", async change => {
//     updateLog(change);
//     const {
//         operationType,
//         fullDocument,
//         documentKey: { _id: documentId }
//     } = change;
//     if (operationType == "insert") {
//         const company = await Company.findOne({ _id: fullDocument.companyId });
//         updateLog(await Member.updateOne({ _id: documentId }, { $set: { companyName: company.name } }));
//     }

//     if (operationType == "update") {
//         const {
//             updateDescription: {
//                 updatedFields
//             } } = change;
//         if (updatedFields.avatar || updatedFields.name) {
//             const instance = {};
//             if (updatedFields.avatar) instance.avatar = updatedFields.avatar;
//             if (updatedFields.name) instance.name = updatedFields.name;
//             updateLog(await Timeline.updateMany({ senderId: documentId }, { $set: instance }).exec());
//             updateLog(await Comment.updateMany({ senderId: documentId }, { $set: instance }).exec());
//             updateLog(await Content.updateMany({ senderId: documentId }, { $set: instance }).exec());
//         }
//         if (updatedFields.companyId) {
//             const company = await Company.findOne({ _id: updatedFields.companyId });
//             updateLog(await Member.updateOne({ _id: documentId }, { $set: { companyName: company.name } }));
//         }
//     }
//     if (operationType == "delete") {
//         const instance = { avatar: "avatar", name: "削除された会員", };
//         updateLog(await Timeline.updateMany({ senderId: documentId }, { $set: instance }).exec());
//         updateLog(await Comment.updateMany({ senderId: documentId }, { $set: instance }).exec());
//         updateLog(await Content.updateMany({ senderId: documentId }, { $set: instance }).exec());
//     }
// });
// Company.watch().on("change", async change => {
//     const {
//         operationType,
//         fullDocument,
//         documentKey: { _id: documentId }
//     } = change;
//     if (operationType == "update") {
//         const
//             {
//                 updateDescription: {
//                     updatedFields
//                 }
//             } = change;
//         if (updatedFields.name) {
//             updateLog(await Member.updateMany({ companyId: documentId }, { $set: { companyName: updatedFields.name } }).exec());
//         }
//     }
//     if (operationType == "delete") {
//         updateLog(await Member.updateMany({ companyId: documentId }, { $set: { companyName: "削除された会社" } }).exec());
//     }
// });

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

// websocket
// require("./ws");