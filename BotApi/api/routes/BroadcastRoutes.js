'use strict';
module.exports = function (app) {
    var BroadcastController = require('../controllers/BroadcastController');

    app.route('/broadcast')
        .post(BroadcastController.send_a_broadcast);
};
