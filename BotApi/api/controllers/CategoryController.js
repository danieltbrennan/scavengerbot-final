'use strict';

var mongoose = require('mongoose'),
    Categories = mongoose.model('ExibitCategory'),
    QAs = mongoose.model('QA');

exports.list_all_Category = function (req, res) {
    Categories.find({}, function (err, category) {
        if (err)
            res.send(err);
        res.json(category);
    });
};

exports.create_a_Category = function (req, res) {
    var new_cat = new Categories(req.body);
    new_cat.save(function (err, category) {
        if (err)
            res.send(err);
        res.json(category);
    });
};

exports.read_a_Category = function (req, res) {
    Categories.findById(req.params.categoryId, function (err, category) {
        if (err)
            res.send(err);
        res.json(category);
    });
};

exports.update_a_Category = function (req, res) {
    Categories.findOneAndUpdate({ _id: req.params.categoryId }, req.body, { new: true }, function (err, category) {
        if (err)
            res.send(err);
        res.json(category);
    });
};

exports.delete_a_Category = function (req, res) {
    QAs.remove({ exhibitCategory: req.params.categoryId }, function (err, qa) {
        if (err)
            res.send(err);
        Categories.remove({
            _id: req.params.categoryId
        }, function (err, cat) {
            if (err)
                res.send(err);
            res.json({ message: 'Category successfully deleted' });
        });
    });

};

