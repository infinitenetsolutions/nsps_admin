<?php  
include "include/authentication.php"; 
if(isset($_POST["approvedAll"])){
	if(isset($_POST["chkl"]) && count($_POST["chkl"]) > 0){
		$c = 0;
		foreach($_POST["chkl"] as $allChecks){
			$sql_update = "UPDATE `tbl_fee_status` 
							SET 
							`exam_status` = 'Approve'
							WHERE  `fee_status_id` = '$allChecks';
							";
			if($con->query($sql_update))
				$c++;
		}
		if($c > 0)
			echo "
				<script>
					alert('".$c." student has beed approved successfully...');
					location.replace('student_nodues_list');
				</script>
			";
		else
			echo "
				<script>
					alert('Something went wrong please try again...');
					location.replace('student_nodues_list');
				</script>
			";
	} else{
		echo "
			<script>
				alert('Please select atleast one data...');
				location.replace('student_nodues_list');
			</script>
		";
	}
}
if(isset($_POST["disapprovedAll"])){
	if(isset($_POST["chkl"]) && count($_POST["chkl"]) > 0){
		$c = 0;
		foreach($_POST["chkl"] as $allChecks){
			$sql_update = "UPDATE `tbl_fee_status` 
							SET 
							`exam_status` = 'Not Approve'
							WHERE  `fee_status_id` = '$allChecks';
							";
			if($con->query($sql_update))
				$c++;
		}
		if($c > 0)
			echo "
				<script>
					alert('".$c." student has beed disapproved successfully...');
					location.replace('student_nodues_list');
				</script>
			";
		else
			echo "
				<script>
					alert('Something went wrong please try again...');
					location.replace('student_nodues_list');
				</script>
			";
	} else{
		echo "
			<script>
				alert('Please select atleast one data...');
				location.replace('student_nodues_list');
			</script>
		";
	}
}		
?> 