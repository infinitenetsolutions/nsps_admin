<?php 
    $page_no = "4";
    $page_no_inside = "4_1";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Prospectus </title>
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
            <h1>Prospectus Form</h1>
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
         <!-- <div class="card-header">
            <h3 class="card-title">Prospectus Form</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>-->
			
          <form role="form" action="" method="POST" id="prospectus_form">                           
          <div class="card-body">
            <div class="row">
			  <div class="col-md-12" id="error_section"></div>
			    <div class="col-4">
                  <label>Prospectus No.</label>
				  <input type="text" id="add_prospectus_no" name="add_prospectus_no" class="form-control" required>
                </div>
                
				<div class="col-4">
                  <label>Applicant Name</label>
                  <input type="text" id="add_prospectus_applicant_name" name="add_prospectus_applicant_name" class="form-control" required>  
                </div>
				
                <div class="col-4">
                  <label>Gender</label>
                  <select id="add_prospectus_gender" name="add_prospectus_gender" class="form-control">  
                  <option value="0">Select</option>	
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>				  
                  </select>				  
                </div>               
              
                <div class="col-4">
                  <label>Father Name</label>
                   <input type="text" id="add_prospectus_father_name" name="add_prospectus_father_name" class="form-control" required>  
                </div>
			  
                <div class="col-4">
                  <label>Address</label>
                  <textarea id="add_prospectus_address" name="add_prospectus_address" class="form-control" style="height:38px;"></textarea>  
                </div>
				<div class="col-4">
                  <label>Country</label>
                  <select id="add_prospectus_country" name="add_prospectus_country" class="form-control">  
                  <option value="India">India</option>					  
                  </select>	 
              </div>
                <div class="col-4"> 
                  <label>State</label>
                  <select id="add_prospectus_state" name="add_prospectus_state"  class="form-control" >
					<option value="0">Select State</option>
					<option value="Jharkhand">Jharkhand</option>
					</select>				  
                </div>                         			  				  
                <div class="col-4">   
                 <label>City</label>
                <select id="add_prospectus_city" name="add_prospectus_city"  class="form-control" >
					<option value="0">Select City</option>					
					<option value="Jamshedpur">Jamshedpur</option>
					<option value="Ranchi">Ranchi</option>
					</select>
					</div>                           
			  
			  <div class="col-4">
                  <label>Postal Code</label>
                  <input type="text" id="add_prospectus_postal_code" name="add_prospectus_postal_code" class="form-control" >  
                </div>
               <div class="col-4">   
                 <label>Email ID</label>
                  <input type="email" id="add_prospectus_emailid" name="add_prospectus_emailid" class="form-control" required>				
                </div>                           
			  
			  <div class="col-4">
                  <label>DOB</label>
                  <input type="date" id="add_prospectus_dob" name="add_prospectus_dob" class="form-control" required>  
                </div>
                <div class="col-4">  
                 <label>Mobile No</label>
                  <input type="text" id="mobile" name="mobile" class="form-control" required>				              
              </div>
			  
			    <div class="col-4">
                  <label>Course</label>
                  <select id="add_prospectus_course_name" name="add_prospectus_course_name" class="form-control">
						<option value="0">Select Course</option>
						<?php 
						$sql="select * from tbl_course";
						$query=mysqli_query($con,$sql);
						while($row=mysqli_fetch_array($query)){
						?>
                        <option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
					    <?php } ?>
				  </select>  
                </div>
               <div class="col-4">  
                 <label>Prospectus Rate</label>
                  <input type="text" id="add_prospectus_rate" name="add_prospectus_rate" value="550" class="form-control" readonly>				
                </div> 
				
              <div class="col-4">
                  <label>Ledger Type</label>
                  <select id="add_prospectus_ledger_type" name="add_prospectus_ledger_type" class="form-control">
					<option value="0">Select Ledger Type</option>
					<option value="Admission Ledger">Admission Ledger</option>	
					<option value="Prospectus Ledger">Prospectus Ledger</option>
					</select> 
                </div>					
              <div class="col-4" style="margin-bottom: 20px;">  
                 <label>Payment Mode</label>
                  <select id="add_prospectus_payment_mode" name="add_prospectus_payment_mode" class="form-control">
					<option value="0">Select Mode</option>
					<option value="Cash">Cash</option>	
					<option value="Online">Online</option>
					<option value="Cheque">Cheque</option>
					<option value="DD">DD</option>
					<option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
					</select> 				
                </div>              
            </div>
			<div class="col-md-12">
				<div id="loader_section"></div>
			</div>
			<div class="col-md-6">
				<input type="hidden" name="action" value="prospectus_form" />
				 <input type="button" id="prospectus_form_button" name="prospectus_form_button" class="btn btn-primary" value="Submit">
  
				<button type="reset" class="btn btn-primary">Reset</button>
			</div>
          </div>
		  
		  </form>
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
<!-- Contact Form Section -->
<script>
    $(function(){

        $('#prospectus_form_button').click(function(){
           // $('#loader_section').append('<center><img width="50px" src = "images/icons/loader2.gif" alt="Currently loading" id = "loading" /></center>');
            $('#prospectus_form_button').prop('disabled', true);
            $.ajax({
                url: 'include/controller.php',
                type: 'POST',
                data: $('#prospectus_form').serializeArray(),
                success: function(result){
                    $('#response').remove();
                    $('#prospectus_form')[0].reset();
                    $('#error_section').append('<p id = "response" class="first-title">' + result + '</p>');
                    $('#loading').fadeOut(500, function(){
                         $(this).remove();
                    });
                    $('#prospectus_form_button').prop('disabled', false);
                }

            });         

        });

    });
</script>
</body>
</html>
