'use strict';

var mongoose = require('mongoose'),
    BroadcastHistory = mongoose.model('BroadcastHistory');

exports.list_all_History = function (req, res) {
    BroadcastHistory.find({}, function (err, bhistory) {
        if (err)
            res.send(err);
        res.json(bhistory);
    });
};

exports.create_a_History = function (req, res) {
    var new_broadcast = new BroadcastHistory(req.body);
    new_broadcast.save(function (err, broadcast) {
        if (err)
            res.send(err);
        res.json(broadcast);
    });
};