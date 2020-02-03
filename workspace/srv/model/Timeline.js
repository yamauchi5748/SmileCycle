const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
const moment = require("moment-timezone");
module.exports = model("Timeline", Schema({
    senderId: {
        type: ObjectId,
        required: true,
        ref: "Member"
    },
    avatar: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 20
    },
    text: {
        type: String,
        maxlength: 1000
    },
    images: {
        type: [String],
        default: []
    },
    commentsCount: {
        type: Number,
        default: 0,
    },
    created_at: {
        type: Date,
        default: Date.now
    }
}));
