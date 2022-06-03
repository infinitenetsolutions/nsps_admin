<?php
if (isset($_SESSION['MSG'])) {
  // echo "test";
  echo "
        <script>
        $('#error_section').append(<div id = 'response'><div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fas fa-check'></i> Subject added successfully!!!</div></div>)
        </script>";
}



$page_no = "7";
$page_no_inside = "7_1";
include "include/authentication.php";
$visible = md5("visible");
date_default_timezone_set("Asia/Calcutta");
$date_variable_today_month_year_with_timing = date("d M, Y. h:i A");

$sql11 = "SELECT * FROM `tbl_branch` WHERE 1";
$result11 = $con->query($sql11);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NETAJI SUBHAS PUBLIC SCHOOL | Add Fee</title>
  <link rel="icon" href="images/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fa-fa icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- multiselect start -->
  <link rel="stylesheet" type="text/css" href="css/example-styles.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/demo-styles.css"> -->
  <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="js/jquery.multi-select.js"></script>
  <!-- multiselect end -->


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
              <h1>Add Fee</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Fee</li>
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
              <h3 class="card-title">Add Fee</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-success"><a href="fee_details" style="color:#fff;">Fee List</a></button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
              </div>
            </div>
            <br>

            <form role="form" method="POST" id="add_subjects_form">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12" id="error_section"></div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Class Name</label>
                      <select class="form-control" name="class_id" onchange="showdesg(this.value)">
                        <option value="0">Select Class</option>
                        <?php
                        $sql_course = "SELECT * FROM `tbl_class` WHERE `status` = '$visible';";
                        $result_course = $con->query($sql_course);
                        while ($row_course = $result_course->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $row_course["course_id"]; ?>"><?php echo $row_course["course_name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Section</label>
                      <select class="form-control" name="section_id" id="sem">
                        <option value="-1">Select</option>
                      </select>
                    </div>
                    <div class="form-group">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Branch Name</label> <br>
                      <select class="form-control" id="people" name="branch[]" multiple>
                        <option selected disabled>Select Branch</option>
                        <?php
                        $sql_course = "SELECT * FROM `tbl_branch` WHERE 1";
                        $result_course = $con->query($sql_course);
                        while ($row_course = $result_course->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $row_course['id']; ?>"><?php echo $row_course['branch_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <label>Session</label>
                    <select id="session_check" class="form-control" name="academic_year">
                      <option selected disabled>Select Academic Year</option>
                      <?php
                      $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                       WHERE `status` = '$visible';
                                       ";
                      $result_ac_year = $con->query($sql_ac_year);
                      while ($row_ac_year = $result_ac_year->fetch_assoc()) {


                      ?>
                        <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo date("Y", strtotime($row_ac_year["university_details_academic_start_date"])) . " -  " . date("Y", strtotime($row_ac_year["university_details_academic_end_date"])); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

              </div>

              <!-- /.card-header -->

              <div class="card-body">
                <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">
                  <thead>
                    <tr>
                      <th data-field="S.NO" data-sortable="true" rowspan="2">S.no</th>
                      <th data-field="fee_name" data-sortable="true" rowspan="2">Add Particulars</th>
                      <th data-field="fee" data-sortable="true" rowspan="2">Add Fee</th>
                      <th data-field="ExamDate" data-sortable="true" rowspan="2">Last Date</th>
                      <th data-field="FullMarks" data-sortable="true" rowspan="2">Fine Amount</th>
                      <th data-field="PassMarks" data-sortable="true" rowspan="2">Tennure</th>
                      <th rowspan="2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="5%"><input type="text" id="slno1" value="1" readonly class="form-control" style="border:none;" /></td>
                      <td width="20%"><input type="text" name="fee_name[]" placeholder="Particular" class="form-control" /></td>
                      <td width="10%"><input type="text" name="fee[]" placeholder="Fee" class="form-control" /></td>
                      <td width="5%"><input type="date" name="last_date[]" placeholder="Last Date" class="form-control" /></td>
                      <td width="10%"><input type="number" name="fine[]" placeholder="Fine" class="form-control" /></td>
                      <td width="22%">
                        <select class="form-control" name="tennure[]">
                          <option value="#" selected disabled>Select Tennure</option>
                          <option value="monthly">Monthly</option>
                          <option value="quarterly">Quarterly</option>
                          <option value="weekly">Weekly</option>
                          <option value="daily">Daily</option>
                        </select>
                      </td>
                      <!-- <td width="22%">
                            <select id="branch" name="branch[]" multiple class="form-control" class="multi">
                                    <option value="#" disabled>Select Branch</option>
                                    <?php
                                    $sql = "SELECT * FROM `tbl_branch` WHERE 1";
                                    $result = $con->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['branch_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td> -->

                      <!-- <input type="number" name="pass_marks[]" placeholder="Tennure Marks" class="form-control"/>-->

                      <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></td>

                    </tr>
                  </tbody>
                </table>

                <br>
                <input type='hidden' name='action' value='add_fee' />
                <div class="col-md-12" id="loader_section"></div>
                <button type="button" id="add_subjects_button" class="btn btn-primary">Add</button>
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

  <!-- modal start -->
  <div class="row" id="facultyData">

  </div>
  <!-- modal end -->

  <!-- <script src="plugins/jquery/jquery.min.js"></script> -->
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


  <script>
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
  </script>

  <script>
    $(document).ready(function() {
      $('#fetchStudentDataForm').submit(function(event) {
        $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
        $('#fetchStudentDataButton').prop('disabled', true);
        $.ajax({
          url: 'include/view.php?action=get_sub',
          type: 'POST',
          data: $('#fetchStudentDataForm').serializeArray(),
          success: function(result) {
            if (result == 0) {
              $('#response').remove();
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
  <script>
    $(function() {

      $('#add_subjects_button').click(function() {
        $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
        $('#add_subjects_button').prop('disabled', true);
        $.ajax({
          url: 'include/controller.php',
          type: 'POST',
          data: $('#add_subjects_form').serializeArray(),
          success: function(result) {
            $('#loading').fadeOut(500, function() {
              $(this).remove();
            });
            $(result).modal({
              show: true
            });
            $('#add_subjects_button').prop('disabled', false);
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
        $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added" ><td><input type="text" id="slno' + i + '" value="' + i + '" readonly class="form-control" style="border:none;" /></td><td><input type="text" name="fee_name[]" placeholder="Particular" class="form-control" /></td><td><input type="text" name="fee[]" placeholder="Fee" class="form-control"/></td> <td width="10%"><input type="date" name="last_date[]" placeholder="Last Date" class="form-control"/></td><td width="15%"><input type="number" name="fine[]" placeholder="Fine" class="form-control"/></td><td width="22%"><select class="form-control" name="tennure[]"><option value="#" selected disabled>Select Tennure</option><option value="monthly">Monthly</option><option value="quarterly">Quarterly</option><option value="weekly">Weekly</option><option value="daily">Daily</option></select></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
      });

      $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
      });

    });
  </script>

  <script type="text/javascript">
    $(function() {
      $('#people').multiSelect();
    });
  </script>

</body>

</html>