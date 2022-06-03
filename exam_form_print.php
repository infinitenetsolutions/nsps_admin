<?php 
	if(isset($_POST["course_id"]) && isset($_POST["academic_year"])){
	$page_no = "11";
	$page_no_inside = "11_6";
	include "include/authentication.php";
    $course_id = $_POST["course_id"];
	$academic_year = $_POST["academic_year"];
        
    /* if($_GET["action"] == "fetchExaminationForm"){
        $id = $_GET["id"];*/
        $sql = "SELECT * FROM `tbl_examination_form` WHERE `status` = '$visible' && `academic_year` = '$academic_year' && `course_id` = '$course_id'
        ";
        $result = $con->query($sql);
        //$row = $result->fetch_assoc();
?>
<html>

<head>
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
	<!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }

    </style>
    <style>
        body {
            margin: 0;
            padding: 0;
            font: 12pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 1cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            /*background-image:  url(images/marksheet/nsu_print_bg.png);*/
            background-size: cover;
            background-position: fixed;
            background-repeat: no-repeat;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0cm;
            height: 256mm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                page-break-after: always;
            }
        }

        .footer {
            position: fixed;
            left: 57px;
            bottom: 0;
            width: 88%;
            color: black;
            text-align: center;
        }

        .courseText h5 {
            font-size: 15px;
            text-align: center;
            margin-top: -24px;
        }

        table {
            border-collapse: collapse;
        }

        table {
            width: 706px;
            margin-left: -28px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            text-align: center;

        }

        .courseText h5 {
            font-size: 18px;
            text-align: center;
            margin-top: -24px;
        }

        .tableText {
            margin: 5px 0;
            margin-left: -28px;
        }

        .qr-code {
            position: relative;
        }

        .qr-code img {
            position: absolute;
            top: 0px;
            left: 50px;
        }

    </style>
</head>

