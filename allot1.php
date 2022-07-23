<?php 
    include "include/config.php";
	$visible = md5("visible");
	error_reporting(0);
if(isset($_POST['action']))
{
    echo "<pre>";
    print_r($_POST);
//
//$reg_no = $_POST["reg_no"];
//$admission_id = $_POST["admission_id"];
//$course_id = $_POST["course_id"];		
//$academic_year = $_POST["academic_year"];              
//$roll_no = $_POST["roll_no"];              
//$semester_id = $_POST["semester_id"];
//
//            $all = count($semester_id);    
//				                  
//                    for($i = 0; $i<$all; $i++){
//
//							$sql_get .= "INSERT INTO `tbl_allot_semester`(`allot_id`, `admission_id`,`reg_no`,`course_id`, `academic_year`, `roll_no`,`semester_id`, `status`) 
//                                         VALUES ('','$admission_id[$i]','$reg_no[$i]','$course_id[$i]','$academic_year[$i]','$roll_no[$i]','$semester_id[$i]','$visible');";
//                
//                        
//                    }
// if($con->multi_query($sql_get))
//                       echo "<script>
//                                alert('Added successfully!!!');
//                                location.replace('student_semester');
//                            </script>";
//                   
}
?>