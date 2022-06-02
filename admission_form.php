<?php
$page_no = "5";
$page_no_inside = "5_1";
$visible = md5("visible");
include "include/authentication.php";

if (isset($_SESSION['massage'])) {
  echo $_SESSION['massage'];
  unset($_SESSION['massage']);
}

?>
<!DOCTYPE html>
<html>
<style>
  .mrt { 13px!important; }
  </style>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NETAJI SUBHAS PUBLIC SCHOOL | Admission Form </title>
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .form-control {
      font-weight: 900 !important;
      color: #060631 !important;
    }

    .col-8,
    .col-4 {
      margin-top: 13px;
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
              <h1>Admission Form</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- SELECT2 EXAMPLE -->
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Admission Form</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
              </div>
            </div>

            <form role="form" action="include/controller.php" method="POST" id="add_admission_form" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12" id="error_section"></div>
                  
                  <div class="col-4">
                    <label>Branch</label>
                    <select id="branch" name="branch" class="form-control" required>
                      <option value="0">Select Branch</option>
                      <?php
                      $sql_branch = "select * from tbl_branch";
                      $query_branch = mysqli_query($con, $sql_branch);
                      while ($row_branch = mysqli_fetch_array($query_branch)) {
                      ?>
                        <option value="<?php echo $row_branch['id']; ?>"><?php echo $row_branch['branch_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  
                  <div class="col-4">
                    <label>Session</label>
                    <select id="session_check" class="form-control" name="session">
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
                  
                  <div class="col-4">
                    <label>Class</label>
                    <select class="form-control" id="course" name="class" onchange="showdesg(this.value)" required>
                      <option value="0">Select Class</option>
                      <?php
                      $sql = "select * from tbl_class WHERE `status` = '$visible'";
                      $query = mysqli_query($con, $sql);
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                        <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-4 mrt">
                    <div class="form-group">
                      <label>Select Section</label>
                      <select class="form-control" name="course_id" id="sem" required>
                        <option value="-1">Select</option>
                      </select>
                    </div>
                    <div class="form-group">
                    </div>
                  </div>
                  
                 <div class="col-4">

                    <?php
                    $sel = mysqli_query($con, " SELECT MAX(student_id) + 1 AS id FROM tbl_student");
                    $result = mysqli_fetch_array($sel)
                    ?>
                    <label>Roll No</label>
                    <input type="text" name="roll_no" value="<?php echo $result['id'] ?>" class="form-control">

                  </div>


                  <div class="col-4">
                    <label>Student Name</label>
                    <input id="first_name" type="text" name="student_name" class="form-control" required>
                  </div>

                  <div class="col-4">
                    <label>Date Of Birth</label>
                    <input id="dob" type="date" name="dob" class="form-control" required>
                  </div>

                  <div class="col-4">
                    <label>Nationality</label>
                    <input type="text" name="nationality" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Aadhar No</label>
                    <input type="text" name="aadhar_no" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Gender</label>
                    <select id="gender" name="gender" class="form-control">
                      <option value="0">Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="col-8">
                    <label>Full Address <i class="fa fa-map" aria-hidden="true"></i> </label>
                    <textarea type="date" placeholder="Full address of student" name="address" class="form-control"></textarea>
                  </div>
                  <div class="col-4">
                    <label>Date Of Admission </label>
                    <input type="date" name="date_of_admission" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div class="col-4">
                    <label>Profile photo <i class="fa fa-user" aria-hidden="true"></i> </label>
                    <input type="file" name="tc" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div class="col-4">
                    <label>Transfer Certificate <i class="fa fa-file" aria-hidden="true"></i></i></label>
                    <input type="file" name="photo" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                </div>
              </div>
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Parent Details</h3>
                </div>

                <div class="card-body table-responsive p-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-4">
                        <label>Father Name</label>
                        <input id="father_name" type="text" name="father_name" class="form-control">
                      </div>
                      <div class="col-4">
                        <label>Father Whatsapp No</label>
                        <input type="text" name="father_whatsappno" class="form-control">
                      </div>
                      <div class="col-4">
                        <label>Mother Name</label>
                        <input id="mother_name" type="text" name="mother_name" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div id="loader_section"></div>
              </div>
              <div class="col-md-6">
                <input type="hidden" name="action" value="add_admission" />
                <button type="submit" id="add_admission_button" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
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
    function showdesg(dept) {
      $.ajax({
        url: 'ajaxdata_sec.php',
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
    $(document).ready(function() {
      $('#form_no').on('keyup', function(event) {
        $.ajax({
          url: 'include/view.php?action=fetch_prospectus_info',
          type: 'POST',
          data: $('#add_admission_form').serializeArray(),
          success: function(result) {
            $('#first_name').val('');
            $('#last_name').val('');
            $('#gender').val('0');
            $('#father_name').val('');
            $('#address').val('');
            $('#country').val('');
            $('#state').val('');
            $('#city').val('');
            $('#postal_code').val('');
            $('#email_id').val('');
            $('#dob').val('');
            $('#mobile_no').val('');
            $('#course').val('0');
            if (result != "") {
              var fullinfo = result.split('|||');
              $('#first_name').val(fullinfo[0]);
              $('#last_name').val(fullinfo[1]);
              $('#gender').val(fullinfo[2]);
              $('#father_name').val(fullinfo[3]);
              $('#address').val(fullinfo[4]);
              $('#country').val(fullinfo[5]);
              $('#state').val(fullinfo[6]);
              $('#city').val(fullinfo[7]);
              $('#postal_code').val(fullinfo[8]);
              $('#email_id').val(fullinfo[9]);
              $('#dob').val(fullinfo[10]);
              $('#mobile_no').val(fullinfo[11]);
              $('#course').val(Number(fullinfo[12]));
              $('#session_check').val(Number(fullinfo[13]));
              $('#mother_name').val(fullinfo[14]);
            }
          }
        });
        event.preventDefault();
      });
    });
  </script>
</body>

</html>