<body>
    <div class="book">
        <?php
        while($row = $result->fetch_assoc()){
            ?>
        <div class="page">
            <div class="subpage">
                <center>
                    <h2 style="color: #c70013;font-weight: bolder;"><img src="images/nsu.png" style="width: 87px;
    margin-left: -35px;"><b style="font-size: 25px;">NETAJI SUBHAS PUBLIC SCHOOL</b></h2>
                    <h2 style="color: #055ac3fc;font-weight: bolder;margin-top: -34px;font-size: 20px;">EXAMINATION FORM</h2>
                    <h6 style="margin-top: -12px;">For University Campus Programme. </h6>
                </center>
                <form id="view_exam_list_form" role="form" method="POST" class="form-horizontal">
                    <div class="card-body" style="margin-bottom: 50px;">
                        <div class="col-md-12" id="edit_error_section"></div>
                        <div class="row">
                            <div class="col-md-4" style="width: 30% !important;">
                                <div class="form-group">
                                    To, <br>
                                        The Controller of Examinations,<br>
                                        NETAJI SUBHAS PUBLIC SCHOOL,<br>
                                        Pokhari, Jamshedpur-(JH).<br>
                                        Sir,
                                    
                                </div>
                            </div>
                            <div class="col-md-5" style="width: 40% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp; <b>Reg No:</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][0])) echo strtoupper($row["registration_no"])[0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][1])) echo strtoupper($row["registration_no"])[1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][2])) echo strtoupper($row["registration_no"])[2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][3])) echo strtoupper($row["registration_no"])[3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][4])) echo strtoupper($row["registration_no"])[4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][5])) echo strtoupper($row["registration_no"])[5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][6])) echo strtoupper($row["registration_no"])[6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][7])) echo strtoupper($row["registration_no"])[7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][8])) echo strtoupper($row["registration_no"])[8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][9])) echo strtoupper($row["registration_no"])[9]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["registration_no"][10])) echo strtoupper($row["registration_no"])[10]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="width: 30% !important;">
                                <div class="form-group">
                                    <img src="images/student_images/<?php echo $row["passport_photo"]; ?>" alt="" style="height:134px;width:126px" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-4" style="width: 30% !important;">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-5" style="margin-top: -64px;width: 40% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp; <b>Roll No:</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][0])) echo strtoupper($row["roll_no"])[0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][1])) echo strtoupper($row["roll_no"])[1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][2])) echo strtoupper($row["roll_no"])[2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][3])) echo strtoupper($row["roll_no"])[3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][4])) echo strtoupper($row["roll_no"])[4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][5])) echo strtoupper($row["roll_no"])[5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][6])) echo strtoupper($row["roll_no"])[6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][7])) echo strtoupper($row["roll_no"])[7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][8])) echo strtoupper($row["roll_no"])[8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][9])) echo strtoupper($row["roll_no"])[9]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["roll_no"][10])) echo strtoupper($row["roll_no"])[10]; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3" style="width: 30% !important;">
                                <div class="form-group">
                                </div>
                            </div>
                        </div>
                        
                        <p style="letter-spacing: 2px;font-size: 12px;">I <b style="-webkit-text-decoration-line: underline; /* Safari */text-decoration-line: underline;"> <?php echo strtoupper($row["candidate_name"]); ?>,</b> Son/Daughter/Wife of <b style="-webkit-text-decoration-line: underline; /* Safari */text-decoration-line: underline;"><?php echo strtoupper($row["father_name"]); ?></b>, request permission to appear </p>
                        <div class="row">
                            <div class="col-md-4" style="width:33.33% !important;">
                                <label style="font-size: 11px;">
                                    <center><b>Course</b></center>
                                </label>
                                <?php 
                $sql_course = "SELECT * FROM `tbl_course`
                               WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
                               ";
                $result_course = $con->query($sql_course);
                $row_course = $result_course->fetch_assoc();
                ?>
                                <input type="text" name="" id="" value="<?php echo $row_course["course_name"]; ?>" class="form-control">
                            </div>
                            <div class="col-md-4" style="width:33.33% !important;">
                                <label style="font-size: 11px;"><b>Department/Specialization</b></label>
                                <input type="text" name="" id="" value="<?php echo strtoupper($row["department"]); ?>" class="form-control">
                            </div>
                            <?php 
            $sql_sem = "SELECT * FROM `tbl_semester`
                           WHERE `status` = '$visible' && `semester_id` = '".$row["semester_id"]."';
                           ";
            $result_sem = $con->query($sql_sem);
            $row_sem = $result_sem->fetch_assoc();
            ?>
                            <div class="col-4" style="width:33.33% !important;">
                                <label style="font-size: 11px;"><b>Semester</b></label>
                                <input type="text" name="" id="" value="<?php echo $row_sem["semester"]; ?>" class="form-control">
                            </div>
                            <p style="letter-spacing: 2px;font-size: 12px;">&nbsp;&nbsp;at the ensuing examination. I furnish my details as stated below: </p>
                        </div>
                         <h2 style="font-size:14px;"><b><u>PERSONAL DETAILS: </u></b></h2>

                        <div class="row">
                            <div class="col-md-12" style="width:100% !important;">
                                <label style="font-size: 11px;"><b>1. NAME OF THE STUDENT IN CAPITAL LETTERS: <br> (Leave one box vacant between First Name, Middle Name and Surname)</b></label>
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][0])) echo strtoupper($row["candidate_name"])[0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][1])) echo strtoupper($row["candidate_name"])[1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][2])) echo strtoupper($row["candidate_name"])[2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][3])) echo strtoupper($row["candidate_name"])[3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][4])) echo strtoupper($row["candidate_name"])[4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][5])) echo strtoupper($row["candidate_name"])[5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][6])) echo strtoupper($row["candidate_name"])[6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][7])) echo strtoupper($row["candidate_name"])[7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][8])) echo strtoupper($row["candidate_name"])[8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][9])) echo strtoupper($row["candidate_name"])[9]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][10])) echo strtoupper($row["candidate_name"])[10]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][11])) echo strtoupper($row["candidate_name"])[11]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][12])) echo strtoupper($row["candidate_name"])[12]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][13])) echo strtoupper($row["candidate_name"])[13]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][14])) echo strtoupper($row["candidate_name"])[14]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][15])) echo strtoupper($row["candidate_name"])[15]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][16])) echo strtoupper($row["candidate_name"])[16]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][17])) echo strtoupper($row["candidate_name"])[17]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][18])) echo strtoupper($row["candidate_name"])[18]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][19])) echo strtoupper($row["candidate_name"])[19]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["candidate_name"][20])) echo strtoupper($row["candidate_name"])[20]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="width:50% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;"><b>2. GENDER:</b>&nbsp; </label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][0])) echo strtoupper($row["gender"])[0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][1])) echo strtoupper($row["gender"])[1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][2])) echo strtoupper($row["gender"])[2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][3])) echo strtoupper($row["gender"])[3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][4])) echo strtoupper($row["gender"])[4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["gender"][5])) echo strtoupper($row["gender"])[5]; ?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="width:30% !important;">
                                <div class="form-group">

                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>3. Date Of Birth:</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" class="form-control" value="<?php echo $row["dob"]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="width:100% !important;">
                                <label style="font-size: 11px;"><b>4. CORRESPONDENCE ADDRESS (for all communication by the University): </b></label>
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][0])) echo strtoupper($row["address"])[0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][1])) echo strtoupper($row["address"])[1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][2])) echo strtoupper($row["address"])[2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][3])) echo strtoupper($row["address"])[3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][4])) echo strtoupper($row["address"])[4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][5])) echo strtoupper($row["address"])[5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][6])) echo strtoupper($row["address"])[6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][7])) echo strtoupper($row["address"])[7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][8])) echo strtoupper($row["address"])[8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][9])) echo strtoupper($row["address"])[9]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][10])) echo strtoupper($row["address"])[10]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][11])) echo strtoupper($row["address"])[11]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][12])) echo strtoupper($row["address"])[12]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][13])) echo strtoupper($row["address"])[13]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][14])) echo strtoupper($row["address"])[14]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][15])) echo strtoupper($row["address"])[15]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][16])) echo strtoupper($row["address"])[16]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][17])) echo strtoupper($row["address"])[17]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][18])) echo strtoupper($row["address"])[18]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][19])) echo strtoupper($row["address"])[19]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][20])) echo strtoupper($row["address"])[20]; ?>">
                                    </div>
                                    <div class="input-group mb-1">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][22])) echo strtoupper($row["address"])[22]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][23])) echo strtoupper($row["address"])[23]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][24])) echo strtoupper($row["address"])[24]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][25])) echo strtoupper($row["address"])[25]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][26])) echo strtoupper($row["address"])[26]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][27])) echo strtoupper($row["address"])[27]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][28])) echo strtoupper($row["address"])[28]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][29])) echo strtoupper($row["address"])[29]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][30])) echo strtoupper($row["address"])[30]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][31])) echo strtoupper($row["address"])[31]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][32])) echo strtoupper($row["address"])[32]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][33])) echo strtoupper($row["address"])[33]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][34])) echo strtoupper($row["address"])[34]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][35])) echo strtoupper($row["address"])[35]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][36])) echo strtoupper($row["address"])[36]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][37])) echo strtoupper($row["address"])[37]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][38])) echo strtoupper($row["address"])[38]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][39])) echo strtoupper($row["address"])[39]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][40])) echo strtoupper($row["address"])[40]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][41])) echo strtoupper($row["address"])[41]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][42])) echo strtoupper($row["address"])[42]; ?>">
                                    </div>
                                    <div class="input-group mb-1">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][43])) echo strtoupper($row["address"])[43]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][44])) echo strtoupper($row["address"])[44]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][45])) echo strtoupper($row["address"])[45]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][46])) echo strtoupper($row["address"])[46]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][47])) echo strtoupper($row["address"])[47]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][48])) echo strtoupper($row["address"])[48]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][49])) echo strtoupper($row["address"])[49]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][50])) echo strtoupper($row["address"])[50]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][51])) echo strtoupper($row["address"])[51]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][52])) echo strtoupper($row["address"])[52]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][53])) echo strtoupper($row["address"])[53]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][54])) echo strtoupper($row["address"])[54]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][55])) echo strtoupper($row["address"])[55]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][56])) echo strtoupper($row["address"])[56]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][57])) echo strtoupper($row["address"])[57]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][58])) echo strtoupper($row["address"])[58]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][59])) echo strtoupper($row["address"])[59]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][60])) echo strtoupper($row["address"])[60]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][61])) echo strtoupper($row["address"])[61]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][62])) echo strtoupper($row["address"])[62]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["address"][63])) echo strtoupper($row["address"])[63]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="width:100% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>5. LAST EXAMINATION PASSED & YEAR:</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" value="<?php echo strtoupper($row["last_exam_year"])?>" type="text" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="width:50% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>6. Email Address:</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" value="<?php echo $row["email_id"]; ?>" type="text" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="width:50% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>Mobile No:(01)</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][0])) echo $row["mobile_no1"][0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][1])) echo $row["mobile_no1"][1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][2])) echo $row["mobile_no1"][2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][3])) echo $row["mobile_no1"][3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][4])) echo $row["mobile_no1"][4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][5])) echo $row["mobile_no1"][5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][6])) echo $row["mobile_no1"][6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][7])) echo $row["mobile_no1"][7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][8])) echo $row["mobile_no1"][8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no1"][9])) echo $row["mobile_no1"][9]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="width:50% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>AADHAR NO: </b>&nbsp;&nbsp;</label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][0])) echo $row["adhar_no"][0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][1])) echo $row["adhar_no"][1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][2])) echo $row["adhar_no"][2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][3])) echo $row["adhar_no"][3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][4])) echo $row["adhar_no"][4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][5])) echo $row["adhar_no"][5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][6])) echo $row["adhar_no"][6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][7])) echo $row["adhar_no"][7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][8])) echo $row["adhar_no"][8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["adhar_no"][9])) echo $row["mobile_no2"][9]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="width:50% !important;">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>Mobile No:(02)</b>&nbsp;&nbsp;</label>
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][0])) echo $row["mobile_no2"][0]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][1])) echo $row["mobile_no2"][1]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][2])) echo $row["mobile_no2"][2]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][3])) echo $row["mobile_no2"][3]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][4])) echo $row["mobile_no2"][4]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][5])) echo $row["mobile_no2"][5]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][6])) echo $row["mobile_no2"][6]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][7])) echo $row["mobile_no2"][7]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][8])) echo $row["mobile_no2"][8]; ?>">
                                        <input id="" name="" type="text" class="form-control p-0 text-center otp-text remove-spin" value="<?php if(isset($row["mobile_no2"][9])) echo $row["mobile_no2"][9]; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group mb-1">
                                        <label style="font-size: 11px;">&nbsp;&nbsp;<b>7. SUBJECT DETAILS:-</b> &nbsp;&nbsp;</label>
                                    </div>
                                    <table border="1" style="width: 100%;font-size: 14px;margin-left: 0px;" >
                                        <thead>
                                            <tr>
                                                <th scope="col">S.NO</th>
                                                <th scope="col">PAPER CODE</th>
                                                <th scope="col">PAPER NAME</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                             $s_no=1;
						//$subject_id = $_POST["subject_id"];                        
                        $sql_subject = "SELECT * FROM `tbl_subjects` WHERE course_id = '".$row["course_id"]."' && semester_id = '".$row["semester_id"]."' ORDER BY `subject_id` ASC ";
                        $result_subject = $con->query($sql_subject);
                        while($row_subject = $result_subject->fetch_assoc()){                     
                        ?>
                                            <tr>
                                                <td width=10%><?php echo $s_no; ?></td>
                                                <td width=30%><?php echo $row_subject["subject_code"] ?></td>
                                                <td width=60%><?php echo $row_subject["subject_name"] ?></td>
                                            </tr>
                                            <?php 
                            $s_no++;
                        } 
                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--<header class="w3-container" style="background: #54a91f; color:white;width: 775px;border-top: 7px solid #e0811f;">
                        <span onclick="document.getElementById('view_exam_lists').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                        <h2 align="center" style="font-size:18px;">BEFORE SUBMITTING THE EXAMINATION FORM PLEASE ENSURE THAT:</h2>
                    </header>
                    <ul>
                        <li>Registration is valid for only enrolled Course</li>
                        <li>The enrolment number, subject code, papers’ name are correctly filled in the examination form. </li>
                        <li>Examination fees once paid, not refundable / adjusted in any case. </li>
                    </ul>
                    <p>N.B: In case of non-compliance of any of the above conditions, candidature for appearing in the Examination will not be considered and no Admit Card will be issued. </p>
                    <header class="w3-container" style="background: #54a91f; color:white;width: 775px;border-top: 7px solid #e0811f;">
                        <span onclick="document.getElementById('view_exam_lists').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                        <h2 align="center" style="font-size:18px;">INSTRUCTIONS FOR FILLING UP THE EXAMINATION FORM: </h2>
                    </header>
                    <ol>
                        <li>Write correct subject code(s) as indicated in your Programme Guide / Syllabus. </li>
                        <li>In case, wrong / invalid course or subject code is mentioned in examination form, the Admit Card will not be issued.</li>
                        <li>Submit examination form within the due date. </li>
                        <li>It is advised to enclose photocopy of Admit Card / Mark sheet / Registration slip of the last examination passed. </li>
                    </ol>-->
                        <!--<span onclick="document.getElementById('view_exam_lists').style.display='none'" class="w3-button w3-display-topright">&times;</span>-->
                        <h2 align="center" style="font-size:14px;"><b><u>DECLARATION BY THE STUDENT: </u></b></h2>
                    
                    <p style="font-size: 11px;text-align: justify;">
                        I hereby declare that I have read and understood the instructions given above. I also affirm that I have submitted all the required numbers of assignment as applicable for the aforesaid course filled in the examination form and my registration for the course is valid and not time barred. If any of my statements is found to be untrue, I will have no claim for appearing in the examination. I undertake that I shall abide by the rules and regulations of the University.
                    </p>
                     
                        </div>
                        <!--<hr style="border-top: 1px solid black;">
                <p>
                    <center><u>For Office Use</u></center>
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <input id="" name="" type="text" class="form-control otp-text remove-spin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <input id="" name="" type="text" class="form-control otp-text remove-spin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <label>&nbsp;&nbsp;Verified By &nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <label>&nbsp;&nbsp;(Seal and signature of HOD)&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </div>
                </div>-->
                    </div>
                </form>
            </div>
           
                <div class="sub_div">
                    <p style="margin-top:27%; margin-left: -6%;width: 706px;">
                        <span style="margin-left: 75px;"><?php echo $row["create_time"]?></span>
                        <span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <img src="student/images/student_images/<?php echo $row["candidate_signature"] ?>" alt="" style="margin-top: 0px;width: 10%;height:3%;" /></span>
                        <span style="margin-left: 132px;"><b>Date</b></span>
                        <span style="margin-left: 34px;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                        <b>Signature Of the Student</b></span>
                    </p>
                </div>
            </div>
        <?php } ?>
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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

   <script>
        window.print();

    </script>

</body>
</html>
<?php 
    }
?>