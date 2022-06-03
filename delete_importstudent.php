<?php  
include "include/authentication.php"; 
$visible = md5("visible");
$trash = md5("trash");
if(isset($_POST["deleteAll"])){
	if(isset($_POST["chkl"]) && count($_POST["chkl"]) > 0){
		$c = 0;
		foreach($_POST["chkl"] as $allChecks){
			$sql = "UPDATE `tbl_student` SET `status` = '$trash'							
							WHERE `status` = '$visible' && `student_id` = '$allChecks';
							";
			if($con->query($sql))
				$c++;
		}
		if($c > 0)
			echo "
				<script>
					alert('".$c." Students has been Deleted successfully...');
					location.replace('student_view');
				</script>
			";
		else
			echo "
				<script>
					alert('Something went wrong please try again...');
					location.replace('student_view');
				</script>
			";
	} else{
		echo "
			<script>
				alert('Please select atleast one data...');
				location.replace('student_view');
			</script>
		";
	}
}	
?> 