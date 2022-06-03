<?php  
include "include/authentication.php"; 
if(isset($_POST["approvedAll"])){
	if(isset($_POST["chkl"]) && count($_POST["chkl"]) > 0){
		$c = 0;
		foreach($_POST["chkl"] as $allChecks){
			$sql_update = "UPDATE `tbl_allot_semester` 
							SET 
							`admitcard_status` = 'Approve'
							WHERE  `allot_id` = '$allChecks';
							";
			if($con->query($sql_update))
				$c++;
		}
		if($c > 0)
			echo "
				<script>
					alert('".$c." student has been approved successfully...');
					location.replace('students_view');
				</script>
			";
		else
			echo "
				<script>
					alert('Something went wrong please try again...');
					location.replace('students_view');
				</script>
			";
	} else{
		echo "
			<script>
				alert('Please select atleast one data...');
				location.replace('students_view');
			</script>
		";
	}
}
if(isset($_POST["disapprovedAll"])){
	if(isset($_POST["chkl"]) && count($_POST["chkl"]) > 0){
		$c = 0;
		foreach($_POST["chkl"] as $allChecks){
			$sql_update = "UPDATE `tbl_allot_semester` 
							SET 
							`admitcard_status` = 'Not Approve'
							WHERE  `allot_id` = '$allChecks';
							";
			if($con->query($sql_update))
				$c++;
		}
		if($c > 0)
			echo "
				<script>
					alert('".$c." student has been disapproved successfully...');
					location.replace('students_view');
				</script>
			";
		else
			echo "
				<script>
					alert('Something went wrong please try again...');
					location.replace('students_view');
				</script>
			";
	} else{
		echo "
			<script>
				alert('Please select atleast one data...');
				location.replace('students_view');
			</script>
		";
	}
}		
?>