<?php 
    $page_no = "11";
    $page_no_inside = "11_1";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS Public School | Add Semester </title>
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
	    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script>

    </script>

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
                            <h1>Add Section</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Add Section</li>
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
                            <h3 class="card-title">Add Section</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-success"><a href="semester_view" style="color: #fff;"> Section List</a></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <form role="form" method="POST" id="add_semester_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12" id="error_section"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Class Name</label>
                                            <select class="form-control" name="course_id">
                                                <option value="all">All</option>
                                                <?php 
                        $sql_course = "SELECT * FROM `tbl_class`
                                       WHERE `status` = '$visible';
                                       ";
                        $result_course = $con->query($sql_course);
                        while($row_course = $result_course->fetch_assoc()){
                    ?>
                                                <option value="<?php echo $row_course["course_id"]; ?>"><?php echo $row_course["course_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Academic Year</label>
                                            <select class="form-control" name="academic_year">
                                                <?php 
                        $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                       WHERE `status` = '$visible';
                                       ";
                        $result_ac_year = $con->query($sql_ac_year);
                        while($row_ac_year = $result_ac_year->fetch_assoc()){
                    ?>
                                                <?php 
					  $completeSessionStart = explode("-", $row_ac_year["university_details_academic_start_date"]);
					  $completeSessionEnd = explode("-", $row_ac_year["university_details_academic_end_date"]);
					  $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
					?>
                                                <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo $completeSessionOnlyYear ; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- /.card-header -->

                            <div class="card-body">
                                <table class="table table-bordered table-responsive" id="dynamic_field" style="overflow-y:auto;">
                                    <thead>
                                        <tr>
                                            <th data-field="S.NO" data-sortable="true" rowspan="2">S.NO</th>
                                            <th data-field="Semester" data-sortable="true" rowspan="2">Semester</th>
                                            <th data-field="Exam Fee" data-sortable="true" rowspan="2">Exam Fee</th>
                                            <th data-field="Exam Fine" data-sortable="true" rowspan="2" width=40%>Exam Fine</th>
                                            <th data-field="Exam Fee Last Date" data-sortable="true" rowspan="2">Exam Fee Last Date</th>
                                            <th data-field="Status" data-sortable="true" rowspan="2">Status</th>
                                            <th data-field="ExamName" data-sortable="true" rowspan="2">Exam Name</th>
                                            <th data-field="Name Of School" data-sortable="true" rowspan="2">Name Of School</th>
                                            <th data-field="Exam Month" data-sortable="true" rowspan="2">Exam Month</th>
                                            <th data-field="Date of Result" data-sortable="true" rowspan="2">Date of Result</th>
                                            <th rowspan="2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="5%"><input type="text" id="slno1" value="1" readonly class="form-control" style="border:none;" /></td>
                                            <td width="200%"><input type="text" name="semester[]" placeholder="Semester" class="form-control" /></td>
                                            <td width="200%"><input type="text" name="exam_fee[]" placeholder="Exam Fee" class="form-control" /></td>
                                            <td width="200%"><input type="text" name="exam_fine[]" placeholder="Exam Fine" class="form-control" /></td>
                                            <td width="200%"><input type="date" name="exam_fee_last_date[]" placeholder="" class="form-control" /></td>
                                            <td width="200%"><select name="fee_status[]" class="form-control">
                                                    <option value="0">Select</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select></td>
                                            <td width="100%"><input type="text" name="examname[]" placeholder="Exam Name" class="form-control" /></td>
                                            <td width="100%"><input type="text" name="name_of_school[]" placeholder="Name Of School" class="form-control" /></td>
                                            <td width="100%"><input type="text" name="examination_month[]" placeholder="Examination held in the month of" class="form-control" /></td>
                                            <td width="100%"><input type="date" name="date_of_result[]" placeholder="Date of publication of result" class="form-control" /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></td>

                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                                <input type='hidden' name='action' value='add_semester' />
                                <div class="col-md-12" id="loader_section"></div>
                                <button type="button" id="add_semester_button" class="btn btn-primary">Add</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                            <!-- /.card-body -->


                    </div>

                    </form>
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
	<!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <!-- Page script -->
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

        })

    </script>
    <script>
        $(function() {

            $('#add_semester_button').click(function() {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#add_semester_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#add_semester_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        if (result == "courseempty")
                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please First Add!!!</div></div>');
                        if (result == "empty")
                            $('#error_section').append('<div id = "response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out all required fields!!!</div></div>');
                        if (result == "error")
                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                        if (result == "success") {
                            $('#add_semester_form')[0].reset();
                            $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Semester added successfully!!!</div></div>');
                        }
                        if (result == "update") {
                            $('#add_semester_form')[0].reset();
                            $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Semester updated successfully!!!</div></div>');
                        }
                        console.log(result);
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#add_semester_button').prop('disabled', false);
                    }

                });
            });

        });

    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 1;

            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added" ><td><input type="text" id="slno' + i + '" value="' + i + '" readonly class="form-control" style="border:none;" /></td><td><input type="text" name="semester[]" placeholder="Semester" class="form-control" /></td><td><input type="text" name="exam_fee[]" placeholder="Exam Fee" class="form-control" /></td><td><input type="text" name="exam_fine[]" placeholder="Exam Fine" class="form-control" /></td><td><input type="date" name="exam_fee_last_date[]" placeholder="" class="form-control" /></td><td><select name="fee_status[]" class="form-control"><option value="0">Select</option><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td><td><input type="text" name="examname[]" placeholder="Exam Name" class="form-control" /></td><td><input type="text" name="name_of_school[]" placeholder="Name Of School" class="form-control" /></td><td><input type="text" name="examination_month[]" placeholder="Examination Month" class="form-control" /></td><td><input type="date" name="date_of_result[]" placeholder="Date Of Result" class="form-control" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });

    </script>
</body>

</html>
