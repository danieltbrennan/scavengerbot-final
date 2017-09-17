'use strict';
var request = require('request');
var qaDataApiUrl = "http://35.167.125.136/objects/";
exports.read_a_Qa_Data_from_Api = function (req, res) {
    var r = request(qaDataApiUrl + req.params.collid, function (error, response, body) {
        if (!error && response.statusCode == 200) {
            clearTimeout(id);
            var obj = JSON.parse(body);
            if (obj != null) {
                res.json(obj);
            }
            else {
                res.json(0);
            }
        }
        else {
            res.json(error);
        }
    });
    var id = setTimeout(function () {
        r.abort();
        res.json("No data")
    }, 5000);
    
};