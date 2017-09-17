'use strict';

var mongoose = require('mongoose'),
  Winners = mongoose.model('Winner');

exports.list_all_Winner = function(req, res) {
  Winners.find({}, function(err, winner) {
    if (err)
      res.send(err);
    res.json(winner);
  });
};

exports.create_a_Winner = function(req, res) {
  var new_winner = new Winners(req.body);
  new_winner.save(function(err, winner) {
    if (err)
      res.send(err);
    res.json(winner);
  });
};


exports.read_a_Winner = function(req, res) {
  Winners.findById(req.params.winnerId, function(err, winner) {
    if (err)
      res.send(err);
    res.json(winner);
  });
};


exports.update_a_Winner = function(req, res) {
  Winners.findOneAndUpdate({_id: req.params.winnerId}, req.body, {new: true}, function(err, winner) {
    if (err)
      res.send(err);
    res.json(winner);
  });
};


exports.delete_a_Winner = function(req, res) {
  Winners.remove({
    _id: req.params.winnerId
  }, function(err, winner) {
    if (err)
      res.send(err);
    res.json({ message: 'Winner successfully deleted' });
  });
};
