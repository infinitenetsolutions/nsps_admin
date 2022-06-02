<?php 
    $page_no = "9";
    $page_no_inside = "9_5";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Nsuniv Notifications </title>
    <!-- Fav Icon -->
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    
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
                            <h1>Notifications</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Notifications</a></li>
                                <li class="breadcrumb-item active">Notifications</li>
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
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('add_modal').style.display='block'"><i class="fa fa-plus-square"></i> Add Notification</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive" id="data_table">
                
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
        <!-- Add Modal End -->
        <div id="add_modal" class="w3-modal" style="z-index:2020;">
            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:50%; margin-bottom:100px;">
                <header class="w3-container" style="background:#8a0410; color:white;">
                    <span onclick="document.getElementById('add_modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2 align="center">Add Notification</h2>
                </header>
                <form id="addForm" role="form" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Theme</label>
                                    <select id="ThemeColor" name="ThemeColor" class="form-control">
                                        <option value="">Select Theme</option>
                                        <option value="error">Main Red Theme</option>
                                        <option value="success">Main Blue Theme</option>
                                        <option value="info">Slider Blue Theme</option>
                                        <option value="warning">Warning Theme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notifiction</label>
                                    <textarea  class="textarea" id="notification" name="notification" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="errorSection"></div>
                        <input type='hidden' name='action' value='addNotification' />
                        <button type="submit" id="addButton" name="addButton" class="btn btn-success"><span id="addLoader"></span><span id="addText">Add</span></button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Modal End -->
        <?php include 'include/footer.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            $('.textarea').summernote();
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
        $(document).ready(function() {
            $.ajax({
                url: 'include/view.php?action=get_nsuniv_notifications',
                type: 'GET',
                success: function(result) {
                    $("#data_table").html(result);
                }
            });
        });
        $('form#addForm').submit(function(event) {
            event.preventDefault();
            $('#addText').hide();
            $('#addLoader').html('<span id = "loading">Checking...</span>');
            $('#addButton').prop('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: 'include/controller.php',
                type: 'POST',
                data: formData,
                success: function(result) {
                    if(result == "success"){
                        $('#addForm')[0].reset();
                        $('#ThemeColor').removeClass("is-invalid");
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                            $('#addText').show();
                            $('#add_modal').hide();
                            $('#addButton').prop('disabled', false);
                            $("#errorSection").html('<span style="color:red;">Notification Added Successfully!!!</span>');
                            $.ajax({
                                url: 'include/view.php?action=get_nsuniv_notifications',
                                type: 'GET',
                                success: function(result) {
                                    $("#data_table").html(result);
                                }
                            });
                        });
                    } else {
                        if($('#ThemeColor').val() == ''){
                            $('#ThemeColor').addClass("is-invalid");
                        }
                        else
                            $('#ThemeColor').removeClass("is-invalid");
                       
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                            $('#addText').show();
                            $('#addButton').prop('disabled', false);
                            if(result == "empty")
                                $("#errorSection").html(result);
                            else if(result == "error")
                                    $("#errorSection").html(result);
                            else
                                $("#errorSection").html(result);
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
</body>

</html>