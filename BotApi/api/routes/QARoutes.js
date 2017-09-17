'use strict';
module.exports = function (app) {
  var QAController = require('../controllers/QAController');

  // QAController Routes
  app.route('/QAs')
    .get(QAController.list_all_QA)
    .post(QAController.create_a_QA);

  app.route('/qacas/:caId/:level')
    .get(QAController.list_all_QA_By_Category)

  app.route('/qa/:qaId')
    .get(QAController.read_a_QA)
    .put(QAController.update_a_QA)
    .delete(QAController.delete_a_QA);

  app.route('/qaanalytics')
    .get(QAController.list_all_QA_Analytics);

  app.route('/qamainanalytics')
    .get(QAController.Qa_Avg_time_to_completion)
};
