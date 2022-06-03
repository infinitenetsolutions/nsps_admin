<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
// var_dump($id);exit();
$sql = "SELECT course_id,academic_year FROM tbl_course WHERE course_id=".$id;
//echo $sql;

$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result); 


$sql_ac_year = "SELECT * FROM `tbl_university_details`
               WHERE university_details_id = '".$row["academic_year"]."';";
$result_ac_year = $con->query($sql_ac_year);
$row_ac_year = $result_ac_year->fetch_assoc();
  
  echo '<option value="'. $row_ac_year["university_details_id"].'">'.date("d/m/Y", strtotime($row_ac_year["university_details_academic_start_date"])).' to '.date("d/m/Y", strtotime($row_ac_year["university_details_academic_end_date"])).' </option>' 

  //echo '<option value="'.$row['academic_year'].'">'.$row['academic_year'].'   </option>';

?>