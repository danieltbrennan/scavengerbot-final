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
    <title>Scavengerbot - Broadcast</title>
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
                        <a class="navbar-brand" href="Analytics.php"><img src="assets/img/das.png" /> Analytics</a>
                        <a class="navbar-brand " href="Questions.php"><img src="assets/img/que.png" /> Questions</a>
                        <a class="navbar-brand " href="Customizations.php"><img src="assets/img/cust.png" /> Customizations</a>
                        <a class="navbar-brand active" href="Broadcast.php"><img src="assets/img/brod.png" /> Broadcast</a>
                    </div>
                    <a class="navbar-brand" style="float:right" href="logout.php"><img src="assets/img/logout.png" /> Logout</a>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 ">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">New Push Notification</h4>
                                </div>
                                <div class="content">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <textarea id="txtPushnoteId" class="form-control border-input" placeholder="Write something here ..." rows="5" value="Mike"></textarea>
                                                    <br />
                                                    <button id="btnShubmit" type="button" class="btn btn-success btn-fill btn-wd">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 ">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">History</h4>
                                </div>
                                <div id="broadcastHistory" class="content">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <script>
        var apiURL = "https://puamscavengerapi.herokuapp.com/";
        $(document).ready(function () {

            getHistory();

            $("#btnShubmit").on("click", function () {
                var msg = $("#txtPushnoteId").val();
                if (msg != "" && msg != undefined && msg.trim().length > 0) {
                    var r = confirm("Are you sure you want to broadcast to all subscribed users?");
                    if (r == true) {
                        $.ajax({
                            type: 'POST',
                            url: apiURL + 'broadcast',
                            crossDomain: true,
                            data: {
                                "message": msg
                            },
                            dataType: 'json',
                            success: function (responseData, textStatus, jqXHR) {
                                if (responseData == 1) {
                                    //make entry to broadcast history
                                    var data =
                                        {
                                            "message": msg
                                        };
                                    $.ajax({
                                        type: 'POST',
                                        url: apiURL + 'broadcasthistory',
                                        crossDomain: true,
                                        data: data,
                                        dataType: 'json',
                                        success: function (responseData, textStatus, jqXHR) {
                                            $("#txtPushnoteId").val('');
                                            getHistory();
                                            alert("Broadcast sent successfully");
                                        },
                                        error: function (responseData, textStatus, errorThrown) {
                                            alert('Question creation failed.');
                                        }
                                    });
                                }
                            },
                            error: function (responseData, textStatus, errorThrown) {
                                alert('Question creation failed.');
                            }
                        });
                    }
                }
                else {
                    alert("Enter broadcast messsage");
                }
            });
        });

        function getHistory() {
            $.ajax({
                type: 'GET',
                url: apiURL + 'broadcasthistory',
                crossDomain: true,
                dataType: 'json',
                success: function (responseData, textStatus, jqXHR) {
                    if (textStatus == "success") {
                        if (responseData.length > 0) {
                            $("#broadcastHistory").empty();
                            responseData.forEach(function (history) {
                                var dateFormated = moment(new Date(history.createdAt)).format('MM/DD/YY hh:mm a');
                                var div =
                                    "<div class='row push-text'>" +
                                    "<div class='col-md-12'>" +
                                    "<div class='form-group'>" +
                                    "<label>" + dateFormated + "</label>" +
                                    "<p>" + history.message + "</p>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>";
                                $("#broadcastHistory").append(div);
                            });
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>