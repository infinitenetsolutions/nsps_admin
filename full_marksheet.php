<?php
$page_no = "11";
    $page_no_inside = "11_7";
include "include/authentication.php";
$path = 'images/';
   
	$sql = "SELECT * FROM `tbl_allot_semester` 
	INNER JOIN `tbl_student` ON `tbl_allot_semester`.`reg_no` = `tbl_student`.`reg_no`
	INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
	WHERE `tbl_student` .`reg_no` = '".$_GET['id']."' ";			
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	
	$sql_course = "SELECT * FROM `tbl_course`
				   WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
				   ";
	$result_course = $con->query($sql_course);
	$row_course = $result_course->fetch_assoc();	                            
	
	$completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
	$completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
	$completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];

	if (isset($_GET['id'])) {
		
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval('refreshPage()', 1301000);
    });

    function refreshPage() {
        location.reload();
    }
</script><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Print Receipt </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .table td, .table th {
            padding: 0.5rem !important;
        }
		.qr-code {position: relative;}
        .qr-code img {position: absolute; top: 0px; left: 50px;}
    </style>
</head>

<body>
        <div class="wrapper" style="padding: 20px;">
            <!-- Main content -->
            <section class="invoice" style="border: 5px solid #c70013; position: relative;">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-2">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-3">
                                    <h4 class="text-center">
                                        <img src="images/logo.png" width="100%" alt="Image" border="0" title="Images" style="-webkit-filter: drop-shadow(5px 5px 5px #222 ); filter: drop-shadow(5px 5px 5px #222);">
                                    </h4>
                                </div>
                                <div class="col-7">
                                    <div class="text-center mt-5" style="font-family: Times New Roman;">
                                        <h1 class="text-bold">NETAJI SUBHAS PUBLIC SCHOOL</h1>
                                        <p>POKHARI, P.O : BHILAI PAHARI, P.S : M.G.M Dist : EAST SINGHBHUM,<br /> JAMSHEDPUR - 831012 Jharkhand. Contact - (+91) 9835203429 <br />Visit : https://nsuniv.ac.in/</p>
                                    </div>
                                </div>
                                <div class="col-2 pt-1">
                                    <h5>
                                        <small class="float-right">Sl No: .................../2019</small>
                                    </h5>
                                </div>
                                <!-- /.col -->
                            </div>
                            <hr class="mt-0 mb-3" />
                            <!-- info row -->
                            <div class="row invoice-info mb-3 pr-4 pl-4">
                                <!--<div class="col-sm-12 mb-3 invoice-col">
                                    <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">STUDENT FEE CARD ~</h4>
                                </div>-->
                                <div class="col-sm-2 invoice-col">
                                    <p style="font-family: Times New Roman;">
                                        <strong>Registration No.</strong><br>
                                        <strong>Course</strong><br>
                                        <strong>Academic Session</strong><br>
                                    </p>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <p style="font-family: Times New Roman;">
                                        ~<span class="ml-3"> <?php echo $row["reg_no"] ?></span><br>
                                        ~<span class="ml-3"> <?php echo $row_course["course_name"] ?></span><br>
                                        ~<span class="ml-3"> <?php echo $completeSessionOnlyYear ; ?></span><br>
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 invoice-col">
                                    <p style="font-family: Times New Roman;">
                                        <strong>Name : </strong><br>
                                        <strong>Father's Number :</strong><br>
                                        <strong>Roll No</strong><br>
                                    </p>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <p style="font-family: Times New Roman;">
                                        ~<span class="ml-3"> <?php echo $row["student_name"] ?>&nbsp;</span><br>
                                        ~<span class="ml-3"> <?php echo $row["father_name"] ?></span><br>
                                           ~<span class="ml-3"> <?php echo $row["roll_no"] ?></span><br>
                                    </p>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
							<?php 
							$sql_count = "SELECT COUNT(subject_name) as sub,course_id FROM `tbl_subjects` 
							              WHERE course_id= '".$row["course_id"]."'
										  ";
							$result_count = $con->query($sql_count);
							$row_count = $result_count->fetch_assoc();
							
							$sum_total_fullmarks = 0 ;
							$sum_total_marks = 0 ;
							$sql_semester = "SELECT * FROM `tbl_semester`
											 WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
											 ";
							$result_semester = $con->query($sql_semester);
							
							

							while($row_semester = $result_semester->fetch_assoc()){
							?>
                            <div class="row pr-4 pl-4">
                                <div class="col-sm-12 invoice-col">
                                    <h4 class="text-bold" style="font-family: Times New Roman;padding: 5px 10px;"><?php echo $row_semester["semester"] ?></h4>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Subjects</th>
                                                <th>Full Marks</th>
                                                <th>Marks Obtained</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										    <?php 	
									        $sql_get = "SELECT * FROM `tbl_marks` 
														INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
														WHERE  `tbl_marks`.`semester_id` = '".$row_semester["semester_id"]."' && `tbl_marks`.`course_id` = '".$row["course_id"]."' && `tbl_marks`.`fee_academic_year` = '".$row["academic_year"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
														ORDER BY `tbl_subjects`.`subject_id` ASC";	
										    $row_get = $con->query($sql_get);
											$sum2 = 0;											
											$sum_fullmarks = 0 ;
											
											 ?>
							            <?php
										    while($rows = $row_get->fetch_assoc()){
												 
                                            $sum2 += $rows["internal_marks"] + $rows["external_marks"];	
                                            $sum_fullmarks += $rows["full_marks"];
																			
                                          								
                                        ?>
                                            <tr>
                                                <td><?php echo $rows["subject_name"] ?></td>
                                                <td><?php echo $rows["full_marks"] ?></td>
                                                <?php 
												$sum =  $rows["internal_marks"] + $rows["external_marks"] ;
												?>
                                                <td><?php  echo $sum; ?></td> 
                                            </tr>											
											
											 <?php }
												$sum_total_fullmarks += $sum_fullmarks;	
												$sum_total_marks += $sum2;	
											 ?>
                                            <!-- TOTAL AMOUNT -->
                                            <tr>
										        <td align="right"><b>TOTAL</b></td>
										        <td><b><?php echo $sum_fullmarks; ?></b></td>
										        <td><b><?php echo $sum2; ?></b></td>							  										  
									        </tr>
                                        </tbody>
                                    </table>
									
                                </div>
                                <!-- /.col -->								
                            </div>
										
                            <?php } ?>
							
