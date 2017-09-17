'use strict';

var mongoose = require('mongoose'),
    Users = mongoose.model('User');

exports.list_all_User = function (req, res) {
    Users.find({}, function (err, user) {
        if (err)
            res.send(err);
        res.json(user);
    });
};

exports.create_a_User = function (req, res) {
    var new_user = new Users(req.body);
    new_user.save(function (err, user) {
        if (err)
            res.send(err);
        res.json(user);
    });
};

exports.read_a_User = function (req, res) {
    Users.findById(req.params.userId, function (err, user) {
        if (err)
            res.send(err);
        res.json(user);
    });
};

exports.update_a_User = function (req, res) {
    Users.findOneAndUpdate({ _id: req.params.userId }, req.body, { new: true }, function (err, user) {
        if (err)
            res.send(err);
        res.json(user);
    });
};

exports.create_a_User_If_not_exist = function (req, res) {
    Users.find({ fbMessengerId: req.params.fbUserId }, function (err, user) {
        if (err)
            res.send(err);
        if (user != null && user != undefined && typeof user[0] !== 'undefined' && user[0] !== null) {
            Users.findOneAndUpdate({ _id: user[0]._id }, req.body, { new: true }, function (err, userupdated) {
                if (err)
                    res.send(err);
                res.json(userupdated);
            });
        }
        else {
            var new_user = new Users(req.body);
            new_user.save(function (err, user) {
                if (err) {
                    res.send(err);
                }
                res.json(user);
            });
        }
        //res.json(user);
    });
};

exports.read_a_User_by_fbid = function (req, res) {
    Users.find({ fbMessengerId: req.params.fbUserId }, function (err, user) {
        if (err)
            res.send(err);
        res.json(user);
    });
};