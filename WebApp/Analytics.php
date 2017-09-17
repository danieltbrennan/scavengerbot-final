<?php
	require_once('common.php');
	checkUser();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Scavengerbot - Analytics</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet" />
    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a id="logo" class="navbar-brand" href="Analytics.php">Scavenger Hunt</a>
                        <a class="navbar-brand active" href="Analytics.php"><img src="assets/img/das.png" /> Analytics</a>
                        <a class="navbar-brand " href="Questions.php"><img src="assets/img/que.png" /> Questions</a>
                        <a class="navbar-brand " href="Customizations.php"><img src="assets/img/cust.png" /> Customizations</a>
                        <a class="navbar-brand" href="Broadcast.php"><img src="assets/img/brod.png" /> Broadcast</a>
                    </div>
                    <a class="navbar-brand" style="float:right" href="logout.php"><img src="assets/img/logout.png" /> Logout</a>
                </div>
            </nav>
            <div class="content">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="numbers ">
                                            <p>Total Questions Answered</p>
                                            <span id="spanTotalAnswered">N.A</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="numbers ">
                                            <p>Completed Scavenger Hunt</p>
                                            <span id="spanCompleted">N.A</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="numbers ">
                                            <p>Average Questions Answered</p>
                                            <span id="spanAvgAnswered">N.A</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="numbers ">
                                            <p>Average Time to Completion</p>
                                            <span id="spanAvgTimeToCompleted">N.A</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 Sort-pading">
                        <a id="Sorting" class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <p>Sorted By: <strong id="sortingSelected">DATE ENTERED</strong></p>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a onclick="sortByDateEntered();">DATE ENTERED</a></li>
                            <li><a onclick="sortByTotalAsked();">TOTAL ASKED</a></li>
                            <li><a onclick="sortBySuccess();">SUCCESSES</a></li>
                            <li><a onclick="sortBySkip();">SKIPS</a></li>
                            <li><a onclick="sortByMisses();">MISSES</a></li>
                            <li><a onclick="sortByAvgTime();">AVG TIME</a></li>
                        </ul>
                    </div>
                    <div id="divQuestions" class="col-md-12">
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script>
            var apiURL = "https://puamscavengerapi.herokuapp.com/";

            $(function () {
                getQuestionsAnalytics();
            });

            function arrangeQuestions(responseData) {
                var counter = 0;
                $("#divQuestions").empty();
                responseData.forEach(function (qa) {
                    var totalAsked = qa.totalAsked;
                    var success = 0, skip = 0, missed = 0;

                    if (totalAsked != 0) {
                        success = ((Number(qa.success) / totalAsked) * 100).toFixed(0);
                        skip = ((Number(qa.skip) / totalAsked) * 100).toFixed(0);
                        missed = ((Number(qa.missed) / totalAsked) * 100).toFixed(0);
                    }
                    var obj = "<div id='q_" + qa._id + "' class='card'>" +
                        "<div class='header'>" +
                        "<h4 class='title'>Question #" + (++counter) + "</h4>" +
                        "</div >" +
                        "<div class='content'>" +
                        "<div class='row'>" +
                        "<div class='col-md-6'>" +
                        "<div class='form-group'>" +
                        "<p>" + qa.quTitle + "</p>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-md-6'>" +
                        "<div class='col-md-3'>" +
                        "<div class='form-group'>" +
                        "<label>Total Asked</label>" +
                        "<p>" + totalAsked + "</p>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-md-2'>" +
                        "<div class='form-group'>" +
                        "<label>Success</label>" +
                        "<p>" + qa.success + " - " + success + "%</p>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-md-2'>" +
                        "<div class='form-group'>" +
                        "<label>Skip</label>" +
                        "<p>" + qa.skip + " - " + skip + "%</p>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-md-2'>" +
                        "<div class='form-group'>" +
                        "<label>Misses</label>" +
                        "<p>" + qa.missed + " - " + missed + "%</p>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-md-3'>" +
                        "<div class='form-group'>" +
                        "<label>Avg Time</label>" +
                        "<p>" + qa.avgTime + "</p>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $("#divQuestions").append(obj);
                });
            }

            var Questions = [];

            function compareDate(a, b) {
                if (new Date(a.createdDate) > new Date(b.createdDate))
                    return -1;
                if (new Date(a.createdDate) < new Date(b.createdDate))
                    return 1;
                return 0;
            }
            function compareTotalAsked(a, b) {
                if (a.totalAsked > b.totalAsked)
                    return -1;
                if (a.totalAsked < b.totalAsked)
                    return 1;
                return 0;
            }
            function compareSuccesses(a, b) {
                if (a.success > b.success)
                    return -1;
                if (a.success < b.success)
                    return 1;
                return 0;
            }
            function compareSkips(a, b) {
                if (a.skip > b.skip)
                    return -1;
                if (a.skip < b.skip)
                    return 1;
                return 0;
            }
            function compareMisses(a, b) {
                if (a.missed > b.missed)
                    return -1;
                if (a.missed < b.missed)
                    return 1;
                return 0;
            }
            function compareAvgTime(a, b) {
                if (new Date(a.avgTimeMill) > new Date(b.avgTimeMill))
                    return -1;
                if (new Date(a.avgTimeMill) < new Date(b.avgTimeMill))
                    return 1;
                return 0;
            }
            function sortByDateEntered() {
                $("#sortingSelected").text("DATE ENTERED");
                Questions = Questions.sort(compareDate);
                arrangeQuestions(Questions);
            }
            function sortByTotalAsked() {
                $("#sortingSelected").text("TOTAL ASKED");
                Questions = Questions.sort(compareTotalAsked);
                arrangeQuestions(Questions);
            }
            function sortBySuccess() {
                $("#sortingSelected").text("SUCCESSES");
                Questions = Questions.sort(compareSuccesses);
                arrangeQuestions(Questions);
            }
            function sortBySkip() {
                $("#sortingSelected").text("SKIPS");
                Questions = Questions.sort(compareSkips);
                arrangeQuestions(Questions);
            }
            function sortByMisses() {
                $("#sortingSelected").text("MISSES");
                Questions = Questions.sort(compareMisses);
                arrangeQuestions(Questions);
            }
            function sortByAvgTime() {
                $("#sortingSelected").text("AVG TIME");
                Questions = Questions.sort(compareAvgTime);
                arrangeQuestions(Questions);
            }


            function getQuestionsAnalytics() {
                $.ajax({
                    type: 'GET',
                    url: apiURL + 'qaanalytics',
                    crossDomain: true,
                    dataType: 'json',
                    success: function (responseData, textStatus, jqXHR) {
                        if (textStatus == "success") {
                            $("#divQuestions").empty();
                            if (responseData.length > 0) {
                                Questions = responseData;
                                //arrangeQuestion(Questions);
                                sortByDateEntered();
                                var totalSuccess = 0;
                                // var counter = 0;
                                // var qaTimeCount = 0, qaTime = 0;
                                responseData.forEach(function (qa) {
                                    // var totalAsked = qa.totalAsked;
                                    // var success = 0, skip = 0, missed = 0;

                                    // if (totalAsked != 0) {
                                    //     success = ((Number(qa.success) / totalAsked) * 100).toFixed(0);
                                    //     skip = ((Number(qa.skip) / totalAsked) * 100).toFixed(0);
                                    //     missed = ((Number(qa.missed) / totalAsked) * 100).toFixed(0);
                                    // }
                                    totalSuccess += Number(qa.success);

                                    // if (qa.avgTimeMill != null && qa.avgTimeMill != "null") {
                                    //     qaTime += parseFloat(qa.avgTimeMill);
                                    //     qaTimeCount++;
                                    // }
                                });

                                $("#spanTotalAnswered").text(totalSuccess);
                                //$("#spanAvgTimeToCompleted").text(millisToMinutesAndSeconds(qaTime / qaTimeCount));
                                $.ajax({
                                    type: 'GET',
                                    url: apiURL + 'qamainanalytics',
                                    crossDomain: true,
                                    dataType: 'json',
                                    success: function (responseData, textStatus, jqXHR) {
                                        if (textStatus == "success") {
                                            debugger;
                                            $("#spanAvgTimeToCompleted").text(millisToMinutesAndSeconds(responseData));
                                        }
                                    }
                                });
                                $.ajax({
                                    type: 'GET',
                                    url: apiURL + 'users',
                                    crossDomain: true,
                                    dataType: 'json',
                                    success: function (responseData, textStatus, jqXHR) {
                                        if (textStatus == "success") {
                                            var avganswer = (totalSuccess / responseData.length).toFixed(2);
                                            if (avganswer != NaN && avganswer != "NaN")
                                                $("#spanAvgAnswered").text(avganswer);
                                            else
                                                $("#spanAvgAnswered").text("N.A.");
                                        }
                                        $.ajax({
                                            type: 'GET',
                                            url: apiURL + 'winners',
                                            crossDomain: true,
                                            dataType: 'json',
                                            success: function (responseData, textStatus, jqXHR) {
                                                if (textStatus == "success") {
                                                    $("#spanCompleted").text(responseData.length);
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('Analytics loading failed.');
                    }
                });
            }

            function millisToMinutesAndSeconds(millis) {
                var minutes = Math.floor(millis / 60000);
                var seconds = ((millis % 60000) / 1000).toFixed(0);
                if (minutes == "NaN" || seconds == "NaN" || minutes == NaN || seconds == NaN)
                    return "N.A.";
                else
                    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
            }
        </script>
</body>

</html>