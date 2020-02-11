const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
const moment = require("moment-timezone");
moment.tz.setDefault('Asia/Tokyo');

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
    isHurry: {
        type: Boolean,
        default: false
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
        type: ObjectId,
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
        default: moment
    }
}));