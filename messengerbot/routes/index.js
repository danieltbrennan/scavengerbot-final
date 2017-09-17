var express = require('express');
var router = express.Router();
var restify = require('restify');
var builder = require('botbuilder');
//for api request
var request = require('request');
//winner unique id
var uniqid = require('uniqid');
// Create chat bot
var connector = new builder.ChatConnector({
	appId: "a80650b1-7896-42c9-a7f6-bf03febb6d0a",
	appPassword: "1a0Hp6vL2zkrMKoqKLeRjPv"
});

//Bot Api to get and post data
var botApiUrl = "https://puamscavengerapi.herokuapp.com/";

var bot = new builder.UniversalBot(connector);

/* GET home page. */
router.get('/', function (req, res, next) {
	res.render('index', { title: 'Express' });
});

router.post('/', connector.listen());

//Global Actions

//Restart
bot.dialog('restart', function (session, args, next) {
	session.userData = {};
	session.userData.qalevel = 0;
	session.replaceDialog('/greetings');
}).triggerAction({
	matches: /^restart/i,
});

//Level Normal
bot.dialog('changenormal', function (session, args, next) {
	session.send("Starting new quiz at difficulty: normal");
	session.userData = {};
	session.userData.qalevel = 0; // 0 for normal
	session.replaceDialog('/greetings');
}).triggerAction({
	matches: /^levelnormal$/i,
});

//Level Difficult
bot.dialog('changedifficult', function (session, args, next) {
	session.send("Starting new quiz at difficulty: hard");
	session.userData = {};
	session.userData.qalevel = 1; // 1 for difficult
	session.replaceDialog('/greetings');
}).triggerAction({
	matches: /^leveldifficult$/i,
});

//Subscribe
bot.dialog('subscribe', function (session, args, next) {
	updateUser(session, session.message.address.user.id, true);
	session.send("You have been subscribed to events.");
	session.endDialog();
}).triggerAction({
	matches: /^subscribe$/i,
});

//Unsubscribe
bot.dialog('unsubscribe', function (session, args, next) {
	updateUser(session, session.message.address.user.id, false);
	session.send("You have been unsubscribed to events.");
	session.endDialog();
}).triggerAction({
	matches: /^unsubscribe$/i,
});

/* Starting bot point */
bot.dialog('/', [
	function (session) {

		if (session.message.text.toLowerCase() == "hi" || session.message.text.toLowerCase() == "Get started" || session.message.text.toLowerCase() == "restart") {
			session.userData = {};
			session.userData.qalevel = 0;
			session.beginDialog('/greetings');
		}
		else
			session.beginDialog('/greetings');
	}
]);


//Greeting dialog
bot.dialog('/greetings', [

// Greeting message associated with the intro editing on the dashboard
// Uncomment this section out (and comment out the rest of the greeting dialog)
// so dashboard users can update this greeting.

	// function (session) {
	// 			//Access facebook information
	// 	var fbid, fname, lname;
	// 	fbid = session.message.address.user.id;
	// 	if (session.message.address.user.name != undefined) {
	// 		var names = session.message.address.user.name.split(' ');
	// 		fname = names[0];
	// 		lname = names[1];
	// 	}

	// 	//Create user. If interacting again then update the fields
	// 	createUser(session, fbid, fname, lname);

	// 	request(botApiUrl + 'settings', function (error, response, body) {
	// 		if (!error && response.statusCode == 200) {
	// 			var objs = JSON.parse(body);
	// 			if (objs != null && objs.length > 0) {
	// 				var obj = objs[0];
	// 				session.send(obj.introText);
	// 				if (obj.introImage != "" && obj.introImage != null && checkURL(obj.introImage)) {
	// 					var msg = new builder.Message(session)
	// 						.addAttachment({
	// 							contentUrl: obj.introImage,
	// 							contentType: 'image/jpeg',
	// 							name: 'introImage.png'
	// 						});
	// 					session.send(msg);
	// 				}
	// 				session.replaceDialog('loadcategory');
	// 			}
	// 		}
	// 	});
	// },
	function (session) {
				//Access facebook information
		var fbid, fname, lname;
		fbid = session.message.address.user.id;
		if (session.message.address.user.name != undefined) {
			var names = session.message.address.user.name.split(' ');
			fname = names[0];
			lname = names[1];
		}

		//Create user. If interacting again then update the fields
		createUser(session, fbid, fname, lname);

		var msg = "Welcome to the Princeton University Art Museum!"
		session.send(msg);
		msg = "Tap \"Let's go!\" to begin your adventure."
		builder.Prompts.choice(session, msg, "Let's go!", "button")
	},
	function (session) {

		var msg = "Your final paper for history class is due tomorrow and you haven't even started!"
		session.send(msg);
		msg = "You're about to give up, but your roommate reveals one of Princeton University's deepest secrets.";
		builder.Prompts.choice(session, msg, "What secret? 😮", "button");
	},

	function (session, results) {
		var msg = "When Albert Einstein delivered his lectures on the theory of relativity, in 1921 in McCosh 50, he was actually building the world's first time machine!";
		session.send(msg);
		msg = "This is your chance to use the time machine to collect the research you need to finish your paper."
		builder.Prompts.choice(session, msg, "How does it work?", "button");

	},
	function (session, results) {
		var msg = "You'll time travel through the Museum’s four lower-level galleries in search of specific objects. Answer 12 questions to complete your mission!";
		session.send(msg);
		msg = "Read the questions carefully for clues and look closely at each object and its label."
		session.send(msg);
		builder.Prompts.choice(session, "If you haven't already, tap \"Send a Message\" below to bring up the keyboard so you can type your answers.", "Done, I'm ready! 🚀", "button");
	},
	function (session, results) {
		//Start loading categories
		session.replaceDialog('loadcategory');
	}
]);

