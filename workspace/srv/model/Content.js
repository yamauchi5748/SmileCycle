const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
module.exports = model("Content", Schema({
    roomId: {
        type: ObjectId,
        required: true,
        ref: "Room"
    },
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
    contentType: {
        type: Number,
        required: true,
        enum: [1, 2, 3]
    },
    message: {
        type: String,
        required: function () {
            return this.contentType == 1;
        },
        minlength: 1,
        maxlength: 500
    },
    stamp: {
        type: String,
        required: function () {
            return this.contentType == 2;
        }
    },
    image: {
        type: String,
        required: function () {
            return this.contentType == 3;
        }
    },
    alreadyReadList: {
        type: [{
            type: ObjectId,
            ref: "Member"
        }],
        default: []
    },
    created_at: {
        type: Date,
        default: Date.now
    }
}));