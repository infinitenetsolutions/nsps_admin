<?php 
	include 'include/qr-lib/qrlib.php'; 
	    $visible = md5("visible");

	if(isset($_POST["class_id"]) && isset($_POST["section_id"])){
	   // ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
    //     error_reporting(E_ALL);
		?>
		<?php
			$class_id = $_POST["class_id"];
			$section_id = $_POST["section_id"];
			$page_no = "11";
			$page_no_inside = "11_6";
			include "include/authentication.php";
			$path = 'images/';
			//error_reporting(0);
			   
				$sql = "SELECT * FROM `tbl_student`
						INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
						WHERE `tbl_student`.`status` = '$visible'  && `tbl_student`.`course_id` = '$class_id' && `tbl_student`.`section_id` = '$section_id' ORDER BY `tbl_student`.`reg_no` ASC
						
				";		
				$result = $con->query($sql);
				//$row = $result->fetch_assoc();
					/*while($row = $result->fetch_assoc()){
						echo "<pre>";
						print_r($row);
					}
					exit;*/
				?>
				<html>
				<head>
					<style>
						body {
							margin: 0;
							padding: 0;
							font: 12pt ;
							 font-family: Arial, Helvetica, sans-serif;		
							 }

						* {
							box-sizing: border-box;
							-moz-box-sizing: border-box;
						}

						.page {
							width: 21cm;
							min-height: 29.7cm;
							padding: 2cm;
							margin: 1cm auto;
							border: 1px #D3D3D3 solid;
							border-radius: 5px;
							background-image:  url(images/marksheet/nsu_print_bg.png);
							background-size: cover;
							background-position: fixed;
							background-repeat: no-repeat;           
							box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
						}

						.subpage {
							padding: 0cm;
							height: 256mm;
						}
						
        					u {
                            text-decoration: none;
                            border-bottom: 2px solid black;
                          }

						@page {
							size: A4;
							margin: 0;
						}

						@media print {
							.page {
								margin: 0;
								border: initial;
								border-radius: initial;
								width: initial;
								min-height: initial;
								box-shadow: initial;            
								page-break-after: always;
							}
						}
								.footer {
									   position: fixed;
									   left: 57px;
									   bottom: 0;
									   width: 88%;
									   color: black;
									   text-align: center;
									}

									.courseText h5 {
									font-size: 15px;
									text-align: center;
									margin-top: -24px;
									}
									table {
									  border-collapse: collapse;
									}
									table {
									  width: 706px;
									  margin-left: -28px;
									}

									table, th, td {
									  border: 1px solid black;
									  text-align: center;

									}
									
									.courseText h5 {font-size: 18px;text-align: center;margin-top: -24px;}
									.tableText {margin: 5px 0;margin-left: -28px;}
									.qr-code {position: relative;}
									.qr-code img {position: absolute; top: 0px; left: 50px;}
						
					</style>
				</head>

				<body>
					<div class="book">
						<?php 
							while($row = $result->fetch_assoc()){
							$sql_course = "SELECT * FROM `tbl_class`
										   WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
										   ";
							$result_course = $con->query($sql_course);
							$row_course = $result_course->fetch_assoc();
											
							$sql_semester = "SELECT * FROM `tbl_section`
										   WHERE `status` = '$visible' && `section_id` = '".$row["section_id"]."';
										   ";
							$result_semester = $con->query($sql_semester);
							$row_semester = $result_semester->fetch_assoc(); 

                                $sql_count = "SELECT COUNT(subject_name) as sub,class_id FROM `tbl_subjects` 
							              WHERE `status` = '$visible' && class_id= '".$row["course_id"]."' && section_id= '".$row["section_id"]."'
										  ";
								$result_count = $con->query($sql_count);
								$row_count = $result_count->fetch_assoc();								
														
							$completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
							$completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
							$completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
							$grandtotal = 0;
							$passmarks_total = 0;
							$sql_get = "SELECT * FROM `tbl_marks` 
								  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
								  WHERE `tbl_marks`.`status` = '$visible' &&  `tbl_subjects`.`status`= '$visible' && `tbl_marks`.`section_id` = '".$row["section_id"]."' && `tbl_marks`.`class_id` = '".$row["course_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
								  ORDER BY `tbl_subjects`.`subject_id` ASC";	
							$row_get = $con->query($sql_get);


							while($rows = $row_get->fetch_assoc()){ 
								$grandtotal = $grandtotal + $rows['internal_marks'] + $rows["external_marks"] ;
								$passmarks_total = $passmarks_total + $rows["pass_marks"];
							}
							
							
							
						?>
						<?php
							if ($grandtotal >= $passmarks_total)
							{
								$resultVar = "PASS";
							}else
							{
								$resultVar = "FAIL";
							}
							$data = array(
										"University"         =>  "nspsjsr.in",
										"Reg No"             =>  $row["reg_no"],
										"Academic Session"   =>  $completeSessionOnlyYear,
										"Class"             =>  $row_course["course_name"],
										"Student Name"       =>  $row["student_name"],
										"Fathers Name"       =>  $row["father_name"],
										"Result"             =>  $resultVar
									);
								
							  // Include the qrlib file 
							 
							$file = $path.uniqid().uniqid().".png"; 
							// $ecc stores error correction capability('L') (LOW)
							// $ecc stores error correction capability('H') (HIGH)
							$ecc = 'H'; 
							$pixel_Size = 10; 
							$frame_Size = 1;
							// Generates QR Code and Stores it in directory given 
							// QRcode::png(json_encode($data), $file, $ecc, $pixel_Size, $frame_Size);
							// $sql_check = "SELECT * FROM `tbl_barcode` WHERE `student_id` = '".$row['admission_id']."' ";
							// $result_qr = $con->query($sql_check);
							// if ($result_qr) {
							//   if($result_qr->num_rows > 0){
							// 	$row_qr = $result_qr->fetch_assoc();
							// 	unlink($row_qr["barcode_image"]);
								
							// 	$sql_update = "UPDATE `tbl_barcode` SET  `total_marks` = '$grandtotal', `barcode_image` = '$file'  WHERE `student_id` = '".$row['admission_id']."' ";
							// 	$con->query($sql_update);
							//   } else {
							// 	$sql_insert="INSERT INTO `tbl_barcode`(`barcode_id`,`student_id`,`total_marks`,`barcode_image`,`result`)
							// 				 VALUES('','".$row['admission_id']."','$grandtotal','$file','$resultVar')";
							// 	$query=mysqli_query($con,$sql_insert);
							//   }
							// }  
						?>
						<div class="page">
							<div class="subpage">
								<img  height='100px' style='margin-left: -30px; margin-top: -35px;' width='100px' src='<?= $file ?>'>
								<p style="margin-top: -98px;margin-right: -38px; text-align: right;"><b>Sl No: <?php //echo $row["serial_no"] ?></b></p>
								<center><img src="images/marksheet/nsu_image.png" style="height:278px; margin-top:-15px; margin-left: -11px;"/></center>
							
								<div class="courseText mb3">
									<h5><u><?php echo $row_semester["section_name"] ?> Examination - 2020</u></h5>
								</div>
								<div class="tableText" style="width: 706px;">
								  <p style="text-align: left; line-height: 50%;"><b>NAME </b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;: <b style="font-size: 18px;"><?php echo $row["student_name"]  ?></b>&nbsp;</p>              
								  <p style="text-align: left; line-height: 50%;"><b>FATHER'S NAME </b>&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;"><?php echo $row["father_name"] ?></b></p>                          
								  <p style="text-align: left; line-height: 50%;"><b>NAME OF THE SCHOOL </b>&nbsp;: <b style="font-size: 14px;"><?php echo $row["university_details_university_name"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>NAME OF THE COURSE </b>&nbsp;: <b style="font-size: 14px;">
								   <?php echo $row_course["course_name"] ?>
							    	   
								  </b></p>
								  <p style="text-align: left; line-height: 50%;"><b> REG No. </b>&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;"><?php echo $row["reg_no"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b> ROLL No. </b>&nbsp;&nbsp;&nbsp;: <b style="font-size: 14px;"><?php echo $row["roll_no"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>EXAMINATION TYPE </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;">REGULAR<?php //echo $row["type"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>Examination held in the month of <?php //echo $row_semester["examination_month"] ?></b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -27px;">Session: <?php echo $completeSessionOnlyYear ; ?></b></p>
								</div>
								
								 <table style="font-size: 14px;">
									 <tr>
										<!-- <th rowspan='2' style="background: #f7bb84d6;width:15%;">COURSE CODE</th> -->
										<th rowspan='2' style="background: #f7bb84d6;">SUBJECT NAME</th>
										<th rowspan='2' style="background: #f7bb84d6;">FULL<br>MARKS</th>
										<th rowspan='2' style="background: #f7bb84d6;">PASS<br>MARKS</th>
										<th colspan="2" style="background: #f7bb84d6;">MARKS SECURED</th>
										<th rowspan="2" style="background: #f7bb84d6;">TOTAL<br>MARKS<br>OBTD.</th>
									  </tr>           
									  <tr>
										<th style="background: #f7bb84d6;">TEST<br/>(30)</th>
										<th style="background: #f7bb84d6;">HALF YEARLY EXAM<br/>(70)</th>
									  </tr>
										  <?php 	
											$sql_get = "SELECT * FROM `tbl_marks` 
													  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
													  WHERE `tbl_marks`.`status` = '$visible' &&  `tbl_subjects`.`status`= '$visible' && `tbl_marks`.`section_id` = '".$row["section_id"]."' && `tbl_marks`.`class_id` = '".$row["course_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
													  ORDER BY `tbl_subjects`.`subject_id` ASC";	
											$row_get = $con->query($sql_get);
											
											 $grandtotals = 0 ;
											 $countLine = 0;
											 $iPer = 0;
											 while($rows = $row_get->fetch_assoc()){ 
											 $grandtotals = $grandtotals + $rows['internal_marks'] + $rows["external_marks"] ;
											 $passmarks_total = $passmarks_total + $rows["pass_marks"];
										        $iPer++;
										        if(strlen($rows["subject_name"]) > 35 && strlen($rows["subject_name"]) <= 70)
										            $countLine = $countLine + 1;
										        else if(strlen($rows["subject_name"]) > 70 && strlen($rows["subject_name"]) <= 105)
										                $countLine = $countLine + 2;
										        else if(strlen($rows["subject_name"]) > 105 && strlen($rows["subject_name"]) <= 140)
										                $countLine = $countLine + 3;
										        else if(strlen($rows["subject_name"]) > 140)
										                $countLine = $countLine + 4;
										 ?>
									  <tr>
<!-- 										<td><?php echo $rows["subject_code"] ?></td>
 -->										<td style="text-align: left;"><?php echo $rows["subject_name"] ?></td>
										<td><?php echo $rows["full_marks"] ?></td>
										<td><?php echo $rows["pass_marks"] ?></td>
										<td><?php echo $rows["internal_marks"] ?></td>
										<td><?php echo $rows["external_marks"] ?></td>   
										<?php $sum_total =  $rows["internal_marks"] + $rows["external_marks"] ; ?>
										<td><b><?php  echo $sum_total; ?></b></td>    
									  </tr>
										 <?php }		 
										 ?>
											   
									  <tr class="tableLastChild">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"><br><p style="margin-block-start: -12px;margin-left: -190px;"><b>Date of Publication of Result: <?php //echo date("d/m/Y", strtotime($row_semester["date_of_result"])) ?></b></p></td>
										<td colspan="1" style="text-align: right;"><b>GRAND TOTAL</b></td>
										  <td><b><?php echo $grandtotals; ?></b></td>					  
									  </tr>
										<tr class="">
										  <td colspan="7" style="border-block-end-color: white;border-left: 2px solid #00000000; border-right: 2px solid #00000000; padding:0;"><br/><br/></td>				  
									  </tr>
									 <tr class="">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000; border-top: 2px solid #00000000; padding:0;"></td>
										  <td colspan="2" style="border-block-end-color: white; border-left: 2px solid #00000000;padding:0; text-align:right"><b>PERCENTAGE &nbsp;</b></td>
										  <td style="border-block-end-color: white;border-left: 2px solid #00000000;  border-right: 2px solid #00000000; padding:0; text-align:left"> : &nbsp;<b><?php $divnum = ($grandtotals) / $row_count["sub"] ;
	                                       $number = $divnum;
                                           echo round($number, 2);
	                                        
	                                      
	                                       ?></b></td>					  
									  </tr>
									  <tr class="">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"></td>
										  <td colspan="2" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0; text-align:right;"><b>RESULT &nbsp;<b></td>
										  <td style="border-block-end-color: white;border-left: 2px solid #00000000; border-right: 2px solid #00000000; padding:0; text-align:left"> : &nbsp;<b><?= $resultVar ?></b></td>					  
									  </tr>
								  </table><br/>
								 <!--<div class="tableText" style="width: 706px;">
								 <p style="text-align: right; line-height: 50%;"><b style="">PERCENTAGE &nbsp;<b style="letter-spacing: 3px;">:</b></b>&nbsp;&nbsp; <b><?php $divnum = ($grandtotals) / $row_count["sub"] ;
	                                       echo $divnum ?></b></p>
								  <p style="text-align: right; line-height: 50%;"><b>RESULT &nbsp;&nbsp;&nbsp;<b style="letter-spacing: 3px;">:</b></b>&nbsp;&nbsp; <b><?= $resultVar ?></b></p>
								</div>-->
								<?php 
								    
								    $perApply = 0;
								    $iPer = $iPer + $countLine;
								    // echo $iPer;
								    switch($iPer):
								        case 2:
								            $perApply = 35;
								            break;
								        case 3:
								            $perApply = 31.5;
								            break;
								        case 4:
								            $perApply = 25;
								            break;
								        case 5:
								            $perApply = 24.5;
								            break;
								        case 6:
								            $perApply = 21;
								            break;
								        case 7:
								            $perApply = 17.5;
								            break;
								        case 8:
								            $perApply = 14;
								            break;
								        case 9:
								            $perApply = 10.5;
								            break;
								        case 10:
								            $perApply = 7;
								            break;
								        case 11:
								            $perApply = 3.5;
								            break;
								        default:
								            $perApply = 0;
								            break;
								    endswitch;
								?>
                                <div class="sub_div">
								<!-- <p style="margin-top:<?= $perApply; ?>%; margin-left: -6%;width: 706px;">-->
								 <p style="margin-top:-5%; margin-left: -6%;width: 706px;">
									<span ><img src="images/sign/manoj.png" style="width: 18%;    margin-left: 19px;"></span>
									<span ><img src="images/sign/sneha.png" style="width: 16%;margin-left: 127px; margin-bottom: 15px;"></span>
									<span ><img src="images/sign/OPS.png" style="width: 20%; margin-bottom: 0px;margin-left: 137px;"></span>
									<span style=" margin-left: -655px;">Tabulator-I</span>
									<span >&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;Tabulator-II</span>
									<span style="margin-left: 34px;" >&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;Controller of Examination</span>
								</p>
								</div>
							</div>
						</div>
						<?php 
							}
						?>
						
					</div>
					<script>
						window.print();
					</script>
				
				</body>

				</html>
			<?php
							
				
	}
?>