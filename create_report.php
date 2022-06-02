<?php
$page_no = "11";
$page_no_inside = "11_6";
include "include/authentication.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Student List </title>
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }
    </style>
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
                            <h1>Student List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Student List</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Student List</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <form role="form" method="POST" id="fetchStudentDataForm">
                            <div class="card-body" style="margin-top: 0px;">
                                <div class="row">
                                    <div class="col-12" id="error_section"></div>
                                    
                                    <?php 
                                    if($_SESSION["logger_type"] == "admin"){
                                    ?>
                                   <div class="col-3">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select class="form-control" name="branch" >
                                                <option value="0">Select Branch</option>
                                                <option value="all">All</option>
                                                <?php 
                                                    $sql_branch = "SELECT * FROM `tbl_branch`;";
                                                    $result_branch = $con->query($sql_branch);
                                                    while($row_branch = $result_branch->fetch_assoc()){
                                                ?>
                                                <option value="<?php echo $row_branch["id"]; ?>"><?php echo $row_branch["branch_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Class Name</label>
                                            <select class="form-control" name="class_id" onchange="showdesg(this.value)">
                                                <option value="0" >Select Class</option>
                                                <?php
                                                $sql_course = "SELECT * FROM `tbl_class`
                                                WHERE `status` = '$visible';
                                                ";
                                                $result_course = $con->query($sql_course);
                                                while ($row_course = $result_course->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $row_course["course_id"]; ?>"><?php echo $row_course["course_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select class="form-control" name="section_id" id="sem" onchange="show(this.value)">
                                                <option value="-1" >Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-1" style="margin-top: 29px;">
                                        <button type="submit" id="fetchStudentDataButton" class="btn btn-primary">Go</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12" id="loader_section"></div>
                        <!-- /.card-header -->
                        <div class="card-body" id="data_table">

                        </div>
                    </div>

                </div>

        </div>
        </section>
        <!-- /.content -->
    </div>

    <?php include 'include/footer.php'; ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page script -->
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#fetchStudentDataForm').submit(function(event) {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#fetchStudentDataButton').prop('disabled', true);
                $.ajax({
                    url: 'include/view.php?action=fetch_student',
                    type: 'POST',
                    data: $('#fetchStudentDataForm').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        if (result == 0) {
                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                        } else {
                            $('#data_table').append('<div id = "response">' + result + '</div>');
                        }
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#fetchStudentDataButton').prop('disabled', false);
                    }
                });
                event.preventDefault();
            });
        });
    </script>
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
        function showdesg(dept) {
            $.ajax({
                url: 'ajaxdata.php',
                type: 'POST',
                data: {
                    depart: dept
                },
                success: function(data) {
                    $("#sem").html(data);
                },
            });
        }
    </script>
</body>

</html>