<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
// var_dump($id);exit();
$sql = "SELECT semester_id,semester,exam_fee FROM tbl_semester WHERE course_id=".$id;
// var_dump("SELECT id,desg_name FROM designation WHERE dept=".$deptid);exit();

$result = mysqli_query($con,$sql);
echo "<option>Select</option>";
while( $row = mysqli_fetch_array($result) ){
   
   echo '<option value="'.$row['semester_id'].'">'.$row['semester'].'   </option>';
}
?>