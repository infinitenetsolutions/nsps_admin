<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
// var_dump($id);exit();
$sql = "SELECT section_id,section_name FROM tbl_section WHERE course_id=".$id;
// var_dump("SELECT id,desg_name FROM designation WHERE dept=".$deptid);exit();

$result = mysqli_query($con,$sql);
$res = '<option value="all">All</option>';
while( $row = mysqli_fetch_array($result) ){
    
   $res .= '<option value="'.$row['section_id'].'">'.$row['section_name'].'   </option>';
}
echo $res;
?>