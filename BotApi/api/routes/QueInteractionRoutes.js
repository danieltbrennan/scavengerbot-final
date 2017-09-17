'use strict';
module.exports = function (app) {
    var QueInteractionController = require('../controllers/QueInteractionController');

    // QueInteractionController Routes
    app.route('/QueInteractions')
        .get(QueInteractionController.list_all_QueInteraction)
        .post(QueInteractionController.create_a_QueInteraction);


    app.route('/queinteraction/:qiId')
        .get(QueInteractionController.read_a_QueInteraction)
        .put(QueInteractionController.update_a_QueInteraction)
        .delete(QueInteractionController.delete_a_QueInteraction);
};
