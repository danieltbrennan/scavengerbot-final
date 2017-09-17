'use strict';
module.exports = function (app) {
    var SettingController = require('../controllers/SettingController');

    // Settings Routes
    app.route('/Settings')
        .get(SettingController.list_all_Setting)
        .post(SettingController.create_a_Setting);


    app.route('/Setting/:settingId')
        .get(SettingController.read_a_Setting)
        .post(SettingController.update_a_Setting);
};
