'use strict';
module.exports = function(app) {
  var WinnerController = require('../controllers/WinnerController');

  // WinnerController Routes
  app.route('/Winners')
    .get(WinnerController.list_all_Winner)
    .post(WinnerController.create_a_Winner);

  app.route('/winner/:winnerId')
    .get(WinnerController.read_a_Winner)
    .put(WinnerController.update_a_Winner)
    .delete(WinnerController.delete_a_Winner);
};
