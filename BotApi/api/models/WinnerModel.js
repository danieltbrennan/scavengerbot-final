'use strict';
var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var winnerSchema = new Schema({
    winnerCode: {
        type: String,
    },
    userId: {
        type: String,
    },
    quizStatTime:{
        type : Date,
    },
    winDate: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model("Winner", winnerSchema);