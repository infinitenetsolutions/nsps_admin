<?php 
 
// Load the database configuration file 
include_once 'config.php'; 
  $visible = md5("visible");
  $branch = $_GET['branch'];
  $class_id = $_GET['classid'];
  $section_id = $_GET['sectionid'];


if ($branch == 'all' && $class_id == '0' && $section_id == '-1') {
    $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible'  ORDER BY `student_id` ASC";
    $query = $con->query($data);
}

// Particular branch with any class and section
else if ($branch != 'all' && $class_id == '0' && $section_id == '-1') {
    $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' && `branch_id` = '$branch' ORDER BY `student_id` ASC";
    $query = $con->query($data);
}
// Any branch with particular class and any section
else if ($branch == 'all' && $class_id != '0' && $section_id == 'all') {
    $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' && `course_id` = '$class_id' ORDER BY `student_id` ASC";
    $query = $con->query($data);
}
// All branch with particular class and particular section
else if ($branch == '0' || $branch == 'all' && $class_id != '0' && $section_id != 'all') {
     $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' && `course_id` = '$class_id' && `section_id` = '$section_id' ORDER BY `student_id` ASC";
    $query = $con->query($data);
}
// Particular branch and particular class
else if ($branch != '0' && $class_id != '0' && $section_id == 'all') {
     $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' 
&& `branch_id` = '$branch' && `course_id` = '$class_id'  ORDER BY `student_id` ASC";
    $query = $con->query($data);


}
// Particular branch with Particular class and particular section
else if ($branch != '0' && $class_id != '0' && $section_id != 'all') {
    $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' 
&& `branch_id` = '$branch' && `course_id` = '$class_id' && `section_id` = '$section_id' ORDER BY `student_id` ASC";
    $query = $con->query($data);

} else {

    $data = "SELECT * FROM `tbl_student` WHERE `status` = '$visible' 
&& `course_id` = '$class_id' && `section_id` = '$section_id' ORDER BY `student_id` ASC";
$query = $con->query($data);

}


 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "students-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID', 'SCHOOL NAME', 'BRANCH', 'REGISTRATION NUMBER','ROLL NO', 'STUDENT NAME','DOB', 'GENDER','FATHERS NAME','MOTHERS NAME','PARENT CONTACT NO','CLASS','SECTION','ADDRESS','NATIONALITY'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $sel = "SELECT * FROM tbl_branch WHERE `id`= '$branch'";
        $rs = mysqli_query($con,$sel);
        $row1 = mysqli_fetch_assoc($rs);

        $sel1 = "SELECT * FROM tbl_class WHERE `course_id`= '$class_id'";
        $rs1 = mysqli_query($con,$sel1);
        $row2 = mysqli_fetch_assoc($rs1);
        //$row2['course_name'];

        $sel2 = "SELECT * FROM tbl_section WHERE `section_id`= '$section_id'";
        $rs2 = mysqli_query($con,$sel2);
        $row3 = mysqli_fetch_assoc($rs2);

        $lineData = array($row['student_id'],$row['university_details_id'], $row['branch_id'], $row['reg_no'], $row['roll_no'], $row['student_name'],$row['dob'],$row['gender'], $row['father_name'],$row['mother_name'],$row['parent_contactno'],$row['course_id'],$row['section_id'],$row['address'],$row['nationality']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>