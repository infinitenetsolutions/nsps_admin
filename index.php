<?php 
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
    if(isset($_SESSION["logger_type"]) && isset($_SESSION["logger_username"]) && isset($_SESSION["logger_password"]))
        echo "<script> location.replace('dashboard'); </script>";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Netaji Subhas Public School | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page" style="background-image: url('images/login.jpg');background-position: center;background-repeat: no-repeat;background-size: cover;  margin-top:-92px;">
    
    <div class="login-box">
        <div class="login-logo">
            <a href="index"><img src="images/logo.png" style="width:50%" /></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="admin_login_form" method="POST">
                   <div id="error_section"></div>
                    <div class="input-group mb-3">
                        <input type="text" id="admin_login_username" name="admin_login_username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="admin_login_password" name="admin_login_password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-info">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <input type='hidden' name='action' value='admin_login' />
                            <button type="submit" id="admin_login_button" name="admin_login_button" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <div class="col-12" id="loader_section"></div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--<p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>-->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        $(function() {

            $('#admin_login_form').submit(function( event ) {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/load.gif" alt="Currently loading" /></center>');
                $('#admin_login_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#admin_login_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        $('#admin_login_form')[0].reset();
                        $('#error_section').append('<div id = "response">' + result + '</div>');
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#admin_login_button').prop('disabled', false);
                    }

                });
                event.preventDefault();
            });

        });
    </script>

</body>

</html>