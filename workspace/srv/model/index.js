const debug = require("debug")("app:model");
const
    Member = require("./Member"),
    Company = require("./Company"),
    Invitation = require("./Invitation"),
    Timeline = require("./Timeline"),
    Comment = require("./Comment"),
    Room = require("./Room"),
    Content = require("./Content"),
    Stamp = require("./Stamp");
module.exports = {
    Member,
    Company,
    Invitation,
    Timeline,
    Comment,
    Room,
    Content,
    Stamp
}
const bcrypt = require('bcrypt');
Member.find({}).exec().then(collection => {
    if (collection.length <= 0) {
        Member.create({
            "name": "管理者",
            "ruby": "かんりしゃ",
            "tel": "090-0000-0000",
            "mail": "example@aa.aa",
            "companyId": "5e2fa0d5154b974f7475e6bb",
            "post": "管理者",
            "password": bcrypt.hashSync("lkwjaoieu", 11),
            "department": "愛媛笑門会",
            "isAdmin": true
        });
    }
});

