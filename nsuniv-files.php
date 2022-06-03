<?php 
    $page_no = "9";
    $page_no_inside = "9_6";
    include "include/authentication.php"; 
    include "include/db_class.php";
    $objectDefault = new DBEVAL();
    $objectDefault->sql = "";
    $objectDefault->hostName = "";
    $objectDefault->userName = "";
    $objectDefault->password = "";
    $objectDefault->dbName =   "";
    $objectDefault->new_db("localhost", "nsucms_demo_nsuniv", "4rp5NsX7", "nsucms_demo_nsuniv");
    $objectDefault->sql = "";
    $objectDefault->select("tbl_files");
    $objectDefault->where("`id`='1'");
    $result = $objectDefault->get();
    if($result->num_rows > 0){
        $row = $objectDefault->get_row();
    }
    $val = array("\n","\r");
    $description = str_replace($val, "", $row["description"]);
    $info = json_decode($description);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Nsuniv Files </title>
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
                            <h1>Files</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Files</a></li>
                                <li class="breadcrumb-item active">Nsuniv Files</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-danger">
                          <div class="card-header">
                            <h3 class="card-title" id="errorMessage">National Service Scheme</h3>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form id="addForm" role="form" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="">Description</label>
                                <textarea class="form-control textarea" id="description" name="description"><?= html_entity_decode($info->description); ?></textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Video (Imbaded Youtube Link Only)</label>
                                <input type="text" class="form-control" placeholder="Youtube Link" id="video" name="video" value="<?= html_entity_decode($info->video); ?>">
                              </div>
                              <div class="form-group">
                                <label for="">About The Video</label>
                                <textarea class="form-control textarea" id="aboutVideo" name="aboutVideo"><?= html_entity_decode($info->aboutVideo); ?></textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Select Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                              </div>
                            </div>
                            <!-- /.card-body -->
            
                            <div class="card-footer">
                                <input type='hidden' name='action' value='updateNss' />
                                <button type="submit" id="addButton" name="addButton" class="btn btn-success"><span id="addLoader"></span><span id="addText">Update</span></button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                          </form>
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
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->chrome

    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- page script -->
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
            $('form#addForm').submit(function(event) {
                event.preventDefault();
                $('#addText').hide();
                $('#addLoader').append('<img id = "loading" width="22px" src = "images/ajax-loader.gif" alt="Loading..." />');
                $('#addButton').prop('disabled', true);
                var formData = new FormData(this);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: formData,
                    success: function(result) {
                        if(result == "success"){
                            $('#loading').fadeOut(500, function() {
                                $(this).remove();
                                $('#addText').show();
                                $('#addButton').prop('disabled', false);
                                $("#errorMessage").html("Nss Updated Successfully...");
                                location.replace("nsuniv-files");
                            });
                        } else {
                            $('#loading').fadeOut(500, function() {
                                $(this).remove();
                                $('#addText').show();
                                $('#addButton').prop('disabled', false);
                                $("#errorMessage").html(result);
                            });
                        }
                        setTimeout(function(){ 
                            $("#errorMessage").html("National Service Scheme");
                        }, 10000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
    <!--<script>-->
    <!--    $(document).ready(function() {-->
    <!--        $.ajax({-->
    <!--            url: 'include/view.php?action=get_nsuniv_prospectus_enquiry',-->
    <!--            type: 'GET',-->
    <!--            success: function(result) {-->
    <!--                $("#data_table").html(result);-->
    <!--            }-->
    <!--        });-->
    <!--    });-->
    <!--</script>-->
</body>

</html>