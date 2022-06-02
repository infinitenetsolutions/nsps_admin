<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
// var_dump($id);exit();
$sql = "SELECT student_id,student_name FROM tbl_student WHERE section_id=".$id;
// var_dump("SELECT id,desg_name FROM designation WHERE dept=".$deptid);exit();

$result = mysqli_query($con,$sql);
while( $row = mysqli_fetch_array($result) ){
    
   echo '<option value="'.$row['student_id'].'">'.$row['student_name'].'   </option>';
}
?>