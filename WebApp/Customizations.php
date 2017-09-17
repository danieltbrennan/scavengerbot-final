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
    <title>Scavengerbot - Customizations</title>
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
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
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
                        <a class="navbar-brand active" href="Customizations.php"><img src="assets/img/cust.png" /> Customizations</a>
                        <a class="navbar-brand" href="Broadcast.php"><img src="assets/img/brod.png" /> Broadcast</a>
                    </div>
                    <a class="navbar-brand" style="float:right" href="logout.php"><img src="assets/img/logout.png" /> Logout</a>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                             <!-- CODE FOR UPDATING INTRO SCRIPT, UNCOMMENT FOR IT TO REAPPEAR
                             <div class="col-md-12">
                                    <div class="card">
                                        <div class="header">
                                            <h4 class="title">Script</h4>
                                            <div class="actions"><a class="btn-simple btn-icon intro-button" href="#intro-form"><span class="ti-pencil"></span></a></div>
                                        </div>
                                        <div class="content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Intro Text</label>
                                                        <p id="lblIntroText"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Media</label>
                                                        <p id="lblIntroImg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Script</h4>
                                    <div class="actions"><a class="btn-simple btn-icon outro-button" href="#outro-form"><span class="ti-pencil"></span></a></div>
                                    <input type="hidden" id="hdnSettingId" />
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Outro Text</label>
                                                <p id="lblOutroText"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Media</label>
                                                <p id="lblOutroImg"></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Exhibit Categories</h4>
                                </div>
                                <div class="content">
                                    <div id="divCategories">
                                    </div>
                                    <div>
                                        <a class="btn  btn-success btn-icon cat-button" style="margin-top:25px;" href="#cat-form">Add Category</a>
                                    </div>
                                </div>

                                <!--Intro form-->
                                <div id="intro-form" class="content  mfp-hide white-popup-block">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="header">
                                                        <h4 class="title">Edit Script</h4>
                                                    </div>
                                                    <div class="content">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Intro Text</label>
                                                                        <input id="txtIntroText" type="text" class="form-control border-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Intro Media URL</label>
                                                                        <input id="txtIntroImg" type="text" class="form-control border-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button id="btnSaveIntro" type="button" class="btn btn-success btn-fill btn-wd">Submit</button>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Outro form-->
                                <div id="outro-form" class="content  mfp-hide white-popup-block">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="header">
                                                        <h4 class="title">Edit Script</h4>
                                                    </div>
                                                    <div class="content">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Outro Text</label>
                                                                        <input id="txtOutroText" type="text" class="form-control border-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Outro Media URL</label>
                                                                        <input id="txtOutroImg" type="text" class="form-control border-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button id="btnSaveOutro" type="button" class="btn btn-success btn-fill btn-wd">Submit</button>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category form -->
                                <div id="cat-form" class="content  mfp-hide white-popup-block">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="header">
                                                        <h4 class="title">Add Exhibit Category</h4>
                                                    </div>
                                                    <div class="content">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <input id="txtCategoryName" type="text" class="form-control border-input" placeholder="Enter category name">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button id="btnSaveCategory" type="button" class="btn btn-success btn-fill btn-wd">Submit</button>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script>
        var apiURL = "https://puamscavengerapi.herokuapp.com/";

        $(document).ready(function () {

            getSettingData();
            getCategories();

            $('.intro-button').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#txtIntroText',
                callbacks: {
                    beforeOpen: function () {
                        if ($(window).width() < 700) {
                            this.st.focus = false;
                        } else {
                            this.st.focus = '#txtIntroText';
                        }
                    }
                }
            });
            $('.outro-button').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#txtOutroText',
                callbacks: {
                    beforeOpen: function () {
                        if ($(window).width() < 700) {
                            this.st.focus = false;
                        } else {
                            this.st.focus = '#txtOutroText';
                        }
                    }
                }
            });
            $('.cat-button').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#txtCategoryName',
                callbacks: {
                    beforeOpen: function () {
                        if ($(window).width() < 700) {
                            this.st.focus = false;
                        } else {
                            this.st.focus = '#txtCategoryName';
                        }
                    }
                }
            });

            $("#btnSaveIntro").on("click", function () {
                //call api
                var data =
                    {
                        "introText": $("#txtIntroText").val(),
                        "introImage": $("#txtIntroImg").val()
                    };
                $.ajax({
                    type: 'POST',
                    url: apiURL + 'setting/' + $("#hdnSettingId").val(),
                    crossDomain: true,
                    data: data,
                    dataType: 'json',
                    success: function (responseData, textStatus, jqXHR) {
                        if (responseData._id != undefined) {
                            alert("Saved Successfully");
                            window.scrollTo(0, 0);//Set focus to first question
                            getSettingData();
                            $.magnificPopup.proto.close.call(this);
                        }
                    },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('intro text creation failed.');
                    }
                });
            });

            $("#btnSaveOutro").on("click", function () {
                //call api
                var data =
                    {
                        "outroText": $("#txtOutroText").val(),
                        "outroImage": $("#txtOutroImg").val()
                    };
                $.ajax({
                    type: 'POST',
                    url: apiURL + 'setting/' + $("#hdnSettingId").val(),
                    crossDomain: true,
                    data: data,
                    dataType: 'json',
                    success: function (responseData, textStatus, jqXHR) {
                        if (responseData._id != undefined) {
                            alert("Saved Successfully");
                            window.scrollTo(0, 0);//Set focus to first question
                            getSettingData();
                            $.magnificPopup.proto.close.call(this);
                        }
                    },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('outro text creation failed.');
                    }
                });
            });

            $("#btnSaveCategory").on("click", function () {
                //call api
                var data =
                    {
                        "name": $("#txtCategoryName").val()
                    };
                $.ajax({
                    type: 'POST',
                    url: apiURL + 'categories/',
                    crossDomain: true,
                    data: data,
                    dataType: 'json',
                    success: function (responseData, textStatus, jqXHR) {
                        if (responseData._id != undefined) {
                            alert("Saved Successfully");
                            window.scrollTo(0, 0);//Set focus to first question
                            getCategories();
                            $.magnificPopup.proto.close.call(this);
                        }
                    },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('category creation failed.');
                    }
                });
            });
        });

        function getSettingData() {
            $.ajax({
                type: 'GET',
                url: apiURL + 'settings',
                crossDomain: true,
                dataType: 'json',
                success: function (responseData, textStatus, jqXHR) {
                    if (textStatus == "success") {
                        if (responseData.length > 0) {
                            var setting = responseData[0];
                            $("#hdnSettingId").val(setting._id);
                            $("#txtIntroText").val(setting.introText);
                            $("#lblIntroText").text(setting.introText);
                            $("#txtIntroImg").val(setting.introImage);
                            $("#lblIntroImg").text(setting.introImage);
                            $("#txtOutroText").val(setting.outroText);
                            $("#lblOutroText").text(setting.outroText);
                            $("#txtOutroImg").val(setting.outroImage);
                            $("#lblOutroImg").text(setting.outroImage);
                        }
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert('Category loading failed.');
                }
            });
        }

        function getCategories() {
            $.ajax({
                type: 'GET',
                url: apiURL + 'categories',
                crossDomain: true,
                dataType: 'json',
                success: function (responseData, textStatus, jqXHR) {
                    if (textStatus == "success") {
                        if (responseData.length > 0) {
                            $("#divCategories").empty();
                            responseData.forEach(function (cateogry) {
                                var catDiv = "<div class='row'>" +
                                    "<div class='col-md-12'>" +
                                    "<div class='category'>" +
                                    "<label>" + cateogry.name + "</label>" +
                                    "<a class='delete btn-simple btn-icon btn-del' data-id='" + cateogry._id + "'><span class='ti-trash'></span></a>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>";
                                $("#divCategories").append(catDiv);
                            });
                            initializeButtonClick();
                        }
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert('Category loading failed.');
                }
            });
        }
        function initializeButtonClick() {
            $(".btn-del").on("click", function (e) {
                var id = e.currentTarget.dataset.id;
                if (id != "") {
                    var r = confirm("Are you sure you want to delete this exhibit? All questions in the exhibit will be deleted as well.");
                    if (r == true) {
                        $.ajax({
                            url: apiURL + 'category/' + id,
                            crossDomain: true,
                            type: 'DELETE',
                            success: function (result) {
                                getCategories();
                                //alert(result.message);
                            }
                        });
                    }
                }
            });
        }
    </script>

</body>

</html>