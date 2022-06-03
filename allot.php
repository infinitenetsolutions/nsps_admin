<?php   //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
    include "include/db_class.php";
    // Setting Time Zone in India Standard Timing
    $random_number = rand(111111,999999); // Random Number
    $s_no = 1; //Serial Number
    $visible = md5("visible");
    $trash = md5("trash");
	date_default_timezone_set("Asia/Calcutta");
    $date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
   
    //Creating Object NSUNIV
    $objectDefault = new DBEVAL();
    $objectDefault->sql = "";
    $objectDefault->hostName = "";
    $objectDefault->userName = "";
    $objectDefault->password = "";
    $objectDefault->dbName =   "";
   $objectDefault->new_db("localhost", "root", "", "nsucms_demo_nsuniv");
    //Creating Object NSUCMS
    $objectSecond = new DBEVAL();
    $objectSecond->sql = "";
    $objectSecond->hostName = "";
    $objectSecond->userName = "";
    $objectSecond->password = "";
    $objectSecond->dbName =   "";
     $objectSecond->new_db("localhost", "root", "", "nsucms_cms");
    //All File Directries End

    if(isset($_GET["action"])){
    //Allocate semester to student Start
        if($_GET["action"] == "fetch_student_semester"){
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];
            if($academic_year != 0){
            ?>
        
        <form action="allot1.php" method="post" enctype="multipart/form-data">
           <table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
                <thead>
                    <tr>
                        <th width="10%">S.No</th>
                        <th  width="10%">Reg. No</th>
                        <th width="10%">Student Name</th>
                        <th width="10%">Course</th> 
                        <th width="10%">Session</th>                       
                        <th width="10%">Allot Roll No</th> 						
                        <th class="project-actions text-center">Allot Semester </th>
                    </tr>
                </thead>
                 <tbody>         
                   <?php 
                        if($course_id == "all")
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' 
                                    
                                    ";
                        else
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id'
                                   
                                    ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
									<input type="hidden" name="admission_id[]" class="form-control" value="<?php echo $row["admission_id"] ?>" >
                                      <?php 
                                        $sql_reg = "SELECT * FROM `tbl_admission_details`
                                                       WHERE `status` = '$visible' && `admission_id` = '".$row["admission_id"]."';
                                                       ";
                                        $result_reg = $con->query($sql_reg);
                                        $row_reg = $result_reg->fetch_assoc();
                                      ?>
                                     <td> <input type="text" name="reg_no[]" class="form-control" value="<?php echo $row_reg["reg_no"] ?>" readonly></td>
                                      <td><?php echo $row["admission_first_name"]." ". $row["admission_middle_name"] ." ". $row["admission_last_name"] ?></td>
									  <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                      ?>
                                     <input type="hidden" name="course_id[]" value="<?php echo $row["admission_course_name"]; ?>">
									 <input type="hidden" name="academic_year[]" value="<?php echo $row["admission_session"]; ?>" >
                                    
									<td><?php echo $row_course["course_name"]; ?></td>
                                   <!-- <td></td>-->
                                    <?php 
                                    $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                                    WHERE university_details_id = '".$row["admission_session"]."';";
                                    $result_ac_year = $con->query($sql_ac_year);
                                    $row_ac_year = $result_ac_year->fetch_assoc();?>
									<?php 
									  $completeSessionStart = explode("-", $row_ac_year["university_details_academic_start_date"]);
									  $completeSessionEnd = explode("-", $row_ac_year["university_details_academic_end_date"]);
									  $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
									?>
                                    <td><option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo $completeSessionOnlyYear ; ?></option></td> 
                                    <td> <input type="text" name="roll_no[]" class="form-control" value="<?php echo $row_reg["roll_no"] ?>" readonly></td>
                                    <td>  
									<?php 
										$sql_course = "SELECT * FROM `tbl_semester`
													   WHERE `semester_id` = '".$row_reg["semester_id"]."';
													   ";
										$result_course = $con->query($sql_course);
										$row_course = $result_course->fetch_assoc();
									?>									
                                        <select class="form-control" name="semester_id[]">
                                            <option value="<?php echo $row_reg["semester_id"]; ?>"><?php echo $row_course["semester"]; ?></option>										
                                                <?php 
                                                   	$sql_course = "SELECT * FROM `tbl_semester`
													   WHERE `course_id` = '".$row["admission_course_name"]."';
													   ";
										$result_course = $con->query($sql_course);
                                                    while($rows = $result_course->fetch_assoc()){
                                                ?>
                                                <option value="<?php echo $rows["semester_id"]; ?>"><?php echo $rows["semester"]; ?></option>
                                                <?php } ?>
                                        </select>
                                    </td>                                                   
                                </tr>                        
                            <?php 
                                $s_no++;
                            }
                        } else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                                </div>';
                    ?>
                          <tr>
							<td height="40" colspan="8" valign="middle" align="center" class="narmal">		
							<input type="submit" name="submit" value="Submit" class="btn btn-primary">
							 
							</td>
						  </tr>
                </tbody>
            
     <div class="col-12" id="error_section"></div>				 
				 </table>
				 </form>
           
        <?php      
            } else
                echo "0";
            ?>
         
	<?php  } }
        //Allocate semester to student list end