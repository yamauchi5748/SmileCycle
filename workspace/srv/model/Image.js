const { Schema, model } = require("../mongoose");
module.exports = model("Image", Schema({
    isUsing: {
        type: Boolean,
        default: false
    }
}));