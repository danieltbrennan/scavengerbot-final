'use strict';
var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var settingSchema = new Schema({
    introText: {
        type: String,
        required: "Intro Text is required."
    },
    introImage: {
        type: String,
    },
    outroText: {
        type: String,
        required: "Outro Text is required."
    },
    outroImage: {
        type: String,
    },
    noOfQuestionToWin: {
        type: Number
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model("ChatSetting", settingSchema);