//Load Category
bot.dialog('loadcategory', [
	function (session) {
		//Check Category Loaded or not : This is useful when user types any other text when "Go Ahead" is asked
		if (session.message.text != null && session.message.text != undefined &&
			session.userData.isCategoryLoaded != undefined && session.userData.isCategoryLoaded) {
			session.userData.isCategoryLoaded = false;
			//if user types any text it will load the questions
			session.beginDialog('askquestion');
		}
		else {
			request(botApiUrl + 'categories', function (error, response, body) {
				if (!error && response.statusCode == 200) {
					var objs = JSON.parse(body);
					if (objs != null && objs.length > 0) {

						//Start Quiz interaction
						if(session.userData.quizStartTime == undefined)
							session.userData.quizStartTime = new Date();

						var randomNo = 0;
						session.userData.queattended = []; //clear previously attended question from other category if repeated.
						session.userData.correctAnswerCnt = 0;

						if (session.userData.categoryattended == undefined) {
							//Generate random number
							randomNo = generateRandomNo(objs.length);
							var ca = [];
							ca.push(randomNo);
							session.userData.categoryattended = JSON.stringify(ca);
							var obj = objs[randomNo]; //loading category
							session.userData.runningCategory = obj._id;// category id save
							msg = new builder.Message(session)
								.addAttachment({
									contentUrl: "https://s3-us-west-2.amazonaws.com/puamimage/lowergalleriesmap.png",
									contentType: 'image/png',
									name: 'BotFrameworkLogo.png'
								})
							session.send(msg);
							var msg = new builder.Message(session)
								.text("Buckle up! Time machine activating. Traveling to the " + obj.name + " Galleries in 3, 2, 1...")
								.suggestedActions(
								builder.SuggestedActions.create(
									session, [
										builder.CardAction.imBack(session, "Let's go", "Let's go! 💪")
									]
								));
							session.userData.isCategoryLoaded = true;
							fnMovingToNextQuestion(session, false);
							session.send(msg);
						}
						else {
							var categoryattended = JSON.parse(session.userData.categoryattended);
							if (categoryattended.length == objs.length) {
								//user played all exhibit category
								session.endDialog();
								session.beginDialog('finishquiz');
							}
							else {
								//Generate random number exclude category attended.
								randomNo = generateRandomNoWithNoExist(objs.length, categoryattended);
								if (randomNo != undefined) {
									categoryattended.push(randomNo);
									session.userData.categoryattended = JSON.stringify(categoryattended);
									var obj = objs[randomNo]; //loading category
									session.userData.runningCategory = obj._id;// category id save
									//reset the questions
									session.userData.queattended = undefined;
									session.userData.queRandomNo = undefined;
									//session.send("Moving to " + obj.name + " exhibit.");

									msg = new builder.Message(session)
									.addAttachment({
										contentUrl: "https://s3-us-west-2.amazonaws.com/puamimage/lowergalleriesmap.png",
										contentType: 'image/png',
										name: 'BotFrameworkLogo.png'
									})
									session.send(msg);

									var msg = new builder.Message(session)
										.text("Buckle up! Time machine activating. Traveling to the " + obj.name + " Galleries in 3, 2, 1...")
										.suggestedActions(
										builder.SuggestedActions.create(
											session, [
												builder.CardAction.imBack(session, "Let's go", "Let's go! 💪")
											]
										));
									session.userData.isCategoryLoaded = true;
									fnMovingToNextQuestion(session, false);
									session.send(msg);
								}
								//Sometimes random number undefined from random function. So it will try again to generate the no.
								else {
									session.userData.isCategoryLoaded = false;
									fnMovingToNextQuestion(session, false);
									session.userData.isCategoryLoaded = false;
									session.replaceDialog('loadcategory');
								}
							}
						}
					}
					else {
						//There are no question in this category.
						session.send("No questions!");
						session.endDialog();
					}
				}
				else {
					session.endDialog();
				}
			});
		}
	}
]).beginDialogAction('yes', 'yes', { matches: /^Let's go$/i });

//Same category incase of user is not attemting 3 correct answer in the category
bot.dialog('loadsamecategory', [
	function (session) {

		request(botApiUrl + 'category/' + session.userData.runningCategory, function (error, response, body) {
			if (!error && response.statusCode == 200) {
				var obj = JSON.parse(body);
				if (obj != null) {
					session.userData.queattended = undefined;
					session.userData.correctAnswerCnt = 0;
					session.userData.questionId = undefined;
					var msg = new builder.Message(session)
						.text("You need 3 questions answered in the " + obj.name + " exhibit to proceed. Almost there, try again!")
						.suggestedActions(
						builder.SuggestedActions.create(
							session, [
								builder.CardAction.imBack(session, "go again", "Go again! 💪")
							]
						));
					session.send(msg);
				}
				else {
					session.send("No questions!");
					session.endDialog();
				}
			}
			else {
				session.endDialog();
			}
		});
	}
]).beginDialogAction('yes', 'yes', { matches: /^go again$/i });

//User pressed Let's go or Go again : It will start question
bot.dialog('yes', function (session, args, next) {
	session.endDialog();
	session.beginDialog('askquestion');
});

//Asking Question
bot.dialog('askquestion', [
	function (session, args, next) {

		//User given answer
		if (session.message.text != null && session.message.text != undefined
			&& session.message.attachments.length == 0
			&& session.message.text.toLowerCase() != "skip"
			&& session.message.text.toLowerCase() != "hint"
			&& session.userData.acceptedAnswer != undefined
			&& session.userData.correctResponse != undefined
			&& session.userData.incorrectResponse != undefined) {

			var res = String(session.message.text).toLowerCase();

			if (session.userData.acceptedAnswer.toLowerCase().indexOf(";") !== -1) { // correct answer
				var arrayofAnswer = session.userData.acceptedAnswer.toLowerCase().split(';');
				if (arrayofAnswer.indexOf(res) > -1) { //array contains
					session.userData.isNextQue = true;
					if (session.userData.correctAnswerCnt == undefined)
						session.userData.correctAnswerCnt = 1;
					else
						session.userData.correctAnswerCnt = Number(session.userData.correctAnswerCnt) + 1;
					if (session.userData.correctResponseImage != undefined && session.userData.correctResponseImage.length > 0
						&& checkURL(session.userData.correctResponseImage)) {
						session.send(session.userData.correctResponse);
						//image
						var msg = new builder.Message(session)
							.addAttachment({
								contentUrl: session.userData.correctResponseImage,
								contentType: 'image/jpeg',
								name: 'CorrectImage.png'
							})
							.suggestedActions(
							builder.SuggestedActions.create(
								session, [
									builder.CardAction.imBack(session, "nextquestion", "Next Question 🙌")
								]
							));
						saveQuestionData(session, true, false, false);
						createQueInteraction(session);
						session.send(msg);
					}
					else {
						var msg = new builder.Message(session)
							.text(session.userData.correctResponse)
							.suggestedActions(
							builder.SuggestedActions.create(
								session, [
									builder.CardAction.imBack(session, "nextquestion", "Next Question 🙌")
								]
							));
						saveQuestionData(session, true, false, false);
						createQueInteraction(session);
						session.send(msg);
					}
				}
				else {
					if (session.userData.isNextQue) {
						//next question
						session.userData.isNextQue = false;
						session.beginDialog("nextque");
					}
					else {
						//incorrect answer
						var quickAction = null;
						if (session.userData.hint != undefined && session.userData.hint.length > 0) {
							quickAction = [
								builder.CardAction.imBack(session, "skip", "Skip 🏃"),
								builder.CardAction.imBack(session, "hint", "Hint 🙋")
							];
						}
						else {
							quickAction = [
								builder.CardAction.imBack(session, "skip", "Skip 🏃")
							];
						}
						if (session.userData.incorrectResponseImage != undefined && session.userData.incorrectResponseImage.length > 0
							&& checkURL(session.userData.incorrectResponseImage)) {
							session.send(session.userData.incorrectResponse);
							//image
							var msg = new builder.Message(session)
								.addAttachment({
									contentUrl: session.userData.incorrectResponseImage,
									contentType: 'image/jpeg',
									name: 'BotFrameworkLogo.png'
								})
								.suggestedActions(
								builder.SuggestedActions.create(
									session, quickAction
								));
							saveQuestionData(session, false, true, false);
							//fnMovingToNextQuestion(session, false);
							session.send(msg);
						}
						else {
							var msg = new builder.Message(session)
								.text(session.userData.incorrectResponse)
								.suggestedActions(
								builder.SuggestedActions.create(
									session, quickAction
								));
							saveQuestionData(session, false, true, false);
							session.send(msg);
							//fnMovingToNextQuestion(session, false);
						}
					}
				}
			}
			else if (session.userData.acceptedAnswer.toLowerCase() == res) { // correct answer
				session.userData.isNextQue = true;
				if (session.userData.correctAnswerCnt == undefined)
					session.userData.correctAnswerCnt = 1;
				else
					session.userData.correctAnswerCnt = Number(session.userData.correctAnswerCnt) + 1;
				if (session.userData.correctResponseImage != undefined && session.userData.correctResponseImage.length > 0
					&& checkURL(session.userData.correctResponseImage)) {
					session.send(session.userData.correctResponse);
					//image
					var msg = new builder.Message(session)
						.addAttachment({
							contentUrl: session.userData.correctResponseImage,
							contentType: 'image/jpeg',
							name: 'CorrectImage.png'
						})
						.suggestedActions(
						builder.SuggestedActions.create(
							session, [
								builder.CardAction.imBack(session, "nextquestion", "Next Question 🙌")
							]
						));
					saveQuestionData(session, true, false, false);
					createQueInteraction(session);
					session.send(msg);
				}
				else {
					var msg = new builder.Message(session)
						.text(session.userData.correctResponse)
						.suggestedActions(
						builder.SuggestedActions.create(
							session, [
								builder.CardAction.imBack(session, "nextquestion", "Next Question 🙌")
							]
						));
					saveQuestionData(session, true, false, false);
					createQueInteraction(session);
					session.send(msg);
					//fnMovingToNextQuestion(session, false);
				}

			}
			else {
				if (session.userData.isNextQue) {
					//next question
					session.userData.isNextQue = false;
					session.beginDialog("nextque");
				}
				else {
					//incorrect answer
					var quickAction = null;
					if (session.userData.hint != undefined && session.userData.hint.length > 0) {
						quickAction = [
							builder.CardAction.imBack(session, "skip", "Skip 🏃"),
							builder.CardAction.imBack(session, "hint", "Hint 🙋")
						];
					}
					else {
						quickAction = [
							builder.CardAction.imBack(session, "skip", "Skip 🏃")
						];
					}
					if (session.userData.incorrectResponseImage != undefined && session.userData.incorrectResponseImage.length > 0
						&& checkURL(session.userData.incorrectResponseImage)) {
						session.send(session.userData.incorrectResponse);
						//image
						var msg = new builder.Message(session)
							.addAttachment({
								contentUrl: session.userData.incorrectResponseImage,
								contentType: 'image/jpeg',
								name: 'BotFrameworkLogo.png'
							})
							.suggestedActions(
							builder.SuggestedActions.create(
								session, quickAction
							));
						saveQuestionData(session, false, true, false);
						session.send(msg);
					}
					else {
						var msg = new builder.Message(session)
							.text(session.userData.incorrectResponse)
							.suggestedActions(
							builder.SuggestedActions.create(
								session, quickAction
							));
						saveQuestionData(session, false, true, false);
						session.send(msg);
					}
				}
			}
		}
		//Check for attachment send by user
		else if (session.message.attachments != null && session.message.attachments.length > 0
			&& session.message.text.toLowerCase() != "skip"
			&& session.message.text.toLowerCase() != "hint"
			&& session.userData.acceptedAnswer != undefined
			&& session.userData.correctResponse != undefined
			&& session.userData.incorrectResponse != undefined) {

			var quickAction = null;
			if (session.userData.hint != undefined && session.userData.hint.length > 0) {
				quickAction = [
					builder.CardAction.imBack(session, "skip", "Skip 🏃"),
					builder.CardAction.imBack(session, "hint", "Hint 🙋")
				];
			}
			else {
				quickAction = [
					builder.CardAction.imBack(session, "skip", "Skip 🏃")
				];
			}
			var msg = new builder.Message(session)
				.text("Please type your answer below instead of sending an image!")
				.suggestedActions(
				builder.SuggestedActions.create(
					session, quickAction
				));
			session.send(msg);
		}
		//Asking Question
		else {
			request(botApiUrl + 'qacas/' + session.userData.runningCategory + '/' + session.userData.qalevel, function (error, response, body) {
				if (!error && response.statusCode == 200) {
					var objs = JSON.parse(body);
					if (objs != null && objs.length > 0) {
						var randomNo = 0;
						var obj = null;
						session.userData.questionCount = objs.length;

						if (session.userData.queattended == undefined || session.userData.queattended.length == 0) {
							randomNo = generateRandomNo(objs.length);
							session.userData.queRandomNo = randomNo;
							var obj = objs[randomNo];
							fnAskQuestion(session, obj);
						}
						else {
							var queattended = JSON.parse(session.userData.queattended);
							if (queattended.length == objs.length) {
								//end of the exhibit
								//completed questions from this category
								// Change number of correct answers required
								fnMovingToNextQuestion(session, false);
								if (Number(session.userData.correctAnswerCnt) == 3) {
									session.userData.isCategoryLoaded = false;
									session.replaceDialog('loadcategory');
								}
								else
									session.replaceDialog('loadsamecategory');
							}
							else {
								randomNo = generateRandomNoWithNoExist(objs.length, queattended);
								if (randomNo != undefined) {
									session.userData.queRandomNo = randomNo;
									var obj = objs[randomNo];
									fnAskQuestion(session, obj);
								}
								else {
									fnMovingToNextQuestion(session, false);
									session.replaceDialog('askquestion');
								}
							}
						}
					}
					else {
						session.send("No questions in this exhibit.");
						fnMovingToNextQuestion(session, false);
						session.userData.isCategoryLoaded = false;
						session.replaceDialog('loadcategory');
					}
				}
			});
		}
	}
]).beginDialogAction('nextquestion', 'nextque', { matches: /^nextquestion$/i })
	.beginDialogAction('skipAction', 'skip', { matches: /^skip$/i })
	.beginDialogAction('hintAction', 'hint', { matches: /^hint$/i });

//User given correct answer
bot.dialog('nextque', function (session, args, next) {
	if (Number(session.userData.correctAnswerCnt) == 3) {
		//move to next exhibit
		fnMovingToNextQuestion(session, false);
		session.userData.isCategoryLoaded = false;
		session.replaceDialog('loadcategory');
	}
	else {
		fnMovingToNextQuestion(session, true);
		session.endDialog();
		session.beginDialog('askquestion');
	}
});

//User skip the question
bot.dialog('skip', function (session, args, next) {
	if (session.userData.isNextQue) {
		//next question
		session.userData.isNextQue = false;
		session.replaceDialog("nextque");
	}
	else { //skip
		saveQuestionData(session, false, false, true); // skipped
		fnMovingToNextQuestion(session, true);
		session.endDialog();
		session.beginDialog('askquestion');
	}
});

//Hint with skip and hint option
bot.dialog('hint', function (session, args, next) {
	if (session.userData.isNextQue) {
		//next question
		session.userData.isNextQue = false;
		session.replaceDialog("nextque");
	}
	else { // hint
		if (session.userData.hint != undefined && session.userData.hint.length > 0) {
			//Send hint to user
			var msg = new builder.Message(session)
				.text("Here's a hint: " + session.userData.hint)
				.suggestedActions(
				builder.SuggestedActions.create(
					session, [
						builder.CardAction.imBack(session, "skip", "Skip 🏃"),
						builder.CardAction.imBack(session, "hint", "Hint 🙋")
					]
				));
			session.send(msg);
			session.endDialog();
		}
		else {
			session.endDialog();
		}
	}
}).beginDialogAction('skipAction', 'skip', { matches: /^skip$/i })
	.beginDialogAction('hintAction', 'hint', { matches: /^hint$/i });

//finish Quiz
bot.dialog('finishquiz', [
	function (session) {
		//Generate Unique id
		var uniqueId = uniqid();
		var json = {
			"winnerCode": uniqueId,
			"userId": session.userData.userId,
			"quizStatTime": session.userData.quizStartTime
		};
		//Add to Winner
		request({
			url: botApiUrl + 'Winners',
			method: "POST",
			json: true,
			body: json
		}, function (error, response, body) {
			if (response && (response.statusCode === 200 || response.statusCode === 201)) {
				//Load Outro text
				request(botApiUrl + 'settings', function (error, response, body) {
					if (!error && response.statusCode == 200) {
						var objs = JSON.parse(body);
						if (objs != null && objs.length > 0) {
							var obj = objs[0];
							session.send(obj.outroText);
							if (obj.outroImage != "" && obj.outroImage != null && checkURL(obj.outroImage)) {
								var msg = new builder.Message(session)
									.addAttachment({
										contentUrl: obj.outroImage,
										contentType: 'image/jpeg',
										name: 'outroImage.png'
									});
								session.send(msg);
							}

						}
						session.endDialog();
					}
				});
			}
		});

	},
	function (session, results) {
		session.endDialogWithResult(results);
	}
]);

//Ask Question called from AskQuestion
function fnAskQuestion(session, que) {
	session.userData.isNextQue = false;
	session.userData.successCnt = que.successCnt;
	session.userData.skipCnt = que.skipCnt;
	session.userData.failCnt = que.failCnt;
	session.userData.acceptedAnswer = que.acceptedAnswer;
	session.userData.correctResponse = que.correctResponse;
	session.userData.incorrectResponse = que.incorrectResponse;
	session.userData.correctResponseImage = que.correctResponseImage;
	session.userData.incorrectResponseImage = que.incorrectResponseImage;
	session.userData.hint = que.hint;
	session.userData.interactionStart = new Date().toString();
	if (session.userData.questionId != que._id) {
		session.userData.questionId = que._id;
		var quickAction = null;
		if (que.hint != undefined && que.hint.length > 0) {
			quickAction = [
				builder.CardAction.imBack(session, "skip", "Skip 🏃"),
				builder.CardAction.imBack(session, "hint", "Hint 🙋")
			];
		}
		else {
			quickAction = [
				builder.CardAction.imBack(session, "skip", "Skip 🏃")
			];
		}
		//Question
		if (que.imageUrl != undefined && que.imageUrl.length > 0 && checkURL(que.imageUrl)) {
			session.send(que.promptResponse);
			//image
			var msg = new builder.Message(session)
				.addAttachment({
					contentUrl: que.imageUrl,
					contentType: 'image/jpeg',
					name: 'BotFrameworkLogo.png'
				})
				.suggestedActions(
				builder.SuggestedActions.create(
					session, quickAction
				));
			session.send(msg);
		}
		else {
			var msg = new builder.Message(session)
				.text(que.promptResponse)
				.suggestedActions(
				builder.SuggestedActions.create(
					session, quickAction
				));
			session.send(msg);
		}
	}
}

//Move to next question
function fnMovingToNextQuestion(session, isNext) {
	if (isNext) {
		if (session.userData.queattended == undefined || session.userData.queattended.length == 0) {
			var que = [];
			que.push(session.userData.queRandomNo);
			session.userData.queattended = JSON.stringify(que);
		}
		else {
			var queattended = JSON.parse(session.userData.queattended);
			queattended.push(session.userData.queRandomNo);
			session.userData.queattended = JSON.stringify(queattended);
		}
	}
	session.userData.acceptedAnswer = undefined;
	session.userData.correctResponse = undefined;
	session.userData.incorrectResponse = undefined;
}

// Random no generation
function generateRandomNo(length) {
	return Math.floor(Math.random() * length);
}

// Random no generation with exclude already generated
function generateRandomNoWithNoExist(length, array) {
	var no = generateRandomNo(length);
	if (array.indexOf(no) > -1)
		generateRandomNoWithNoExist(length, array);
	else {
		return no;
	}
}

//Save question data to Database
function saveQuestionData(session, isSuccess, isWrong, isSkipped) {
	var successCnt, skipCnt, failCnt;
	if (isSuccess) {
		if (session.userData.successCnt != undefined)
			successCnt = session.userData.successCnt + 1;
		else
			successCnt = 1;
		session.userData.successCnt = successCnt;
		//make interaction entry

	}
	if (isWrong) {
		if (session.userData.failCnt != undefined)
			failCnt = session.userData.failCnt + 1;
		else
			failCnt = 1;
		session.userData.failCnt = failCnt;
	}
	if (isSkipped) {
		if (session.userData.skipCnt != undefined)
			skipCnt = session.userData.skipCnt + 1;
		else
			skipCnt = 1;
		session.userData.skipCnt = skipCnt;
	}
	var json = {
		"successCnt": successCnt,
		"skipCnt": skipCnt,
		"failCnt": failCnt
	};
	request({
		url: botApiUrl + 'qa/' + session.userData.questionId,
		method: "PUT",
		json: true,
		body: json
	}, function (error, response, body) {
		if (response && (response.statusCode === 200 || response.statusCode === 201)) {
		}
	});
}

//Save Question Interaction
function createQueInteraction(session) {

	var json = {
		"questionId": session.userData.questionId,
		"userId": session.userData.userId,
		"interactionStartAt": session.userData.interactionStart,
		"interactionEndAt": new Date().toString()
	};
	request({
		url: botApiUrl + 'QueInteractions/',
		method: "POST",
		json: true,
		body: json
	}, function (error, response, body) {
		if (response && (response.statusCode === 200 || response.statusCode === 201)) {
			if (body != null) {
			}
			else {
				console.log(error);
			}
		}
	});
}

//Save to User table
function createUser(session, fbMessengerId, firstName, lastName) {

	request(botApiUrl + 'userupdate/' + fbMessengerId, function (error, response, body) {
		if (!error && response.statusCode == 200) {
			var obj = JSON.parse(body);
			var isSubscribed = true;
			if (obj != null && obj != undefined && obj.isSubscribed != undefined) {
				isSubscribed = obj.isSubscribed;
			}
			var json = {
				"fbMessengerId": fbMessengerId,
				"firstName": firstName,
				"lastName": lastName,
				"isSubscribed": isSubscribed
			};
			request({
				url: botApiUrl + 'userupdate/' + fbMessengerId,
				method: "POST",
				json: true,
				body: json
			}, function (error, response, body) {
				if (response && (response.statusCode === 200 || response.statusCode === 201)) {
					if (body != null) {
						//store to userid to make foreign key to other tables
						session.userData.userId = body._id;
					}
					else {
						console.log(error);
					}
				}
			});
		}
	});
}
//Update existing user isSubscribed field
function updateUser(session, fbMessengerId, isSubscribe) {
	var json = {
		"fbMessengerId": fbMessengerId,
		"isSubscribed": isSubscribe
	};
	request({
		url: botApiUrl + 'userupdate/' + fbMessengerId,
		method: "POST",
		json: true,
		body: json
	}, function (error, response, body) {
		if (response && (response.statusCode === 200 || response.statusCode === 201)) {
			if (body != null) {
			}
			else {
				console.log(error);
			}
		}
	});
}

//Url Checking : return true or false.
function checkURL(url) {
	return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}

module.exports = router;
