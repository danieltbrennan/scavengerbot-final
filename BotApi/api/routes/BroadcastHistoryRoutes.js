'use strict';
module.exports = function (app) {
    var BroadcastHistroyController = require('../controllers/BroadcastHistroyController');

    // Settings Routes
    app.route('/broadcasthistory')
        .get(BroadcastHistroyController.list_all_History)
        .post(BroadcastHistroyController.create_a_History);
};
