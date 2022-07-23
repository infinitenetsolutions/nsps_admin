<?php  
include 'include/config.php';
mysqli_select_db($con, 'crud');  
if(isset($_POST["course_id"]) && isset($_POST["academic_year"])){
//$sql = "SELECT admission_id,admission_first_name,admission_middle_name,admission_last_name,admission_course_name,admission_session FROM `tbl_admission` where `admission_session` = '$academic_year' && `admission_course_name` = '$course_id' ";  

$sql = "SELECT * FROM `tbl_examination_form`
		INNER JOIN `tbl_course` ON `tbl_course`.`course_id` = `tbl_examination_form`.`course_id`
		INNER JOIN `tbl_university_details` ON `tbl_university_details`.`university_details_id` = `tbl_examination_form`.`academic_year`
		INNER JOIN `tbl_semester` ON `tbl_semester`.`semester_id` = `tbl_examination_form`.`semester_id`
		WHERE `tbl_examination_form`.`course_id` = '".$_POST["course_id"]."' && `tbl_examination_form`.`academic_year` = '".$_POST["academic_year"]."'
		";
//echo $sql;exit();
$setRec = mysqli_query($con, $sql);  
$columnHeader = '';  
$columnHeader = "Course" . "\t" . "Session" . "\t" ."Semester" . "\t" ."Registration Number" . "\t" . "Roll Number" . "\t" . "Name" . "\t" . "Father Name" . "\t" . "Department" . "\t" . "Candidate Signature" . "\t" . "Passport Photo" . "\t" . "Gender" . "\t" . "DOB" . "\t" . "Email id" . "\t" . "mobile_no1" . "\t" . "mobile_no2" . "\t" ."Adhar no" . "\t" ."Address" . "\t" . "Last Exam Year" . "\t" . "Amount" . "\t" . "Transaction id" . "\t" . "Easebuzz id" . "\t" . "Create Time" ;  
$setData = ''; 
 //echo "<pre>";
  while ($rec = mysqli_fetch_assoc($setRec)) {  
    $rowData = '';  
	//print_r($rec);
	$rowData .= $rec["course_name"]. "\t" .$rec["academic_session"]."\t".$rec["semester"]."\t".$rec["registration_no"]. "\t" .$rec["roll_no"]. "\t" .$rec["candidate_name"]. "\t" .$rec["father_name"]. "\t" .$rec["department"]."\t".$rec["candidate_signature"]."\t".$rec["passport_photo"]. "\t" .$rec["gender"]. "\t" .$rec["dob"]. "\t" .$rec["email_id"]. "\t" .$rec["mobile_no1"]. "\t" .$rec["mobile_no2"]. "\t" .$rec["adhar_no"]. "\t" .$rec["address"]. "\t" .$rec["last_exam_year"]. "\t" .$rec["amount"]. "\t" .$rec["transactionid"]. "\t" .$rec["easebuzzid"]. "\t" .$rec["create_time"];
    $setData .= trim($rowData) . "\n";  
} 
//exit; 
}  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=Student List.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
 ?>