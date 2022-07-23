<?php 
    $page_no = "8";
    $page_no_inside = "8_3";
    include "include/authentication.php"; 
	error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Expenses Details </title>
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
                            <h1>Expenses</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Expenses</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


  <!-- Main content -->
    <!--<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa fa-copy"></i></span>

              <div class="info-box-content">
			    <?php
				$sql="select * from tbl_fee_paid";
				$query=mysqli_query($con,$sql);	
				$sum = 0;							
				while($row=mysqli_fetch_array($query))
				{
					$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}?>
                <span class="info-box-text">Total Admission Income : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_fee_paid WHERE payment_mode='Cash'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}
				?>
                <span class="info-box-text">Cash Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_fee_paid WHERE payment_mode='Cheque'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}
				?>
				<span class="info-box-text">Cheque Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_fee_paid WHERE payment_mode='DD'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}
				?>
				<span class="info-box-text">DD Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_fee_paid WHERE payment_mode='Online'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}
				?>
				<span class="info-box-text">Online Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_fee_paid WHERE payment_mode='NEFT/IMPS/RTGS'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["paid_amount"]));
				}
				?>
				<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum; ?></b></span>
              </div>
              
            </div>
            
          </div>
          
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-copy"></i></span>

               <div class="info-box-content">
			    <?php
				$sql="select * from tbl_prospectus";
				$query=mysqli_query($con,$sql);	
				$sum = 0;							
				while($row=mysqli_fetch_array($query))
				{
					$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}?>
                <span class="info-box-text">Total Prospectus Income : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_prospectus WHERE prospectus_payment_mode='Cash'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}
				?>
                <span class="info-box-text">Cash Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_prospectus WHERE prospectus_payment_mode='Cheque'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}
				?>
				<span class="info-box-text">Cheque Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_prospectus WHERE prospectus_payment_mode='DD'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}
				?>
				<span class="info-box-text">DD Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_prospectus WHERE prospectus_payment_mode='Online'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}
				?>
				<span class="info-box-text">Online Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_prospectus WHERE prospectus_payment_mode='NEFT/IMPS/RTGS'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["prospectus_rate"]));
				}
				?>
				<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum; ?></b></span>
              </div>
             
            </div>
           
          </div>
         
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                   <div class="info-box-content">
			    <?php
				$sql="select * from tbl_extra_income";
				$query=mysqli_query($con,$sql);	
				$sum = 0;							
				while($row=mysqli_fetch_array($query))
				{
					$sum = $sum + array_sum(explode(",", $row["amount"]));
				}?>
                <span class="info-box-text">Total Extra Income : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_extra_income WHERE through='Cash'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["amount"]));
				}
				?>
                <span class="info-box-text">Cash Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_extra_income WHERE through='Cheque'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["amount"]));
				}
				?>
				<span class="info-box-text">Cheque Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_extra_income WHERE through='DD'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["amount"]));
				}
				?>
				<span class="info-box-text">DD Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_extra_income WHERE through='Online'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["amount"]));
				}
				?>
				<span class="info-box-text">Online Payment : <b><?php echo $sum; ?></b></span>
				<?php
				$sum=0;
				$sql="select * from tbl_extra_income WHERE through='NEFT/RTGS/IMPS'";
				$query=mysqli_query($con,$sql);	
				while($row=mysqli_fetch_array($query)){
				$sum = $sum + array_sum(explode(",", $row["amount"]));
				}
				?>
				<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum; ?></b></span>
              </div>
             
            </div>
           
          </div>
         
        </div>
		</div>
		</section>-->


            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="float-sm-right">
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('add_expenses').style.display='block'">Add Expenses</button>
                                </div>
						        <div class="card-body">
                    
                               
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
    <!-- Add Extra Income Modal Start-->
    <div id="add_expenses" class="w3-modal" style="z-index:2020;">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
		
		
            <header class="w3-container" style="background:#343a40; color:white;">
                <span onclick="document.getElementById('add_expenses').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h2 align="center">Add Expenses</h2>
            </header>
            <form id="add_expenses_form" role="form" method="POST">
                <div class="card-body">
                    <div class="col-md-12" id="error_section"></div>
                        <div class="row">
						  <div class="col-md-12" id="error_section"></div>
							<div class="col-4">
							  <label>Payment Date</label>
							  <input type="date" id="payment_date" name="payment_date" class="form-control" required>
							</div>
							
							<div class="col-4">
							  <label>Particulars (Paid For)</label>
							  <input type="text" id="particulars" name="particulars" class="form-control" required>  
							</div>
							
							<div class="col-4">
							  <label>Amount</label>
							  <input type="text" id="amount" name="amount" class="form-control" required>  
							</div>
                              <div class="col-4">
							  <label>Paid To</label>
							  <input type="text" id="paid_to" name="paid_to" class="form-control" required>  
				          </div>
						  <div class="col-4">
							  <label>Remarks</label>
							  <textarea id="remarks" name="remarks" class="form-control" > </textarea> 
						  </div>			
							
							<div class="col-4">
							  <label>Payment Mode</label>
							  <select id="payment_mode" name="payment_mode" class="form-control" onchange="PaymentModeSelect(this.value);">  
							  <option value="0">Select</option>	
							  <option value="Cash">Cash</option>
							  <option value="DD">DD</option>	
                              <option value="Cheque">Cheque</option>
							  <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                              <option value="Online">Online</option>
							  </select>				  
							</div>   
                         
							 <div class="col-4" id="bankName_div" style="display:none">
                              <label>Bank Name</label>
                              <div class="form-group">
                                  <div class="input-group">
                                      <input id="bank_name" name="bank_name" type="text" class="form-control" />
                                  </div>
                                  <!-- /.input group -->
                              </div>
                          </div>
                          <div class="col-4" id="chequeNo_div" style="display:none">
                              <label>Cheque/DD/NEFT No</label>
                              <div class="form-group">
                                  <div class="input-group">
                                      <input id="transaction_no" name="transaction_no" type="text" class="form-control" />
                                  </div>
                                  <!-- /.input group -->
                              </div>
                          </div>
                          <div class="col-4" id="receiptDate_div" style="display:none">
                              <label>Cash/Cheque/DD/NEFT Date</label>
                              <div class="form-group">
                                  <div class="input-group">
                                      <input id="add_transaction_date" name="branch_name" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>"/>
                                  </div>
                                  <!-- /.input group -->
                              </div>
                          </div>
							
						</div></br>
                    <input type='hidden' name='action' value='add_expenses' />
                    <div class="col-md-12" id="loader_section"></div>
                    <button type="button" id="add_expenses_button" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Expenses Modal End -->
  
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

            $('#add_expenses_button').click(function() {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#add_expenses_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#add_expenses_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        $('#add_expenses_form')[0].reset();
                        $('#error_section').append('<div id = "response">' + result + '</div>');
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#add_expenses_button').prop('disabled', false);
                    }

                });
                $.ajax({
                    url: 'include/view.php?action=get_expenses',
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
                url: 'include/view.php?action=get_expenses',
                type: 'GET',
                success: function(result) {
                    $("#data_table").html(result);
                }
            });
        });
    </script>
    <script>
        function PaymentModeSelect(PaymentMode){
            var bankName_div = document.getElementById('bankName_div');
            var chequeNo_div = document.getElementById('chequeNo_div');
            var receiptDate_div = document.getElementById('receiptDate_div');
            if(PaymentMode == "Cash"){
                // cash_div.style.display = "block";
                bankName_div.style.display = "none";
                chequeNo_div.style.display = "none";
                receiptDate_div.style.display = "block";
            } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                        bankName_div.style.display = "block";
                        chequeNo_div.style.display = "block";
                        receiptDate_div.style.display = "block";
                    } else{
                        bankName_div.style.display = "none";
                        chequeNo_div.style.display = "none";
                        receiptDate_div.style.display = "none";
                    }
        }
    </script>
</body>

</html>