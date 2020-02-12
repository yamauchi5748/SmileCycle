const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
module.exports = model("Room", Schema({
    image: {
        type: String,
        default: "thisisthetop"
    },
    name: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 20
    },
    members: {
        type: [{
            type: ObjectId,
            ref: "Member"
        }],
        required: true
    },
    latestContent: {
        type: String,
        default: ""
    },
    unreadCountTable: {
        type: Object,
        default: {}
    },
    managerId: {
        type: ObjectId,
        ref: "Member",
        required: true
    }
}));