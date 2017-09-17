'use strict';
var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var QASchema = new Schema({
    promptResponse: {
        type: String,
        required: "Question is required."
    },
    acceptedAnswer: {
        type: String,
        required: "Answer is required."
    },
    correctResponse: {
        type: String,
        required: "Correct Response is required."
    },
    correctResponseImage: {
        type: String,
    },
    incorrectResponse: {
        type: String,
        required: "Incorrect Response is required."
    },
    incorrectResponseImage: {
        type: String,
    },
    imageUrl: {
        type: String,
    },
    hint: {
        type: String,
        required: "Hint is required."
    },
    exhibitCategory: {
        type: String,
        required: "Category is required."
    },
    level: {
        type: Number,
        required: "Level is required."
    },
    successCnt: {
        type: Number
    },
    skipCnt: {
        type: Number
    },
    failCnt: {
        type: Number
    },
    collApiObjId: {
        type: String,
    },
    createdDate: {
        type: Date,
        default: Date.now
    },
    updatedDate: {
        type: Date
    }
});

module.exports = mongoose.model('QA', QASchema);