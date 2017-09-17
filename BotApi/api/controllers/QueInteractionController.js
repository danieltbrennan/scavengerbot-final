'use strict';

var mongoose = require('mongoose'),
    QueInteractions = mongoose.model('QueInteraction');

exports.list_all_QueInteraction = function (req, res) {
    QueInteractions.find({}, function (err, qi) {
        if (err)
            res.send(err);
        res.json(qi);
    });
};

exports.create_a_QueInteraction = function (req, res) {
    var new_qi = new QueInteractions(req.body);
    new_qi.save(function (err, qi) {
        if (err)
            res.send(err);
        res.json(qi);
    });
};

exports.read_a_QueInteraction = function (req, res) {
    QueInteractions.findById(req.params.qiId, function (err, qi) {
        if (err)
            res.send(err);
        res.json(qi);
    });
};

exports.update_a_QueInteraction = function (req, res) {
    QueInteractions.findOneAndUpdate({ _id: req.params.qiId }, req.body, { new: true }, function (err, qi) {
        if (err)
            res.send(err);
        res.json(qi);
    });
};

exports.delete_a_QueInteraction = function (req, res) {
    QueInteractions.remove({
        _id: req.params.qiId
    }, function (err, qi) {
        if (err)
            res.send(err);
        res.json({ message: 'Question Interaction successfully deleted' });
    });
};
