const { Schema, model } = require("../mongoose");
const { Types: { ObjectId } } = require("mongoose");
module.exports = model("Member", Schema({
    avatar: {
        type: ObjectId,
        default: ObjectId("69616d746865617661746172")
    },
    name: {
        type: String,
        required: true,
        minlength: 2,
        maxlength: 15,
        unique: true
    },
    ruby: {
        type: String,
        required: true,
        minlength: 2,
        maxlength: 30
    },
    tel: {
        type: String,
        required: true,
        match: /^(070|080|090)-\d{4}-\d{4}$/
    },
    mail: {
        type: String,
        required: true,
        match: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
        maxlength: 256
    },
    companyId: {
        type: ObjectId,
        required: true,
        ref: "Company"
    },
    post: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 50
    },
    department: {
        type: String,
        required: true,
        enum: ["東京笑門会", "鎌倉笑門会", "大阪笑門会", "愛媛笑門会"]
    },
    secretaryName: {
        type: String,
        required: function () {
            return this.secretaryMail;
        },
        minlength: 2,
        maxlength: 15
    },
    secretaryMail: {
        type: String,
        required: function () {
            return this.secretaryName;
        },
        match: /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/,
        maxlength: 256
    },
    password: {
        type: String,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        default: false
    },
    notificationInterval: {
        type: Number,
        required: true,
        enum: [0.5, 1, 2, 3, 4, 5, 12, 24],
        default: 12
    },
    isNotification: {
        type: Boolean,
        required: true,
        default: true
    }
}));
