<?php
$page_no = "8";
$page_no_inside = "8_1";
include "include/authentication.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>NETAJI SUBHAS PUBLIC SCHOOL | Extra Income Details </title>
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
							<h1>Extra Income</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Extra Income</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-4 col-sm-6 col-12">
							<h5 style="color: #17a2b7;"><b>Admission/Fee Income</b></h5>
							<div class="info-box">
								<span class="info-box-icon bg-info" style="padding: 0px;"></span>

								<div class="info-box-content">
									<?php
									$sql = "select * from tbl_fee_paid  WHERE `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									$sum1 = 0;
									while ($row = mysqli_fetch_array($query)) {
										$sum1 = $sum1 + array_sum(explode(",", $row["paid_amount"]));
									} ?>
									<span class="info-box-text">Total Admission Income : <b><?php echo $sum1; ?></b></span>
									<?php
									$sum2 = 0;
									$sql = "select * from tbl_fee_paid WHERE payment_mode='Cash' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum2 = $sum2 + array_sum(explode(",", $row["paid_amount"]));
									}
									?>
									<span class="info-box-text">Cash Payment : <b><?php echo $sum2; ?></b></span>
									<?php
									$sum3 = 0;
									$sql = "select * from tbl_fee_paid WHERE payment_mode='Cheque' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum3 = $sum3 + array_sum(explode(",", $row["paid_amount"]));
									}
									?>
									<span class="info-box-text">Cheque Payment : <b><?php echo $sum3; ?></b></span>
									<?php
									$sum4 = 0;
									$sql = "select * from tbl_fee_paid WHERE payment_mode='DD' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum4 = $sum4 + array_sum(explode(",", $row["paid_amount"]));
									}
									?>
									<span class="info-box-text">DD Payment : <b><?php echo $sum4; ?></b></span>
									<?php
									$sum5 = 0;
									$sql = "select * from tbl_fee_paid WHERE payment_mode='Online' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum5 = $sum5 + array_sum(explode(",", $row["paid_amount"]));
									}
									?>
									<span class="info-box-text">Online Payment : <b><?php echo $sum5; ?></b></span>
									<?php
									$sum6 = 0;
									$sql = "select * from tbl_fee_paid WHERE payment_mode='NEFT/IMPS/RTGS' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum6 = $sum6 + array_sum(explode(",", $row["paid_amount"]));
									}
									?>
									<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum6; ?></b></span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<!-- /.col -->
			
						<!-- /.col -->
						<div class="col-md-4 col-sm-6 col-12">
							<h5 style="color: #ffc107;"><b>Extra Income</b></h5>
							<div class="info-box">
								<span class="info-box-icon bg-warning" style="padding: 0px;"></span>
								<div class="info-box-content">
									<?php
									$sql = "select * from tbl_extra_income WHERE  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									$sum13 = 0;
									while ($row = mysqli_fetch_array($query)) {
										$sum13 = $sum13 + array_sum(explode(",", $row["amount"]));
									} ?>
									<span class="info-box-text">Total Extra Income : <b><?php echo $sum13; ?></b></span>
									<?php
									$sum14 = 0;
									$sql = "select * from tbl_extra_income WHERE payment_mode='Cash' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum14 = $sum14 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Cash Payment : <b><?php echo $sum14; ?></b></span>
									<?php
									$sum15 = 0;
									$sql = "select * from tbl_extra_income WHERE payment_mode='Cheque' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum15 = $sum15 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Cheque Payment : <b><?php echo $sum15; ?></b></span>
									<?php
									$sum16 = 0;
									$sql = "select * from tbl_extra_income WHERE payment_mode='DD' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum16 = $sum16 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">DD Payment : <b><?php echo $sum16; ?></b></span>
									<?php
									$sum17 = 0;
									$sql = "select * from tbl_extra_income WHERE payment_mode='Online' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum17 = $sum17 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Online Payment : <b><?php echo $sum17; ?></b></span>
									<?php
									$sum18 = 0;
									$sql = "select * from tbl_extra_income WHERE payment_mode='NEFT/RTGS/IMPS' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum18 = $sum18 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum18; ?></b></span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<div class="col-md-4 col-sm-6 col-12">
							<h5 style="color: #dc3545;"><b>Expenditure</b></h5>
							<div class="info-box">
								<span class="info-box-icon bg-danger" style="padding: 0px;"></span>

								<div class="info-box-content">
									<?php
									$sql = "select * from tbl_expenses WHERE  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									$sum19 = 0;
									while ($row = mysqli_fetch_array($query)) {
										$sum19 = $sum19 + array_sum(explode(",", $row["amount"]));
									} ?>
									<span class="info-box-text">Total Expenditure : <b><?php echo $sum19; ?></b></span>
									<?php
									$sum20 = 0;
									$sql = "select * from tbl_expenses WHERE payment_mode='Cash' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum20 = $sum20 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Cash Payment : <b><?php echo $sum20; ?></b></span>
									<?php
									$sum21 = 0;
									$sql = "select * from tbl_expenses WHERE payment_mode='Cheque' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum21 = $sum21 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Cheque Payment : <b><?php echo $sum21; ?></b></span>
									<?php
									$sum22 = 0;
									$sql = "select * from tbl_expenses WHERE payment_mode='DD' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum22 = $sum22 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">DD Payment : <b><?php echo $sum22; ?></b></span>
									<?php
									$sum23 = 0;
									$sql = "select * from tbl_expenses WHERE payment_mode='Online' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum23 = $sum23 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">Online Payment : <b><?php echo $sum23; ?></b></span>
									<?php
									$sum24 = 0;
									$sql = "select * from tbl_expenses WHERE payment_mode='NEFT/RTGS/IMPS' &&  `status` = '$visible'";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$sum24 = $sum24 + array_sum(explode(",", $row["amount"]));
									}
									?>
									<span class="info-box-text">NEFT/IMPS/RTGS Payment : <b><?php echo $sum24; ?></b></span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<!-- /.col -->
					</div>
				</div>
			</section>
			<!-- /.row -->

			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<div class="float-sm-right">
									<button type="button" class="btn btn-success" onclick="document.getElementById('add_extra_income').style.display='block'">Add Extra Income</button>
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
	<!-- Add Extra Income Modal Start-->
	<div id="add_extra_income" class="w3-modal" style="z-index:2020;">
		<div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
			<header class="w3-container" style="background:#343a40; color:white;">
				<span onclick="document.getElementById('add_extra_income').style.display='none'" class="w3-button w3-display-topright">&times;</span>
				<h2 align="center">Add Extra Income</h2>
			</header>
			<form id="add_extra_income_form" role="form" method="POST">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12" id="error_section"></div>
						<div class="col-4">
							<label>Payment Date</label>
							<input type="date" id="received_date" name="received_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
						</div>
						<div class="col-4">
							<label>Particulars</label>
							<input type="text" id="particulars" name="particulars" class="form-control" value="Cheque received" required>
						</div>
						<div class="col-4">
							<label>Amount</label>
							<input type="text" id="amount" name="amount" class="form-control" required>
						</div>
						<div class="col-4">
							<label>Received From</label>
							<input type="text" id="received_from" name="received_from" class="form-control" value="Laxmi" required>

						</div>
						<div class="col-4">
							<label>Remarks</label>
							<textarea id="remarks" name="remarks" class="form-control"> </textarea>
						</div>
						<div class="col-4">
							<label>Payment Mode</label>
							<select id="paymentmode" name="payment_mode" class="form-control" onchange="PaymentMode_Select(this.value);">
								<option value="0">Select</option>
								<option value="Cash">Cash</option>
								<option value="Cheque">Cheque</option>
								<option value="DD">DD</option>
								<option value="NEFT/IMPS/RTGS">NEFT/RTGS/IMPS</option>
								<option value="Online">Online</option>
							</select>
						</div>
						<div class="col-4" id="bank_Name_div" style="display:none">
							<label>Bank Name</label>
							<div class="form-group">
								<div class="input-group">
									<input id="add_bank_name" name="bank_name" type="text" class="form-control" />
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-4" id="cheque_No_div" style="display:none">
							<label>Cheque/DD/NEFT No</label>
							<div class="form-group">
								<div class="input-group">
									<input id="add_transaction_no" name="account_number" type="text" class="form-control" />
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-4" id="receipt_Date_div" style="display:none">
							<label>Cash/Cheque/DD/NEFT Date</label>
							<div class="form-group">
								<div class="input-group">
									<input id="add_transaction_date" name="branch_name" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
								</div>
								<!-- /.input group -->
							</div>
						</div>
					</div>
					<!--<div style='display:none;' id="bank" style="padding-left: 9px;">					
							  <div class="row">
                             <div class="col-4">  
							 <label>Account No.</label>
							  <input type="text"  name="account_number"  class="form-control" >				
							</div>
							 <div class="col-4">  
							 <label>Bank Name</label>
							  <input type="text"  name="bank_name"  class="form-control">				
							</div>
                            <div class="col-4">  
							 <label>Branch Name</label>
							  <input type="text"  name="branch_name"  class="form-control" >				
							</div>
                            <div class="col-4">  
							 <label>IFSC Code</label>
							  <input type="text"  name="ifsc_code"  class="form-control">				
							</div>
							 <div class="col-4">  
							 <label>Cheque/DD/NEFT No</label>
							  <input type="text"  name="transaction_no"  class="form-control">				
							</div>
							</div>
							</div>-->

				</div></br>
				<div class="col-md-12">
					<input type='hidden' name='action' value='add_extra_income' />
					<div class="col-md-12" id="loader_section"></div>
					<button type="button" id="add_extra_income_button" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-danger">Reset</button>
				</div><br><br>
		</div>
		</form>
	</div>
	</div>
	<!-- Add Extra Income Modal End -->

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
	<script>
		function PaymentMode_Select(PaymentMode) {
			var bank_Name_div = document.getElementById('bank_Name_div');
			var cheque_No_div = document.getElementById('cheque_No_div');
			var receipt_Date_div = document.getElementById('receipt_Date_div');
			if (PaymentMode == "Cash") {
				// cash_div.style.display = "block";
				bank_Name_div.style.display = "none";
				cheque_No_div.style.display = "none";
				receipt_Date_div.style.display = "block";
			} else if (PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS") {
				bank_Name_div.style.display = "block";
				cheque_No_div.style.display = "block";
				receipt_Date_div.style.display = "block";
			} else {
				bank_Name_div.style.display = "none";
				cheque_No_div.style.display = "none";
				receipt_Date_div.style.display = "none";
			}
		}
	</script>
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

			$('#add_extra_income_button').click(function() {
				$('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
				$('#add_extra_income_button').prop('disabled', true);
				$.ajax({
					url: 'include/controller.php',
					type: 'POST',
					data: $('#add_extra_income_form').serializeArray(),
					success: function(result) {
						$('#response').remove();
						$('#add_extra_income_form')[0].reset();
						$('#error_section').append('<div id = "response">' + result + '</div>');
						$('#loading').fadeOut(500, function() {
							$(this).remove();
						});
						$('#add_extra_income_button').prop('disabled', false);
					}

				});
				$.ajax({
					url: 'include/view.php?action=get_extra_income',
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
				url: 'include/view.php?action=get_extra_income',
				type: 'GET',
				success: function(result) {
					$("#data_table").html(result);
				}
			});
		});
	</script>
</body>

</html>