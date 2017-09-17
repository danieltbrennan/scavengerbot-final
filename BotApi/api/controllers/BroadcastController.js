'use strict';
var request = require('request');

var mongoose = require('mongoose'),
    Users = mongoose.model('User');

exports.send_a_broadcast = function (req, res) {
    var bMessage = req.body.message;
    //get Accesstoken
    Users.find({ isSubscribed: true }, function (err, user) {
        for (var i = 0; i < user.length; i++) {
            var userObj = user[i];
            request({
                url: "https://graph.facebook.com/v2.6/me/messages?access_token=EAAbCDZBtoZCGQBAJ93PEGrZBFAeBsvfHhcdoqwJ3f4o6JH9CcP8yQQqE61tqiUK6UEyEZBnSoCf7vXwDbIGy81y0CIOA8tejdGcl5qU0RFAKJcwusXZAD1iJOOYqSjC7xeZCuOh7FAPk2R8ys3MnZBOniMdI8Ai99UbeDFTsOmz1gZDZD",
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                form: {
                    recipient: {"id": userObj.fbMessengerId},
                    message: {"text": bMessage}
                },
            }, function (error, response, body) {
                if (response && (response.statusCode === 200 || response.statusCode === 201)) {
                    console.log("SUCCESS")
                }
            });

        }
    })  
    res.json(1);
};