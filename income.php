<?php
$page_no = "8";
$page_no_inside = "8_2";
//authentication start
//Starting Session
if (empty(session_start()))
	session_start();
//Logger Type
$logger_type = $_SESSION["logger_type"];
if ($logger_type == "subadmin")
	$autority = $_SESSION["authority"];

//DataBase Connectivity
include "include/config.php";
$idle_time = 1200;
$visible = md5("visible");
$trash = md5("trash");
if (time() - $_SESSION["logger_time"] > $idle_time) {
	unset($_SESSION["logger_time"]);
	unset($_SESSION["logger_type"]);
	unset($_SESSION["logger_username"]);
	unset($_SESSION["logger_password"]);
	echo "<script> location.replace('index'); </script>";
} else {
	$_SESSION["logger_time"] = time();
}
if (!isset($_SESSION["logger_type"]) && !isset($_SESSION["logger_username"]) && !isset($_SESSION["logger_password"]))
	echo "<script> location.replace('index'); </script>";
$flag = 0;
if (isset($autority)) {
	$allAutority = json_decode($autority);
	if ($page_no != 1) {
		if (isset($allAutority->$page_no)) {
			$subMenus = explode("||", $allAutority->$page_no);
			for ($i = 0; $i < count($subMenus); $i++) {
				if ($subMenus[$i] == $page_no_inside) {
					$flag++;
					break;
				}
			}
			if ($flag == 0) {
				echo "<script>
                           location.replace('dashboard');
                       </script>";
			}
		} else
			echo "<script>
                           location.replace('dashboard');
                       </script>";
	}
}
//authentication end
//export start
$query = "SELECT * FROM `tbl_income` ORDER BY post_at DESC, id DESC";
$results = mysqli_query($con, $query) or die("database error:" . mysqli_error($con));
$allOrders = array();
while ($order = mysqli_fetch_assoc($results)) {
	$no = 1;
	$allOrders[] = $order;
}
$startDateMessage = '';
$endDate = '';
$noResult = '';
if (isset($_POST["export"])) {
	if (empty($_POST["fromDate"])) {
		$startDateMessage = '<label class="text-danger">Select start date.</label>';
	} else if (empty($_POST["toDate"])) {
		$endDate = '<label class="text-danger">Select end date.</label>';
	} else {
		$orderQuery = "
		SELECT * FROM tbl_income 
		WHERE  post_at >= '" . $_POST["fromDate"] . "' AND post_at <= '" . $_POST["toDate"] . "' ORDER BY post_at DESC, id DESC";
		$orderResult = mysqli_query($con, $orderQuery) or die("database error:" . mysqli_error($con));
		$filterOrders = array();
		while ($order = mysqli_fetch_assoc($orderResult)) {
			$filterOrders[] = $order;
		}
		if (count($filterOrders)) {
			if ($_POST["toDate"] == $_POST["fromDate"])
				$fileName = "Income-Report-" . date('d-m-Y', strtotime($_POST["toDate"])) . ".csv";
			else
				$fileName = "Income-Report-From-" . date('d-m-Y', strtotime($_POST["fromDate"])) . "-To-" . date('d-m-Y', strtotime($_POST["toDate"])) . ".csv";
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$fileName");
			header("Content-Type: application/csv;");
			$file = fopen('php://output', 'w');
			$header = array("S.No", "Date Of Entry", "Reg.No", "Name", "Course", "Session", "Particulars", "Amount", "Payment Mode", "Cheque/DD/Online No", "Payment Date", "Bank Name", "Remarks");
			fputcsv($file, $header);
			foreach ($filterOrders as $order) {
				if ($order["amount"] != "") {
					$orderData = array();
					$orderData[] = $no++;
					$orderData[] = date("d-m-Y", strtotime($order["post_at"]));
					$orderData[] = $order["reg_no"];
					$sql_name = "SELECT * FROM `tbl_admission` WHERE `admission_id` = '" . $order["reg_no"] . "' ";
					$result_name = $con->query($sql_name);
					$row_name = $result_name->fetch_assoc();
					$remove_prospectus = str_replace("(Form No)", "", $order["reg_no"]);
					$sql_name1 = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '" . $remove_prospectus . "'  ";
					$result_name1 = $con->query($sql_name1);
					$row_name1 = $result_name1->fetch_assoc();
					if (strpos($order["reg_no"], "Extra Income") === false)
						$orderData[] = " " . strtoupper($row_name["admission_first_name"]) . " " . strtoupper($row_name["admission_middle_name"]) . " " . strtoupper($row_name["admission_last_name"]) . " " . strtoupper($row_name1["prospectus_applicant_name"]);
					else
						$orderData[] =  " " . $order["particulars"] . " From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])));
					$sql_course = "SELECT * FROM `tbl_course` WHERE `course_id` = '" . $order["course"] . "' ";
					$result_course = $con->query($sql_course);
					$row_course = $result_course->fetch_assoc();
					$orderData[] = $row_course["course_name"];
					$sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '" . $order["academic_year"] . "' ";
					$result_session = $con->query($sql_session);
					$row_session = $result_session->fetch_assoc();
					$orderData[] = intval($row_session["university_details_academic_start_date"]) . " - " . intval($row_session["university_details_academic_end_date"]);
					$orderData[] = strtoupper($order["particulars"]);
					$orderData[] = $order["amount"];
					$orderData[] = $order["payment_mode"];
					$orderData[] = $order["check_no"];
					$orderData[] = date("d-m-Y", strtotime($order["received_date"]));
					$orderData[] = $order["bank_name"];
					fputcsv($file, $orderData);
				}
			}
			fclose($file);
			exit;
		} else {
			$noResult = '<label class="text-danger">There are no record exist with this date range to export. Please choose different date range.</label>';
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>NETAJI SUBHAS PUBLIC SCHOOL | Income Details </title>
	<!-- Fav Icon -->
	<link rel="icon" href="images/logo.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script src="build/js/datepickers.js"></script>
	<style>
		.dtHorizontalExampleWrapper {
			max-width: 600px;
			margin: 0 auto;
		}

		#dtHorizontalExample th,
		td {
			white-space: nowrap;
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
							<h1>Income</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Income</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
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
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-12">

						<div class="card">
							<div class="card-header">
								<div class="float-sm-right">
									<!-- <button type="button" class="btn btn-success" onclick="document.getElementById('add_expenses').style.display='block'">Add Expenses</button>-->
								</div>
								<form method="post">
									<div class="input-daterange">
										<div class="col-md-12">
											<div class="row">
												<div class="col-2">
													From<input type="text" name="fromDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly />
													<?php echo $startDateMessage; ?>
												</div>
												<div class="col-2">
													To<input type="text" name="toDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly />
													<?php echo $endDate; ?>
												</div>
												<div class="col-2">
													<div>&nbsp;</div>
													<button type="submit" name="export" class="btn btn-info"> Export to CSV </button>
												</div>
											</div>
										</div>

								</form>
								</form>
								<div class="row">
									<div class="col-md-8">
										<?php echo $noResult; ?>
									</div>
								</div>
								<div class="card-body">

									<table id="dtHorizontalExample" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>S.No</th>
												<th>Date</th>
												<th>Reg No/Form No</th>
												<th>Name</th>
												<th>Course</th>
												<th>Session</th>
												<th>Particulars</th>
												<th>Amount</th>
												<th>Payment Mode</th>
												<th>Cheque/DD/Online No</th>
												<th>Payment Date</th>
												<th>Bank Name</th>
												<th>Remarks</th>
											</tr>
										</thead>
										<tbody>
											<?php $s_no = 1;
											foreach ($allOrders as $order) {
												if ($order["amount"] != "") {
											?>
													<tr>
														<td><?php echo $s_no; ?></td>
														<td><?php echo date("d-m-Y", strtotime($order["post_at"])); ?></td>
														<td>
															<?php
															if (strpos($order["reg_no"], "Extra Income") === false)
																echo $order["reg_no"];
															else
																echo "Extra Income";
															?>

														</td>
														<?php
														if (strpos($order["reg_no"], "Extra Income") === false) {
															$remove_admission = str_replace("(Reg No)", "", $order["reg_no"]);
														 	$sql_name = "SELECT * FROM `tbl_student` WHERE `student_id` = '" . $remove_admission . "' ";
															$result_name = $con->query($sql_name);
															if ($result_name->num_rows > 0) {
																$row_name = $result_name->fetch_assoc();
														?>
																<td><?php echo strtoupper($row_name["student_name"]) ?></td>
															<?php

															} else {
																$remove_prospectus = str_replace("(Form No)", "", $order["reg_no"]);
																$sql_name1 = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '" . $remove_prospectus . "' ";
																$result_name1 = $con->query($sql_name1);
																$row_name1 = $result_name1->fetch_assoc();
															?>
																<td><?php echo strtoupper($row_name1["prospectus_applicant_name"]); ?></td>
														<?php
															}
														} else {
															echo "<td> " . strtoupper("From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])))) . " </td>";
														}
														?>

														<?php
														$sql_course = "SELECT * FROM `tbl_class` WHERE `course_id` = '" . $order["course"] . "' ";
														$result_course = $con->query($sql_course);
														$row_course = $result_course->fetch_assoc();
														?>
														<td><?php echo $row_course["course_name"]; ?></td>
														<?php
														$sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '" . $order["academic_year"] . "' ";
														$result_session = $con->query($sql_session);
														$row_session = $result_session->fetch_assoc();
														?>
														<td><?php echo intval($row_session["university_details_academic_start_date"]) . " - " . intval($row_session["university_details_academic_end_date"]); ?></td>
														<td><?php
															if (strpos($order["reg_no"], "Extra Income") === false)
																echo strtoupper($order["particulars"]);
															else
																echo " " . $order["particulars"] . " From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])));
															?>

														</td>
														<td><?php echo $order["amount"]; ?></td>
														<td><?php echo $order["payment_mode"]; ?></td>
														<td><?php echo  $order["check_no"]; ?></td>
														<td><?php echo date("d-m-Y", strtotime($order["received_date"])); ?></td>
														<td><?php echo $order["bank_name"]; ?></td>
														<td><?php echo $row["remarks"]; ?></td>

													</tr>
											<?php
													$s_no++;
												}
											}

											?>
										</tbody>
										<?php
										$sum170 = 0;
										$sql = "select * from tbl_income WHERE 1";
										$query = mysqli_query($con, $sql);
										while ($row = mysqli_fetch_array($query)) {
											$sum170 = $sum170 + array_sum(explode(",", $row["amount"]));
										}
										?>
										<tfoot>
											<tr>
												<th>
													Overall Total Income- <?php echo $sum170 ?>												</th>
											</tr>
										</tfoot>
									</table>

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

	<!-- jQuery -->
	<!--<script src="plugins/jquery/jquery.min.js"></script>-->
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
		$(document).ready(function() {
			$('#dtHorizontalExample').DataTable({
				"scrollX": true
			});
			$('.dataTables_length').addClass('bs-select');
		});
	</script>
</body>

</html>