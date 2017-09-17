'use strict';
var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var queInteractionSchema = new Schema({
    questionId: {
        type: String,
    },
    userId: {
        type: String,
    },
    interactionStartAt: {
        type: Date,
    },
    interactionEndAt: {
        type: Date,
    }
});

module.exports = mongoose.model("QueInteraction", queInteractionSchema);