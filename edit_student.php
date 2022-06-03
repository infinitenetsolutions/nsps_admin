<?php 
    $page_no = "5";
    $page_no_inside = "5_1";
    include "include/authentication.php"; 

	function sm_registerglobal () {

			$args = func_get_args();

			while (list(,$key) = each ($args)) {

				if (isset($_GET[$key])) $value = $_GET[$key];
				if (isset($_POST[$key])) $value = $_POST[$key];

				if (isset($value)) {

					if (!ini_get ('magic_quotes_gpc')) {

						if (!is_array($value))
							$value = addslashes($value);
						else
							$value = sm_slasharray($value);
					}
					//$value = stripslashes($value);
					$GLOBALS[$key] = $value;
					unset($value);
				}
			}
		}
	
    sm_registerglobal('photo','photo1','photo2','photo3','photo4','photo5','photo6','photo7','photo8');
	
	if(isset($_POST['submit'])){
	   if (isset($_GET['id'])) {
				
			$transferfile = "images/student_images/";
			$transferfile = $transferfile.basename($_FILES["admission_profile_image"]["name"]);
			$file = basename($_FILES["admission_profile_image"]["name"]);
			if ($_FILES["admission_profile_image"]["name"]!=""){
				if ($_FILES["admission_profile_image"]["error"] > 0){}
				$admission_profile_image = $_FILES['admission_profile_image']['name'];
				if (is_uploaded_file($_FILES['admission_profile_image']['tmp_name'])) {	
					$ext = explode(".",$_FILES['admission_profile_image']['name']);
					$str = date("mdY_hms");
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];
					$updir = "images/student_images/";
					$uppath = $updir.$new_thumbname;
					move_uploaded_file($_FILES['admission_profile_image']['tmp_name'],$uppath);
					$file = $new_thumbname;
			} 
			}else { 
			$file = $photo;
			}
			
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_tenth_marksheet"]["name"]);		
			$file1 = basename($_FILES["admission_tenth_marksheet"]["name"]);		
			if ($_FILES["admission_tenth_marksheet"]["name"]!=""){		
				if ($_FILES["admission_tenth_marksheet"]["error"] > 0){}			
				$admission_tenth_marksheet = $_FILES['admission_tenth_marksheet']['name'];			
				if (is_uploaded_file($_FILES['admission_tenth_marksheet']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_tenth_marksheet']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_tenth_marksheet']['tmp_name'],$uppath);				
					$file1 = $new_thumbname;
			} 
			}else { 		
			$file1 = $photo1;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_tenth_passing_certificate"]["name"]);		
			$file2 = basename($_FILES["admission_tenth_passing_certificate"]["name"]);		
			if ($_FILES["admission_tenth_passing_certificate"]["name"]!=""){		
				if ($_FILES["admission_tenth_passing_certificate"]["error"] > 0){}			
				$admission_tenth_passing_certificate = $_FILES['admission_tenth_passing_certificate']['name'];			
				if (is_uploaded_file($_FILES['admission_tenth_passing_certificate']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_tenth_passing_certificate']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_tenth_passing_certificate']['tmp_name'],$uppath);				
					$file2 = $new_thumbname;
			} 
			}else { 		
			$file2 = $photo2;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_twelve_markesheet"]["name"]);		
			$file3 = basename($_FILES["admission_twelve_markesheet"]["name"]);		
			if ($_FILES["admission_twelve_markesheet"]["name"]!=""){		
				if ($_FILES["admission_twelve_markesheet"]["error"] > 0){}			
				$admission_twelve_markesheet = $_FILES['admission_twelve_markesheet']['name'];			
				if (is_uploaded_file($_FILES['admission_twelve_markesheet']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_twelve_markesheet']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_twelve_markesheet']['tmp_name'],$uppath);				
					$file3 = $new_thumbname;
				} 
			}else { 			
			$file3 = $photo3;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_twelve_passing_certificate"]["name"]);		
			$file4 = basename($_FILES["admission_twelve_passing_certificate"]["name"]);		
			if ($_FILES["admission_twelve_passing_certificate"]["name"]!=""){		
				if ($_FILES["admission_twelve_passing_certificate"]["error"] > 0){}			
				$admission_twelve_passing_certificate = $_FILES['admission_twelve_passing_certificate']['name'];			
				if (is_uploaded_file($_FILES['admission_twelve_passing_certificate']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_twelve_passing_certificate']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_twelve_passing_certificate']['tmp_name'],$uppath);				
					$file4 = $new_thumbname;
			} 
			}else { 				
			$file4 = $photo4;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_graduation_marksheet"]["name"]);		
			$file5 = basename($_FILES["admission_graduation_marksheet"]["name"]);		
			if ($_FILES["admission_graduation_marksheet"]["name"]!=""){		
				if ($_FILES["admission_graduation_marksheet"]["error"] > 0){}			
				$admission_graduation_marksheet = $_FILES['admission_graduation_marksheet']['name'];			
				if (is_uploaded_file($_FILES['admission_graduation_marksheet']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_graduation_marksheet']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_graduation_marksheet']['tmp_name'],$uppath);				
					$file5 = $new_thumbname;
			} 
			}else { 			
			$file5 = $photo5;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_recent_character_certificate"]["name"]);		
			$file6 = basename($_FILES["admission_recent_character_certificate"]["name"]);		
			if ($_FILES["admission_recent_character_certificate"]["name"]!=""){		
				if ($_FILES["admission_recent_character_certificate"]["error"] > 0){}			
				$admission_recent_character_certificate = $_FILES['admission_recent_character_certificate']['name'];			
				if (is_uploaded_file($_FILES['admission_recent_character_certificate']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_recent_character_certificate']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_recent_character_certificate']['tmp_name'],$uppath);				
					$file6 = $new_thumbname;
			} 
			}else { 			
			$file6 = $photo6;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_other_certificate"]["name"]);		
			$file7 = basename($_FILES["admission_other_certificate"]["name"]);		
			if ($_FILES["admission_other_certificate"]["name"]!=""){		
				if ($_FILES["admission_other_certificate"]["error"] > 0){}			
				$admission_other_certificate = $_FILES['admission_other_certificate']['name'];			
				if (is_uploaded_file($_FILES['admission_other_certificate']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_other_certificate']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_other_certificate']['tmp_name'],$uppath);				
					$file7 = $new_thumbname;
			} 
			}else { 				
			$file7 = $photo7;
			}
			 
			$transferfile = "images/student_certificates/";		
			$transferfile = $transferfile.basename($_FILES["admission_character_certificate"]["name"]);		
			$file8 = basename($_FILES["admission_character_certificate"]["name"]);		
			if ($_FILES["admission_character_certificate"]["name"]!=""){		
				if ($_FILES["admission_character_certificate"]["error"] > 0){}			
				$admission_character_certificate = $_FILES['admission_character_certificate']['name'];			
				if (is_uploaded_file($_FILES['admission_character_certificate']['tmp_name'])) {				
					$ext = explode(".",$_FILES['admission_character_certificate']['name']);				
					$str = date("mdY_hms");				
					$new_thumbname = "st_".$str."_".$ext[0].".".$ext[1];				
					$updir = "images/student_certificates/";				
					$uppath = $updir.$new_thumbname;				
					move_uploaded_file($_FILES['admission_character_certificate']['tmp_name'],$uppath);				
					$file8 = $new_thumbname;
			} 
			}else { 			
			$file8 = $photo8;
			}
			 
            $update =  "UPDATE `tbl_admission` SET `admission_form_no`='".$_POST['admission_form_no']."',`admission_no`='".$_POST['admission_no']."',`admission_title`='".$_POST['admission_title']."',`admission_first_name`='".$_POST['admission_first_name']."',`admission_middle_name`= '".$_POST['admission_middle_name']."',`admission_last_name`='".$_POST['admission_last_name']."',`admission_course_name`='".$_POST['admission_course_name']."',`admission_session`='".$_POST['admission_session']."',`admission_dob`='".$_POST['admission_dob']."',`admission_nationality`='".$_POST['admission_nationality']."',`admission_aadhar_no`='".$_POST['admission_aadhar_no']."',`date_of_admission`='".$_POST['date_of_admission']."',`admission_category`='".$_POST['admission_category']."',`admission_gender`='".$_POST['admission_gender']."',`admission_username`='".$_POST['admission_username']."',`admission_password`='".$_POST['admission_password']."',`admission_blood_group`='".$_POST['admission_blood_group']."',`admission_hostel`='".$_POST['admission_hostel']."',`admission_transport`='".$_POST['admission_transport']."',`admission_profile_image`='".$file."',`admission_residential_address`='".$_POST['admission_residential_address']."',`admission_state`='".$_POST['admission_state']."',`admission_city`='".$_POST['admission_city']."',`admission_district`='".$_POST['admission_district']."',`admission_pin_code`='".$_POST['admission_pin_code']."',`admission_home_landlineno`='".$_POST['admission_home_landlineno']."',`admission_mobile_student`='".$_POST['admission_mobile_student']."',`admission_father_phoneno`='".$_POST['admission_father_phoneno']."',`admission_emailid_father`='".$_POST['admission_emailid_father']."',`admission_emailid_student`='".$_POST['admission_emailid_student']."',`admission_father_name`='".$_POST['admission_father_name']."',`admission_father_whatsappno`='".$_POST['admission_father_whatsappno']."',`admission_mother_name`='".$_POST['admission_mother_name']."',`admission_high_school_board_university`='".$_POST['admission_high_school_board_university']."',`admission_high_school_college_name`='".$_POST['admission_high_school_college_name']."',`admission_high_school_passing_year`='".$_POST['admission_high_school_passing_year']."',`admission_high_school_per`='".$_POST['admission_high_school_per']."',`admission_high_school_subjects`='".$_POST['admission_high_school_subjects']."',`admission_intermediate_board_university`='".$_POST['admission_intermediate_board_university']."',`admission_intermediate_college_name`='".$_POST['admission_intermediate_college_name']."',`admission_intermediate_passing_year`='".$_POST['admission_intermediate_passing_year']."',`admission_intermediate_per`='".$_POST['admission_intermediate_per']."',`admission_intermediate_subjects`='".$_POST['admission_intermediate_subjects']."',`admission_graduation_board_university`='".$_POST['admission_graduation_board_university']."',`admission_graduation_college_name`='".$_POST['admission_graduation_college_name']."',`admission_graduation_passing_year`='".$_POST['admission_graduation_passing_year']."',`admission_graduation_per`='".$_POST['admission_graduation_per']."',`admission_graduation_subjects`='".$_POST['admission_graduation_subjects']."',`admission_post_graduation_board_university`='".$_POST['admission_post_graduation_board_university']."',`admission_post_graduation_college_name`='".$_POST['admission_post_graduation_college_name']."',`admission_post_graduation_others`='".$_POST['admission_post_graduation_others']."',`admission_post_graduation_per`='".$_POST['admission_post_graduation_per']."',`admission_post_graduation_subjects`='".$_POST['admission_post_graduation_subjects']."',`admission_others_board_university`='".$_POST['admission_others_board_university']."',`admission_others_college_name`='".$_POST['admission_others_college_name']."',`admission_others_passing_year`='".$_POST['admission_others_passing_year']."',`admission_others_per`='".$_POST['admission_others_per']."',`admission_others_subjects`='".$_POST['admission_others_subjects']."',`admission_tenth_marksheet`='".$file1."',`admission_tenth_passing_certificate`='".$file2."',`admission_twelve_markesheet`='".$file3."',`admission_twelve_passing_certificate`='".$file4."',`admission_graduation_marksheet`='".$file5."',`admission_recent_character_certificate`='".$file6."',`admission_other_certificate`='".$file7."',`admission_character_certificate`='".$file8."',`admission_course1`='".$_POST['admission_course1']."',`admission_board_university1`='".$_POST['admission_board_university1']."',`admission_year_of_passing1`='".$_POST['admission_year_of_passing1']."',`admission_percentage1`='".$_POST['admission_percentage1']."',`admission_course2`='".$_POST['admission_course2']."',`admission_board_university2`='".$_POST['admission_board_university2']."',`admission_year_of_passing2`='".$_POST['admission_year_of_passing2']."',`admission_percentage2`='".$_POST['admission_percentage2']."',`admission_course3`='".$_POST['admission_course3']."',`admission_board_university3`='".$_POST['admission_board_university3']."',`admission_year_of_passing3`='".$_POST['admission_year_of_passing3']."',`admission_percentage3`='".$_POST['admission_percentage3']."',`admission_course4`='".$_POST['admission_course4']."',`admission_board_university4`='".$_POST['admission_board_university4']."',`admission_year_of_passing4`='".$_POST['admission_year_of_passing4']."',`admission_percentage4`='".$_POST['admission_percentage4']."',`admission_course5`='".$_POST['admission_course5']."',`admission_board_university5`='".$_POST['admission_board_university5']."',`admission_year_of_passing5`='".$_POST['admission_year_of_passing5']."',`admission_percentage5`='".$_POST['admission_percentage5']."',`admission_name_of_org1`='".$_POST['admission_name_of_org1']."',`admission_designation1`='".$_POST['admission_designation1']."',`admission_duration1`='".$_POST['admission_duration1']."' ,`approval`='".$_POST['approval']."' WHERE admission_id = '".$_GET['id']."'";
					    if($con->query($update)){
					        $message="Dear $admission_first_name, Your Admission Form has been Successfully submitted.\nYour Username - $admission_username \n Password - $admission_password \nClick below link to login Student dashboard.\nhttp://nspsjsr.in/isms/student_login.php \n\nRegards,\nNETAJI SUBHAS PUBLIC SCHOOL, \nJamshedpur. ";
							$senderId="NSUJSR";
							$serverUrl="msg.msgclub.net";
							$authKey="6a4743a8355fb97aa42dc2452185a1cd";
							$routeId="1";
							$postData = array(
								'mobileNumbers' => $admission_mobile_student,
								'smsContent' => $message,
								'senderId' => $senderId,
								'routeId' => $routeId,
								"smsContentType" =>'english'
							);
							$data_json = json_encode($postData);
							$url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey;
							$ch = curl_init();
							curl_setopt_array($ch, array(
								CURLOPT_URL => $url,
								CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_json)),
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_POST => true,
								CURLOPT_POSTFIELDS => $data_json,
								CURLOPT_SSL_VERIFYHOST => 0,
								CURLOPT_SSL_VERIFYPEER => 0
							));
							curl_exec($ch);
							echo "<script>
									alert('Added successfully!!!');
									location.replace('student_list');
								</script>";
							}
							else
							echo "<script>
									alert('Something went wrong please try again!!!');
									location.replace('student_list');
								</script>";
			                }		 
					    }

			$sql = mysqli_query($con,"select * from tbl_admission where admission_id='".$_GET['id']."'");
			$row1 = mysqli_fetch_array($sql);


			$sql_course = "SELECT * FROM `tbl_course`
					    WHERE `status` = '$visible' && `course_id` = '".$row1["admission_course_name"]."';
					    ";
			$result_course = $con->query($sql_course);
			$row_course = $result_course->fetch_assoc();
                                    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Admission Form </title>
    <link rel="icon" href="images/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include 'include/navbar.php'; ?>
