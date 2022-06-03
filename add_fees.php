<?php 
    $page_no = "7";
    $page_no_inside = "7_1";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Add Fees </title>
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
            <h1>Fee Payment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Fees</li>
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
            <h3 class="card-title">Add Fees</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <form role="form" method="POST" id="add_fee_form">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" id="error_section"></div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Add Fee For</label>
                     <select class="form-control" name="fee_type" required>
                     <option value="" selected disabled>Select Fee Type</option>
                      <option value="Installment & Hostel Fee">Installment & Hostel Fee</option>
                      <option value="Examination Fee">Examination Fee</option>
                  
                  </select>
                </div>
               
                <div class="form-group">                    
                </div>               
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Course Name</label>
				  <select class="form-control" name="course_id" required>
                     <option value="" selected disabled>Select Course</option>
                      <option value="all">All</option>
                   <?php 
                        $sql_course = "SELECT * FROM `tbl_course`
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
				  <select class="form-control" name="academic_year" >
                   <?php 
                        $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                       WHERE `status` = '$visible';
                                       ";
                        $result_ac_year = $con->query($sql_ac_year);
                        while($row_ac_year = $result_ac_year->fetch_assoc()){
                    ?>
                            <option value="<?php echo $row_ac_year["university_details_id"]; ?>" ><?php echo $row_ac_year["university_details_academic_start_date"]." to ".$row_ac_year["university_details_academic_end_date"]; ?></option>
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
                  <div class="col-md-12">
                       <p class="text-red">Note : If you add a Hostel Fee please write "Hostel Fee" only. Don't use any extra words.</p>
                  </div>
			     <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">  
                    <thead>
                        <tr>
                            <th data-field="S.NO" data-sortable="true" rowspan="2" >S.NO</th>
                            <th data-field="Particulars" data-sortable="true" rowspan="2">Particulars</th>
                            <th data-field="Amount" data-sortable="true" rowspan="2">Amount</th>
							<th data-field="Fine" data-sortable="true" rowspan="2">Fine</th>
							<th data-field="FeeLastDate" data-sortable="true" rowspan="2">Fee Last Date</th>
							<th data-field="Status" data-sortable="true" rowspan="2">Status</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr> 
                             <td width="5%"><input type="text" id="slno1" value="1" readonly class="form-control" style="border:none;" /></td>
                            <td width="30%"><input type="text" name="particulars[]" placeholder="Particulars" class="form-control" /></td>
                            <td width="25%"><input type="text" name="amount[]" placeholder="Amount" class="form-control"/></td>
							<td width="10%"><input type="text" name="fine[]" placeholder="Fine" class="form-control"/></td>                           
							<td width="15%"><input type="date" name="lastdate[]" placeholder="" class="form-control"/></td>
                            <td width="15%"><select name="astatus[]" class="form-control"><option value="0">Select</option><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td>          
                            <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></td>  

                        </tr> 
                    </tbody>					
                </table> 
             
			  <br>
			  <input type='hidden' name='action' value='add_fees' />
              <div class="col-md-12" id="loader_section"></div>
			  <button type="button" id="add_fee_button" class="btn btn-primary">Add</button>
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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
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
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
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

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
    $(function() {

        $('#add_fee_button').click(function() {
            $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
            $('#add_fee_button').prop('disabled', true);
            $.ajax({
                url: 'include/controller.php',
                type: 'POST',
                data: $('#add_fee_form').serializeArray(),
                success: function(result) {
                    $('#response').remove();
                    if(result == "courseempty")
                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please First Add Courses!!!</div></div>');
                    if(result == "empty")
                        $('#error_section').append('<div id = "response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out all required fields!!!</div></div>');
                    if(result == "error")
                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                    if(result == "success"){
                        $('#add_fee_form')[0].reset();
                        $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fees added successfully!!!</div></div>');
                    }
                    if(result == "update"){
                        $('#add_fee_form')[0].reset();
                        $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fees updated successfully!!!</div></div>');
                    }
                    console.log(result);
                    $('#loading').fadeOut(500, function() {
                        $(this).remove();
                    });
                    $('#add_fee_button').prop('disabled', false);
                }

            });
        });

    });

</script>

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  
   
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td><input type="text" name="particulars[]" placeholder="Particulars" class="form-control" /></td><td><input type="text" name="amount[]" placeholder="Amount" class="form-control" /></td><td><input type="text" name="fine[]" placeholder="Fine" class="form-control" /></td><td><input type="date" name="lastdate[]" placeholder="" class="form-control" /></td><td><select name="astatus[]" class="form-control"><option value="0">Select</option><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });
  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
    });  
</script>

</body>
</html>
