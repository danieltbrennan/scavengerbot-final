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
    <title>Scavengerbot - Questions</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,400,400i,700,700i|Playfair+Display:400,700" rel="stylesheet">
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
                        <a class="navbar-brand active" href="Questions.php"><img src="assets/img/que.png" /> Questions</a>
                        <a class="navbar-brand " href="Customizations.php"><img src="assets/img/cust.png" /> Customizations</a>
                        <a class="navbar-brand" href="Broadcast.php"><img src="assets/img/brod.png" /> Broadcast</a>
                    </div>
                    <a class="navbar-brand" style="float:right" href="logout.php"><img src="assets/img/logout.png" /> Logout</a>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <div class="col-md-6 ">
                        <a id="Sorting" class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <p>Sorted By: <strong id="sortingSelected">DATE ENTERED</strong></p>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a onclick="sortByDateEntered();">DATE ENTERED</a></li>
                            <li><a onclick="sortByCategory();">EXHIBIT CATEGORY</a></li>
                            <li><a onclick="sortByLevel();">LEVEL</a></li>
                        </ul>
                    </div>
                    <a class='btn  btn-success btn-icon add-button' style="float:right;margin-bottom:15px" href='#add-form'>Add Question</a>
                    <div class="row">

                        <div id="divQuestions" class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>


            <!--Add form-->
            <div id="add-form" class="content  mfp-hide white-popup-block">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 left-part">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Collection API Reference</h4>
                                </div>
                                <div class="content">
                                    <form id="frmColl">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Object ID</label>
                                                    <input id="txtColObjectId" type="text" class="form-control border-input" placeholder="Collection Object API ID">
                                                    <br />
                                                    <button id="btnLookup" type="button" class="btn btn-success btn-fill btn-wd">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="divNote" class="row" style="display:none">
                                            <div class="col-md-12">
                                                <span>NOTE: <i>Missing images means the API was missing data.</i></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Title: </label><span id="spanTitle"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Maker: </label><span id="spanMarker"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Accession Number: </label><span id="spanAccNumber"></span>
                                            </div>
                                        </div>
                                        <div id="objColl">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 right-part">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Question</h4>
                                </div>
                                <div class="content">
                                    <form>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Prompt Response</label><label class="error">*</label>
                                                    <input id="txtPrompRes" type="text" class="form-control border-input" placeholder="Prompt Response">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Prompt Response Image URL</label>
                                                    <input id="txtImageUrl" type="text" class="form-control border-input" placeholder="Image Url">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Accepted Answer</label><label class="error">*</label>
                                                    <input id="txtAcceptedAns" type="text" class="form-control border-input" placeholder="Accepted Answer">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Correct Response</label><label class="error">*</label>
                                                    <input id="txtCorrectedRes" type="text" class="form-control border-input" placeholder="Correct Response">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Correct Response Image URL</label>
                                                    <input id="txtCorrectedResImg" type="text" class="form-control border-input" placeholder="Correct Response Image Url">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Incorrect Response</label><label class="error">*</label>
                                                    <input id="txtIncorrectRes" type="text" class="form-control border-input" placeholder="Incorrect Response">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Incorrect Response Image URL</label>
                                                    <input id="txtIncorrectedResImg" type="text" class="form-control border-input" placeholder="Incorrect Response Image Url">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Hint</label><label class="error">*</label>
                                                    <input id="txtHint" type="text" class="form-control border-input" placeholder="Hint">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Exhibit Category</label><label class="error">*</label>
                                                    <select id="selCategory" class="form-control border-input" placeholder="Exhibit Category"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Level</label><label class="error">*</label>
                                                    <select id="selLevel" class="form-control border-input" placeholder="Level"></select>
                                                    <!--<input id="txtLevel" type="text" class="form-control border-input" placeholder="Level">-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Object ID</label>
                                                    <input id="txtObjectId" type="text" class="form-control border-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button id="btnSave" type="button" class="btn btn-success btn-fill btn-wd">Save</button>
                                            <button id="btnUpdate" type="button" style="display:none" class="btn btn-success btn-fill btn-wd">Update</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label id="lblError" style="display:none" class="error">You must fill out all required fields.</label>
                                                </div>
                                            </div>
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

    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>

    <script>
        var apiURL = "https://puamscavengerapi.herokuapp.com/";
        
        var id = '';
        var categories = [];
        var levels = ["normal", "difficult"];
        $(document).ready(function () {
            getCategories();
            setLevels();
            //popup add form
            $('.add-button').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#txtPrompRes',
                callbacks: {
                    beforeOpen: function () {
                        $('#txtPrompRes,#txtAcceptedAns,#txtCorrectedRes,#txtCorrectedResImg,#txtIncorrectRes,#txtIncorrectedResImg,#txtHint,#txtImageUrl,#txtColObjectId,#txtObjectId').val('');
                        $('#lblError').hide();
                        $("#selCategory").val($("#selCategory option:first").val());
                        $("#selLevel").val($("#selLevel option:first").val());
                        $('#spanTitle,#spanMarker,#spanAccNumber').text('');
                        $('#objColl').empty();
                        $("#btnSave").show();
                        $("#btnUpdate").hide();
                        id = '';
                        if ($(window).width() < 700) {
                            this.st.focus = false;
                        } else {
                            this.st.focus = '#txtPrompRes';
                        }
                    }
                }
            });

            $("#btnSave").on("click", function () {
                $("#lblError").hide();
                if (ValidData() == true) {
                    //call api
                    var data =
                        {
                            "promptResponse": $("#txtPrompRes").val(),
                            "acceptedAnswer": $("#txtAcceptedAns").val(),
                            "correctResponse": $("#txtCorrectedRes").val(),
                            "correctResponseImage": $("#txtCorrectedResImg").val(),
                            "incorrectResponse": $("#txtIncorrectRes").val(),
                            "incorrectResponseImage": $("#txtIncorrectedResImg").val(),
                            "imageUrl": $("#txtImageUrl").val(),
                            "hint": $("#txtHint").val(),
                            "exhibitCategory": $("#selCategory").val(),
                            "level": Number($("#selLevel").val()),
                            "collApiObjId": $("#txtObjectId").val()
                        };
                    $.ajax({
                        type: 'POST',
                        url: apiURL + 'qas',
                        crossDomain: true,
                        data: data,
                        dataType: 'json',
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData._id != undefined) {
                                alert("Saved Successfully");
                                $('#txtPrompRes,#txtAcceptedAns,#txtCorrectedRes,#txtCorrectedResImg,#txtIncorrectRes,#txtIncorrectedResImg,#txtHint,#txtImageUrl,#txtColObjectId,#txtObjectId').val('');
                                $('#lblError').hide();
                                $("#selCategory").val($("#selCategory option:first").val());
                                $("#selLevel").val($("#selLevel option:first").val());
                                window.scrollTo(0, 0);//Set focus to first question
                                getQuestions();
                                $.magnificPopup.proto.close.call(this);
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert('Question creation failed.');
                        }
                    });
                }
                else {
                    $("#lblError").show();
                }
            });

            $("#btnUpdate").on("click", function () {
                if (ValidData() == true) {
                    //call api
                    var data =
                        {
                            "_id": id,
                            "promptResponse": $("#txtPrompRes").val(),
                            "acceptedAnswer": $("#txtAcceptedAns").val(),
                            "correctResponse": $("#txtCorrectedRes").val(),
                            "correctResponseImage": $("#txtCorrectedResImg").val(),
                            "incorrectResponse": $("#txtIncorrectRes").val(),
                            "incorrectResponseImage": $("#txtIncorrectedResImg").val(),
                            "imageUrl": $("#txtImageUrl").val(),
                            "hint": $("#txtHint").val(),
                            "exhibitCategory": $("#selCategory").val(),
                            "level": Number($("#selLevel").val()),
                            "collApiObjId": $("#txtObjectId").val()
                        };
                    $.ajax({
                        type: 'PUT',
                        url: apiURL + 'qa/' + id,
                        crossDomain: true,
                        data: data,
                        dataType: 'json',
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData._id != undefined) {
                                alert("Updated Successfully");
                                $('#txtPrompRes,#txtAcceptedAns,#txtCorrectedRes,#txtCorrectedResImg,#txtIncorrectRes,#txtIncorrectedResImg,#txtHint,#txtImageUrl,#txtColObjectId,#txtObjectId').val('');
                                $('#lblError').hide();
                                $("#selCategory").val($("#selCategory option:first").val());
                                $("#selLevel").val($("#selLevel option:first").val());
                                window.scrollTo(0, 0);//Set focus to first question
                                getQuestions();
                                $.magnificPopup.proto.close.call(this);
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert('Question creation failed.');
                        }
                    });
                }
                else {
                    $("#lblError").show();
                }
            });

            $('body').on('click', '.delete', function (e) {
                // do something
                var id = e.currentTarget.dataset.id;
                if (id != "") {
                    var r = confirm("Are you sure you want to delete this question?");
                    if (r == true) {
                        $.ajax({
                            url: apiURL + 'qa/' + id,
                            crossDomain: true,
                            type: 'DELETE',
                            success: function (result) {
                                $("#q_" + id).remove();
                                alert(result.message);
                                if ($(".card").length == 0) {
                                    $("#divQuestions").append("<h2>No questions available</h2>");
                                }
                            }
                        });
                    }
                }
            });

            $('#btnLookup').on("click", function () {
                debugger;
                var txtid = $('#txtColObjectId').val();

                if (txtid != "" && txtid != undefined) {
                    $.ajax({
                        type: 'GET',
                        url: apiURL + 'qadata/' + txtid,
                        crossDomain: true,
                        dataType: 'json',
                        success: function (responseData, textStatus, jqXHR) {
                            debugger;
                            if (textStatus == "success") {
                                var obj = responseData;
                                if (obj.displaytitle != undefined) {
                                    $("#objColl").empty();
                                    $("#divNote").show();
                                    $('#spanTitle,#spanMarker,#spanAccNumber').text('');
                                    $("#spanTitle").text(" " + obj.displaytitle);
                                    $("#spanMarker").text(" " + obj.displaymaker);
                                    $("#spanAccNumber").text(" " + obj.objectnumber);
                                    obj.media.forEach(function (media) {
                                        var media = "<div class='row'>" +
                                            "<div class='col-md-12'>" +
                                            "<img  style='height: 100px;' src='" + media.uri + "/full/400,/0/color.jpg" + "' />" +
                                            "<input  type='text' readonly='readonly' class='form-control border-input rdonly' value='" + media.uri + "/full/400,/0/color.jpg" + "'>" +
                                            "</div>" +
                                            "</div>";
                                        $("#objColl").append(media);
                                    });
                                }
                                else {
                                    $("#objColl").empty();
                                    $('#spanTitle,#spanMarker,#spanAccNumber').text('API did not return data');
                                }
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            debugger;
                            $("#objColl").empty();
                            $('#spanTitle,#spanMarker,#spanAccNumber').text('API did not return data');
                        }
                    });
                }
            });
        });

        function editpopup() {
            $('.edit-button').click(function () {
                id = $(this).data('id');
            });
            $('.edit-button').magnificPopup({
                type: 'inline',
                preloader: false,
                focus: '#txtPrompRes',
                // When elemened is focused, some mobile browsers in some cases zoom in
                // It looks not nice, so we disable it:
                callbacks: {
                    beforeOpen: function () {
                        $('#txtPrompRes,#txtAcceptedAns,#txtCorrectedRes,#txtCorrectedResImg,#txtIncorrectRes,#txtIncorrectedResImg,#txtHint,#txtImageUrl,#txtColObjectId,#txtObjectId').val('');
                        $('#lblError').hide();
                        $("#selCategory").val($("#selCategory option:first").val());
                        $("#selLevel").val($("#selLevel option:first").val());
                        $('#spanTitle,#spanMarker,#spanAccNumber').text('');
                        $('#objColl').empty();
                        if ($(window).width() < 700) {
                            this.st.focus = false;
                        } else {
                            this.st.focus = '#txtPrompRes';
                        }
                    },
                    open: function () {

                        getQuestionEditData(id);
                    },
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
                            $("#selCategory").empty();
                            responseData.forEach(function (ca) {
                                categories.push(ca);
                                $("#selCategory").append("<option value='" + ca._id + "'>" + ca.name + "</option>");
                            });
                        }
                        getQuestions();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert('Category loading failed.');
                }
            });
        }

        function setLevels() {
            $("#selLevel").empty();
            for (var index = 0; index < levels.length; index++) {
                var element = levels[index];
                $("#selLevel").append("<option value='" + (index) + "'>" + element + "</option>");
            }
        }

        function searchCategory(nameKey) {
            for (var i = 0; i < categories.length; i++) {
                if (categories[i]._id === nameKey) {
                    return categories[i];
                }
            }
        }

        var Questions = [];

        function compareDate(a, b) {
            if (new Date(a.createdDate) > new Date(b.createdDate))
                return -1;
            if (new Date(a.createdDate) < new Date(b.createdDate))
                return 1;
            return 0;
        }

        function compareCategory(a, b) {
            if (searchCategory(a.exhibitCategory).name < searchCategory(b.exhibitCategory).name)
                return -1;
            if (searchCategory(a.exhibitCategory).name > searchCategory(b.exhibitCategory).name)
                return 1;
            return 0;
        }

        function compareLevel(a, b) {
            if (a.level < b.level)
                return -1;
            if (a.level > b.level)
                return 1;
            return 0;
        }

        function sortByDateEntered() {
            $("#sortingSelected").text("DATE ENTERED");
            Questions = Questions.sort(compareDate);
            arrangeQuestions(Questions);
        }

        function sortByCategory() {
            $("#sortingSelected").text("EXHIBIT CATEGORY");
            Questions = Questions.sort(compareCategory);
            arrangeQuestions(Questions);
        }
        function sortByLevel() {
            $("#sortingSelected").text("LEVEL");
            Questions = Questions.sort(compareLevel);
            arrangeQuestions(Questions);
        }

        function getQuestions() {
            $.ajax({
                type: 'GET',
                url: apiURL + 'qas',
                crossDomain: true,
                dataType: 'json',
                success: function (responseData, textStatus, jqXHR) {
                    if (textStatus == "success") {

                        if (responseData.length > 0) {
                            Questions = responseData;
                            sortByDateEntered();
                            //arrangeQuestions(Questions);
                        }
                        else {
                            $("#divQuestions").append("<h2>No questions available</h2>");
                        }
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert('Question loading failed.');
                }
            });
        }

        function arrangeQuestions(responseData) {
            var counter = 0;
            $("#divQuestions").empty();
            responseData.forEach(function (qa) {
                var category = searchCategory(qa.exhibitCategory);
                var categoryName = "";
                if (category != undefined)
                    categoryName = category.name;
                var row = "<div id='q_" + qa._id + "' class='card'>" +
                    "<div class='header'>" +
                    "<h4 class='title'>Question #" + (++counter) + "</h4><p style class='category hide'>Collection object Id : " + qa._id + "</p>" +
                    "<div class='actions'>" +
                    "<a class='delete btn-simple btn-icon' href='#' data-id='" + qa._id + "'><span class='ti-trash'></span></a>" +
                    "<a class='btn-simple btn-icon edit-button' data-id='" + qa._id + "' href='#add-form'><span class='ti-pencil'></span></a>" +
                    "</div>" +
                    "</div>" +
                    "<div  class='content'>" +
                    "<div class='row'>" +
                    "<div class='col-md-6'>" +
                    "<div class='form-group'>" +
                    "<label>Prompt Response</label>" +
                    "<p>" + qa.promptResponse + "</p>" +
                    "<p style='word-wrap: break-word;'>Media: <i>" + (qa.imageUrl == "" ? "n/a" : qa.imageUrl) + "</i></p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Collection Object ID</label>" +
                    "<p>" + qa.collApiObjId + "</p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Exhibit Category</label>" +
                    "<p>" + categoryName + "</p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Hint</label>" +
                    "<p>" + qa.hint + "</p>" +
                    "</div>" +
                    "</div>" +


                    "<div class='col-md-6'>" +
                    "<div class='form-group'>" +
                    "<label>Accepted Answer</label>" +
                    "<p>" + qa.acceptedAnswer + "</p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Correct Response</label>" +
                    "<p>" + qa.correctResponse + "</p>" +
                    "<p style='word-wrap: break-word;'>Media: <i>" + (qa.correctResponseImage == "" ? "n/a" : qa.correctResponseImage) + "</i></p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Incorrect Response</label>" +
                    "<p>" + qa.incorrectResponse + "</p>" +
                    "<p style='word-wrap: break-word;'>Media: <i>" + (qa.incorrectResponseImage == "" ? "n/a" : qa.incorrectResponseImage) + "</i></p>" +
                    "</div>" +
                    "<div class='form-group'>" +
                    "<label>Level</label>" +
                    "<p>" + levels[qa.level] + "</p>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div></div>";

                $("#divQuestions").append(row);
            });

            editpopup();
        }

        function getQuestionEditData(id) {
            if (id != "" && id != undefined) {
                $.ajax({
                    type: 'GET',
                    url: apiURL + 'qa/' + id,
                    crossDomain: true,
                    dataType: 'json',
                    success: function (responseData, textStatus, jqXHR) {
                        if (responseData._id != undefined && responseData._id != "") {
                            $("#txtPrompRes").val(responseData.promptResponse);
                            $("#txtAcceptedAns").val(responseData.acceptedAnswer);
                            $("#txtCorrectedRes").val(responseData.correctResponse);
                            $("#txtIncorrectRes").val(responseData.incorrectResponse);
                            $("#txtCorrectedResImg").val(responseData.correctResponseImage);
                            $("#txtIncorrectedResImg").val(responseData.incorrectResponseImage);
                            $("#txtImageUrl").val(responseData.imageUrl);
                            $("#txtHint").val(responseData.hint);
                            $("#selCategory").val(responseData.exhibitCategory);
                            $("#selLevel").val(responseData.level);
                            //$("#txtColObjectId").val(responseData.collApiObjId);
                            $("#txtColObjectId").val('');
                            $("#txtObjectId").val(responseData.collApiObjId);
                            $("#btnSave").hide();
                            $("#btnUpdate").show();
                        }
                    },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('Question loading failed.');
                    }
                });
            }
        }

        //Validation
        function ValidData() {
            var isValid = true;
            if ($("#txtPrompRes").val() == undefined || $("#txtPrompRes").val() == "")
                isValid = false;

            if ($("#txtAcceptedAns").val() == undefined || $("#txtAcceptedAns").val() == "")
                isValid = false;

            if ($("#txtCorrectedRes").val() == undefined || $("#txtCorrectedRes").val() == "")
                isValid = false;

            if ($("#txtIncorrectRes").val() == undefined || $("#txtIncorrectRes").val() == "")
                isValid = false;

            if ($("#txtHint").val() == undefined || $("#txtHint").val() == "")
                isValid = false;

            if ($("#selCategory").val() == undefined || $("#selCategory").val() == "")
                isValid = false;

            if ($("#selLevel").val() == undefined || $("#selLevel").val() == "")
                isValid = false;

            return isValid;
        }
    </script>
</body>

</html>