<?php include 'include/aside.php'; ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admission Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>            
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Admission Form</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
			
          <form role="form" action="#" method="POST" id="" enctype="multipart/form-data">
          <div class="card-body">
		  <div class="row">
		  <div class="col-md-12" id="error_section"></div>
		   <div class="col-4">
		  
		  <label>Give Approval</label>		 
		  <select name="approval" class="form-control">  
		  <option value="<?php echo $row1['approval']; ?>"><?php echo $row1['approval']; ?></option>	
		  <option value="Approve">Approve</option>
		  <option value="Not Approve">Not Approve</option>			  
		  </select>			
		  </div>
		  <div class="col-4">
		  
		  <label>Registration No</label>		 
			<input type="text" name="admission_id" value="<?php echo $row1['admission_id']; ?>" class="form-control" readonly>
		  </div>
		  <div class="col-4">
		  <label>Prospectus Form No</label>
			<input type="text" name="admission_form_no" value="<?php echo $row1['admission_form_no']; ?>" class="form-control" required>
		  </div>
		  <div class="col-4">
		  <label>Admission No</label>
			<input type="text" name="admission_no" class="form-control" value="" readonly placeholder="Generate By University">
		  </div>
		 			  
			      <div class="col-4">
                  <label>Title</label>
				  <select name="admission_title" class="form-control">  
                  <option value="<?php echo $row1['admission_title']; ?>"><?php echo $row1['admission_title']; ?></option>	
                  <option value="Master">Master</option>
                  <option value="Miss">Miss</option>
				  <option value="Mr">Mr</option>
				  <option value="Mrs">Mrs</option>				  
                  </select>				  
                  </div>
                
				<div class="col-4">
                  <label>First Name</label>
                  <input type="text" name="admission_first_name" value="<?php echo $row1['admission_first_name']; ?>" class="form-control" required>  
                </div> 				
                
				<div class="col-4">               
				 <label>Middle Name</label>
                  <input type="text" name="admission_middle_name" value="<?php echo $row1['admission_middle_name']; ?>" class="form-control" >                      	  
                </div>
				
			    <div class="col-4">
                  <label>Last Name</label>
                   <input type="text" name="admission_last_name" value="<?php echo $row1['admission_last_name']; ?>" class="form-control">  
                </div>
					
                 <div class="col-4">   
                 <label>Course</label>
                 <select name="admission_course_name" class="form-control">
				   <?php
						$sql_c = "SELECT * FROM `tbl_course`
									   WHERE `status` = '$visible';
									   ";
						$result_c = $con->query($sql_c);
						while($row_c = $result_c->fetch_assoc()){
					?>
					<option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
					<?php } ?>
				</select>			
                </div> 				
				
			      
                
				 <div class="col-4">
                  <label>Session</label>
                   <select name="admission_session"  class="form-control">
				   <?php
						$sql_c = "SELECT * FROM `tbl_university_details`
									   WHERE `status` = '$visible';
									   ";
						$result_c = $con->query($sql_c);
						while($row_c = $result_c->fetch_assoc()){
					?>
					<option value="<?php echo $row_c["university_details_id"]; ?>" <?php if($row_c["university_details_id"] == $row1["admission_session"]) echo 'selected'; ?> ><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
					<?php } ?>
				</select>
                </div>
                 <div class="col-4">
                  <label>Date Of Birth</label>
				  <input type="date" name="admission_dob" value="<?php echo $row1["admission_dob"]; ?>" class="form-control" >                   				
                </div>   			  
			  
                <div class="col-4">  
                 <label>Nationality</label>
                 <input type="text" name="admission_nationality" value="<?php echo $row1["admission_nationality"]; ?>" class="form-control" > 
                </div>   
                <div class="col-4">
                  <label>Aadhar No</label>
                  <input type="text" name="admission_aadhar_no" value="<?php echo $row1["admission_aadhar_no"]; ?>" class="form-control" >  
                </div>				
			  
			    <div class="col-4">                   
                 <label>Date Of Admission</label>
                  <input type="date" name="date_of_admission" value="<?php echo $row1["date_of_admission"]; ?>" class="form-control" >				
                </div> 
                <div class="col-4">
                  <label>Category</label>
                  <select name="admission_category" class="form-control">
                  <option value="<?php echo $row1["admission_category"]; ?>"><?php echo $row1["admission_category"]; ?></option>					  
                  <option value="General">General</option>
                  <option value="SC">SC</option>	
                  <option value="ST">ST</option>
                  <option value="OBC">OBC</option>				  
                  </select>	
                </div>
				<div class="col-4">
                  <label>Gender</label>
                  <select name="admission_gender" class="form-control">
                  <option value="<?php echo $row1["admission_gender"]; ?>"><?php echo $row1["admission_gender"]; ?></option>				  
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>				  
                  </select>	                				  
                </div>

              
			   <div class="col-md-4">
                  <label>Username</label>
                  <input type="text" name="admission_username"  value="<?php echo $row1["admission_username"]; ?>" class="form-control" required>  
                </div>              
                <div class="col-4">
                  <label>Password</label>
                  <input type="text" name="admission_password" value="<?php echo $row1["admission_password"]; ?>" class="form-control" required>  
                </div>
                <div class="col-4">   
                 <label>Blood Group</label>
                  <input type="text" name="admission_blood_group" value="<?php echo $row1["admission_blood_group"]; ?>" class="form-control">				
                </div>				
              
			  <div class="col-4">   
                 <label>Hostel</label>
                  <select name="admission_hostel" class="form-control">
                  <option value="<?php echo $row1["admission_hostel"]; ?>"><?php echo $row1["admission_hostel"]; ?></option>					  
                  <option value="No">No</option>				 
                  <option value="Yes">Yes</option>                 				  
                  </select>			
                </div> 
               <div class="col-4">
                  <label>Transport</label>
                  <select name="admission_transport" class="form-control"> 
				  <option value="<?php echo $row1["admission_transport"]; ?>"><?php echo $row1["admission_transport"]; ?></option>	
                  <option value="No">No</option>				 
                  <option value="Yes">Yes</option>                 				  
                  </select>
                </div>
			  
			  <div class="col-4">
                  	
                </div> 
				<div class="col-4">   
                <label>Image</label>
				<input name="admission_profile_image" type="file" class="form-control"  />
				<input type="hidden" name="photo" class="form-control" value="<?php echo $row1['admission_profile_image']; ?>"  />			
                </div>
                <div class="col-4"> 
				  <img src="images/student_images/<?php echo $row1['admission_profile_image']; ?>"  style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120" height="120">				               
               </div>                          
             
			</div>
	    </div>
	</div>
			 
			<div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title">PRESENT ADDRESS</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
              <div class="card-body">
            <div class="row">
              <div class="col-4">
			  <label>Residential Address</label>
				<textarea name="admission_residential_address" value="<?php echo $row1["admission_residential_address"]; ?>" class="form-control" style="height: 38px;"><?php echo $row1["admission_residential_address"]; ?></textarea>
			  </div>
			  <div class="col-4">
			  <label>State</label>
				<input type="text" name="admission_state" value="<?php echo $row1["admission_state"]; ?>" class="form-control">
			  </div>
              <div class="col-4">
			  <label>City</label>
				<input type="text" name="admission_city" value="<?php echo $row1["admission_city"]; ?>" class="form-control">
			  </div>
			  <div class="col-4">
			  <label>District</label>
				<input type="text" name="admission_district" value="<?php echo $row1["admission_district"]; ?>" class="form-control">
			  </div>			  
			  <div class="col-4">
			  <label>Pin Code</label>
				<input type="text" name="admission_pin_code" value="<?php echo $row1["admission_pin_code"]; ?>" class="form-control">
			  </div>  
              <div class="col-4">
			  <label>Home Landline no.</label>
				<input type="text" name="admission_home_landlineno" value="<?php echo $row1["admission_home_landlineno"]; ?>" class="form-control">
			  </div>			  
			  <div class="col-4">
			  <label>Mobile No. (Student)</label>
				<input type="text" name="admission_mobile_student" value="<?php echo $row1["admission_mobile_student"]; ?>" class="form-control">
			  </div>			  			  
			  <div class="col-4">
			  <label>Father Phone No.</label>
				<input type="text" name="admission_father_phoneno" value="<?php echo $row1["admission_father_phoneno"]; ?>" class="form-control">
			  </div>
			  <div class="col-4">
			  <label>Email Id (Father)</label>
				<input type="email" name="admission_emailid_father" value="<?php echo $row1["admission_emailid_father"]; ?>" class="form-control">
			  </div>
			  <div class="col-4">
			  <label>Email Id (Student)</label>
				<input type="email" name="admission_emailid_student" value="<?php echo $row1["admission_emailid_student"]; ?>"  class="form-control">
			  </div>
		
            </div>
			  </div>
              </div>
			  </div>
			  
			  <div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title">Parent Details</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
              <div class="card-body">
            <div class="row">
              <div class="col-4">
			  <label>Father Name</label>
				<input type="text" name="admission_father_name" value="<?php echo $row1["admission_father_name"]; ?>" class="form-control">
			  </div>
			  <div class="col-4">
			  <label>Father Whatsapp No</label>
				<input type="text" name="admission_father_whatsappno" value="<?php echo $row1["admission_father_whatsappno"]; ?>" class="form-control">
			  </div>
              <div class="col-4">
			  <label>Mother Name</label>
				<input type="text" name="admission_mother_name" value="<?php echo $row1["admission_mother_name"]; ?>" class="form-control">
			  </div>		
            </div>
		    </div>
		    </div>
		    </div>
			   
			  <div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title">Academic Details</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Qualification</th>
                      <th>Board/University</th>
                      <th>School/College Name</th>
                      <th>Year Of Passing</th>
					  <th>Percentage or CGPA</th>
                      <th>Subjects</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>High School</td>
					  <td><input type="text" name="admission_high_school_board_university" value="<?php echo $row1["admission_high_school_board_university"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_high_school_college_name" value="<?php echo $row1["admission_high_school_college_name"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_high_school_passing_year" value="<?php echo $row1["admission_high_school_passing_year"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_high_school_per" value="<?php echo $row1["admission_high_school_per"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_high_school_subjects" value="<?php echo $row1["admission_high_school_subjects"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>2</td>
                      <td>Intermediate</td>
					  <td><input type="text" name="admission_intermediate_board_university" value="<?php echo $row1["admission_intermediate_board_university"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_intermediate_college_name" value="<?php echo $row1["admission_intermediate_college_name"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_intermediate_passing_year" value="<?php echo $row1["admission_intermediate_passing_year"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_intermediate_per" value="<?php echo $row1["admission_intermediate_per"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_intermediate_subjects" value="<?php echo $row1["admission_intermediate_subjects"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>3</td>
                      <td>Graduation</td>
					  <td><input type="text" name="admission_graduation_board_university" value="<?php echo $row1["admission_graduation_board_university"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_graduation_college_name" value="<?php echo $row1["admission_graduation_college_name"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_graduation_passing_year" value="<?php echo $row1["admission_graduation_passing_year"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_graduation_per" value="<?php echo $row1["admission_graduation_per"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_graduation_subjects" value="<?php echo $row1["admission_graduation_subjects"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>4</td>
                      <td>Post Graduation</td>
					  <td><input type="text" name="admission_post_graduation_board_university" value="<?php echo $row1["admission_post_graduation_board_university"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_post_graduation_college_name" value="<?php echo $row1["admission_post_graduation_college_name"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_post_graduation_others" value="<?php echo $row1["admission_post_graduation_others"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_post_graduation_per" value="<?php echo $row1["admission_post_graduation_per"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_post_graduation_subjects" value="<?php echo $row1["admission_post_graduation_subjects"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>5</td>
                      <td>Others</td>
					  <td><input type="text" name="admission_others_board_university" value="<?php echo $row1["admission_others_board_university"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_others_college_name" value="<?php echo $row1["admission_others_college_name"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_others_passing_year" value="<?php echo $row1["admission_others_passing_year"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_others_per" value="<?php echo $row1["admission_others_per"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_others_subjects" value="<?php echo $row1["admission_others_subjects"]; ?>" size="15" value=""></td>
                    </tr>
                  </tbody>
                </table>
              </div>
			  </div>
              
			   
			  <div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title">Documents Required For Admission</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
              <div class="card-body">
            <div class="row">
              <div class="col-3">
			  <label>10th Marksheet</label>
				<input type="file" name="admission_tenth_marksheet" class="form-control">
				<input type="hidden" name="photo1" class="form-control" value="<?php echo $row1['admission_tenth_marksheet']; ?>"  />	
			  </div>
			   <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_tenth_marksheet']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_tenth_marksheet']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
              <div class="col-3">
			  <label>10th Passing Certificate</label>
				<input type="file" name="admission_tenth_passing_certificate" class="form-control">
				<input type="hidden" name="photo2" class="form-control" value="<?php echo $row1['admission_tenth_passing_certificate']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_tenth_passing_certificate']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_tenth_passing_certificate']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
			  <div class="col-3">
			  <label>12th Marksheet</label>
				<input type="file" name="admission_twelve_markesheet" class="form-control">
				<input type="hidden" name="photo3" class="form-control" value="<?php echo $row1['admission_twelve_markesheet']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_twelve_markesheet']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_twelve_markesheet']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
			  <div class="col-3">
			  <label>12th Passing Certificate</label>
				<input type="file" name="admission_twelve_passing_certificate" class="form-control">
				<input type="hidden" name="photo4" class="form-control" value="<?php echo $row1['admission_twelve_passing_certificate']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_twelve_passing_certificate']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_twelve_passing_certificate']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
              <div class="col-3">
			  <label>Graduation Marksheet</label>
				<input type="file" name="admission_graduation_marksheet" class="form-control">
				<input type="hidden" name="photo5" class="form-control" value="<?php echo $row1['admission_graduation_marksheet']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_graduation_marksheet']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_graduation_marksheet']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
			  <div class="col-3">
			  <label>Recent Character Certificate</label>
				<input type="file" name="admission_recent_character_certificate" class="form-control">
				<input type="hidden" name="photo6" class="form-control" value="<?php echo $row1['admission_recent_character_certificate']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_recent_character_certificate']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_recent_character_certificate']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
			  <div class="col-3">
			  <label>Other Certificate (If applicable)</label>
				<input type="file" name="admission_other_certificate" class="form-control">
				<input type="hidden" name="photo7" class="form-control" value="<?php echo $row1['admission_other_certificate']; ?>"  />	
			  </div>
			  <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_other_certificate']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_other_certificate']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
			  <div class="col-3">
			  <label>Character Certificate (If applicable)</label>
				<input type="file" name="admission_character_certificate" class="form-control">
				<input type="hidden" name="photo8" class="form-control" value="<?php echo $row1['admission_character_certificate']; ?>"  />	
			  </div>
		       <div class="col-1"> 
				  <a href="images/student_certificates/<?php echo $row1['admission_character_certificate']; ?>"><img src="images/student_certificates/<?php echo $row1['admission_character_certificate']; ?>"  style="margin-top:17px;margin-left:5px;border:solid 1px lightgray;" width="60" height="60"></a>			               
               </div> 
            </div>
			  </div>
              </div>
			  </div>
			  
			<div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title">TECHNICAL QUALIFICATION (IF ANY)</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Course</th>
                      <th>Board / University</th>
                      <th>Year Of Passing</th>
                      <th>Percentage or CGPA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
					  <td><input type="text" name="admission_course1" value="<?php echo $row1["admission_course1"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_board_university1" value="<?php echo $row1["admission_board_university1"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_year_of_passing1" value="<?php echo $row1["admission_year_of_passing1"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_percentage1" value="<?php echo $row1["admission_percentage1"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>2</td>
					  <td><input type="text" name="admission_course2" value="<?php echo $row1["admission_course2"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_board_university2" value="<?php echo $row1["admission_board_university2"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_year_of_passing2" value="<?php echo $row1["admission_year_of_passing2"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_percentage2" value="<?php echo $row1["admission_percentage2"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>3</td>
					  <td><input type="text" name="admission_course3" value="<?php echo $row1["admission_course3"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_board_university3" value="<?php echo $row1["admission_board_university3"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_year_of_passing3" value="<?php echo $row1["admission_year_of_passing3"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_percentage3" value="<?php echo $row1["admission_percentage3"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>4</td>
					  <td><input type="text" name="admission_course4" value="<?php echo $row1["admission_course4"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_board_university4" value="<?php echo $row1["admission_board_university4"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_year_of_passing4" value="<?php echo $row1["admission_year_of_passing4"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_percentage4" value="<?php echo $row1["admission_percentage4"]; ?>" size="15" value=""></td>
                    </tr>
					<tr>
                      <td>5</td>
					  <td><input type="text" name="admission_course5" value="<?php echo $row1["admission_course5"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_board_university5" value="<?php echo $row1["admission_board_university5"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_year_of_passing5" value="<?php echo $row1["admission_year_of_passing5"]; ?>" size="15" value=""></td>
					  <td><input type="text" name="admission_percentage5" value="<?php echo $row1["admission_percentage5"]; ?>" size="15" value=""></td>
                    </tr>
                  </tbody>
                </table>
              </div>
			  </div>
			  
			  <div class="card card-secondary">
			  <div class="card-header">
                <h3 class="card-title"> WORK EXPERIENCE (IF ANY)</h3>
              </div>
			  			  
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Name of organisation</th>
                      <th>Designation</th>
                      <th>Duration</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
					  <td><input type="text" name="admission_name_of_org1" value="<?php echo $row1["admission_name_of_org1"]; ?>"  size="15"></td>
					  <td><input type="text" name="admission_designation1" value="<?php echo $row1["admission_designation1"]; ?>"  size="15"></td>
					  <td><input type="text" name="admission_duration1" value="<?php echo $row1["admission_duration1"]; ?>"  size="15"></td>
					  <!--<td><input type="text" name="admission_location1" value="<?php echo $row1["admission_location1"]; ?>"  size="15"></td>-->
                    </tr>
				<!--	<tr>
                      <td>2</td>
					  <td><input type="text" name="admission_name_of_org2" value="<?php echo $row1["admission_name_of_org2"]; ?>"  size="15"></td>
					  <td><input type="text" name="admission_designation2" value="<?php echo $row1["admission_designation2"]; ?>"  size="15"></td>
					  <td><input type="text" name="admission_duration2" value="<?php echo $row1["admission_duration2"]; ?>"  size="15"></td>
					  <td><input type="text" name="admission_location2" value="<?php echo $row1["admission_location2"]; ?>"  size="15"></td>
                    </tr>-->
                  </tbody>
                </table>
              </div>
			  </div>
                        
			<div class="col-md-12">
			<div id="loader_section"></div>
			</div>
			<div class="col-md-6">
				<input type="hidden" name="action" value="add_admission" />
				<!--<button type="submit" id="add_admission_button" class="btn btn-primary">Submit</button>-->
				<input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
				<button type="reset" class="btn btn-primary">Reset</button>
			</div>      		  
		  </form>
        			
      </div>
    </section>
    <!-- /.content -->
  </div>

  <?php include 'include/footer.php'; ?>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
</body>
</html>