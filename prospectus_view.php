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
                            <h1>Prospectus List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Prospectus</li>
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
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('add_prospectus').style.display='block'">Add Prospectus</button>
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
    <!-- Add prospectus Modal Start-->
    <div id="add_prospectus" class="w3-modal" style="z-index:2020;">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
            <header class="w3-container" style="background:#343a40; color:white;">
                <span onclick="document.getElementById('add_prospectus').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h2 align="center">Add Prospectus</h2>
            </header>
            <form id="add_prospectus_form" role="form" method="POST">
                <div class="card-body">
                    <div class="col-md-12" id="error_section"></div>
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
							   <input type="text" id="add_prospectus_father_name" name="add_prospectus_father_name" class="form-control">  
							</div>
                            <div class="col-4">
							  <label>Mother Name</label>
							   <input type="text" id="add_prospectus_mother_name" name="add_prospectus_mother_name" class="form-control">  
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
							  <input type="text" id="add_prospectus_state" name="add_prospectus_state" class="form-control" required>  
							 <!-- <select id="add_prospectus_state" name="add_prospectus_state"  class="form-control" >-->
								<!--<option value="0">Select State</option>-->
								<!--<option value="Jharkhand">Jharkhand</option>-->
								<!--</select>				  -->
							</div>                         			  				  
							<div class="col-4">   
							 <label>City</label>
							 <input type="text" id="add_prospectus_city" name="add_prospectus_city" class="form-control" required>  
							<!--<select id="add_prospectus_city" name="add_prospectus_city"  class="form-control" >-->
							<!--	<option value="0">Select City</option>					-->
							<!--	<option value="Jamshedpur">Jamshedpur</option>-->
							<!--	<option value="Ranchi">Ranchi</option>-->
							<!--	</select>-->
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
							  <select id="add_prospectus_course_name" name="add_prospectus_course_name" class="form-control" onchange="showdesg(this.value)">
									<option value="0">Select Course</option>
									<?php 
									$sql="select * from tbl_course";
									$query=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($query)){
									?>
									<option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
									<?php } ?>
							  </select>  
							</div>
							<div class="col-4">
                                        <div class="form-group">
                                            <label>Academic Year</label>
                                            <select class="form-control" name="add_prospectus_session" id="add_prospectus_session">
                                                <option value="0">Select Academic Year</option>
                                                <?php 
                                                    $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                                                   WHERE `status` = '$visible';
                                                                   ";
                                                    $result_ac_year = $con->query($sql_ac_year);
                                                    while($row_ac_year = $result_ac_year->fetch_assoc()){
                                                ?>
                                                <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo $row_ac_year["university_details_academic_start_date"]." to ".$row_ac_year["university_details_academic_end_date"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                            </div>
						   <div class="col-4">  
							 <label>Prospectus Rate</label>
							 <select class="form-control" name="add_prospectus_rate" id="add_prospectus_rate" onchange="show(this.value)">
							 <option>Select</option>
							 </select>			
							</div> 
							<div class="col-4">
                                                 <label>Payment Mode</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <select id="add_prospectus_payment_mode" name="add_prospectus_payment_mode" class="form-control" onchange="PaymentModeSelect(this.value);">
                                                              <option value="0">Select</option>
                                                              <option value="Cash">Cash</option>
                                                              <option value="Cheque">Cheque</option>
                                                              <option value="DD">DD</option>
                                                              <option value="Online">Online</option>
                                                              <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                          </select>
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="bankName_div" style="display:none">
                                                  <label>Bank Name</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input id="add_bank_name" name="add_bank_name" type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="chequeNo_div" style="display:none">
                                                  <label>Cheque/DD/NEFT No</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input id="add_transaction_no" name="add_transaction_no" type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="cashDepositTo_div" style="display:none">
                                                  <label>Cash Deposit To</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <select id="cashDepositTo" name="cashDepositTo" class="form-control">
                                                              <option value="0">Select</option>
                                                              <option value="University Office">University Office</option>
                                                              <option value="Deposit to Bank">Deposit to Bank</option>
                                                              <option value="City Office">City Office</option>
                                                          </select>
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>

                                              <div class="col-4" id="receiptDate_div" style="display:none">
                                                  <label>Cash/Cheque/DD/NEFT Date</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input id="add_transaction_date" name="add_transaction_date" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>"/>
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                          							
						  	
						</div>
                    <input type='hidden' name='action' value='add_prospectus' />
                    <div class="col-md-12" id="loader_section"></div>
                    <button type="button" id="add_prospectus_button" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Prospectus Modal End -->
  
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
        function PaymentModeSelect(PaymentMode){
            var bankName_div = document.getElementById('bankName_div');
            var chequeNo_div = document.getElementById('chequeNo_div');
            var receiptDate_div = document.getElementById('receiptDate_div');
            var cashDepositTo_div = document.getElementById('cashDepositTo_div');
            if(PaymentMode == "Cash"){
                // cash_div.style.display = "block";
                bankName_div.style.display = "none";
                chequeNo_div.style.display = "none";
                receiptDate_div.style.display = "block";
                cashDepositTo_div.style.display = "block";
            } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                        bankName_div.style.display = "block";
                        chequeNo_div.style.display = "block";
                        receiptDate_div.style.display = "block";
                        cashDepositTo_div.style.display = "none";
                    } else{
                        bankName_div.style.display = "none";
                        chequeNo_div.style.display = "none";
                        receiptDate_div.style.display = "none";
                        cashDepositTo_div.style.display = "block";
                    }
        }
    </script>
    <script>
        $(function() {

            $('#add_prospectus_button').click(function() {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#add_prospectus_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#add_prospectus_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        $('#add_prospectus_form')[0].reset();
                        $('#error_section').append('<div id = "response">' + result + '</div>');
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#add_prospectus_button').prop('disabled', false);
                    }

                });
                $.ajax({
                    url: 'include/view.php?action=get_prospectus',
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
            $('#data_table').html('<center><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
            $.ajax({
                url: 'include/view.php?action=get_prospectus',
                type: 'GET',
                success: function(result) {
                    $("#data_table").html(result);
                }
            });
//            $('#add_course_button').click(function(){
//                $.ajax({
//                    url: 'include/view.php?action=get_courses',
//                    type: 'GET',
//                    success: function(result) {
//                        $("#data_table").html(result);
//                    }
//                });
//            });
        });
    </script>
    <script>
    function showdesg(dept) {
        $.ajax({
            url: 'ajaxdata1.php',
            type: 'POST',
            data: {depart: dept},
            success: function (data) {
                $("#add_prospectus_rate").html(data);
            },
        });
    }
</script>
</body>

</html>