const debug = require("debug")("app:mongoose");
const mongoose = require("mongoose");
const uri = "mongodb://mongo:27017/test";
const db = mongoose.connection;
db.on("error", debug);
db.once("connected", function () {
    debug("connected with database.");
});
db.on("disconnected", function () {
    debug("Lost connection with database.");
});
db.on("reconnected", function () {
    debug("Reconnected with database.");
});
mongoose.connect(uri, { useUnifiedTopology: true, useNewUrlParser: true })
module.exports = mongoose;
