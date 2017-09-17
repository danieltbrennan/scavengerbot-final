'use strict';
module.exports = function (app) {
    var CategoryController = require('../controllers/CategoryController');

    // Category Controller Routes
    app.route('/categories')
        .get(CategoryController.list_all_Category)
        .post(CategoryController.create_a_Category);


    app.route('/category/:categoryId')
        .get(CategoryController.read_a_Category)
        .put(CategoryController.update_a_Category)
        .delete(CategoryController.delete_a_Category);
};
