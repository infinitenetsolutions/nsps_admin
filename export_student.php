<?php  
include 'include/config.php';
mysqli_select_db($con, 'crud');  
if(isset($_POST["course_id"]) && isset($_POST["academic_year"])){
//$sql = "SELECT admission_id,admission_first_name,admission_middle_name,admission_last_name,admission_course_name,admission_session FROM `tbl_admission` where `admission_session` = '$academic_year' && `admission_course_name` = '$course_id' ";  

$sql = "SELECT * FROM `tbl_admission`
		INNER JOIN `tbl_course` ON `tbl_course`.`course_id` = `tbl_admission`.`admission_course_name`
		INNER JOIN `tbl_university_details` ON `tbl_university_details`.`university_details_id` = `tbl_admission`.`admission_session`
		WHERE `tbl_admission`.`admission_course_name` = '".$_POST["course_id"]."' && `tbl_admission`.`admission_session` = '".$_POST["academic_year"]."' ORDER BY  `tbl_admission`.`admission_first_name` ASC
		";

$setRec = mysqli_query($con, $sql);  
$columnHeader = '';  
$columnHeader = "Admission Reg No" . "\t" . "Name" . "\t" ."Course" . "\t" ."Academic Session" . "\t" . "Semester" . "\t" . "Marksheet Serial No" . "\t" . "Marksheet Reg No" . "\t" . "Marksheet Roll No" . "\t" . "Type";  
$setData = ''; 
 //echo "<pre>";
  while ($rec = mysqli_fetch_assoc($setRec)) {  
    $rowData = '';  
	//print_r($rec);
	$rowData .= $rec["admission_id"]. "\t" .$rec["admission_first_name"]." ".$rec["admission_middle_name"]." ".$rec["admission_last_name"]. "\t" .$rec["course_name"]. "\t" .$rec["academic_session"];
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