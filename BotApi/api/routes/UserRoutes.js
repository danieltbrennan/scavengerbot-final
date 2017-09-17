'use strict';
module.exports = function (app) {
    var UserController = require('../controllers/UserController');

    // UserController Routes
    app.route('/Users')
        .get(UserController.list_all_User)
        .post(UserController.create_a_User);


    app.route('/user/:userId')
        .get(UserController.read_a_User)
        .put(UserController.update_a_User);

    app.route('/userupdate/:fbUserId')
        .get(UserController.read_a_User_by_fbid)
        .post(UserController.create_a_User_If_not_exist);
};
