const { Schema, model } = require("../mongoose");
module.exports = model("Company", Schema({
    name: {
        type: String,
        required: true,
        minlength: 1,
        maxlength: 150
    },
    tel: {
        type: String,
        required: true,
        match: /^\d{2,4}-\d{2,4}-\d{2,4}$/
    },
    address: {
        type: String,
        required: true,
        maxlength: 128
    }
}));