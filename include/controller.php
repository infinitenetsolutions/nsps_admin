<?php

//Starting Session
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//error_reporting(0);

//   echo"<pre>"; print_r($_POST); //exit();


if (empty(session_start()))
    session_start();
//DataBase Connectivity
include "config.php";
include "db_class.php";
// Setting Time Zone in India Standard Timing
$random_number = rand(111111, 999999); // Random Number
$visible = md5("visible");
$trash = md5("trash");
date_default_timezone_set("Asia/Calcutta");
$date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
//All File Directries Start
$university_logos_dir = "../images/university_logos";
$admission_profile_image_dir = "../images/student_images";
$certificates = "../images/student_certificates";
$nssImageDir = "../images/nss/";
//Creating Object NSUNIV
$objectDefault = new DBEVAL();
$objectDefault->sql = "";
$objectDefault->hostName = "";
$objectDefault->userName = "";
$objectDefault->password = "";
$objectDefault->dbName =   "";
// $objectDefault->new_db("localhost", "root", "", "nsucms_demo_nsuniv");
//Creating Object NSUCMS
$objectSecond = new DBEVAL();
$objectSecond->sql = "";
$objectSecond->hostName = "";
$objectSecond->userName = "";
$objectSecond->password = "";
$objectSecond->dbName =   "";
// $objectSecond->new_db("localhost", "root", "", "nsucms_cms");
//All File Directries End
if (isset($_POST["action"])) {
    //Action Section Start
    /* ---------- All Admin(Backend) Codes Start ---------- */
    //Login Section Start With Ajax
    if ($_POST["action"] == "admin_login") {
        $admin_login_username = $_POST["admin_login_username"];
        $admin_login_password = md5($_POST["admin_login_password"]);
        if (!empty($admin_login_username && $admin_login_password)) {
            $sql = "SELECT * FROM `tbl_admin`
                        WHERE `admin_username` = '$admin_login_username' && `admin_password` = '$admin_login_password' && `status` = '$visible'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row["admin_type"] == "superadmin") {
                    $_SESSION["logger_type"] = "admin";
                    $_SESSION["admin_branch"] = '0';
                    $_SESSION["authority"] = $row["admin_permission"];

                } else {
                    $_SESSION["logger_type"] = "subadmin";
                    $_SESSION["authority"] = $row["admin_permission"];
                    $_SESSION["admin_name"] = $row["admin_name"];
                    $_SESSION["admin_branch"] = $row["admin_branch"];
                }
                $_SESSION["logger_username"] = $admin_login_username;
                $_SESSION["logger_password"] = $admin_login_password;

                $_SESSION["logger_time"] = time();
                echo '
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-check"></i> You have logged in Successfully!!!
                        </div>';
                echo "<script> location.replace('dashboard') </script>";
            } else
                echo '
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-ban"></i> Incorrect Credential, Please try again!!!
                        </div>';
        } else {
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Username and Password!!!
                    </div>';
        }
    }
    //Login Section End With Ajax
    //Change Password Section Start With Ajax
    if ($_POST["action"] == "sendOtpForPassword") {
        if (isset($_SESSION["logger_username"])) {
            $sql = "SELECT * FROM `tbl_admin`
                        WHERE `admin_username` = '" . $_SESSION["logger_username"] . "' && `admin_password` = '" . $_SESSION["logger_password"] . "' && `status` = '$visible'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (isset($_SESSION["OTP_REAR"]))
                    unset($_SESSION["OTP_REAR"]);
                $_SESSION["OTP_REAR"] = $random_number;
                $message = "Your OTP for Change password $random_number, Please do not share this OTP to anyone.\n\n Regards,\nNetaji Subhas Public School, JSR";
                $objectSecond->send_otp($row["admin_mobile"], $message);
                echo "success";
            }
        }
    }
    if ($_POST["action"] == "checkOtpForPassword") {
        if (isset($_SESSION["OTP_REAR"])) {
            if ($_SESSION["OTP_REAR"] == $_POST["checkOTPForPass"]) {
                echo "success";
                unset($_SESSION["OTP_REAR"]);
            } else
                echo "Incorrect OTP, Please try again with correct OTP...";
        } else
            echo "Something went wrong plase try again...";
    }
    if ($_POST["action"] == "changeForPassword") {
        if (isset($_SESSION["logger_username"])) {
            $sql = "UPDATE `tbl_admin` SET `admin_password` = '" . md5($_POST["changePassOne"]) . "'
                        WHERE `admin_username` = '" . $_SESSION["logger_username"] . "' && `admin_password` = '" . $_SESSION["logger_password"] . "' && `status` = '$visible'
                        ";
            if ($con->query($sql))
                echo "success";
            else
                echo "Something went wrong please try agian...";
        } else
            echo "Something went wrong please try agian...";
    }
    //Change Password Section End With Ajax
    //Add University Details Start
    if ($_POST["action"] == "add_university_details") {
        $add_university_details_financial_start_date = $_POST["add_university_details_financial_start_date"];
        $add_university_details_financial_end_date = $_POST["add_university_details_financial_end_date"];
        $add_university_details_academic_start_date = $_POST["add_university_details_academic_start_date"];
        $add_university_details_academic_end_date = $_POST["add_university_details_academic_end_date"];
        $add_university_details_university_name = $_POST["add_university_details_university_name"];
        $add_university_details_affiliation_details = $_POST["add_university_details_affiliation_details"];
        $add_university_details_address = $_POST["add_university_details_address"];
        $add_university_details_email = $_POST["add_university_details_email"];
        $add_university_details_contact = $_POST["add_university_details_contact"];
        $add_university_details_logo_image = $_FILES["add_university_details_logo_image"]["name"];
        $add_university_details_website_url = $_POST["add_university_details_website_url"];
        if (!empty($add_university_details_financial_start_date && $add_university_details_financial_end_date && $add_university_details_academic_start_date && $add_university_details_academic_end_date && $add_university_details_university_name && $add_university_details_affiliation_details && $add_university_details_address && $add_university_details_email && $add_university_details_contact  && $add_university_details_website_url)) {
            $add_university_details_logo_image_rand = $random_number . "_" . $add_university_details_logo_image;
            if (move_uploaded_file($_FILES["add_university_details_logo_image"]["tmp_name"], "$university_logos_dir/$add_university_details_logo_image_rand")) {
                $sql = "INSERT INTO `tbl_university_details`
                                (`university_details_id`, `university_details_financial_start_date`, `university_details_financial_end_date`, `university_details_academic_start_date`, `university_details_academic_end_date`, `university_details_university_name`, `university_details_affiliation_details`, `university_details_address`, `university_details_email`, `university_details_contact`, `university_details_logo_image`, `university_details_website_url`, `status`) 
                                VALUES 
                                (NULL,'$add_university_details_financial_start_date','$add_university_details_financial_end_date','$add_university_details_academic_start_date','$add_university_details_academic_end_date','$add_university_details_university_name','$add_university_details_affiliation_details','$add_university_details_address','$add_university_details_email','$add_university_details_contact','$add_university_details_logo_image_rand','$add_university_details_website_url','$visible')
                                ";
                if ($con->query($sql)) {
                    echo "<script>
                                    alert('University details added successfully!!!');
                                    location.replace('../add_university_details');
                                </script>";
                } else
                    echo "<script>
                                    alert('Something went wrong please try again!!!');
                                    location.replace('../add_university_details');
                                </script>";
            } else
                echo "<script>
                                    alert(' Image not uploaded successfully !!!');
                                    location.replace('../add_university_details');
                                </script>";
        } else {
            echo "<script>
                                alert('Please fill out all required fields!!!');
                                location.replace('../add_university_details');
                            </script>";
        }
    }
    //Add University Details End


    //Add Courses Start With Ajax
    if ($_POST["action"] == "add_courses") {
        $add_course_name = $_POST["add_course_name"];
        if (!empty($add_course_name)) {
            $sql = "SELECT * FROM `tbl_class`
                        WHERE `status` = '$visible' && `course_name` = '$add_course_name'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
                echo '
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> This Course already exsits!!!
                        </div>';
            else {
                $sql = "INSERT INTO `tbl_class`
                            (`course_id`, `course_name`, `course_time`, `status`) 
                            VALUES 
                            (NULL,'$add_course_name','$date_variable_today_month_year_with_timing','$visible')
                            ";
                if ($con->query($sql))
                    echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Class added successfully!!!
                            </div>';
                else
                    echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
            }
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Course Name!!!
                    </div>';
    }
    //Add Courses End With Ajax

    //Add Branches Start With Ajax
    if ($_POST["action"] == "add_branches") {
        $add_branch_name = $_POST["add_branch_name"];
        $add_branch_address = $_POST["add_branch_address"];
        $add_branch_phone = $_POST["add_branch_phone"];
        if (!empty($add_branch_name)) {
            $sql = "SELECT * FROM `tbl_branch`
                        WHERE `branch_name` = '$add_branch_name'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
                echo '
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> This Branch already exsits!!!
                        </div>';
            else {
                $sql = "INSERT INTO `tbl_branch`
                            (`id`, `branch_name`, `branch_address`, `branch_phone`) 
                            VALUES 
                            (NULL,'$add_branch_name','$add_branch_address','$add_branch_phone')
                            ";
                if ($con->query($sql))
                    echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Branch added successfully!!!
                            </div>';
                else
                    echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
            }
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Branch Name!!!
                    </div>';
    }
    //Add Branches End With Ajax

    //Add Employee Start With Ajax
    if ($_POST["action"] == "add_employee") {
        $add_employee_name = $_POST["add_employee_name"];
        $add_employee_address = $_POST["add_employee_address"];
        $add_employee_phone = $_POST["add_employee_phone"];
        $add_employee_email = $_POST["add_employee_email"];
        if (!empty($add_employee_phone)) {
            $sql = "SELECT * FROM `tbl_employee` WHERE `phone` = '$add_employee_phone'";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
                echo '
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> This employee already exsits!!!
                        </div>';
            else {
                $sql = "INSERT INTO `tbl_employee`
                            (`id`, `name`, `address`, `phone` , `email`) 
                    VALUES (NULL,'$add_employee_name','$add_employee_address','$add_employee_phone', '$add_employee_email')";
                if ($con->query($sql))
                    echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Employee added successfully!!!
                            </div>';
                else
                    echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
            }
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Employee Phone!!!
                    </div>';
    }
    //Add Employee End With Ajax

    //Delete Exam Start With Ajax
    if ($_POST["action"] == "delete_branch") {
        $delete_branch_id = $_POST["delete_branch_id"];
        if (!empty($delete_branch_id)) {
            // $sql = "DELETE FROM `tbl_branch` WHERE `id`='$delete_branch_id'";
            $sql = "DELETE FROM `tbl_branch` WHERE `id`='$delete_branch_id'";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Exam End With Ajax

    //Add Exam Start With Ajax
    if ($_POST["action"] == "add_exam") {
        $add_exam_name = $_POST["add_exam_name"];
        if (!empty($add_exam_name)) {
            $sql = "SELECT * FROM `tbl_exam`
                        WHERE `status` = '$visible' && `exam_name` = '$add_exam_name'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
                echo '
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> This exam already exsits!!!
                        </div>';
            else {
                $sql = "INSERT INTO `tbl_exam`
                            (`exam_id`, `exam_name`, `create_time`, `status`) 
                            VALUES 
                            (NULL,'$add_exam_name','$date_variable_today_month_year_with_timing','$visible')
                            ";


                if ($con->query($sql))
                   { echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Exam added successfully!!!
                            </div>';
                    echo "<script>window.location.reload();</script>";}
                else
                    echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
            }
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Exam Name!!!
                    </div>';
    }
    //Add Exam End With Ajax



    //Edit Courses Start With Ajax
    if ($_POST["action"] == "edit_courses") {
        $edit_course_name = $_POST["edit_course_name"];
        $edit_course_id = $_POST["edit_course_id"];

        if (!empty($edit_course_name && $edit_course_id)) {
            $sql = "SELECT * FROM `tbl_class`
                        WHERE `status` = '$visible' && `course_name` = '$edit_course_name';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo 'exsits';
            } else {
           
           $sql = "UPDATE `tbl_class` SET `course_name` = '$edit_course_name', `course_time` = '$date_variable_today_month_year_with_timing' 
                            WHERE `status` = '$visible' && `course_id` = '$edit_course_id';";
                if ($con->query($sql))
                    {
                        echo 'success';
                    }
                else
                    echo 'error';
             }
        } else
            echo 'empty';
    }
    //Edit Courses End With Ajax

    //Edit Exam Start With Ajax
    if ($_POST["action"] == "edit_exam") {
        $edit_exam_name = $_POST["edit_course_name"];
        $edit_exam_id = $_POST["edit_course_id"];
        if (!empty($edit_exam_name && $edit_exam_id)) {
            $sql = "SELECT * FROM `tbl_exam`
                        WHERE `status` = '$visible' && `exam_name` = '$edit_exam_name';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo 'exsits';
            } else {
                $sql = "UPDATE `tbl_exam` SET `exam_name` = '$edit_exam_name', `create_time` = '$date_variable_today_month_year_with_timing' 
                            WHERE `status` = '$visible' && `exam_id` = '$edit_exam_id';";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Edit Exam End With Ajax



    //Delete Exam Start With Ajax
    if ($_POST["action"] == "delete_exam") {
        $delete_course_id = $_POST["delete_course_id"];
        if (!empty($delete_course_id)) {
            $sql = "UPDATE `tbl_exam` 
                        SET 
                        `status` = '$trash', `create_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `exam_id` = '$delete_course_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }


    //Delete Exam End With Ajax


    //Delete Courses Start With Ajax
    if ($_POST["action"] == "delete_courses") {
        $delete_course_id = $_POST["delete_course_id"];
        if (!empty($delete_course_id)) {
            $sql = "UPDATE `tbl_class` 
                        SET 
                        `status` = '$trash', `course_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `course_id` = '$delete_course_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Courses End With Ajax


    //Add Subject Start With Ajax
    // if($_POST["action"] == "add_subjects"){
    //     $add_subject_course_name = $_POST["add_subject_course_name"];
    //     $add_subject_name = $_POST["add_subject_name"];
    //     if(!empty($add_subject_name  && ($add_subject_course_name != "select"))){


    //             $sql = "INSERT INTO `tbl_section`
    //                     (`subject_id`, `subject_course_name`, `subject_name`, `subject_time`, `status`) 
    //                     VALUES 
    //             (NULL,'$add_subject_course_name','$add_subject_name','$date_variable_today_month_year_with_timing','$visible')
    //                     ";
    //             if($con->query($sql))
    //                 echo '
    //                     <div class="alert alert-success alert-dismissible">
    //                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
    //                         <i class="icon fas fa-check"></i> Section added successfully!!!
    //                     </div>';
    //             else
    //                echo '
    //                     <div class="alert alert-danger alert-dismissible">
    //                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
    //                         <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
    //                     </div>';

    //     } else
    //         echo '
    //             <div class="alert alert-warning alert-dismissible">
    //                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
    //                 <i class="icon fas fa-exclamation-triangle"></i>  Please fill out all required fields!!!
    //             </div>';
    // }




    if ($_POST["action"] == "add_subjects") {

        // if($_SESSION["logger_type"] != "admin")
        // {
            $add_subject_course_name = $_POST["add_subject_course_name"];
            $add_subject_name = $_POST["add_subject_name"];
        // }
        // else
        // {
        //     $add_subject_course_name = $_POST["add_subject_course_name"];
        //     $add_subject_name = $_POST["add_subject_name"];
        //     $branch = $_POST['branch'];
        // }


        if (!empty($add_subject_course_name) && $add_subject_name[0] != "") {

            $no_subject_name = count($add_subject_name);

            $sql = "";
            for ($i = 0; $i < $no_subject_name; $i++) {

                $sql .= "INSERT INTO `tbl_section`
                                    (`section_id`, `course_id`, `section_name`, `section_time`, `status`) 
                              VALUES(NULL,'$add_subject_course_name','$add_subject_name[$i]','$date_variable_today_month_year_with_timing','$visible');
                                    ";
            }
            if ($con->multi_query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Add Subject End With Ajax
    //Edit Subject Start With Ajax
    if ($_POST["action"] == "edit_subjects") {
        $edit_subject_course_name = $_POST["edit_subject_course_name"];
        $edit_subject_code = $_POST["edit_subject_code"];
        $edit_subject_name = $_POST["edit_subject_name"];
        $edit_subject_id = $_POST["edit_subject_id"];
        if (!empty($edit_subject_name && $edit_subject_id)) {
            $sql = "SELECT * FROM `tbl_subject`
                        WHERE `status` = '$visible' && `subject_code` = '$edit_subject_code' && `subject_course_name` = '$edit_subject_course_name' && `subject_name` = '$edit_subject_name';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo 'exsits';
            } else {
                $sql = "UPDATE `tbl_subject` 
                            SET 
                            `subject_course_name` = '$edit_subject_course_name', `subject_code` = '$edit_subject_code', `subject_name` = '$edit_subject_name', `subject_time` = '$date_variable_today_month_year_with_timing' 
                            WHERE `status` = '$visible' && `subject_id` = '$edit_subject_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Edit Subject End With Ajax

    //Delete Section Start With Ajax
    if ($_POST["action"] == "delete_section") {
        $delete_section_id = $_POST["delete_section_id"];
        //echo $delete_section_id; exit;
        if (!empty($delete_section_id)) {
            $sql = "UPDATE `tbl_section` 
                        SET 
                        `status` = '$trash', `subject_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `section_id` = '$delete_section_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Section End With Ajax









    //Delete Subject Start With Ajax
    if ($_POST["action"] == "delete_subjects") {
        $delete_subject_id = $_POST["delete_subject_id"];
        if (!empty($delete_subject_id)) {
            $sql = "UPDATE `tbl_subject` 
                        SET 
                        `status` = '$trash', `subject_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `subject_id` = '$delete_subject_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Subject End With Ajax
    //Restore From Trash Start With Ajax
    if ($_POST["action"] == "trash_restore") {
        $action_tbl = $_POST["action_tbl"];
        $restore_id = $_POST["restore_id"];
        $id_name = "";
        if (!empty($action_tbl && $restore_id)) {
            switch ($action_tbl) {
                case "tbl_admin":
                    $id_name = "admin_id";
                    break;
                case "tbl_course";
                    $id_name = "course_id";
                    break;
                case "tbl_subject":
                    $id_name = "subject_id";
                    break;
                case "tbl_university_details";
                    $id_name = "university_details_id";
                    break;
                default:
                    $id_name = "";
                    break;
            }
            if (!empty($id_name)) {
                $sql = "UPDATE `$action_tbl` 
                            SET 
                            `status` = '$visible'
                            WHERE `$id_name` = '$restore_id' && `status` = '$trash'
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'error';
        } else
            echo 'empty';
    }
    //Restore From Trash End With Ajax
    //Delete From Trash Start With Ajax
    if ($_POST["action"] == "trash_delete") {
        $action_tbl = $_POST["action_tbl"];
        $delete_id = $_POST["delete_id"];
        $id_name = "";
        if (!empty($action_tbl && $delete_id)) {
            switch ($action_tbl) {
                case "tbl_admin":
                    $id_name = "admin_id";
                    break;
                case "tbl_course";
                    $id_name = "course_id";
                    break;
                case "tbl_subject":
                    $id_name = "subject_id";
                    break;
                case "tbl_university_details";
                    $id_name = "university_details_id";
                    break;
                default:
                    $id_name = "";
                    break;
            }
            if (!empty($id_name)) {
                $sql = "DELETE FROM `$action_tbl` 
                            WHERE `$id_name` = '$delete_id' && `status` = '$trash'
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete From Trash End With Ajax
    //Add Fee Start With Ajax
    if ($_POST["action"] == "add_fees") {
        $fee_type = $_POST["fee_type"];
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $particulars = $_POST["particulars"];
        $amount = $_POST["amount"];
        $fine = $_POST["fine"];
        $lastdate = $_POST["lastdate"];
        $astatus = $_POST["astatus"];

        //echo $fee_type;
        //ADD FEE START
        if ($fee_type == 'Examination Fee') {

            //echo 'working';  exit;
            if (!empty($fee_type && $course_id && $academic_year) && $particulars[0] != "" && $amount[0] != "" && $fine[0] != "" && $lastdate[0] != "" && $astatus[0] != "") {
                $allParticulars = count($particulars);
                $allAmount = count($amount);
                //$allFee = count($fee);
                //$allLastdate = count($lastdate);
                //$allAstatus = count($astatus);
                if ($course_id == "all") {
                    $sql = "SELECT * FROM `tbl_course`
                            WHERE `status` = '$visible'
                            ";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $sql = "";
                        while ($row = $result->fetch_assoc()) {
                            $course_id_all = $row["course_id"];
                            for ($i = 0; $i < $allParticulars; $i++) {
                                $sql_check = "SELECT * FROM `tbl_examination_fee`
                                             WHERE `status` = '$visible' && `course_id` = '$course_id_all' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                                             ";
                                $result_check = $con->query($sql_check);
                                if ($result_check->num_rows > 0) {
                                    $row_check = $result_check->fetch_assoc();
                                    $sql .= "UPDATE `tbl_examination_fee` 
                                            SET `exfee_amount`='$amount[$i]',`exfee_time`='$date_variable_today_month_year_with_timing'
                                            WHERE `exfee_id` = '" . $row_check['exfee_id'] . "';
                                            ";
                                } else {
                                    $sql .= "INSERT INTO `tbl_examination_fee`
                                            (`exfee_id`, `course_id`, `exfee_academic_year`, `exfee_particulars`, `exfee_amount`, `exfee_fine`,`exfee_lastdate`,`exfee_astatus`,`exfee_time`, `status`) 
                                            VALUES 
                                            (NULL,'$course_id_all','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                            ";
                                }
                            }
                        }
                        if ($con->multi_query($sql))
                            echo 'success';
                        else
                            echo 'error1';
                    } else
                        echo 'courseempty';
                } else {
                    $sql = "";
                    for ($i = 0; $i < $allParticulars; $i++) {
                        $sql_check = "SELECT * FROM `tbl_examination_fee`
                                     WHERE `status` = '$visible' && `course_id` = '$course_id' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                                     ";
                        $result = $con->query($sql_check);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $sql .= "UPDATE `tbl_examination_fee` 
                                    SET `exfee_amount`='$amount[$i]',`exfee_time`='$date_variable_today_month_year_with_timing'
                                    WHERE `status` = '$visible' && `course_id` = '$course_id' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                                    ";
                        } else {
                            $sql .= "INSERT INTO `tbl_examination_fee`
                                    (`exfee_id`, `course_id`, `exfee_academic_year`, `exfee_particulars`, `exfee_amount`,`exfee_fine`,`exfee_lastdate`,`exfee_astatus`, `exfee_time`, `status`) 
                                    VALUES 
                                    (NULL,'$course_id','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                    ";
                        }
                    }
                    if ($con->multi_query($sql))
                        echo 'success';
                    else
                        echo 'error2';
                }
            } else
                echo 'empty';
        }

        //ADD FEE END


        //ADD EXAM FEE START

        else {

            //echo 'working1242';  exit;

            if (!empty($fee_type && $course_id && $academic_year) && $particulars[0] != "" && $amount[0] != "" && $fine[0] != "" && $lastdate[0] != "" && $astatus[0] != "") {
                $allParticulars = count($particulars);
                $allAmount = count($amount);
                //$allFee = count($fee);
                //$allLastdate = count($lastdate);
                //$allAstatus = count($astatus);
                if ($course_id == "all") {
                    $sql = "SELECT * FROM `tbl_course`
                            WHERE `status` = '$visible'
                            ";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $sql = "";
                        while ($row = $result->fetch_assoc()) {
                            $course_id_all = $row["course_id"];
                            for ($i = 0; $i < $allParticulars; $i++) {
                                $sql_check = "SELECT * FROM `tbl_fee`
                                             WHERE `status` = '$visible' && `course_id` = '$course_id_all' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                                             ";
                                $result_check = $con->query($sql_check);
                                if ($result_check->num_rows > 0) {
                                    $row_check = $result_check->fetch_assoc();
                                    $sql .= "UPDATE `tbl_fee` 
                                            SET `fee_amount`='$amount[$i]',`fee_time`='$date_variable_today_month_year_with_timing'
                                            WHERE `fee_id` = '" . $row_check['fee_id'] . "';
                                            ";
                                } else {
                                    $sql .= "INSERT INTO `tbl_fee`
                                            (`fee_id`, `course_id`, `fee_academic_year`, `fee_particulars`, `fee_amount`, `fee_fine`,`fee_lastdate`,`fee_astatus`,`fee_time`, `status`) 
                                            VALUES 
                                            (NULL,'$course_id_all','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                            ";
                                }
                            }
                        }
                        if ($con->multi_query($sql))
                            echo 'success';
                        else
                            echo 'error';
                    } else
                        echo 'courseempty';
                } else {
                    $sql = "";
                    for ($i = 0; $i < $allParticulars; $i++) {
                        $sql_check = "SELECT * FROM `tbl_fee`
                                     WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                                     ";
                        $result = $con->query($sql_check);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $sql .= "UPDATE `tbl_fee` 
                                    SET `fee_amount`='$amount[$i]',`fee_time`='$date_variable_today_month_year_with_timing'
                                    WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                                    ";
                        } else {
                            $sql .= "INSERT INTO `tbl_fee`
                                    (`fee_id`, `course_id`, `fee_academic_year`, `fee_particulars`, `fee_amount`,`fee_fine`,`fee_lastdate`,`fee_astatus`, `fee_time`, `status`) 
                                    VALUES 
                                    (NULL,'$course_id','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                    ";
                        }
                    }
                    if ($con->multi_query($sql))
                        echo 'success';
                    else
                        echo 'error';
                }
            } else
                echo 'empty';
        }

        //END EXAM FEE START


    }
    //Add Fee End With Ajax



    //Edit Examination Fee Details Start With Ajax
    if ($_POST["action"] == "edit_examfees") {
        if (isset($_POST["edit_examfee_status"])) {
            $edit_examfee_status = $_POST["edit_examfee_status"];
            $edit_examfee_id = $_POST["edit_examfee_id"];
            if (!empty($edit_examfee_id && $edit_examfee_status)) {
                if ($edit_examfee_status == "Inactive")
                    $sql = "UPDATE `tbl_examination_fee` 
                                SET 
                                `exfee_astatus`='Active'
                                WHERE `status` = '$visible' && `exfee_id` = '$edit_examfee_id';
                                ";
                if ($edit_examfee_status == "Active")
                    $sql = "UPDATE `tbl_examination_fee` 
                            SET 
                            `exfee_astatus`='Inactive'
                            WHERE `status` = '$visible' && `exfee_id` = '$edit_examfee_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'empty';
        } else {
            $edit_examfee_id = $_POST["edit_examfee_id"];
            $edit_examfee_course_name = $_POST["edit_examfee_course_name"];
            $edit_examfee_particulars = $_POST["edit_examfee_particulars"];
            $edit_examfee_amount = $_POST["edit_examfee_amount"];
            $edit_examfee_fine = $_POST["edit_examfee_fine"];
            $edit_examfee_latedate = $_POST["edit_examfee_latedate"];
            if (!empty($edit_examfee_id && $edit_examfee_course_name && $edit_examfee_particulars && $edit_examfee_amount)) {
                $sql = "UPDATE `tbl_examination_fee` 
                            SET 
                            `course_id`='$edit_examfee_course_name', `exfee_particulars`='$edit_examfee_particulars', `exfee_amount`='$edit_examfee_amount', `exfee_time`='$date_variable_today_month_year_with_timing', `exfee_fine` = '$edit_examfee_fine', `exfee_lastdate` = '$edit_examfee_latedate'
                            WHERE `status` = '$visible' && `exfee_id` = '$edit_examfee_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'empty';
        }
    }
    //Edit Examination  Fee Details End With Ajax












    //Edit Fee Details Start With Ajax
    if ($_POST["action"] == "edit_fees") {
        if (isset($_POST["edit_fee_status"])) {
            $edit_fee_status = $_POST["edit_fee_status"];
            $edit_fee_id = $_POST["edit_fee_id"];
            if (!empty($edit_fee_id && $edit_fee_status)) {
                if ($edit_fee_status == "Inactive")
                    $sql = "UPDATE `tbl_fee` 
                                SET 
                                `fee_astatus`='Active'
                                WHERE `status` = '$visible' && `fee_id` = '$edit_fee_id';
                                ";
                if ($edit_fee_status == "Active")
                    $sql = "UPDATE `tbl_fee` 
                            SET 
                            `fee_astatus`='Inactive'
                            WHERE `status` = '$visible' && `fee_id` = '$edit_fee_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'empty';
        } else {
            $edit_fee_id = $_POST["edit_fee_id"];
            $edit_fee_course_name = $_POST["edit_fee_course_name"];
            $edit_fee_particulars = $_POST["edit_fee_particulars"];
            $edit_fee_amount = $_POST["edit_fee_amount"];
            $edit_fee_fine = $_POST["edit_fee_fine"];
            $edit_fee_latedate = $_POST["edit_fee_latedate"];
            if (!empty($edit_fee_id && $edit_fee_course_name && $edit_fee_particulars && $edit_fee_amount)) {
                $sql = "UPDATE `tbl_fee` 
                            SET 
                            `course_id`='$edit_fee_course_name', `fee_particulars`='$edit_fee_particulars', `fee_amount`='$edit_fee_amount', `fee_time`='$date_variable_today_month_year_with_timing', `fee_fine` = '$edit_fee_fine', `fee_lastdate` = '$edit_fee_latedate'
                            WHERE `status` = '$visible' && `fee_id` = '$edit_fee_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'empty';
        }
    }
    //Edit Fee Details End With Ajax
    //Delete Fee Details Start With Ajax
    if ($_POST["action"] == "delete_fees") {
        $delete_fee_id = $_POST["delete_fee_id"];
        if (!empty($delete_fee_id)) {
            $sql = "UPDATE `tbl_fee` 
                        SET 
                        `status` = '$trash', `fee_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `fee_id` = '$delete_fee_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Fee Details End With Ajax




    //Delete Examination Fee Details Start With Ajax
    if ($_POST["action"] == "delete_examfees") {
        $delete_examfee_id = $_POST["delete_examfee_id"];
        if (!empty($delete_examfee_id)) {
            $sql = "UPDATE `tbl_examination_fee` 
                        SET 
                        `status` = '$trash', `exfee_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `exfee_id` = '$delete_examfee_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Examination Fee Details End With Ajax



    //Add late Fee Start With Ajax
    if ($_POST["action"] == "add_latefees") {
        $fine_amount = $_POST["fine_amount"];
        if (!empty($fine_amount)) {
            $sql = "SELECT * FROM `tbl_latefee`
                        WHERE `status` = '$visible';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $sql = "Update `tbl_latefee`
                            SET `latefee_fine`='$fine_amount',`latefee_time`='$date_variable_today_month_year_with_timing',`status`='$visible' 
                            WHERE `status` = '$visible';
                            ";
                if ($con->query($sql))
                    echo 'update';
                else
                    echo 'error';
            } else {
                $sql = "INSERT INTO `tbl_latefee`
                            (`latefee_id`, `latefee_fine`, `latefee_time`, `status`) 
                            VALUES 
                            (NULL,'$fine_amount','$date_variable_today_month_year_with_timing','$visible');
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Add Late Fee End With Ajax
    //Add Due Date Start With Ajax
    if ($_POST["action"] == "add_duedates") {
        $academic_year = $_POST["academic_year"];
        $april_date = $_POST["april_date"];
        $may_date = $_POST["may_date"];
        $june_date = $_POST["june_date"];
        $july_date = $_POST["july_date"];
        $august_date = $_POST["august_date"];
        $september_date = $_POST["september_date"];
        $october_date = $_POST["october_date"];
        $november_date = $_POST["november_date"];
        $december_date = $_POST["december_date"];
        $january_date = $_POST["january_date"];
        $february_date = $_POST["february_date"];
        $march_date = $_POST["march_date"];
        $month_array = array("April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March");
        $month_date = array("$april_date", "$may_date", "$june_date", "$july_date", "$august_date", "$september_date", "$october_date", "$november_date", "$december_date", "$january_date", "$february_date", "$march_date");
        if ($academic_year != "select" && ($april_date || $may_date || $june_date || $july_date || $august_date || $september_date || $october_date || $november_date || $december_date || $january_date || $february_date || $march_date)) {
            $imploded_month_array = implode(",", $month_array);
            $imploded_month_date = implode(",", $month_date);
            $sql = "SELECT * FROM `tbl_fee_due_date`
                        WHERE `status` = '$visible' && `fee_due_date_academic_year` = '$academic_year';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $sql = "UPDATE `tbl_fee_due_date` 
                            SET `fee_due_date_month_array`='$imploded_month_array', `fee_due_date_month_date`='$imploded_month_date', `fee_due_date_time`='$date_variable_today_month_year_with_timing'
                            WHERE `fee_due_date_id` = '" . $row["fee_due_date_id"] . "' && `fee_due_date_academic_year` = '$academic_year';
                            ";
                if ($con->query($sql))
                    echo 'update';
                else
                    echo 'error';
            } else {
                $sql = "INSERT INTO `tbl_fee_due_date`
                            (`fee_due_date_id`, `fee_due_date_academic_year`, `fee_due_date_month_array`, `fee_due_date_month_date`, `fee_due_date_time`, `status`) 
                            VALUES 
                            (NULL,'$academic_year','$imploded_month_array','$imploded_month_date','$date_variable_today_month_year_with_timing','$visible');
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Add Due Date End With Ajax
    //Edit Student Details Start With Ajax
    if ($_POST["action"] == "edit_student_lists") {
        $edit_admission_id = $_POST["edit_admission_id"];
        $edit_student_list_reg_no = $_POST["edit_student_list_reg_no"];
        $edit_student_list_admission_no = $_POST["edit_student_list_admission_no"];
        $edit_student_list_course_name = $_POST["edit_student_list_course_name"];
        $edit_student_list_session = $_POST["edit_student_list_session"];
        $edit_student_list_first_name = $_POST["edit_student_list_first_name"];
        $edit_student_list_last_name = $_POST["edit_student_list_last_name"];
        $edit_student_list_contact_no = $_POST["edit_student_list_contact_no"];
        $edit_student_list_email = $_POST["edit_student_list_email"];
        $edit_student_list_father_name = $_POST["edit_student_list_fathers_name"];
        $edit_student_list_fathers_contact = $_POST["edit_student_list_fathers_contact"];
        $edit_student_list_hostel = $_POST["edit_student_list_hostel"];
        $edit_student_list_transport = $_POST["edit_student_list_transport"];
        $edit_student_list_username = $_POST["edit_student_list_username"];
        $edit_student_list_password = $_POST["edit_student_list_password"];
        if (!empty($edit_student_list_first_name && $edit_student_list_last_name && $edit_student_list_contact_no && $edit_student_list_fathers_contact && $edit_student_list_username && $edit_student_list_password) && $edit_student_list_father_name != "") {
            $sql = "UPDATE `tbl_admission` 
                        SET 
                        `admission_course_name` = '$edit_student_list_course_name', `admission_session` = '$edit_student_list_session', `admission_first_name` = '$edit_student_list_first_name', `admission_last_name` = '$edit_student_list_last_name', `admission_mobile_student` = '$edit_student_list_contact_no', `admission_emailid_student` = '$edit_student_list_email', `admission_father_name` = '$edit_student_list_father_name', `admission_father_phoneno` = '$edit_student_list_fathers_contact', `admission_hostel` = '$edit_student_list_hostel', `admission_transport` = '$edit_student_list_transport', `admission_username` = '$edit_student_list_username', `admission_password` = '$edit_student_list_password'
                        WHERE `status` = '$visible' && `admission_id` = '$edit_admission_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Edit Student Details End With Ajax

    //Delete Student Details Start With Ajax
    if ($_POST["action"] == "delete_student_lists") {
        $delete_admission_id = $_POST["delete_admission_id"];
        if (!empty($delete_admission_id)) {
            $sql = "DELETE FROM `tbl_admission`
                        WHERE `status` = '$visible' && `admission_id` = '$delete_admission_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Student Details End With Ajax

    //Delete Student Details Start With Ajax
    if ($_POST["action"] == "delete_student") {
        $delete_student_id = $_POST["student_id"];
        if (!empty($delete_student_id)) {
            $sql = "DELETE FROM `tbl_student`
                        WHERE `status` = '$visible' && `student_id` = '$delete_student_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Student Details End With Ajax




    //Edit Fee Paid Status Start With Ajax
    if ($_POST["action"] == "change_Fee_Status") {
        $feepaid_id = $_POST["feepaid_id"];
        $status = $_POST["status"];
        if (!empty($feepaid_id && $status)) {
            $sql = "UPDATE `tbl_fee_paid` 
                        SET 
                        `payment_status` = '$status'
                        WHERE `status` = '$visible' && `feepaid_id` = '$feepaid_id';
                        ";
            if ($con->query($sql)) {
                if ($status == "pending") {
                    $completeResult[] = '<span class="bg-warning">PENDING</span>';
                    $completeResult[] = "#ffffed";
                } else if ($status == "bounced") {
                    $completeResult[] = '<span class="bg-danger">BOUNCED</span>';
                    $completeResult[] = "#ffcccb";
                } else if ($status == "refunded") {
                    $completeResult[] = '<span class="bg-danger">REFUNDED</span>';
                    $completeResult[] = "#ffa7a7";
                } else {
                    $completeResult[] = '<span class="">CLEARED</span>';
                    $completeResult[] = "";
                }
                $results = implode(",", $completeResult);
                echo $results;
            } else
                echo 'error';
        } else
            echo 'empty';
    }
    //Edit Fee Paid Status End With Ajax
    /* ----------------- Priti Mam Start ----------------------- */

    //Add prospectus Start With Ajax
    if ($_POST["action"] == "add_prospectus") {
        $add_prospectus_no = $_POST["add_prospectus_no"];
        $add_prospectus_applicant_name = $_POST["add_prospectus_applicant_name"];
        $add_prospectus_gender = $_POST["add_prospectus_gender"];
        $add_prospectus_father_name = $_POST["add_prospectus_father_name"];
        $add_prospectus_mother_name = $_POST["add_prospectus_mother_name"];
        $add_prospectus_address = $_POST["add_prospectus_address"];
        $add_prospectus_country = $_POST["add_prospectus_country"];
        $add_prospectus_state = $_POST["add_prospectus_state"];
        $add_prospectus_city = $_POST["add_prospectus_city"];
        $add_prospectus_postal_code = $_POST["add_prospectus_postal_code"];
        $add_prospectus_dob = $_POST["add_prospectus_dob"];
        $add_prospectus_emailid = $_POST["add_prospectus_emailid"];
        $mobile = $_POST["mobile"];
        $add_prospectus_course_name = $_POST["add_prospectus_course_name"];
        $add_prospectus_session = $_POST["add_prospectus_session"];
        $add_prospectus_rate = $_POST["add_prospectus_rate"];
        $add_prospectus_payment_mode = $_POST["add_prospectus_payment_mode"];
        $cashDepositTo = $_POST["cashDepositTo"];
        $add_bank_name = $_POST["add_bank_name"];
        $add_transaction_no = $_POST["add_transaction_no"];
        $add_transaction_date = $_POST["add_transaction_date"];
        $date = date_create()->format('yy-m-d');

        if (!empty($add_prospectus_no && $add_prospectus_applicant_name && $add_prospectus_gender && $add_prospectus_address && $add_prospectus_emailid && $mobile && $add_prospectus_course_name && $add_prospectus_session && $add_prospectus_rate && $add_prospectus_payment_mode)) {

            $sql = "INSERT INTO `tbl_prospectus`
                            (`id`, `prospectus_no`, `prospectus_applicant_name`, `prospectus_gender`, `prospectus_father_name`, `prospectus_mother_name`, `prospectus_address`, `prospectus_country`, `prospectus_state`, `prospectus_city`, `prospectus_postal_code`, `prospectus_dob`, `prospectus_emailid`,`mobile`,`prospectus_course_name`,`prospectus_session`,`prospectus_rate`,`prospectus_payment_mode`,`prospectus_deposit_to`,`bank_name`,`transaction_no`,`transaction_date`,`post_at`, `type`,`easebuzz_id`,`transaction_id`,`status`) 
                            VALUES 
                            (NULL,'$add_prospectus_no','$add_prospectus_applicant_name','$add_prospectus_gender','$add_prospectus_father_name','$add_prospectus_mother_name','$add_prospectus_address','$add_prospectus_country','$add_prospectus_state','$add_prospectus_city','$add_prospectus_postal_code','$add_prospectus_dob','$add_prospectus_emailid','$mobile','$add_prospectus_course_name','$add_prospectus_session','$add_prospectus_rate','$add_prospectus_payment_mode','$cashDepositTo','$add_bank_name','$add_transaction_no','$add_transaction_date','$date','','','','$visible')
                            ";

            $sql_prospectus = "INSERT INTO `tbl_income`
                    				(`id`, `reg_no`,`course`,`academic_year`,`received_date`, `particulars`, `amount`, `payment_mode`,`check_no`,`bank_name`,`income_from`,`post_at`) 
                    				VALUES 
                    				(NULL,'$add_prospectus_no(Form No)','$add_prospectus_course_name','$add_prospectus_session','$add_transaction_date','Prospectus','$add_prospectus_rate','$add_prospectus_payment_mode','$add_transaction_no','$add_bank_name','Prospectus','" . date("Y-m-d") . "')
                    				";
            $query = mysqli_query($con, $sql_prospectus);

            if ($con->query($sql)) {

                function sendsmsGET($mobileNumber, $message)
                {
                    $senderId = 'NSUJSR';
                    $routeId1 = 1;
                    $getData = 'mobileNos=' . $mobileNumber . '&message=' . urlencode($message) . '&senderId=' . $senderId . '&routeId=' . $routeId1;
                    //API URL
                    $serverUrl1 = 'msg.msgclub.net';
                    $authKey1 = '6a4743a8355fb97aa42dc2452185a1cd';
                    $url = "http://" . $serverUrl1 . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . $authKey1 . "&" . $getData;
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0
                    ));
                    $output = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'error:' . curl_error($ch);
                    }
                    curl_close($ch);
                    return $output;
                }

                $student_msg = "Dear $add_prospectus_applicant_name, Thank you for the payment of Rs. $add_prospectus_rate through $add_prospectus_payment_mode towards your Prospectus of selected Course $add_prospectus_course_name. Regards NSU";
                sendsmsGET($mobile, $student_msg);

                echo "<script>
                                alert('Prospectus details added successfully!!!');
                                location.replace('prospectus_view');
                            </script>";
            } else
                echo "<script>
                                alert('Something went wrong please try again!!!');
                                location.replace('prospectus_view');
                            </script>";
            /*} else
                    echo "<script>
                                alert('Something went wrong please try again!!!');
                                location.replace('../add_university_details');
                            </script>";*/
        } else {
            echo "<script>
                            alert('Please fill out all required fields!!!');
                            location.replace('prospectus_view');
                        </script>";
        }
    }
    //Add prospectus End With Ajax

    //Edit prospectus Start With Ajax
    if ($_POST["action"] == "edit_prospectus") {
        $edit_prospectus_no = $_POST["edit_prospectus_no"];
        $edit_prospectus_applicant_name = $_POST["edit_prospectus_applicant_name"];
        $edit_prospectus_gender = $_POST["edit_prospectus_gender"];
        $edit_prospectus_father_name = $_POST["edit_prospectus_father_name"];
        $edit_prospectus_address = $_POST["edit_prospectus_address"];
        $edit_prospectus_country = $_POST["edit_prospectus_country"];
        $edit_prospectus_state = $_POST["edit_prospectus_state"];
        $edit_prospectus_city = $_POST["edit_prospectus_city"];
        $edit_prospectus_postal_code = $_POST["edit_prospectus_postal_code"];
        $edit_prospectus_dob = $_POST["edit_prospectus_dob"];
        $edit_prospectus_emailid = $_POST["edit_prospectus_emailid"];
        $edit_mobile = $_POST["edit_mobile"];
        $edit_prospectus_course_name = $_POST["edit_prospectus_course_name"];
        $edit_prospectus_session = $_POST["edit_prospectus_session"];
        $edit_prospectus_rate = $_POST["edit_prospectus_rate"];
        $edit_prospectus_payment_mode = $_POST["edit_prospectus_payment_mode"];
        $edit_bank_name = $_POST["edit_bank_name"];
        $edit_transaction_no = $_POST["edit_transaction_no"];
        $add_transaction_date = $_POST["edit_transaction_date"];
        $edit_id = $_POST["edit_id"];
        if (!empty($edit_prospectus_no && $edit_id)) {
            $sql = "SELECT * FROM `tbl_prospectus`
                        WHERE `status` = '$visible' && `prospectus_no` = '$edit_prospectus_no';
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo 'exsits';
            } else {
                $sql = "UPDATE `tbl_prospectus` 
                            SET 
                            `prospectus_no` = '$edit_prospectus_no',`prospectus_applicant_name` = '$edit_prospectus_applicant_name',`prospectus_gender` = '$edit_prospectus_gender',`prospectus_father_name` = '$edit_prospectus_father_name',`prospectus_address` = '$edit_prospectus_address',`prospectus_country` = '$edit_prospectus_country',`prospectus_state` = '$edit_prospectus_state',`prospectus_city` = '$edit_prospectus_city',`prospectus_postal_code` = '$edit_prospectus_postal_code',`prospectus_dob` = '$edit_prospectus_dob',`prospectus_emailid` = '$edit_prospectus_emailid',`mobile` = '$edit_mobile',`prospectus_course_name` = '$edit_prospectus_course_name',`prospectus_session` = '$edit_prospectus_session',`prospectus_rate` = '$edit_prospectus_rate',`prospectus_payment_mode` = '$edit_prospectus_payment_mode',`bank_name` = '$edit_bank_name',`transaction_no` = '$edit_transaction_no',`transaction_date` = '$edit_transaction_date'
                             WHERE `status` = '$visible' && `id` = '$edit_id';
                            ";
                if ($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Edit prospectus End With Ajax
    //Delete prospectus Start With Ajax
    if ($_POST["action"] == "delete_prospectus") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $sql = "UPDATE `tbl_prospectus` SET `status` = '$trash' 
                    WHERE `status` = '$visible' && `id` = '$delete_id';";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete prospectus End With Ajax
    //Add Admission Form Start
    if ($_POST["action"] == "add_admission") {

        // echo "<pre>";
        // print_r($_POST);
        // exit;
        // $queryYear = "SELECT * FROM `tbl_university_details` WHERE `status` = '$visible'";
        // $yearResult =  $con->query($queryYear);
        // $yearRow = $yearResult->fetch_assoc();

        $branchh = $_POST['branch'];
        $class = $_POST['class'];
        $section_id = $_POST['course_id'];
        $session = $_POST['session'];
        $roll_no = $_POST['roll_no'];
        $student_name = $_POST['student_name'];
        $dob = $_POST['dob'];
        $nationality = $_POST['nationality'];
        $aadhar_no = $_POST['aadhar_no'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $date_of_admission = $_POST['date_of_admission'];
        $father_name = $_POST['father_name'];
        $father_whatsappno = $_POST['father_whatsappno'];
        $mother_name = $_POST['mother_name'];
        $branch_id = $_SESSION['admin_branch'];
        $current_time = date('Y-m-d h:m:s');
        $registration_no = 'NSP00' . $_POST['roll_no'];
        $visible = md5('visible');
        $url = $_SERVER['HTTP_REFERER'];
        // $year_start = substring($yearRow['university_details_academic_start_date'],0,4);
        // $year_end = substring($yearRow['university_details_academic_end_date'],0,4);
        // echo $year_start; exit;
        if (!empty($_FILES["photo"]["name"])) {
            $photo =   addslashes(file_get_contents($_FILES["photo"]["tmp_name"]));
        } else {
            $photo = "";
        }
        if (!empty($_FILES["tc"]["name"])) {
            $tc =   addslashes(file_get_contents($_FILES["tc"]["tmp_name"]));
        } else {
            $tc = "";
        }


         $sql = "INSERT INTO `tbl_student`(`student_id`, `university_details_id`, `branch_id`, `reg_no`, `roll_no`, `course_id`, `section_id`, `student_name`, `dob`, `gender`, `father_name`, `mother_name`, `parent_contactno`, `create_time`, `aadhar_no`, `photo`, `tc`, `address`, `nationality`, `status`) VALUES 
                                   (NULL,'$session','$branchh','$registration_no','$roll_no','$class','$section_id','$student_name','$dob','$gender','$father_name','$mother_name','$father_whatsappno','$current_time','$aadhar_no','$photo','$tc','$address','$nationality','$visible')";
        // echo  $sql = "INSERT INTO `tbl_student`(`student_id`, `university_details_id`, `branch_id`, `reg_no`, `roll_no`, `course_id`, `section_id`, `student_name`, `dob`, `gender`, `father_name`, `mother_name`, `parent_contactno`, `create_time`, `aadhar_no` `address`, `nationality`, `status`) VALUES 
        //                                 (NULL,'$session','$branch_id','$registration_no','$roll_no','$class','$section_id','$student_name','$dob','$gender','$father_name','$mother_name','$father_whatsappno','$current_time','$aadhar_no','$address','$nationality','$visible')";
                                        
        //exit (); 
        if ($con->query($sql)) {
            $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data successfully added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <script>
          setTimeout(function() {  window.location.replace("' . $url . '") },2000);
          </script>

          ';
            echo '   <script>
          window.location.replace("' . $url . '") ;
          </script>';
        } else
            $_SESSION['massage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning! </strong> ' . $con->error . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';

        echo '   <script>
      window.location.replace("' . $url . '") ;
      </script>';
    }


    //Add Admission Form End
    //Add Pay Fee Start
    if ($_POST["action"] == "add_feepaid") {
        $student_id = $_POST["student_id"];
        $getdata = "SELECT * FROM `tbl_admission`
                            WHERE `status` = '$visible' && `admission_id` = '$student_id' 
                            ";
        $getResult =  $con->query($getdata);
        $getRows = $getResult->fetch_assoc();

        $getRe = "SELECT `feepaid_id` FROM `tbl_fee_paid`
						WHERE `status` = '$visible'
						";
        $receipt_no_gen = 0;
        $getReResult =  $con->query($getRe);
        while ($getReRow = $getReResult->fetch_assoc())
            $receipt_no_gen = $getReRow["feepaid_id"];
        $receipt_no_gen++;

        $admission_id = $_POST["student_id"];
        $course_id = $getRows["admission_course_name"];
        $allPaid = implode(",", $_POST["paidFor"]);
        $allPerticularsFor = $_POST["allPerticularsFor"];
        //echo $allPerticularsFor." ".$allPaid;

        $paid_amount = $_POST["paid_amount"];
        $rebate_amount = $_POST["rebate_amount"];
        $fine = $_POST["fine"];
        $balance = $_POST["balance"];
        $payment_mode = $_POST["payment_mode"];
        $cash_deposit_to = $_POST["cash_deposit_to"];
        $cash_date = $_FILES["cash_date"];
        $notes = $_POST["notes"];
        $receipt_date = $_POST["receipt_date"];
        $bank_name = $_POST["bank_name"];
        $transaction_no = $_POST["transaction_no"];
        $transaction_date = $_POST["transaction_date"];
        $receipt_no = $_POST["receipt_no"];
        $paid_on = date('Y-m-d');
        $university_details_id = $getRows["admission_session"];
        $sql = "INSERT INTO `tbl_fee_paid`
                            (`feepaid_id`, `student_id`, `course_id`, `particular_id`, `paid_amount`, `rebate_amount`, `fine`, `balance`, `payment_mode`, `cash_deposit_to`, `cash_date`, `notes`,`receipt_date`,`bank_name`,`transaction_no`,`transaction_date`,`receipt_no`,`paid_on`,`university_details_id`,`fee_paid_time`, `status`) 
                            VALUES 
                            (NULL,'$admission_id','$course_id','$allPerticularsFor','$allPaid','$rebate_amount','$fine','$balance','$payment_mode','$cash_deposit_to','$cash_date','$notes','$receipt_date','$bank_name','$transaction_no','$transaction_date','NSU_$receipt_no_gen','$paid_on','$university_details_id','$fee_paid_time','$visible')
                            ";
        if ($con->query($sql)) {

            echo "<script>
                                alert('Inserted successfully!!!');
                                location.replace('../payfee');
                            </script>";
        } else

            echo "<script>
                                alert('Something went wrong please try again!!!');
                                location.replace('../payfee');
                            </script>";
    }
    //Add Pay Fee End


    //Pay Fee Start
    if ($_POST["action"] == "pay_fees") {
        $registrationNumber = $_POST["registrationNumber"];
        $academicYear = $_POST["academicYear"];
        $courseId = $_POST["courseId"];
        $particular_paid_id = $_POST["particular_paid_id"];
        // echo "<pre>";
        // print_r($particular_paid_id);
        // exit;
        $particular_paid_amount = $_POST["particular_paid_amount"];
        $fine_amount = $_POST["fine_amount"];
        $rebate_amount = $_POST["rebate_amount"];
        $rebate_from = $_POST["rebate_from"];
        $total_amount = $_POST["total_amount"];
        $remaining_amount = $_POST["remaining_amount"];
        $PaymentMode = $_POST["PaymentMode"];
        $cashDepositTo = $_POST["cashDepositTo"];
        $bankName = $_POST["bankName"];
        $chequeAndOthersNumber = $_POST["chequeAndOthersNumber"];
        $paidDate = $_POST["paidDate"];
        $paymentDate = $_POST["paymentDate"];
        $NotesByAdmin = $_POST["NotesByAdmin"];
        $branch_idd = $_SESSION["admin_branch"];
        $generated_id = $_SESSION["admin_name"];
        $FeeStatus = "cleared";
        if ($rebate_amount > 0) {
            if ($rebate_from == "") {
                echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-ban"></i> Please select Rebate From!!!
                          </div>';
                exit();
            } else
                $implodedRebate = $rebate_amount . "," . $rebate_from;
        } else
            $implodedRebate = "";
        if (!empty($registrationNumber && $academicYear && $courseId) && (count($particular_paid_id) != 0) && (count($particular_paid_amount) != 0) && !empty($total_amount)) {
            if (($PaymentMode != "0" && $cashDepositTo != "0") || ($PaymentMode != "0" && !empty($chequeAndOthersNumber))) {
                if ($fine_amount >= 0 && $rebate_amount >= 0 && $total_amount >= 0 && $remaining_amount >= 0) {
                    $getRe = "SELECT `feepaid_id` FROM `tbl_fee_paid`
                                  WHERE `status` = '$visible'
                                 ";
                    $receipt_no_gen = 0;
                    $getReResult =  $con->query($getRe);
                    while ($getReRow = $getReResult->fetch_assoc())
                        $receipt_no_gen = $getReRow["feepaid_id"];
                    $receipt_no_gen++;
                    $implodedId = implode(",", $particular_paid_id);
                    $implodedAmount = implode(",", $particular_paid_amount);
                    if (isset($_POST["extra_fine"]) && !empty($_POST["extra_fine"]))
                        $complete_extra_fine = $_POST["extra_fine"] + "|separator|" + htmlspecialchars($_POST["extra_fine_description"], ENT_QUOTES);
                    else
                        $complete_extra_fine = "";
                    if ($PaymentMode == "Cheque")
                        $FeeStatus = "pending";
                    $sql = "INSERT INTO `tbl_fee_paid`
                                (`feepaid_id`, `student_id`, `course_id`, `particular_id`, `paid_amount`, `rebate_amount`, `fine`, `extra_fine`, `balance`, `payment_mode`, `cash_deposit_to`, `cash_date`, `notes`, `receipt_date`, `bank_name`, `transaction_no`, `transaction_date`, `receipt_no`, `paid_on`, `university_details_id`, `fee_paid_time`, `payment_status`,`branch_id`,`generated_by`, `status`) 
                                VALUES 
                                (NULL, '$registrationNumber', '$courseId', '$implodedId', '$implodedAmount', '$implodedRebate', '$fine_amount', '$complete_extra_fine', '$remaining_amount', '$PaymentMode', '$cashDepositTo', '$paymentDate', '$NotesByAdmin', '$paidDate', '$bankName', '$chequeAndOthersNumber', '$paymentDate', 'NSPS_$receipt_no_gen', '$paymentDate', '$academicYear', '$date_variable_today_month_year_with_timing', '$FeeStatus','$branch_idd','$generated_id', '$visible')
                                ";

                    //insert into tbl_income
                    $sql_course = "SELECT * FROM `tbl_class`
						WHERE `status` = '$visible' &&  `course_id` = '$courseId'
						";
                    $result_course = $con->query($sql_course);
                    $row_course = $result_course->fetch_assoc();

                    $perticulars = explode(",", $implodedId);
                    $amounts = explode(",", $implodedAmount);

                    for ($i = 0; $i < count($perticulars); $i++) {
                        if ($amounts[$i] > 0) {
                            $sql_fee = "SELECT * FROM `tbl_fee`
            						WHERE `status` = '$visible' && `id` = '" . $perticulars[$i] . "'
            						";
                            $result_fee = $con->query($sql_fee);
                            $row_fee = $result_fee->fetch_assoc();

                            $sql_inc = "INSERT INTO `tbl_income`
            				(`id`,`reg_no`,	`course`, `academic_year`,`received_date`, `particulars`, `amount`, `payment_mode`,`check_no`,`bank_name`,`income_from`,`post_at`) 
            				VALUES
            				(NULL,'$registrationNumber(Reg No)','$courseId',$academicYear,'$paidDate','" . $row_fee["particular"] . "','$amounts[$i]','$PaymentMode','$chequeAndOthersNumber','$bankName','Fee','" . date("Y-m-d") . "')
            				";
                            $query = mysqli_query($con, $sql_inc);
                        }
                    }
                    //end tbl_income

                    if ($con->query($sql)) {
                        // $thanksMessage = " \n\nRegards,\nNetaji Subhas Public School, \nJamshedpur. ";
                        // $objectSecond->send_otp($mobileNumberOfStudent, $thanksMessage);
                    echo 'success';
                    } else
                        echo '<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                    <i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again!!!
                                  </div>';
                } else
                    echo '<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Cannot calculate Fees with <b>Negative</b> values!!!
                              </div>';
            } else
                echo '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> Please Fill out Payment Details!!!
                          </div>';
        } else
            echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-ban"></i> Please Fill Out Fee Amounts!!!
                      </div>';
    }
    //Pay Fee End




    //Pay Fee Start
    if ($_POST["action"] == "pay_examfees") {
        $registrationNumber = $_POST["registrationNumber"];
        $academicYear = $_POST["academicYear"];
        $courseId = $_POST["courseId"];
        $particular_paid_id = $_POST["particular_paid_id"];
        $particular_paid_amount = $_POST["particular_paid_amount"];
        $fine_amount = $_POST["fine_amount"];
        // $rebate_amount = $_POST["rebate_amount"];
        // $rebate_from = $_POST["rebate_from"];
        $total_amount = $_POST["total_amount"];
        // $remaining_amount = $_POST["remaining_amount"];
        $PaymentMode = $_POST["PaymentMode"];
        $cashDepositTo = $_POST["cashDepositTo"];
        $bankName = $_POST["bankName"];
        $chequeAndOthersNumber = $_POST["chequeAndOthersNumber"];
        $paidDate = $_POST["paidDate"];
        $paymentDate = $_POST["paymentDate"];
        $NotesByAdmin = $_POST["NotesByAdmin"];
        $FeeStatus = "cleared";
        // echo  $particular_paid_id; 
        // echo "<pre>";
        // print_r($_POST); 
        // if($rebate_amount > 0){
        // if($rebate_from == ""){
        //     echo '<div class="alert alert-danger alert-dismissible">
        //             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
        //             <i class="icon fas fa-ban"></i> Please select Rebate From!!!
        //           </div>';
        //     exit();
        // } else
        //     $implodedRebate = $rebate_amount.",".$rebate_from;
        // } else
        //     $implodedRebate = ""; 


        if (!empty($registrationNumber && $academicYear && $courseId) && (count($particular_paid_id) != 0) && (count($particular_paid_amount) != 0) && !empty($total_amount)) {

            if (($PaymentMode != "0" && $cashDepositTo != "0") || ($PaymentMode != "0" && !empty($chequeAndOthersNumber))) {
                if ($fine_amount >= 0  && $total_amount >= 0) {
                    $getRe = "SELECT `exfeepaid_id` FROM `tbl_examfee_paid`
                                  WHERE `status` = '$visible'
                                 ";
                    $receipt_no_gen = 0;
                    $getReResult =  $con->query($getRe);
                    while ($getReRow = $getReResult->fetch_assoc())
                        $receipt_no_gen = $getReRow["exfeepaid_id"];
                    $receipt_no_gen++;
                    $implodedId = implode(",", $particular_paid_id);
                    $implodedAmount = implode(",", $particular_paid_amount);
                    if (isset($_POST["extra_fine"]) && !empty($_POST["extra_fine"]))
                        $complete_extra_fine = $_POST["extra_fine"] + "|separator|" + htmlspecialchars($_POST["extra_fine_description"], ENT_QUOTES);
                    else
                        $complete_extra_fine = "";
                    if ($PaymentMode == "Cheque")
                        $FeeStatus = "pending";


                    // insert exam fee paid
                    $perticulars = explode(",", $implodedId);
                    $amounts = explode(",", $implodedAmount);

                    //  echo  "<pre>";
                    //  print_r($perticulars); 
                    // echo  "countof=".count($perticulars); 
                    //exit;


                    for ($i = 0; $i < count($perticulars); $i++) {
                        $sql_fee = "SELECT * FROM `tbl_examination_fee`
                                    WHERE `status` = '$visible' && `exfee_id` = '" . $perticulars[$i] . "'
                                    ";

                        // var_dump($sql_fee); 

                        $result_fee = $con->query($sql_fee);
                        $row_fee = $result_fee->fetch_assoc();

                        $sql = "INSERT INTO `tbl_examfee_paid`
                                (`exfeepaid_id`, `student_id`, `course_id`, `particular_id`, `paid_amount`,`fine`, `extra_fine`,`payment_mode`, `cash_deposit_to`, `cash_date`, `notes`, `receipt_date`, `bank_name`, `transaction_no`, `transaction_date`, `receipt_no`, `paid_on`, `university_details_id`, `fee_paid_time`, `payment_status`, `status`) 
                              VALUES 
                                (NULL, '$registrationNumber', '$courseId','" . $row_fee["exfee_id"] . "','$amounts[$i]','$fine_amount', '$complete_extra_fine','$PaymentMode', '$cashDepositTo', '$paymentDate', '$NotesByAdmin', '$paidDate', '$bankName', '$chequeAndOthersNumber', '$paymentDate', 'NSU_$receipt_no_gen', '$paymentDate', '$academicYear', '$date_variable_today_month_year_with_timing', '$FeeStatus', '$visible')
                                ";

                        $query = mysqli_query($con, $sql);
                        // echo "<br>i="+$i."<br>";
                        // echo $sql."<br>";

                    }



                    // end  exam fee paid


                    //insert into tbl_income

                    $getdata = "SELECT * FROM `tbl_admission`
                            WHERE `status` = '$visible' && `admission_id` = '$registrationNumber' 
                            ";

                    $getResult =  $con->query($getdata);
                    $getRows = $getResult->fetch_assoc();


                    $sql_course = "SELECT * FROM `tbl_course`
                        WHERE `status` = '$visible' &&  `course_id` = '" . $getRows["admission_course_name"] . "'
                        ";
                    $result_course = $con->query($sql_course);
                    $row_course = $result_course->fetch_assoc();

                    $perticulars = explode(",", $implodedId);
                    $amounts = explode(",", $implodedAmount);

                    for ($i = 0; $i < count($perticulars); $i++) {
                        $sql_fee = "SELECT * FROM `tbl_examination_fee`
                                    WHERE `status` = '$visible' && `exfee_id` = '" . $perticulars[$i] . "'
                                    ";

                        // var_dump($sql_fee); 

                        $result_fee = $con->query($sql_fee);
                        $row_fee = $result_fee->fetch_assoc();


                        $sql_inc = "INSERT INTO `tbl_income`
                            (`id`,`reg_no`, `course`, `academic_year`,`received_date`, `particulars`, `amount`, `payment_mode`,`check_no`,`bank_name`,`income_from`,`post_at`) 
                            VALUES
                            (NULL,'$registrationNumber(Reg No)','$courseId',$academicYear,'$paidDate','" . $row_fee["exfee_particulars"] . "','$amounts[$i]','$PaymentMode','$chequeAndOthersNumber','$bankName','Examination Fee','" . date("Y-m-d") . "')
                            ";
                        $query = mysqli_query($con, $sql_inc);
                    }
                    //end tbl_income

                    if ($sql) {
                        // $thanksMessage = " \n\nRegards,\nNetaji Subhas Public School, \nJamshedpur. ";
                        // $objectSecond->send_otp($mobileNumberOfStudent, $thanksMessage);
                        echo "success";
                    } else
                        echo '<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                    <i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again!!!
                                  </div>';
                } else
                    echo '<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Cannot calculate Fees with <b>Negative</b> values!!!
                              </div>';
            } else
                echo '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-exclamation-triangle"></i> Please Fill out Payment Details!!!
                          </div>';
        } else
            echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-ban"></i> Please Fill Out Fee Amounts!!!
                      </div>';
    }
    //Pay  Exam Fee End



    //Delete Print Receipt Start With Ajax
    if ($_POST["action"] == "delete_print_receipts") {
        $delete_feepaid_id = $_POST["delete_feepaid_id"];
        if (!empty($delete_feepaid_id)) {
            $sql = "UPDATE `tbl_fee_paid` 
                        SET 
                        `status` = '$trash'
                        WHERE `status` = '$visible' && `feepaid_id` = '$delete_feepaid_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Print Receipt End With Ajax

    //Add Extra Income Start With Ajax
    if ($_POST["action"] == "add_extra_income") {
        $received_date = $_POST["received_date"];
        $particulars = $_POST["particulars"];
        $amount = $_POST["amount"];
        $payment_mode = $_POST["payment_mode"];
        $account_number = $_POST["account_number"];
        $bank_name = $_POST["bank_name"];
        $branch_name = $_POST["branch_name"];
        $ifsc_code =' ';
        $transaction_no ='';

        if($_POST["ifsc_code"]!=''){
            $ifsc_code = $_POST["ifsc_code"];
        }
        if($_POST["transaction_no"]!=''){
            $transaction_no = $_POST["transaction_no"];

        }
        $remarks =' ';
        $received_from = $_POST["received_from"];
        $remarks = $_POST["remarks"];

        if (!empty($received_date && $particulars && $amount && $payment_mode && $received_from && $remarks)) {

            $sql = "INSERT INTO `tbl_extra_income`
                            (`id`, `received_date`, `particulars`, `amount`, `payment_mode`,`account_number`,`bank_name`,`branch_name`,`ifsc_code`,`transaction_no`, `received_from`,`remarks`, `status`) 
                            VALUES 
                            (NULL,'$received_date','$particulars','$amount','$payment_mode','$account_number','$bank_name','$branch_name',
                            '$ifsc_code','$transaction_no','$received_from','$remarks','$visible')
                            ";

                            // inserting the data of the extra income
             $get_last_id = "SELECT MAX(id) as id FROM tbl_extra_income";
             $get_extra_income_id = mysqli_query($con, $get_last_id);
             $extra_income_id = mysqli_fetch_array($get_extra_income_id)['id'];

             $sql_inc = "INSERT INTO `tbl_income`
                 (`id`,`reg_no`,`course`,`received_date`, `academic_year`,`particulars`, `amount`, `payment_mode` ,`check_no`,`bank_name`,`income_from`,`post_at`,`table_name`,`table_id`) 
                 VALUES (NULL,'(Extra Income)$received_from','','$received_date','','$particulars','$amount','$payment_mode','$account_number','$bank_name','Extra Income','" . date("Y-m-d") . "','tbl_extra_income','$extra_income_id')";
             $query = mysqli_query($con, $sql_inc);

            if ($con->query($sql)) {

                echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Added successfully!!!
                            </div>';
                echo "<script>window.location.reload();</script>"; 
            } else
                echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out all Fields!!!
                    </div>';
    }
    //Add Extra Income End With Ajax		
    //Edit Extra Income Start With Ajax
    if ($_POST["action"] == "edit_extra_income") {
        $received_date = $_POST["received_date"];
        $particulars = $_POST["particulars"];
        $amount = $_POST["amount"];
        $payment_mode = $_POST["payment_mode"];
        $account_number = $_POST["account_number"];
        $bank_name = $_POST["bank_name"];
        $branch_name = $_POST["branch_name"];
        $ifsc_code = $_POST["ifsc_code"];
        $transaction_no = $_POST["transaction_no"];
        $received_from = $_POST["received_from"];
        $remarks = $_POST["remarks"];
        $edit_id = $_POST["edit_id"];
        if (!empty($received_date && $particulars && $amount && $payment_mode && $received_from && $remarks && $edit_id)) {

            $sql = "UPDATE `tbl_extra_income` 
                            SET 
                            `received_date` = '$received_date',`particulars` = '$particulars',`amount` = '$amount',`payment_mode` = '$payment_mode',`account_number` = '$account_number',`bank_name` = '$bank_name',`branch_name` = '$branch_name',`ifsc_code` = '$ifsc_code',`transaction_no` = '$transaction_no',`received_from` = '$received_from',`remarks` = '$remarks'
                             WHERE `status` = '$visible' && `id` = '$edit_id';
                            ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        }
    }
    //Edit Extra Income End With Ajax

    //Delete Extra Income Start With Ajax
    if ($_POST["action"] == "delete_extra_income") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $sql = "UPDATE `tbl_extra_income` 
                        SET 
                        `status` = '$trash' 
                        WHERE `status` = '$visible' && `id` = '$delete_id';
                        ";
         $get_last_id = "SELECT * FROM tbl_extra_income WHERE `id`='$delete_id'";
         $get_extra_income_id = mysqli_query($con, $get_last_id);
         $extra_income = mysqli_fetch_array($get_extra_income_id);
         $received_from = '';
         $received_date = $extra_income['received_date'];
         $particulars = $extra_income['particulars'];
         $amount = '-' . $extra_income['amount'];
         $payment_mode = $extra_income['payment_mode'];
         $account_number = $extra_income['account_number'];
         $bank_name = $extra_income['bank_name'];

                $sql_inc = "INSERT INTO `tbl_income`
                (`id`,`reg_no`,`course`,`received_date`, `academic_year`,`particulars`, `amount`, `payment_mode` ,`check_no`,`bank_name`,`income_from`,`post_at`,`table_name`,`table_id`) 
                VALUES 
                (NULL,'(Extra Income deleted)$received_from','','$received_date','','$particulars','$amount','$payment_mode','$account_number','$bank_name','Extra Income','" . date("Y-m-d") . "','tbl_extra_income','$delete_id')
                ";
        $query = mysqli_query($con, $sql_inc);
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Extra Income End With Ajax

    //Add Expenses Start With Ajax
    if ($_POST["action"] == "add_expenses") {
        $payment_date = $_POST["payment_date"];
        $particulars = $_POST["particulars"];
        $amount = $_POST["amount"];
        $payment_mode = $_POST["payment_mode"];
        $account_number = $_POST["account_number"];
        $bank_name = $_POST["bank_name"];
        $branch_name = $_POST["branch_name"];
        $ifsc_code = $_POST["ifsc_code"];
        $transaction_no = $_POST["transaction_no"];
        $paid_to = $_POST["paid_to"];
        $remarks = $_POST["remarks"];

        if (!empty($payment_date && $particulars && $amount && $payment_mode)) {

            $sql = "INSERT INTO `tbl_expenses`
                            (`id`, `payment_date`, `particulars`,`amount`, `payment_mode`,`account_number`,`bank_name`,`branch_name`,`ifsc_code`,`transaction_no`, `paid_to`, `remarks`, `status`) 
                            VALUES 
                            (NULL,'$payment_date','$particulars','$amount','$payment_mode','$account_number','$bank_name','$branch_name','$ifsc_code','$transaction_no','$paid_to','$remarks','$visible')
                            ";
            if ($con->query($sql)) {

                echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Added successfully!!!
                            </div>';
            } else
                echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out all Fields!!!
                    </div>';
    }
    //Add Expenses End With Ajax		
    //Edit Expenses Start With Ajax
    if ($_POST["action"] == "edit_expenses") {
        $payment_date = $_POST["payment_date"];
        $particulars = $_POST["particulars"];
        $amount = $_POST["amount"];
        $payment_mode = $_POST["payment_mode"];
        $bank_name = $_POST["bank_name"];
        $transaction_no = $_POST["transaction_no"];
        $paid_to = $_POST["paid_to"];
        $remarks = $_POST["remarks"];
        $edit_id = $_POST["edit_id"];

        if (!empty($payment_date && $particulars && $amount && $payment_mode && $paid_to && $remarks)) {

            $sql = "UPDATE `tbl_expenses` 
                            SET 
                            `payment_date` = '$payment_date',`particulars` = '$particulars',`amount` = '$amount',`payment_mode` = '$payment_mode',`account_number` = '$account_number',`bank_name` = '$bank_name',`branch_name` = '$branch_name',`ifsc_code` = '$ifsc_code',`transaction_no` = '$transaction_no',`paid_to` = '$paid_to',`remarks` = '$remarks'
                             WHERE `status` = '$visible' && `id` = '$edit_id';
                            ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        }
    }
    //Edit Expenses End With Ajax
    //Delete Expenses Start With Ajax
    if ($_POST["action"] == "delete_expenses") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $sql = "UPDATE `tbl_expenses` 
                        SET 
                        `status` = '$trash' 
                        WHERE `status` = '$visible' && `id` = '$delete_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Expenses End With Ajax
    //Add admin Start With Ajax
    if ($_POST["action"] == "add_admin") {

        //echo "<pre>";
        //print_r($_POST); 
        $admin_name = $_POST["admin_name"];
        $admin_username = $_POST["admin_username"];
        $admin_password = md5($_POST["admin_password"]);


        //$retype_password = $_POST["retype_password"];
        // $admin_email = $_POST["admin_email"];
        // $admin_mobile = $_POST["admin_mobile"];
        $admin_type = $_POST["admin_type"];
        $admin_branch = $_POST["admin_branch"];
        $admin_employee = $_POST["admin_employee"];
        if (!empty($admin_name && $admin_username && $admin_password)) {
            if (count($_POST["permission_3"]) >= 1) {
                $permission_3 = implode("||", $_POST["permission_3"]);
            } else
                $permission_3 = "";
            if (count($_POST["permission_4"]) >= 1) {
                $permission_4 = implode("||", $_POST["permission_4"]);
            } else
                $permission_4 = "";
            if (count($_POST["permission_5"]) >= 1) {
                $permission_5 = implode("||", $_POST["permission_5"]);
            } else
                $permission_5 = "";
            if (count($_POST["permission_6"]) >= 1) {
                $permission_6 = implode("||", $_POST["permission_6"]);
            } else
                $permission_6 = "";
            if (count($_POST["permission_7"]) >= 1) {
                $permission_7 = implode("||", $_POST["permission_7"]);
            } else
                $permission_7 = "";
            if (count($_POST["permission_8"]) >= 1) {
                $permission_8 = implode("||", $_POST["permission_8"]);
            } else
                $permission_8 = "";
            if (count($_POST["permission_9"]) >= 1) {
                $permission_9 = implode("||", $_POST["permission_9"]);
            } else
                $permission_9 = "";
            if (count($_POST["permission_11"]) >= 1) {
                $permission_11 = implode("||", $_POST["permission_11"]);
            } else
                $permission_11 = "";
            if (count($_POST["permission_12"]) >= 1) {
                $permission_12 = implode("||", $_POST["permission_12"]);
            } else
                $permission_12 = "";
            if (count($_POST["permission_13"]) >= 1) {
                $permission_13 = implode("||", $_POST["permission_13"]);
            } else
                $permission_13 = "";
            if (count($_POST["permission_14"]) >= 1) {
                $permission_14 = implode("||", $_POST["permission_14"]);
            } else
                $permission_14 = "";

            $allPermissions = array(
                "3"          =>       $permission_3,
                "4"          =>       $permission_4,
                "5"          =>       $permission_5,
                "6"          =>       $permission_6,
                "7"          =>       $permission_7,
                "8"          =>       $permission_8,
                "9"          =>       $permission_9,
                "11"         =>       $permission_11,
                "12"         =>       $permission_12,
                "13"         =>       $permission_13,
                "14"         =>       $permission_14
            );
            $sql = "INSERT INTO `tbl_admin`
                            ( `admin_name`, `admin_username`, `admin_password`, `admin_type`, `admin_permission`, `admin_branch`,`employee_id`, `status`) 
                            VALUES 
                            ('$admin_name','$admin_username','$admin_password','$admin_type','" . json_encode($allPermissions) . "','$admin_branch','$admin_employee','$visible')
                            ";
            $sql1 = "UPDATE `tbl_employee` SET `branch_id`='$admin_branch',`user_id`='$admin_username',`password`='$admin_password' WHERE `id`='$admin_employee'";
            //   echo $sql; exit();
            if ($con->query($sql) && $con->query($sql1)) {

                echo '
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-check"></i> Added successfully!!!
                        </div>';
            } else
                echo '
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                            <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                        </div>';
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Fill out all required fields!!!
                    </div>';
    }
    //Add admin End With Ajax
    //Edit Admin Start With Ajax
    if ($_POST["action"] == "edit_admin") {
        $edit_admin_name = $_POST["edit_admin_name"];
        // $edit_permissions = $_POST["edit_permissions"];
        $edit_admin_username = $_POST["edit_admin_username"];
        //$edit_admin_password = $_POST["edit_admin_password"];
        $edit_admin_email = $_POST["edit_admin_email"];
        $edit_admin_mobile = $_POST["edit_admin_mobile"];
        $edit_admin_id = $_POST["edit_admin_id"];
        if (!empty($edit_admin_name && $edit_admin_id)) {
            if ($_POST["permission_3"] != "") {
                $permission_3 = $_POST["permission_3"];
            } else
                $permission_3 = "";
            if ($_POST["permission_4"] != "") {
                $permission_4 = $_POST["permission_4"];
            } else
                $permission_4 = "";
            if ($_POST["permission_5"] != "") {
                $permission_5 = $_POST["permission_5"];
            } else
                $permission_5 = "";
            if ($_POST["permission_6"] != "") {
                $permission_6 = $_POST["permission_6"];
            } else
                $permission_6 = "";
            if ($_POST["permission_7"] != "") {
                $permission_7 = $_POST["permission_7"];
            } else
                $permission_7 = "";
            if ($_POST["permission_8"] != "") {
                $permission_8 = $_POST["permission_8"];
            } else
                $permission_8 = "";
            if ($_POST["permission_9"] != "") {
                $permission_9 = $_POST["permission_9"];
            } else
                $permission_9 = "";
            if ($_POST["permission_11"] != "") {
                $permission_11 = $_POST["permission_11"];
            } else
                $permission_11 = "";
            if ($_POST["permission_12"] != "") {
                $permission_12 = $_POST["permission_12"];
            } else
                $permission_12 = "";
            if ($_POST["permission_13"] != "") {
                $permission_13 = $_POST["permission_13"];
            } else
                $permission_13 = "";

            $allPermissions = array(
                "3"          =>       $permission_3,
                "4"          =>       $permission_4,
                "5"          =>       $permission_5,
                "6"          =>       $permission_6,
                "7"          =>       $permission_7,
                "8"          =>       $permission_8,
                "9"          =>       $permission_9,
                "11"         =>       $permission_11,
                "12"         =>       $permission_12,
                "13"         =>       $permission_13
            );
            $sql = "UPDATE `tbl_admin` 
                        SET 
                        `admin_name` = '$edit_admin_name', `admin_email` = '$edit_admin_email', `admin_mobile` = '$edit_admin_mobile', `admin_permission` = '" . json_encode($allPermissions) . "'
                        WHERE `status` = '$visible' && `admin_id` = '$edit_admin_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Edit Admin End With Ajax
    //Delete Admin Start With Ajax
    if ($_POST["action"] == "delete_admin") {
        $delete_admin_id = $_POST["delete_admin_id"];
        $admin_employee = $_POST["admin_employee"];

        echo $sql1 = "UPDATE `tbl_employee` SET `branch_id`=' ',`user_id`=' ',`password`=' ' WHERE `id`='$admin_employee'";
        $con->query($sql1);   

        if (!empty($delete_admin_id)) {
            $sql = "UPDATE `tbl_admin` 
                        SET 
                        `status` = '$trash'
                        WHERE `status` = '$visible' && `admin_id` = '$delete_admin_id';
                        ";
                           
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Admin End With Ajax

    //Delete University Home Start With Ajax
    if ($_POST["action"] == "delete_university_home_enquiry") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $check = $objectDefault->update("admission_enquiry_tbl", "`is_deleted` = '1' WHERE `id`='$delete_id'");
            if ($check == 1)
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete University Home End With Ajax
    //Delete University Prospectus Start With Ajax
    if ($_POST["action"] == "delete_university_prospectus_enquiry") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $check = $objectSecond->update("tbl_prospectus", "`status` = '$trash' WHERE `id`='$delete_id'");
            if ($check == 1)
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete University Prospectus End With Ajax

    //Delete University Get Enquiry Start With Ajax
    if ($_POST["action"] == "delete_university_get_enquiry") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $check = $objectDefault->update("admission_enquiry_tbl", "`is_deleted` = '1' WHERE `id`='$delete_id'");
            if ($check == 1)
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete University Get Enquiry End With Ajax

    //Delete University Prospectus Start With Ajax
    if ($_POST["action"] == "update_prospectus_enquiry") {
        $prosprectus_number = $_POST["prosprectus_number"];
        $prosprectus_id = $_POST["prosprectus_id"];
        $prospectus_course_name = $_POST["prospectus_course_name"];
        $prospectus_session = $_POST["prospectus_session"];
        $prospectus_rate = $_POST["prospectus_rate"];
        $post_at = $_POST["post_at"];
        if (!empty($prosprectus_number && $prosprectus_id)) {
            $objectSecond->select("tbl_prospectus");
            $objectSecond->where("`status` = '$visible' && `prospectus_no` = '$prosprectus_number'");
            $result = $objectSecond->get();
            if ($result->num_rows > 0) {
                echo 'exsits';
            } else {
                $objectSecond->sql = "";
                $check = $objectSecond->update("tbl_prospectus", "`prospectus_no` = '$prosprectus_number'  WHERE `id`='$prosprectus_id'");
                if ($check == 1) {
                    $date = date_create()->format('yy-m-d');
                    $objectSecond->sql = "";
                    $objectSecond->insert("tbl_income", "(`id`,`reg_no`,`course`,`academic_year` ,`received_date`, `particulars`, `amount`, `payment_mode`, `check_no`, `bank_name`,`income_from`,`post_at`) 
	                    VALUES (NULL,'$prosprectus_number(Form No)','$prospectus_course_name','$prospectus_session','$post_at','Prospectus','$prospectus_rate','Online','','','Prospectus','" . date("Y-m-d") . "')");

                    $objectSecond->sql = "";
                    $objectSecond->select("tbl_prospectus");
                    $objectSecond->where("`status` = '$visible' && `id`='$prosprectus_id'");
                    $result = $objectSecond->get();
                    if ($result->num_rows > 0) {
                        $row = $objectSecond->get_row();
                        $prospectus_name = $row["prospectus_applicant_name"];
                        $prospectus_mobile = $row["mobile"];
                        $prospectus_course = $row["prospectus_course_name"];
                        $prospectus_course_link = "";
                        switch ($prospectus_course) {
                            case "PH.D":
                                $prospectus_course_link = "course_phd";
                                break;
                            case "BBA":
                                $prospectus_course_link = "course_bba";
                                break;
                            case "MBA":
                                $prospectus_course_link = "course_mba";
                                break;
                            case "B.COM":
                                $prospectus_course_link = "course_bcom";
                                break;
                            case "M.COM":
                                $prospectus_course_link = "course_mcom";
                                break;
                            case "B.PHARM":
                                $prospectus_course_link = "course_bpharm";
                                break;
                            case "D.PHARM":
                                $prospectus_course_link = "course_dpharm";
                                break;
                            case "B.SC IN HOTEL MANAGEMENT":
                                $prospectus_course_link = "course_hotel";
                                break;
                            case "BCA":
                                $prospectus_course_link = "course_bca";
                                break;
                            case "MCA":
                                $prospectus_course_link = "course_mca";
                                break;
                            case "B.ED":
                                $prospectus_course_link = "course_bed";
                                break;
                            case "M.A IN EDUCATION":
                                $prospectus_course_link = "course_m_a_in_edu";
                                break;
                            case "LLB":
                                $prospectus_course_link = "course_llb";
                                break;
                            case "BBA LLB (HONS.)":
                                $prospectus_course_link = "course_bba_llb";
                                break;
                            case "B.SC (BOTANY)":
                                $prospectus_course_link = "course_bsc_botany";
                                break;
                            case "B.SC (ZOOLOGY)":
                                $prospectus_course_link = "course_bsc_zoology";
                                break;
                            case "B.SC (MATHEMATICS)":
                                $prospectus_course_link = "course_bsc_mathematics";
                                break;
                            case "B.SC (PHYSICS)":
                                $prospectus_course_link = "course_bsc_physics";
                                break;
                            case "B.SC (CHEMISTRY)":
                                $prospectus_course_link = "course_bsc_chemistry";
                                break;
                            case "M.SC (BOTANY)":
                                $prospectus_course_link = "course_msc_botany";
                                break;
                            case "M.SC (ZOOLOGY)":
                                $prospectus_course_link = "course_msc_zoology";
                                break;
                            case "M.SC (MATHEMATICS)":
                                $prospectus_course_link = "course_msc_mathematics";
                                break;
                            case "M.SC (PHYSICS)":
                                $prospectus_course_link = "course_msc_physics";
                                break;
                            case "M.SC (CHEMISTRY)":
                                $prospectus_course_link = "course_msc_chemistry";
                                break;
                            case "POLYTECHNIC":
                                $prospectus_course_link = "course_polytechnic";
                                break;
                            case "M.SC (MATHEMATICS)":
                                $prospectus_course_link = "course_msc_mathematics";
                                break;
                            case "B.A":
                                $prospectus_course_link = "course_ba";
                                break;
                            case "M.A":
                                $prospectus_course_link = "course_ma";
                                break;
                            case "B.A IN JOURNALISM And MASS COMM":
                                $prospectus_course_link = "course_BA_masscomm";
                                break;
                            case "M.A IN EDUCATION":
                                $prospectus_course_link = "course_ma";
                                break;
                            default:
                                $prospectus_course_link = "course_bca";
                                break;
                        }
                        $message = "Dear $prospectus_name, Your Prospectus Form has been Successfully approved.\nYour Prospectus No - $prosprectus_number \nClick below link to apply Admission Form.\nhttps://nspsjsr.in/admission?course=$prospectus_course_link \n\nRegards,\nNetaji Subhas Public School, \nJamshedpur. ";
                        $objectSecond->send_otp($prospectus_mobile, $message);
                        echo 'success';
                    } else {
                        $objectSecond->sql = "";
                        $check = $objectSecond->update("tbl_prospectus", "`prospectus_no` = '' WHERE `id`='$prosprectus_id'");
                        echo 'error';
                    }
                } else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Delete University Prospectus End With Ajax


    /* NSUNIV Notification Section */
    //Delete Notification Start With Ajax
    if ($_POST["action"] == "delete_university_notification") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $check = $objectDefault->update("notification_tbl", "`status` = '$trash' WHERE `id`='$delete_id'");
            if ($check == 1)
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Notification End With Ajax
    //Notification Of NSUNIV Start With Ajax
    if ($_POST["action"] == "addNotification") {
        $ThemeColor = $_POST["ThemeColor"];
        $notification = str_replace("'", "&#39;", $_POST["notification"]);
        if (!empty($ThemeColor && $notification)) {
            $check = $objectDefault->insert("notification_tbl", "(`id`, `theme`, `notification`, `visibility`, `timing`, `status`) VALUES (NULL, '$ThemeColor', '$notification', 'active', '$date_variable_today_month_year_with_timing', '$visible')");
            if ($check == 1)
                echo 'success';
            else
                echo '<span style="color:red;">Something went wrong please try again!!!<br/></span>';
        } else
            echo '<span style="color:red;">Please complete both fields!!!<br/></span>';
    }
    //Notification Of NSUNIV End With Ajax
    //Add Semester Start With Ajax
    if ($_POST["action"] == "add_semester") {
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $semester = str_replace("'", "&#39;", $_POST["semester"]);
        $exam_fee = str_replace("'", "&#39;", $_POST["exam_fee"]);
        $exam_fine = str_replace("'", "&#39;", $_POST["exam_fine"]);
        $exam_fee_last_date = $_POST["exam_fee_last_date"];
        $fee_status = $_POST["fee_status"];
        $examname = str_replace("'", "&#39;", $_POST["examname"]);
        $name_of_school = str_replace("'", "&#39;", $_POST["name_of_school"]);
        $examination_month = str_replace("'", "&#39;", $_POST["examination_month"]);
        $date_of_result     = $_POST["date_of_result"];
        if (!empty($course_id && $academic_year) && $semester[0] != "" && $examname[0] != "") {
            $allSemester = count($semester);
            $allExamname = count($examname);
            if ($course_id == "all") {
                $sql = "SELECT * FROM `tbl_course`
                            WHERE `status` = '$visible'
                            ";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    $sql = "";
                    while ($row = $result->fetch_assoc()) {
                        $course_id_all = $row["course_id"];
                        for ($i = 0; $i < $allSemester; $i++) {
                            $sql_check = "SELECT * FROM `tbl_semester`
                                             WHERE `status` = '$visible' && `course_id` = '$course_id_all' && `fee_academic_year` = '$academic_year' && `semester` = '$semester[$i]';
                                             ";
                            $result_check = $con->query($sql_check);
                            if ($result_check->num_rows > 0) {
                                $row_check = $result_check->fetch_assoc();
                                $sql .= "UPDATE `tbl_semester` 
                                            SET `examname`='$examname[$i]',`add_time`='$date_variable_today_month_year_with_timing'
                                            WHERE `semester_id` = '" . $row_check['semester_id'] . "';
                                            ";
                            } else {
                                $sql .= "INSERT INTO `tbl_semester`
                                            (`semester_id`, `course_id`, `fee_academic_year`, `semester`,`exam_fee`,`exam_fine`,`exam_fee_last_date`,`fee_status`, `examname`,`name_of_school`,`examination_month`,`date_of_result`,`add_time`, `status`) 
                                            VALUES 
                                            (NULL,'$course_id_all','$academic_year','$semester[$i]','$exam_fee[$i]','$exam_fine[$i]','$exam_fee_last_date[$i]','$fee_status[$i]','$examname[$i]','$name_of_school[$i]','$examination_month[$i]','$date_of_result[$i]','$date_variable_today_month_year_with_timing','$visible');
                                            ";
                            }
                        }
                    }
                    if ($con->multi_query($sql))
                        echo 'success';
                    else
                        echo 'error';
                } else
                    echo 'courseempty';
            } else {
                $sql = "";
                for ($i = 0; $i < $allSemester; $i++) {
                    $sql_check = "SELECT * FROM `tbl_semester`
                                     WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `semester` = '$semester[$i]';
                                     ";
                    $result = $con->query($sql_check);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $sql .= "UPDATE `tbl_semester` 
                                    SET `examname`='$examname[$i]',`add_time`='$date_variable_today_month_year_with_timing'
                                    WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `semester` = '$semester[$i]';
                                    ";
                    } else {
                        $sql .= "INSERT INTO `tbl_semester`
                                    (`semester_id`, `course_id`, `fee_academic_year`, `semester`,`exam_fee`,`exam_fine`,`exam_fee_last_date`,`fee_status`, `examname`,`name_of_school`,`examination_month`,`date_of_result`, `add_time`, `status`) 
                                    VALUES 
                                    (NULL,'$course_id','$academic_year','$semester[$i]','$exam_fee[$i]','$exam_fine[$i]','$exam_fee_last_date[$i]','$fee_status[$i]','$examname[$i]','$name_of_school[$i]','$examination_month[$i]','$date_of_result[$i]','$date_variable_today_month_year_with_timing','$visible');
                                    ";
                    }
                }
                if ($con->multi_query($sql))
                    echo 'success';
                else
                    echo 'error';
            }
        } else
            echo 'empty';
    }
    //Add Semester End With Ajax
    //Edit Semester Start With Ajax
    if ($_POST["action"] == "edit_semester_list") {
        $course_id = $_POST["course_id"];
        $semester = $_POST["semester"];
        $fee_academic_year = $_POST["fee_academic_year"];
        $exam_fee = str_replace("'", "&#39;", $_POST["exam_fee"]);
        $exam_fine = str_replace("'", "&#39;", $_POST["exam_fine"]);
        $exam_fee_last_date = $_POST["exam_fee_last_date"];
        $fee_status = $_POST["fee_status"];
        $examname = str_replace("'", "&#39;", $_POST["examname"]);
        $name_of_school = str_replace("'", "&#39;", $_POST["name_of_school"]);
        $examination_month = str_replace("'", "&#39;", $_POST["examination_month"]);
        $date_of_result = $_POST["date_of_result"];
        $exam_reporting_time = $_POST["exam_reporting_time"];
        $time_of_examination = $_POST["time_of_examination"];
        $edit_id = $_POST["edit_id"];
        if (!empty($course_id && $fee_academic_year)) {

            $sql = "UPDATE `tbl_semester` 
                            SET 
                            `course_id` = '$course_id',`semester` = '$semester',`fee_academic_year` = '$fee_academic_year',
							`exam_fee` = '$exam_fee',`exam_fine` = '$exam_fine',`exam_fee_last_date` = '$exam_fee_last_date',
							`fee_status` = '$fee_status',`examname` = '$examname',`name_of_school` = '$name_of_school',
							`examination_month` = '$examination_month',`date_of_result` = '$date_of_result',`exam_reporting_time` = '$exam_reporting_time',`time_of_examination` = '$time_of_examination',`add_time` = '$date_variable_today_month_year_with_timing' 
                             WHERE `status` = '$visible' && `semester_id` = '$edit_id';
                            ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        }
    }
    //Edit Semester End With Ajax
    //Delete Semester Start With Ajax
    if ($_POST["action"] == "delete_get_semester") {
        $semester_id = $_POST["semester_id"];
        if (!empty($semester_id)) {
            $sql = "UPDATE `tbl_semester` 
                        SET 
                        `status` = '$trash', `add_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `semester_id` = '$semester_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Semester End With Ajax


    //Add new fee Start With Ajax
    if ($_POST["action"] == "add_fee") {
        $class_id = $_POST["class_id"];
        $section_id = $_POST["section_id"];
        $fee_name = str_replace("'", "&#39;", $_POST["fee_name"]);
        $fee = $_POST["fee"];
        $last_date = $_POST["last_date"];
        $fine = $_POST["fine"];
        $tennure = $_POST["tennure"];
        $branch = $_POST["branch"];
        $academic_year = $_POST["academic_year"];

        // $branch = count($_POST["branch"]);
        // $j = count($branch);
        // echo "<pre>";
        // print_r($branch);
        // exit();

        $particulars[] = $fee_name;
        $date[] = $last_date;
        $duration[] = $tennure;
        foreach ($branch as $br) {
            $branches[]  =   $br;
            $brc = implode(',', $branches);
            if (!empty($class_id && $fee_name[0] != "" && $fee[0] != "" && $last_date[0] != "" && $fine[0] != "" && $tennure[0] != "" && $br != "")) {
                $allParticulars = count($fee);
                // echo "<pre>";
                // print_r($allParticulars);
                // exit();
                $sql = "";

                if ($section_id == 0) {
                    $sql_sect = "SELECT * FROM tbl_section WHERE course_id=" . $class_id;
                    $result_sect = mysqli_query($con, $sql_sect);
                    while ($row_sect = mysqli_fetch_array($result_sect)) {
                        $sectt = $row_sect['section_id'];
                        for ($i = 0; $i < $allParticulars; $i++) {

                            $sql = "INSERT INTO `tbl_fee`
                                    (`class`, `section`, `particular`, `fee`, `last_date`,`fee_academic_year`, `fine_amount`, `tennure`, `branch`) 
                                    VALUES 
                                    ('$class_id','$sectt','$fee_name[$i]','$fee[$i]','$last_date[$i]','$academic_year[$i]','$fine[$i]','$tennure[$i]','$br');";

                            $success = $con->query($sql);
                        }
                    }
                } else {
                    for ($i = 0; $i < $allParticulars; $i++) {

                        $sql = "INSERT INTO `tbl_fee`
                                    (`class`, `section`, `particular`, `fee`, `last_date`,`fee_academic_year`, `fine_amount`, `tennure`, `branch`) 
                                    VALUES 
                                    ('$class_id','$section_id','$fee_name[$i]','$fee[$i]','$last_date[$i]','$academic_year[$i]','$fine[$i]','$tennure[$i]','$br');";

                        $success = $con->query($sql);
                    }
                }
            } else
                echo 'empty';
        }
        // print_r($brc);
        // print_r($particulars);
        // print_r($date);
        // print_r($duration);
        //     exit();
        if ($success) {

            $class = "SELECT * FROM `tbl_class` WHERE course_id = $class_id";
            $class_id = $con->query($class);
            $row_cls = mysqli_fetch_assoc($class_id);


            $section = "SELECT * FROM `tbl_section` WHERE section_id = $section_id";
            $section_id1 = $con->query($section);
            $row_sec = mysqli_fetch_assoc($section_id1);


            $sql_course = "SELECT * FROM `tbl_branch` WHERE id NOT IN ($brc)";
            $result_course = $con->query($sql_course);


?>
<div class="modal fade" id="registration" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 910px!important">
        <div class="modal-content">
            <div class="modal-body">
                <form action="./lol.php" method="POST">

                    <!-- /.card-header -->

                    <div class="card-body">
                        <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">
                            <thead>
                                <tr>
                                    <th data-field="S.NO" data-sortable="true" rowspan="2">Branch</th>
                                    <th data-field="fee_name" data-sortable="true" rowspan="2">class</th>
                                    <th data-field="fee" data-sortable="true" rowspan="2">section</th>
                                    <th data-field="fee" data-sortable="true" rowspan="2">Particulars</th>
                                    <th data-field="fee" data-sortable="true" rowspan="2">Fee</th>
                                    <th data-field="ExamDate" data-sortable="true" rowspan="2">Last Date</th>
                                    <th data-field="FullMarks" data-sortable="true" rowspan="2">Fine Amount</th>
                                    <th data-field="PassMarks" data-sortable="true" rowspan="2">Tennure</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                            //  $cnt = count($particulars);
                                            //  print_r($duration);
                                            //  exit();
                                            $test = ($section_id == 0) ? "All" : ($row_sec['section_name']);
                                            $test1 = ($section_id == 0) ? 0 : ($row_sec['section_id']);
                                            // echo "<pre>";
                                            // var_dump($test);
                                            // exit();
                                            while ($row = mysqli_fetch_array($result_course)) {
                                                $branc = $row['branch_name'];
                                                $brand = $row['id'];
                                                for ($i = 0; $i < $allParticulars; $i++) {


                                            ?>
                                <tr>
                                    <td width="20%">
                                        <input type='hidden' name='branch[]' value='<?php echo $brand ?>' />
                                        <input type="text" name="brand[]" placeholder="branch"
                                            value="<?php echo $branc ?>" readonly class="form-control"
                                            style="border:none;" />
                                    </td>
                                    <td width="10%">
                                        <input type='hidden' name='class_name[]'
                                            value='<?php echo $row_cls['course_id']; ?>' />
                                        <input type="text" name="class[]" placeholder="class"
                                            value="<?php echo $row_cls['course_name']; ?>" readonly
                                            class="form-control" />
                                    </td>
                                    <td width="10%">
                                        <input type='hidden' name='section_name[]' value='<?php echo $test1; ?>' />
                                        <input type="text" name="section[]" placeholder="section"
                                            value="<?php echo $test; ?>" readonly class="form-control" />
                                    </td>
                                    <td width="25%">
                                        <input type="text" name="particular[]" placeholder="particular"
                                            value="<?php echo $particulars[0][$i]; ?>" readonly class="form-control" />
                                    </td>
                                    <td width="15%">
                                        <input type="text" name="fee[]" placeholder="Fee" class="form-control" />
                                    </td>
                                    <td width="5%">
                                        <input type="date" name="last_date[]" placeholder="Last Date"
                                            value="<?php echo $date[0][$i]; ?>" readonly class="form-control" />
                                    </td>
                                    <td width="12%">
                                        <input type="number" name="fine[]" placeholder="Fine" class="form-control" />
                                    </td>
                                    <td width="22%">
                                        <input type="text" name="tennure[]" placeholder="tennure"
                                            value="<?php echo $duration[0][$i]; ?>" readonly class="form-control" />
                                    </td>


                                </tr>
                                <?php    }
                                            } ?>
                            </tbody>
                        </table>

                        <br>
                        <input type='hidden' name='action' value='fee_test' />
                        <div class="col-md-12" id="loader_section"></div>
                        <input type="submit" class="btn btn-primary" name="fee_detail" value="Add">
                        <!-- <button type="submit" id="add_subjects_button" class="btn btn-primary" name="fee_detail">Add</button> -->
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                    <!-- /.card-body -->


            </div>

            </form>
        </div>
    </div>
</div>
</div>

<?php

        } else
            echo 'error';
    }
    //Add new fee End With Ajax

    //Add new subject Start With Ajax
    if ($_POST["action"] == "add_sub") 
    {
            $class_id = $_POST["class_id"];
            $section_id = $_POST["section_id"];
            $subject_name = str_replace("'", "&#39;", $_POST["subject_name"]);
            $pass_marks = $_POST["pass_marks"];
            $full_marks = $_POST["full_marks"];
            
            if (!empty($class_id && $subject_name[0] != "" && $full_marks[0] != "" && $pass_marks[0] != "")) { 
                $allParticulars = count($subject_name);
    
                //$sql = "";
                
                if($_SESSION["logger_type"] != "admin")
                {  
                    $branchh = $_SESSION["admin_branch"];   
                    if ($section_id == 'all') 
                    {
                        $sql_sect = "SELECT * FROM tbl_section WHERE course_id=" . $class_id;
                        $result_sect = mysqli_query($con, $sql_sect);           
                        while ($row_sect = mysqli_fetch_array($result_sect)) {
                        $sectt = $row_sect['section_id'];
                        for ($i = 0; $i < $allParticulars; $i++) 
                            {
                        $sql = "INSERT INTO `tbl_subjects`
                                 (`subject_id`,`branch_id`,`class_id`,`section_id`,`subject_name`,`full_marks`,`pass_marks`, `add_time`, `status`) 
                                 VALUES 
                                 (NULL,'$branchh','$class_id','$sectt','$subject_name[$i]','$full_marks[$i]','$pass_marks[$i]','$date_variable_today_month_year_with_timing','$visible');";
                        $success = $con->query($sql);
                        }
                        }
                    }
                    else
                    {
                    for ($i = 0; $i < $allParticulars; $i++) {

                        $sql = "INSERT INTO `tbl_subjects`(`subject_id`,`branch_id`,`class_id`,`section_id`,`subject_name`,`full_marks`,`pass_marks`, `add_time`, `status`) 
                                            VALUES 
                                            (NULL,'$branchh','$class_id','$section_id','$subject_name[$i]','$full_marks[$i]','$pass_marks[$i]','$date_variable_today_month_year_with_timing','$visible');";
                        $success = $con->query($sql);
                        }
                    }
                }
            else
            {
                $branch = $_POST['branch'];
                if ($section_id == 'all') 
                {
                    $sql_sect = "SELECT * FROM tbl_section WHERE course_id=" . $class_id;
                    $result_sect = mysqli_query($con, $sql_sect);           
                    while ($row_sect = mysqli_fetch_array($result_sect)) {
                    $sectt = $row_sect['section_id'];
                    for ($i = 0; $i < $allParticulars; $i++) 
                        {
                    $sql = "INSERT INTO `tbl_subjects`
                             (`subject_id`,`branch_id`,`class_id`,`section_id`,`subject_name`,`full_marks`,`pass_marks`, `add_time`, `status`) 
                             VALUES 
                             (NULL,'$branch','$class_id','$sectt','$subject_name[$i]','$full_marks[$i]','$pass_marks[$i]','$date_variable_today_month_year_with_timing','$visible');";
                    $success = $con->query($sql);
                    }
                    }
                }
                else
                {
                for ($i = 0; $i < $allParticulars; $i++) {

                    $sql = "INSERT INTO `tbl_subjects`(`subject_id`, `branch_id`,`class_id`,`section_id`,`subject_name`,`full_marks`,`pass_marks`, `add_time`, `status`) 
                                        VALUES 
                                        (NULL,'$branch','$class_id','$section_id','$subject_name[$i]','$full_marks[$i]','$pass_marks[$i]','$date_variable_today_month_year_with_timing','$visible');";
                    $success = $con->query($sql);
                    }
                }
            }
            if ($success)
            echo 'success';
        else
            echo 'error';
        }   
        else
            echo 'empty';
    }
    //Add new Subject End With Ajax	 
    //Edit Subject Start With Ajax
    if ($_POST["action"] == "edit_subject_list") {
        $class_id = $_POST["class_id"];
        $section_id = $_POST["section_id"];
        $subject_name1 = str_replace("'", "&#39;", $_POST["subject_name1"]);
        $subject_name2 = str_replace("'", "&#39;", $_POST["subject_name2"]);
        $subject_name3 = str_replace("'", "&#39;", $_POST["subject_name3"]);
        $subject_name4 = str_replace("'", "&#39;", $_POST["subject_name4"]);
        $subject_name5 = str_replace("'", "&#39;", $_POST["subject_name5"]);
        $subject_name6 = str_replace("'", "&#39;", $_POST["subject_name6"]);
        $subject_name7 = str_replace("'", "&#39;", $_POST["subject_name7"]);
        $subject_name8 = str_replace("'", "&#39;", $_POST["subject_name8"]);
        $subject_name9 = str_replace("'", "&#39;", $_POST["subject_name9"]);
        $subject_name10 = str_replace("'", "&#39;", $_POST["subject_name10"]);
        $full_marks = $_POST["full_marks"];
        $pass_marks = $_POST["pass_marks"];
        $edit_id = $_POST["edit_id"];
        if (!empty($class_id)) {

            $sql = "UPDATE `tbl_subjects` 
                            SET 
                            `class_id` = '$class_id',`section_id` = '$section_id',`subject_name1` = '$subject_name1',`subject_name2` = '$subject_name2',`subject_name3` = '$subject_name3',`subject_name4` = '$subject_name4',
                            `subject_name5` = '$subject_name5', `subject_name6` = '$subject_name6', `subject_name7` = '$subject_name7', `subject_name8` = '$subject_name8', `subject_name9` = '$subject_name9', `subject_name10` = '$subject_name10',`full_marks` = '$full_marks',`pass_marks` = '$pass_marks'
                             WHERE `status` = '$visible' && `subject_id` = '$edit_id';
                            ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        }
    }
    //Edit Subject End With Ajax
    //Delete Subject Start With Ajax
    if ($_POST["action"] == "delete_get_subject") {
        $subject_id = $_POST["subject_id"];
        //echo $subject_id; exit;
        if (!empty($subject_id)) {
            $sql = "UPDATE `tbl_subjects` 
                        SET 
                        `status` = '$trash', `add_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `subject_id` = '$subject_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Get subject End With Ajax
    //Add marks Start With Ajax
    if ($_POST["action"] == "add_marks") {
        $class_id = $_POST["class_id"];
        $section_id = $_POST["section_id"];
        $subject_id = $_POST["subject_id"];
        $exam_id = $_POST["exam_id"];
        $reg_no = $_POST["reg_no"];
        $external_marks = $_POST["external_marks"];

        // echo "<pre>";
        //print_r($_POST);

        $allParticulars = count($external_marks);

        for ($i = 0; $i < $allParticulars; $i++) {

            $sql_check = "SELECT * FROM `tbl_marks` WHERE `subject_id` = '$subject_id' ";
            $result = $con->query($sql_check);

            if ($result) {
                if ($result->num_rows > 0) {

                    $sql_update = "UPDATE `tbl_marks` SET  `class_id` = '$class_id',`section_id` = '$section_id',`subject_id`= '$subject_id', `external_marks` = '$external_marks[$i]' ,`exam_id` = '$exam_id' ,`add_time` = '$date_variable_today_month_year_with_timing'  WHERE `reg_no` = '$reg_no[$i]' && `subject_id` = '$subject_id'";

                    $con->query($sql_update);
                } else {
                    // for($i = 0; $i<$allParticulars; $i++){

                    $sql = "INSERT INTO `tbl_marks`
                                    (`marks_id`, `class_id`,`section_id`, `reg_no`,`exam_id`,`subject_id`,`external_marks`,`add_time`, `status`) 
                                    VALUES 
                                    (NULL,'$class_id','$section_id','$reg_no[$i]','$exam_id','$subject_id','$external_marks[$i]','$date_variable_today_month_year_with_timing','$visible')";

                    // echo $sql; exit();

                    // var_dump("INSERT INTO `tbl_marks`
                    //             (`marks_id`, `class_id`,`section_id`, `reg_no`,`exam_id`,`subject_id`,`external_marks`,`add_time`, `status`) 
                    //             VALUES 
                    //             (NULL,'$class_id','$section_id','$reg_no[$i]','$exam_id','$subject_id','$external_marks[$i]','$date_variable_today_month_year_with_timing','$visible')"); exit;

                    //}      

                }
            }
        }

        $con->multi_query($sql);
        echo 'success';
    }
    //Add marks End With Ajax  


    //Add semester to student Start With Ajax
    if ($_POST["action"] == "add_sem") {
        $admission_id = $_POST["admission_id"];
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $semester_id = $_POST["semester_id"];

        $all = count($semester_id);

        for ($i = 0; $i < $all; $i++) {

            $sql .= "INSERT INTO `tbl_allot_semester`
                                    (`allot_id`, `admission_id`,`course_id`, `academic_year`, `semester_id`, `status`) 
                                    VALUES 
                                    (NULL,'$admission_id','$course_id','$academic_year','$semester_id[$i]','$visible');";
        }
        if ($con->multi_query($sql))
            echo 'success';
        else
            echo 'error';
    }
    //Add semester to student End With Ajax 
    //Add Get Student Start With Ajax
    if ($_POST["action"] == "add_student") {
        $course_id = $_POST["course_id"];
        $university_details_id = $_POST["university_details_id"];
        $semester_id = $_POST["semester_id"];
        $serial_no = str_replace("'", "&#39;", $_POST["serial_no"]);
        $reg_no = str_replace("'", "&#39;", $_POST["reg_no"]);
        $roll_no = str_replace("'", "&#39;", $_POST["roll_no"]);
        $student_name = str_replace("'", "&#39;", $_POST["student_name"]);
        $father_name = str_replace("'", "&#39;", $_POST["father_name"]);
        $type = str_replace("'", "&#39;", $_POST["type"]);
        if (!empty($course_id && $university_details_id && $semester_id && $reg_no && $roll_no && $student_name && $father_name)) {

            $sql = "INSERT INTO `tbl_student`
                            (`student_id`, `course_id`, `university_details_id`,`semester_id`,`serial_no`, `reg_no`,`roll_no`,`student_name`,`father_name`,`type`, `create_time`,`status`) 
                            VALUES 
                            (NULL,'$course_id','$university_details_id','$semester_id','$serial_no','$reg_no','$roll_no','$student_name','$father_name','$type','$date_variable_today_month_year_with_timing','$visible')
                            ";
            if ($con->query($sql)) {

                echo '
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-check"></i> Added successfully!!!
                            </div>';
            } else
                echo '
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                                <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                            </div>';
        } else
            echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out all Fields!!!
                    </div>';
    }
    //Add Get Student End With Ajax
    //Edit Get Student Start With Ajax
    if ($_POST["action"] == "edit_student") {
        $student_id = $_POST["student_id"];
        $course_id = $_POST["course_id"];
        $section_id = $_POST["section_id"];
        $gender = $_POST["gender"];
        $dob =  $_POST["dob"];
        $reg_no = str_replace("'", "&#39;", $_POST["reg_no"]);
        $roll_no = str_replace("'", "&#39;", $_POST["roll_no"]);
        $student_name = str_replace("'", "&#39;", $_POST["student_name"]);
        $father_name = str_replace("'", "&#39;", $_POST["father_name"]);
        $mother_name = str_replace("'", "&#39;", $_POST["mother_name"]);
        $parent_contactno = str_replace("'", "&#39;", $_POST["parent_contactno"]);
        if (!empty($course_id && $section_id && $reg_no && $roll_no && $student_name && $father_name)) {

            $sql = "UPDATE `tbl_student` 
                            SET 
                            `course_id` = '$course_id', `section_id` = '$section_id',`gender` = '$gender',`dob` = '$dob', `reg_no` = '$reg_no',`student_name` = '$student_name',`father_name` = '$father_name',`mother_name` = '$mother_name',`roll_no` = '$roll_no',`parent_contactno` = '$parent_contactno',`create_time` = '$date_variable_today_month_year_with_timing' 
                            WHERE `status` = '$visible' && `student_id` = '$student_id';
                            ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Edit Get Student End With Ajax
    //Delete Get Student Start With Ajax
    if ($_POST["action"] == "delete_get_student") {
        $student_id = $_POST["student_id"];
        if (!empty($student_id)) {
            $sql = "UPDATE `tbl_student` 
                        SET 
                        `status` = '$trash', `create_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `student_id` = '$student_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Get Student End With Ajax
    //Nss Updation Start With Ajax
    if ($_POST["action"] == "updateNss") {
        $description = htmlentities($_POST["description"]);
        $video = htmlentities($_POST["video"]);
        $aboutVideo = htmlentities($_POST["aboutVideo"]);
        $imagesImplode = "";
        $images = $_FILES["images"]["name"];
        if (!empty($images)) {
            $imagesImplode = implode(",", $_FILES["images"]["name"]);
            for ($i = 0; $i < count($images); $i++) {
                if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $nssImageDir . $images[$i]))
                    $uploaded = 1;
                else
                    $uploaded = 0;
            }
        }
        $completeDescription = array(
            "description"   => $description,
            "video"         => $video,
            "aboutVideo"    => $aboutVideo,
            "images"        => $imagesImplode
        );
        if (!empty($description)) {
            $check = $objectDefault->update("tbl_files", "`description` = '" . json_encode($completeDescription) . "' WHERE `id`='1'");
            if ($check == 1)
                echo 'success';
            else
                echo 'Something Went Wrong Please Try Again';
        } else
            echo 'Connot Go With Empty Data...';
    }
    //Nss Updation Start With Ajax
    // dues, no dues update start
    if ($_POST["action"] == "checkStatus") {
        if (isset($_POST["admission_id"])) {
            $admission_id = $_POST["admission_id"];
            $particular_id = $_POST["particular_id"];
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];
            if (!empty($admission_id && $particular_id && $course_id && $academic_year)) {
                $sqlTblFeeStatus = "SELECT *
										 FROM `tbl_fee_status`
										 WHERE `particular_id` = '" . $particular_id . "' AND `admission_id` = '" . $admission_id . "' AND `course_id` = '" . $course_id . "' AND `academic_year` = '" . $academic_year . "'
										 ";
                $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                if ($resultTblFeeStatus->num_rows > 0) {
                    $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                    if (strtolower($rowTblFeeStatus["fee_status"]) == "dues") {
                        //uPDATE nO dUES
                        $sql_update = "UPDATE `tbl_fee_status` 
                            SET 
                            `fee_status` = 'No Dues'
                            WHERE `particular_id` = '" . $particular_id . "' && `admission_id` = '" . $admission_id . "' && `course_id` = '" . $course_id . "' && `academic_year` = '" . $academic_year . "';
                            ";
                        if ($con->query($sql_update))
                            echo "success";
                        else
                            echo "error";
                    } else {
                        //uPDATE dUES
                        $sql = "UPDATE `tbl_fee_status` 
                            SET 
                            `fee_status` = 'Dues'
                            WHERE `particular_id` = '" . $particular_id . "' && `admission_id` = '" . $admission_id . "' && `course_id` = '" . $course_id . "' && `academic_year` = '" . $academic_year . "';
                            ";
                        if ($con->query($sql))
                            echo "success";
                        else
                            echo "error";
                    }
                } else {
                    //iNSERT nO dUES
                    $sql_insert = "INSERT INTO `tbl_fee_status`
                            (`fee_status_id`, `admission_id`,`course_id`,`academic_year`, `particular_id`,`fee_status`) 
                            VALUES 
                            (NULL,'$admission_id','$course_id','$academic_year','$particular_id','No Dues')
                            ";
                    if ($con->query($sql_insert))
                        echo "success";
                    else
                        echo "error";
                }
            } else
                echo 'empty';
        }
    }
    //dues nodues end


    //EXAM dues, no dues update start
    if ($_POST["action"] == "checkExamStatus") {
        if (isset($_POST["admission_id"])) {
            $admission_id = $_POST["admission_id"];
            $particular_id = $_POST["particular_id"];
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];
            if (!empty($admission_id && $particular_id && $course_id && $academic_year)) {
                $sqlTblFeeStatus = "SELECT *
                                         FROM `tbl_examfee_status`
                                         WHERE `particular_id` = '" . $particular_id . "' AND `admission_id` = '" . $admission_id . "' AND `course_id` = '" . $course_id . "' AND `academic_year` = '" . $academic_year . "'
                                         ";
                $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                if ($resultTblFeeStatus->num_rows > 0) {
                    $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                    if (strtolower($rowTblFeeStatus["fee_status"]) == "dues") {
                        //uPDATE nO dUES
                        $sql_update = "UPDATE `tbl_examfee_status` 
                            SET 
                            `fee_status` = 'No Dues'
                            WHERE `particular_id` = '" . $particular_id . "' && `admission_id` = '" . $admission_id . "' && `course_id` = '" . $course_id . "' && `academic_year` = '" . $academic_year . "';
                            ";
                        if ($con->query($sql_update))
                            echo "success";
                        else
                            echo "error";
                    } else {
                        //uPDATE dUES
                        $sql = "UPDATE `tbl_examfee_status` 
                            SET 
                            `fee_status` = 'Dues'
                            WHERE `particular_id` = '" . $particular_id . "' && `admission_id` = '" . $admission_id . "' && `course_id` = '" . $course_id . "' && `academic_year` = '" . $academic_year . "';
                            ";
                        if ($con->query($sql))
                            echo "success";
                        else
                            echo "error";
                    }
                } else {
                    //iNSERT nO dUES
                    $sql_insert = "INSERT INTO `tbl_examfee_status`
                            (`exfee_status_id`, `admission_id`,`course_id`,`academic_year`, `particular_id`,`fee_status`) 
                            VALUES 
                            (NULL,'$admission_id','$course_id','$academic_year','$particular_id','No Dues')
                            ";
                    if ($con->query($sql_insert))
                        echo "success";
                    else
                        echo "error";
                }
            } else
                echo 'empty';
        }
    }

    //Exam dues nodues end











    //exam status approve start
    if ($_POST["action"] == "examStatus") {
        if (isset($_POST["fee_status_id"])) {
            $fee_status_id = $_POST["fee_status_id"];
            $exam_status = $_POST["exam_status"];
            //var_dump($_POST);
            if (!empty($exam_status)) {
                $sqlTblFeeStatus = "SELECT *
										 FROM `tbl_fee_status`
										 WHERE  `fee_status_id` = '$fee_status_id'
										 ";
                $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                if ($resultTblFeeStatus->num_rows > 0) {
                    $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                    if ($rowTblFeeStatus["exam_status"] == "Approve")
                        $sql_update = "UPDATE `tbl_fee_status` 
											SET 
											`exam_status` = 'Not Approve'
											WHERE  `fee_status_id` = '$fee_status_id';
											";
                    else
                        $sql_update = "UPDATE `tbl_fee_status` 
											SET 
											`exam_status` = 'Approve'
											WHERE  `fee_status_id` = '$fee_status_id';
											";
                    if ($con->query($sql_update))
                        echo "success";
                    else
                        echo "error";
                } else
                    echo 'empty';
            }
        }
    }
    //exam status approve end
    //Delete Complaint Start With Ajax
    if ($_POST["action"] == "delete_complaint") {
        $delete_id = $_POST["delete_id"];
        if (!empty($delete_id)) {
            $sql = "UPDATE `tbl_complaint` 
                        SET 
                        `status` = '$trash' 
                        WHERE `status` = '$visible' && `complaint_id` = '$delete_id';
                        ";
            if ($con->query($sql))
                echo 'success';
            else
                echo 'error';
        } else
            echo 'empty';
    }
    //Delete Complaint End With Ajax
    //admit card status approve start
    if ($_POST["action"] == "admitcardStatus") {
        if (isset($_POST["allot_id"])) {
            $allot_id = $_POST["allot_id"];
            $admitcard_status = $_POST["admitcard_status"];
            //var_dump($_POST);
            if (!empty($admitcard_status)) {
                $sqlTblFeeStatus = "SELECT *
										 FROM `tbl_allot_semester`
										 WHERE  `allot_id` = '$allot_id'
										 ";
                $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                if ($resultTblFeeStatus->num_rows > 0) {
                    $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                    if ($rowTblFeeStatus["admitcard_status"] == "Approve")
                        $sql_update = "UPDATE `tbl_allot_semester` 
											SET 
											`admitcard_status` = 'Not Approve'
											WHERE  `allot_id` = '$allot_id';
											";
                    else
                        $sql_update = "UPDATE `tbl_allot_semester` 
											SET 
											`admitcard_status` = 'Approve'
											WHERE  `allot_id` = '$allot_id';
											";
                    if ($con->query($sql_update))
                        echo "success";
                    else
                        echo "error";
                } else
                    echo 'empty';
            }
        }
    }
    //admit card status approve end
    /* ---------- All Admin(Backend) Codes End ---------- */


    //student status change
    if ($_POST['action'] == 'student_status_update') {
        //   print_r($_POST); EXIT;
        $admission_id = $_POST['id'];
        $stud_status = $_POST['status'];

        // echo  $admission_id;
        // echo  $stud_status;   exit;

        if ($stud_status == 1) {
            $sql = "UPDATE `tbl_admission` 
                                SET 
                                `stud_status` = 0
                                WHERE `status` = '$visible' && `admission_id` = '$admission_id' && `stud_status` = '$stud_status';
                                ";
            if ($con->query($sql))

                echo 'success';
            else
                echo 'error';
        } else {
            $sql = "UPDATE `tbl_admission` 
                                SET 
                                `stud_status` = 1
                                WHERE `status` = '$visible' && `admission_id` = '$admission_id' && `stud_status` = '$stud_status';
                                ";
            if ($con->query($sql)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    //Action Section End   
}
?>