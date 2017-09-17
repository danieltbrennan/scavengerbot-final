'use strict';
var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var bhistorySchema = new Schema({
    message: {
        type: String,
        required: "message is required."
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model("BroadcastHistory", bhistorySchema);