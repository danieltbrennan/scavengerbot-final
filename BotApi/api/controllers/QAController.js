'use strict';


var mongoose = require('mongoose'),
  QAs = mongoose.model('QA'),
  QueInteractions = mongoose.model('QueInteraction'),
  Winners = mongoose.model('Winner');

exports.list_all_QA = function (req, res) {
  QAs.find({}, function (err, qa) {
    if (err)
      res.send(err);
    res.json(qa);
  });
};

exports.list_all_QA_By_Category = function (req, res) {
  QAs.find({ exhibitCategory: req.params.caId, level: req.params.level }, function (err, qa) {
    if (err)
      res.send(err);
    res.json(qa);
  });
};

exports.create_a_QA = function (req, res) {
  var new_qa = new QAs(req.body);
  new_qa.save(function (err, qa) {
    if (err)
      res.send(err);
    res.json(qa);
  });
};


exports.read_a_QA = function (req, res) {
  QAs.findById(req.params.qaId, function (err, qa) {
    if (err)
      res.send(err);
    res.json(qa);
  });
};


exports.update_a_QA = function (req, res) {
  QAs.findOneAndUpdate({ _id: req.params.qaId }, req.body, { new: true }, function (err, qa) {
    if (err)
      res.send(err);
    res.json(qa);
  });
};

exports.delete_a_QA = function (req, res) {
  // QAs.findOneAndUpdate({ _id: req.params.qaId }, { isActive: false }, { multi: true }, function (err, qa) {
  //   if (err)
  //     res.send(err);
  //   res.json({ message: 'QA successfully deleted' });
  // });
  QAs.remove({
    _id: req.params.qaId
  }, function (err, qa) {
    if (err)
      res.send(err);
    res.json({ message: 'QA successfully deleted' });
  });
};

exports.Qa_Avg_time_to_completion = function (req, res) {
  var counter = 0;
  var QaTotalTime = 0;
  Winners.find({}, function (err, winner) {
    var counter = 0;
    for (var i = 0; i < winner.length; i++) {
      var winUser = winner[i];
      if (winUser.quizStatTime != undefined) {
        QaTotalTime += Math.abs(new Date(winUser.winDate) - new Date(winUser.quizStatTime));
        counter++;
      }
    }
    res.json(QaTotalTime / counter);
  });
};

exports.list_all_QA_Analytics = function (req, res) {
  QAs.find({}, function (err, qa) {
    if (err)
      res.send(err);

    QueInteractions.find({}, function (err, qi) {

      var QuiColl = [];
      for (var j = 0; j < qi.length; j++) {
        var objQi = qi[j];
        console.log(objQi.interactionEndAt);
        console.log(objQi.interactionStartAt);
        var objQTime = { qiId: objQi.questionId, time: Math.abs(new Date(objQi.interactionEndAt) - new Date(objQi.interactionStartAt)) };
        console.log(objQTime.time);
        if (objQTime.time < (30 * 60000)) //ignore this question time
          QuiColl.push(objQTime);
      }

      console.log(JSON.stringify(QuiColl));

      var data = [];
      for (var i = 0; i < qa.length; i++) {
        var successCnt = 0, skipCnt = 0, failCnt = 0, totalCnt = 0;
        var obj = qa[i];
        if (obj.successCnt != undefined)
          successCnt = obj.successCnt;
        if (obj.skipCnt != undefined)
          skipCnt = obj.skipCnt;
        if (obj.failCnt != undefined)
          failCnt = obj.failCnt;
        totalCnt = successCnt + skipCnt + failCnt;

        //find time
        var timeTotal = 0, timeCount = 0;
        for (var k = 0; k < QuiColl.length; k++) {
          var qui = QuiColl[k];
          if (qui.qiId == obj._id) {
            timeTotal += qui.time;
            timeCount++;
          }
        }
        console.log(timeTotal);

        var timeavg = timeTotal / timeCount;
        var d = {
          _id: obj._id,
          quTitle: obj.promptResponse,
          createdDate: obj.createdDate,
          totalAsked: totalCnt,
          success: successCnt,
          skip: skipCnt,
          missed: failCnt,
          avgTime: millisToMinutesAndSeconds(timeavg),
          avgTimeMill: timeavg,
        };
        data.push(d);
      }
      res.json(data);

    });


  });
};


function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  if (minutes == "NaN" || seconds == "NaN" || minutes == NaN || seconds == NaN)
    return "N.A.";
  else
    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}