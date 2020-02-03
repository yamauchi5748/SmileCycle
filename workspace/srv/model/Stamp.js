const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
module.exports = model("Stamp", Schema({
    tabImage: {
        type: String,
        required: true
    },
    stamps: {
        type: [String],
        default: []
    },
    isAll: {
        type: Boolean,
        required: true
    },
    members: {
        type: [{
            type: ObjectId,
            ref: "Member"
        }],
        default: []
    }
}));