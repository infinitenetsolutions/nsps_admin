<?php
$page_no = "11";
$page_no_inside = "11_6";
include "include/authentication.php";
$path = 'images/';
error_reporting(0);
   
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
					
	$sql_semester = "SELECT * FROM `tbl_semester`
				   WHERE `status` = '$visible' && `semester_id` = '".$row["semester_id"]."';
				   ";
	$result_semester = $con->query($sql_semester);
	$row_semester = $result_semester->fetch_assoc();                                  
	
	$completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
	$completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
	$completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];

	if (isset($_GET['id'])) {
		
?>
<!DOCTYPE html>
<html>
<head>
<style>
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
<style>
.footer {
   position: fixed;
   left: 57px;
   bottom: 0;
   width: 88%;
   color: black;
   text-align: center;
}
</style>
</head>
<body style='background-image:  url(images/marksheet/nsu_print_bg.png);background-size: cover;background-position: fixed;background-repeat: no-repeat;'>
<center>
    <div class="tableText" style="justify-content: flex-end;">
    <p style="margin-top: 62px;padding-right: 75px;text-align: right;"><b>Sl No: <?php echo $row["serial_no"] ?></b></p>
    </div>
 <div class="imageNSU" style="margin-top:50px;">
    <img src="images/marksheet/nsu_image.png" style="height:250px; margin-top:-56px;"/>
  </div>
			
   <div class="courseText mb3">
		<h5> <?php echo $row_semester["semester"] ?> Examination - 2020</h5>
	</div>
	<div class="tableText" >
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>NAME: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["student_name"] ?>&nbsp;</p>              
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>FATHER'S NAME: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["father_name"] ?></p>                          
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>NAME OF SCHOOL: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_semester["name_of_school"] ?></p>
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>NAME OF COURSE: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_course["course_name"] ?></p>
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>ROLL NO: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["roll_no"] ?></p>
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>REGISTRATION NO: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["reg_no"] ?></b></p>
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>EXAMINATION TYPE: </b>&nbsp;&nbsp;&nbsp;<?php echo $row["type"] ?></p>
	  <p style="text-align: left;padding-left: 60px; line-height: 50%;"><b>Examination held in the month of <?php echo $row_semester["examination_month"] ?></b><b style="margin-left: 210px;">Session : <?php echo $completeSessionOnlyYear ; ?></b></p>
	</div>
   
  <table style="width:85%;min-height: 600px;">
     <tr>
        <th rowspan='2'>PAPER CODE</th>
        <th rowspan='2'>SUBJECT NAME</th>
        <th rowspan='2'>FULL MARKS</th>
        <th rowspan='2'>PASS MARKS</th>
        <th colspan="2">MARKS SECURED</th>
        <th rowspan="2">TOTAL<br/>(100)</th>
      </tr>           
      <tr>
        <th>INTERNAL<br/>(30)</th>
        <th>EXTERNAL<br/>(70)</th>
      </tr>
	    <?php 	
		  $sql_get = "SELECT * FROM `tbl_marks` 
	                  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
	                  WHERE `tbl_marks`.`semester_id` = '".$row["semester_id"]."' && `tbl_marks`.`course_id` = '".$row["course_id"]."' && `tbl_marks`.`fee_academic_year` = '".$row["university_details_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
					  ORDER BY `tbl_subjects`.`subject_id` ASC";	
		$row_get = $con->query($sql_get);
		
		$passmarks_total =0;
		$grandtotal = 0;
		 while($rows = $row_get->fetch_assoc()){ 
		 $grandtotal = $grandtotal + $rows['internal_marks'] + $rows["external_marks"] ;
		 $passmarks_total = $passmarks_total + $rows["pass_marks"];
		 
		 ?>
      <tr>
        <td><?php echo $rows["subject_code"] ?></td>
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
          <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"><p style="text-align: left;padding-left: 0px; line-height: 100%;">Date of Publication of Result: <?php echo date("d/m/Y", strtotime($row_semester["date_of_result"])) ?></p></td>
          <td colspan="2">GRAND TOTAL</td>
          <td><?php 
		  echo $grandtotal; ?>
		  </td>
		  
      </tr>
  </table>
  
  <!-- qr image check insert & update  -->
  <?php
		if ($grandtotal >= $passmarks_total)
		{
			$resultVar = "PASS";
		}else
		{
			$resultVar = "FAIL";
		}
  $data = array(
                "University"         =>  "nsuniv.ac.in",
                "Reg No"             =>  $row["reg_no"],
                "Academic Session"   =>  $completeSessionOnlyYear,
                "Course"             =>  $row_course["course_name"],
                "Student Name"       =>  $row["student_name"],
                "Fathers Name"       =>  $row["father_name"],
                "Result"             =>  $resultVar
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
    <p style="text-align: right;padding-right: 205px; line-height: 50%;"><b>PERCENTAGE: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -80px;"><?php $divnum = ($grandtotal) / 5 ;
	echo $divnum ?></b></p>            
    <p style="text-align: right;padding-right: 160px; line-height: 50%;"><b>RESULT: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -47px;">
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
    <div class="qr-code">
    <?php 
    // Displaying the stored QR code from directory 
    echo "<center><img width='100px' src='".$file."'></center>"; 
?>
   <!-- <img src="images/marksheet/5e69c0b29bf625e69c0b29bf9d.png" alt="qr-code" height="100px"  />-->
  </div>  
<div class="footer">
  <p style="margin-top:-80px;">Tabulator-I&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Tabulator-II &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Controller of Examination</p>
</div>
</center>
<?php } ?>
</body>
</html>