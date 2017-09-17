'use strict';

var mongoose = require('mongoose'),
    Settings = mongoose.model('ChatSetting');

exports.list_all_Setting = function (req, res) {
    Settings.find({}, function (err, setting) {
        if (err)
            res.send(err);
        res.json(setting);
    });
};

exports.create_a_Setting = function (req, res) {
    var new_setting = new Settings(req.body);
    new_setting.save(function (err, setting) {
        if (err)
            res.send(err);
        res.json(setting);
    });
};

exports.read_a_Setting = function (req, res) {
    Settings.findById(req.params.settingId, function (err, setting) {
        if (err)
            res.send(err);
        res.json(setting);
    });
};

exports.update_a_Setting = function (req, res) {
    Settings.findOneAndUpdate({ _id: req.params.settingId }, req.body, { new: true }, function (err, setting) {
        if (err)
            res.send(err);
        res.json(setting);
    });
};
