const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
const moment = require("moment-timezone");
module.exports = model("Invitation", Schema({
    title: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 32
    },
    text: {
        type: String,
        default: "",
        maxlength: 1000
    },
    images: {
        type: [String],
        default: Array
    },
    members: {
        type: [{
            type: ObjectId,
            ref: "Member"
        }],
        default: Array
    },
    deadline_at: {
        type: Date,
        required: true
    },
    created_at: {
        type: Date,
        default: Date.now
    },
    statusTable: {
        type: Object,
        default: Object
    }
}));