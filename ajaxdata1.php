<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
// var_dump($id);exit();
$sql = "SELECT course_id,prospectus_rate FROM tbl_course WHERE course_id=".$id;
//echo $sql;

$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result); 
    
   echo '<option value="'.$row['prospectus_rate'].'">'.$row['prospectus_rate'].'   </option>';

?>