<?php
require_once('common.php');

$error = '0';

if (isset($_POST['submitBtn'])){
	// Get user input
	$password = isset($_POST['password']) ? $_POST['password'] : '';
        
	// Try to login the user
	$error = loginUserOnlyPassword($password);
}
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Scavengerbot - Login</title>
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

    </head>

    <body>
        <div class="wrapper">

            <div class="full-page login-page">

                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="ccol-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform" class="login-form">
                                    <div class="card" data-background="color" data-color="blue">
                                        <div class="card-header">
                                            <h3 class="card-title login-title">Scavenger Hunt Dashboard</h3>
                                        </div>
                                        <div class="card-content">

                                            <div class="form-group">
                                                <label class="password">Password</label>
                                                <input class="form-control input-no-border" name="password" placeholder="Enter Password" type="password">
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <input class="btn  btn-success btn-icon add-button btn-login" type="submit" name="submitBtn" value="Login" />
                                        </div>
                                    </div>
                                </form>
                                <table width="100%">
                                    <tr>
                                        <td><br/>
                                            <?php
                                                if ($error == '') {
                                                     echo "<script> location.href='index.php'; </script>";
                                                     exit;
                                                }
                                                else
                                                {
                                                    if($error != '0') echo $error;
                                                }
                                            ?>
                                                <br/><br/><br/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>

                
                <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
                <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    </body>

    </html>