<!-- qr image check insert & update  -->
  <?php
    $divnum = ($sum_total_marks) / $row_count["sub"]; 
		if($divnum >= 60)
		{
			$resultvar = "First Class";
		}elseif($divnum >= 50)
		{
			$resultvar = "Second Class";
		}
		elseif($divnum >= 40)
		{
			$resultvar = "Third Class";
		}else
		{
			$resultvar = "Fail";
		}
  $data = array(
                "University"         =>  "nsuniv.ac.in",
                "Reg No"             =>  $row["reg_no"],
                "Academic Session"   =>  $completeSessionOnlyYear,
                "Course"             =>  $row_course["course_name"],
                "Student Name"       =>  $row["student_name"],
                "Fathers Name"       =>  $row["father_name"],
                "Result"             =>  $resultvar
            );
			
    // Include the qrlib file 
    include 'include/qr-lib/qrlib.php'; 
	 
    $file = $path.uniqid().uniqid().".png"; 
    // $ecc stores error correction capability('L') (LOW)
    // $ecc stores error correction capability('H') (HIGH)
    $ecc = 'H'; 
    $pixel_Size = 10; 
    $frame_Size = 1;
    // Generates QR Code and Stores it in directory given 
    QRcode::png(json_encode($data), $file, $ecc, $pixel_Size, $frame_Size);
  $sql_check = "SELECT * FROM `tbl_barcode_fullmarksheet` WHERE `student_id` = '".$_GET['id']."' ";
	$result = $con->query($sql_check);
	if ($result) {
	  if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		unlink($row["barcode_image"]);
		
		$sql_update = "UPDATE `tbl_barcode_fullmarksheet` SET  `total_marks` = '$sum_total_marks', `barcode_image` = '$file'  WHERE `student_id` = '".$_GET['id']."' ";
		$con->query($sql_update);
	  } else {
		$sql_insert="INSERT INTO `tbl_barcode_fullmarksheet`(`barcode_id`,`student_id`,`total_marks`,`barcode_image`,`result`)
					 VALUES('','".$_GET['id']."','$sum_total_marks','$file','$resultvar')";
		$query=mysqli_query($con,$sql_insert);
	  }
	}  
	?>
							<p>
							&emsp;&emsp;&emsp;
							Grand Total :  <?php echo $sum_total_fullmarks; ?>&emsp;
							Marks Obtained :  <?php echo $sum_total_marks; ?>&emsp; 
							Percentage : <?php echo $divnum ?> &emsp;
							<?php 
							if($divnum >= 60)
							{
								$resultvar = "First Class";
							}elseif($divnum >= 50)
							{
								$resultvar = "Second Class";
							}
							elseif($divnum >= 40)
							{
								$resultvar = "Third Class";
							}else
							{
							    $resultvar = "Fail";
							}
							?>
							Result : <?php echo $resultvar; ?></p>
                            <!-- /.row -->
							<div class="qr-code">
							<?php 
							// Displaying the stored QR code from directory 
							echo "<center><img width='100px' src='".$file."'></center>"; 
							?>
						   <!--<img src="images/marksheet/5e69c0b29bf625e69c0b29bf9d.png" alt="qr-code" height="100px"  />-->
						  </div>  <br><br>
                            <div class="row pr-4 pl-4" style="margin-top:100px;">
                                <div class="col-12">
                                    <div class="table-responsive table-striped">                                      
									<p style=""><b>Tabulator-I</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									<b>Tabulator-II</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									<b align="right">Controller of Examination</b></p>
                                               
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
        <!--<script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>-->
	<?php } ?>
</body>
</html>