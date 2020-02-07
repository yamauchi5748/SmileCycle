const { app, http } = require("./server");
const express = require("express");
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
http.listen(PORT, function () {
    console.log(`listening. Port: \u001b[32m${PORT}\u001b[0m`);
});