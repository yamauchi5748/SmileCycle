const io = require("socket.io")(5000, {
    origins: "*:*",
    cookie: false
});

io.on("connect", socket => {

});
module.exports = io;