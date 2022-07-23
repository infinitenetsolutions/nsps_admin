<?php
$page_no = "11";
$page_no_inside = "11_6";
include "include/authentication.php";
$path = 'images/';
//error_reporting(0);
   
	$sql = "SELECT * FROM `tbl_student` 
	INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
	WHERE `tbl_student` .`reg_no` = '".$_GET['id']."' ";			
	$result = $con->query($sql);
	$row = $result->fetch_assoc();

	
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
							              WHERE class_id= '".$row["course_id"]."'
										  ";
	$result_count = $con->query($sql_count);
	$row_count = $result_count->fetch_assoc();
	
	$completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
	$completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
	$completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];

	if (isset($_GET['id'])) {
		
?>
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font: 12pt "Tahoma";
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
            padding: 1cm;
            height: 256mm;
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
		
		.tableText {
		margin: 5px 0;
		}

        table, th, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		  font-size:14px;
		  text-align:center;
		  
		}	
        
        .courseText h5 {font-size: 18px;text-align: center;margin-top: -24px;}
		.tableText {margin: 5px 0;}
		.qr-code {position: relative;}
		.qr-code img {position: absolute; top: 0px; left: 50px;}		
    </style>
</head>

<body>
    <div class="book">
        <div class="page">
            <div class="subpage">
    <?php 
	
	// if ($grandtotal >= $passmarks_total)
	// 	{
	// 		$resultVar = "PASS";
	// 	}else
	// 	{
	// 		$resultVar = "FAIL";
	// 	}
  $data = array(
                "University"         =>  "nspsjsr.in",
                "Reg No"             =>  $row["reg_no"],
                "Academic Session"   =>  $completeSessionOnlyYear,
                "Course"             =>  $row_course["course_name"],
                "Student Name"       =>  $row["student_name"],
                "Fathers Name"       =>  $row["father_name"]
//"Result"             =>  $resultVar
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
	
	
    // Displaying the stored QR code from directory 
    echo "<img  height='100px' style='margin-left: -72px;margin-top: -77px;' width='100px' src='".$file."'>"; 
?>
   <!-- <img src="images/marksheet/5e69c0b29bf625e69c0b29bf9d.png" alt="qr-code" height="100px"  />-->
  
			<!--<img src="<?php //echo '".$file."' ?>" alt="qr-code" height="100px" style="margin-left: -72px;margin-top: -77px;" />-->
			<!-- <p style="margin-top: -98px;margin-right: -80px;text-align: right;"><b>Sl No: <?php echo $row["serial_no"] ?></b></p> -->
			<img src="images/marksheet/nsu_image.png" style="height:250px; margin-top:-15px;"/>
			
			<div class="courseText mb3">
				<h5> <?php echo $row_course["course_name"] ?> - <?php echo $row_semester["section_name"] ?> Examination - 2021</h5>
			</div>
			<div class="tableText" >
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>NAME: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row["student_name"] ?>&nbsp;</p>              
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>FATHER'S NAME: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["father_name"] ?></p>                          
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>NAME OF SCHOOL: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["university_details_university_name"] ?></p>
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>NAME OF CLASS: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_course["course_name"] ?></p>
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>ROLL NO: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["roll_no"] ?></p>
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>REGISTRATION NO: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["reg_no"] ?></b></p>
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>EXAMINATION TYPE: </b>&nbsp;&nbsp;&nbsp;REGULAR<?php //echo $row["type"] ?></p>
			  <p style="text-align: left;margin-left: -65px; line-height: 50%;"><b>Examination held in the month of <?php //echo $row_semester["examination_month"] ?></b><b style="margin-left: 100px;">Session : <?php echo $completeSessionOnlyYear ; ?></b></p>
			</div>
			
			 <table style="width:127%;min-height: 600px;margin-left: -71px;">
				 <tr>
					<th rowspan='2'>SUBJECT NAME</th>
					<th rowspan='2'>FULL MARKS</th>
					<th rowspan='2'>PASS MARKS</th>
					<th colspan="2">MARKS SECURED</th>
					<th rowspan="2">TOTAL<br/>(100)</th>
				  </tr>           
				  <tr>
					<th>PER TEST<br/>(20)</th>
					<th>HALF YEARLY EXAM<br/>(80)</th>
				  </tr>
					  <?php 	
					  $sql_get = "SELECT * FROM `tbl_marks` 
								  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
								  WHERE `tbl_marks`.`section_id` = '".$row["section_id"]."' && `tbl_marks`.`class_id` = '".$row["course_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
								  ORDER BY `tbl_subjects`.`subject_id` ASC";	
					$row_get = $con->query($sql_get);
					
					$passmarks_total =0;
					$grandtotal = 0;
					 while($rows = $row_get->fetch_assoc()){ 
					 $grandtotal = $grandtotal + $rows['internal_marks'] + $rows["external_marks"] ;
					 $passmarks_total = $passmarks_total + $rows["pass_marks"];
					 
					 ?>
				  <tr>
					<td><?php echo $rows["subject_name"] ?></td>
					<td><?php echo $rows["full_marks"] ?></td>
					<td><?php echo $rows["pass_marks"] ?></td>
					<td><?php echo $rows["internal_marks"] ?></td>
					<td><?php echo $rows["external_marks"] ?></td>   
					<?php $sum_total =  $rows["internal_marks"] + $rows["external_marks"] ; ?>
					<td><?php  echo $sum_total; ?></td>    
				  </tr>
					 <?php }		 
					 ?>
						   
				  <tr class="tableLastChild">
					  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"><br><p style="text-align: left;padding-left: 0px; line-height: 100%;">Date of Publication of Result: <?php //echo date("d/m/Y", strtotime($row_semester["date_of_result"])) ?></p></td>
					  <td colspan="1">GRAND TOTAL</td>
					  <td><?php echo $grandtotal; ?></td>					  
				  </tr>
			  </table>
                
				<!-- qr image check insert & update  -->
  <?php
		
			
  
  $sql_check = "SELECT * FROM `tbl_barcode` WHERE `student_id` = '".$_GET['id']."' ";
	$result = $con->query($sql_check);
	if ($result) {
	  if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		unlink($row["barcode_image"]);
		
		$sql_update = "UPDATE `tbl_barcode` SET  `total_marks` = '$grandtotal', `barcode_image` = '$file'  WHERE `student_id` = '".$_GET['id']."' ";
		$con->query($sql_update);
	  } else {
		$sql_insert="INSERT INTO `tbl_barcode`(`barcode_id`,`student_id`,`total_marks`,`barcode_image`,`result`)
					 VALUES('','".$_GET['id']."','$grandtotal','$file','$resultVar')";
		$query=mysqli_query($con,$sql_insert);
	  }
	}  
	?>
	
			    <div class="tableText">
				<p style="text-align: right;padding-right: 43px; line-height: 50%;"><b>PERCENTAGE: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -80px;"><?php $divnum = ($grandtotal) / $row_count["sub"] ;
	             echo $divnum ?>
				</b></p>            
				<p style="text-align: right;padding-right: 10px; line-height: 50%;"><b>RESULT: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -47px;">
				  <?php
				  if ($grandtotal >= $passmarks_total)
				  {
					  $resultVar = "PASS";
					  echo "PASS";
				  }else
				  {
					 echo "FAIL"; 
					 $resultVar = "FAIL";
				  }
				  ?></b></p>
				</div>
			</div>
			
        </div>
		<div class="footer">
		  <p style="margin-top:-80px;">Tabulator-I&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
			Tabulator-II &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
			Controller of Examination</p>
		</div>
    </div>
    <script>
        window.print();
    </script>
	<?php } ?>
</body>

</html>