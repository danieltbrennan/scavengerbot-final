var express = require('express'),
  app = express(),
  port = process.env.PORT || 3001,
  mongoose = require('mongoose'),
  QAS = require('./api/models/QAModel'),
  Settings = require('./api/models/SettingModel'),
  Categories = require('./api/models/CategoryModel'),
  Users = require('./api/models/UserModel'),
  QueInteractions = require('./api/models/QueInteractionModel'),
  Winners = require('./api/models/WinnerModel'),
  BroadcastHistories = require('./api/models/BroadcastHistoryModel'),
  bodyParser = require('body-parser');

mongoose.Promise = global.Promise;
mongoose.connect('mongodb://test:test@ds129053.mlab.com:29053/puamscavenger');

app.use(function (req, res, next) {

  // Website you wish to allow to connect
  res.setHeader('Access-Control-Allow-Origin', '*');

  // Request methods you wish to allow
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');

  // Request headers you wish to allow
  res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

  // Set to true if you need the website to include cookies in the requests sent
  // to the API (e.g. in case you use sessions)
  res.setHeader('Access-Control-Allow-Credentials', true);

  // Pass to next layer of middleware
  next();
});

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

//Register Routes
var routes = require('./api/routes/QARoutes');
routes(app);
var settingroutes = require('./api/routes/SettingRoutes');
settingroutes(app);
var catroutes = require('./api/routes/CategoryRoutes');
catroutes(app);
var userroutes = require('./api/routes/UserRoutes');
userroutes(app);
var qiroutes = require('./api/routes/QueInteractionRoutes');
qiroutes(app);
var winnerroutes = require('./api/routes/WinnerRoutes');
winnerroutes(app);
var qaDataroutes = require('./api/routes/QADataRoutes');
qaDataroutes(app);
var broadcastRoutes = require('./api/routes/BroadcastRoutes');
broadcastRoutes(app);
var broadcastHistoryRoutes = require('./api/routes/BroadcastHistoryRoutes');
broadcastHistoryRoutes(app);

app.listen(port);


console.log('todo list RESTful API server started on: ' + port);

