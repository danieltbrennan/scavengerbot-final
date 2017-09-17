'use strict';
module.exports = function (app) {
    var QADataController = require('../controllers/QADataController');

    app.route('/qadata/:collid')
        .get(QADataController.read_a_Qa_Data_from_Api);
};