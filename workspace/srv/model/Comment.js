const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
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
    avatar: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    text: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 500
    },
    created_at: {
        type: Date,
        default: Date.now
    }
}))