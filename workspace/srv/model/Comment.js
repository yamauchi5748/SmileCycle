const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
const moment = require("moment-timezone");
moment.tz.setDefault('Asia/Tokyo');

module.exports = model("Comment", new Schema({
    timelineId: {
        type: ObjectId,
        ref: "Timeline",
        required: true
    },
    senderId: {
        type: ObjectId,
        ref: "Member",
        required: true
    },
    text: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 500
    },
    created_at: {
        type: Date,
        default: moment
    }
}));