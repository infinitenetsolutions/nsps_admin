<?php 
    $page_no = "11";
    $page_no_inside = "11_3";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Exams </title>
    <!-- Fav Icon -->
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include 'include/navbar.php'; ?>
        <?php include 'include/aside.php'; ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Exam List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Exams</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-sm-right">
                                  
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('add_courses').style.display='block'">Add Exam</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="data_table">
                                
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <?php include 'include/footer.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Add Courses Modal Start-->
    <div id="add_courses" class="w3-modal" style="z-index:2020;">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
            <header class="w3-container" style="background:#343a40; color:white;">
                <span onclick="document.getElementById('add_courses').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h2 align="center">Add Exam</h2>
            </header>
            <form id="add_course_form" role="form" method="POST">
                <div class="card-body">
                    <div class="col-md-12" id="error_section"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Exam</label>
                                <input type="text" name="add_exam_name" class="form-control">
                            </div>

                            <div class="form-group">
                            </div>
                        </div>

                    </div>
                    <input type='hidden' name='action' value='add_exam' />
                    <div class="col-md-12" id="loader_section"></div>
                    <button type="button" id="add_course_button" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Courses Modal End -->
  
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

    </script>
    <script>
        $(function() {

            $('#add_course_button').click(function() {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#add_course_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#add_course_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        $('#add_course_form')[0].reset();
                        $('#error_section').append('<div id = "response">' + result + '</div>');
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#add_course_button').prop('disabled', false);
                    }

                });
                $.ajax({
                    url: 'include/view.php?action=get_exams',
                    type: 'GET',
                    success: function(result) {
                        $("#data_table").html(result);
                    }
                });

            });

        });

    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'include/view.php?action=get_exams',
                type: 'GET',
                success: function(result) {
                    $("#data_table").html(result);
                }
            });
//           
        });
    </script>
</body>

</html>
