<?php
$page_no = "5";
$page_no_inside = "5_1";
$msg = '';
$visible = md5("visible");
include "include/authentication.php";
include "./framwork/main.php";
if (isset($_SESSION['massage'])) {
    echo $_SESSION['massage'];
    unset($_SESSION['massage']);
}
$student_id = $_GET['id'];
if (isset($_POST['course_id']) && $_POST['course_id'] != '' && isset($_POST['student_name']) && $_POST['student_name'] != '') {

    // extracking the image of the file
    if (isset($_FILES['tc']['tmp_name']) && $_FILES['tc']['tmp_name'] != '') {
        $tc_img = addslashes(file_get_contents($_FILES['tc']['tmp_name']));
        $_POST['tc'] = $tc_img;
    }

    if (isset($_FILES['tc']['tmp_name']) && $_FILES['photo']['tmp_name'] != '') {
        $photo_img = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
        $_POST['photo'] = $photo_img;
    }

    $presult =  updateAll('tbl_student', $_POST, "`student_id`='" . $student_id . "'");
    if ($presult == "success") {
        $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success</strong> Your Data Successfully update into the Database
            </div>';
        echo "<script>
        setTimeout(function() {
         window.location.replace(window.location.href);
         }, 1000);
        </script>";
    } else {
        $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong>Alert!</strong>  ' . $presult . '
</div>';
    }
}
$student_data = fetchRow('tbl_student', $student_id);
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
    <style>
        .form-control {
            font-weight: 900 !important;
            color: #060631 !important;
        }

        label {
            margin-top: 13px;
        }
    </style>
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
                            <div class="row">
                                <div class="col-2">
                                    <h3 class="card-title">Admission Form</h3>

                                </div>
                                <div class="col-9">
                                    <?= $msg ?>
                                </div>
                            </div>
                        </div>

                        <form role="form" method="POST" id="add_admission_form" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12" id="error_section"></div>

                                    <div class="col-4">
                                        <label>Branch</label>
                                        <select id="branch" name="branch_id" class="form-control" required>
                                            <?php $branch = fetchRow('tbl_branch', "`id`='" . $student_data['branch_id'] . "'");
                                            if ($branch != '') {
                                            ?>
                                                <option value="<?= $branch['id'] ?>"><?= $branch['branch_name'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php ?>">Select Branch</option>

                                            <?php } ?>
                                            <?php
                                            $sql_branch = "select * from tbl_branch";
                                            $query_branch = mysqli_query($con, $sql_branch);
                                            while ($row_branch = mysqli_fetch_array($query_branch)) {
                                            ?>
                                                <option value="<?php echo $row_branch['id']; ?>"><?php echo $row_branch['branch_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label>Session</label>
                                        <select id="session_check" class="form-control" name="university_details_id">

                                            <?php $branch = fetchRow('tbl_university_details', "`university_details_id`='" . $student_data['university_details_id'] . "'");
                                            if ($branch != '') {
                                            ?>
                                                <option value="<?= $branch['university_details_id'] ?>"><?= explode('-', $branch['university_details_academic_start_date'])[0] . " - " . explode('-', $branch['university_details_academic_end_date'])[0] ?></option>
                                            <?php } else { ?>
                                                <option selected disabled>Select Academic Year</option>

                                            <?php } ?>

                                            <?php
                                            $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                       WHERE `status` = '$visible';
                                       ";
                                            $result_ac_year = $con->query($sql_ac_year);
                                            while ($row_ac_year = $result_ac_year->fetch_assoc()) {


                                            ?>
                                                <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo date("Y", strtotime($row_ac_year["university_details_academic_start_date"])) . " -  " . date("Y", strtotime($row_ac_year["university_details_academic_end_date"])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label>Class</label>
                                        <select class="form-control" id="course" name="course_id" onchange="showdesg(this.value)" required>

                                            <?php $branch = fetchRow('tbl_class', "`course_id`='" . $student_data['course_id'] . "'");
                                            if ($branch != '') {
                                            ?>
                                                <option value="<?= $branch['course_id'] ?>"><?= $branch['course_name'] ?></option>
                                            <?php } else { ?>
                                                <option selected disabled> Select Class </option>
                                            <?php } ?>

                                            <?php
                                            $sql = "select * from tbl_class WHERE `status` = '$visible'";
                                            $query = mysqli_query($con, $sql);
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mrt">
                                        <div class="form-group">
                                            <label>Select Section</label>
                                            <select class="form-control" name="section_id" id="sem" required>
                                                <?php $branch = fetchRow('tbl_section', "`section_id`='" . $student_data['section_id'] . "'");
                                                if ($branch != '') {
                                                ?>
                                                    <option value="<?= $branch['course_id'] ?>"><?= $branch['section_name'] ?></option>
                                                <?php } else { ?>
                                                    <option selected disabled> Select Class </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <label>Roll No</label>
                                        <input type="text" name="roll_no" value="<?= $student_data['roll_no'] ?>" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label>Student Name</label>
                                        <input id="first_name" type="text" value="<?= $student_data['student_name'] ?>" name="student_name" class="form-control" required>
                                    </div>

                                    <div class="col-4">
                                        <label>Date Of Birth</label>
                                        <input id="dob" value="<?= $student_data['dob'] ?>" type="date" name="dob" class="form-control" required>
                                    </div>

                                    <div class="col-4">
                                        <label>Nationality</label>
                                        <input type="text" value="<?= $student_data['nationality'] ?>" name="nationality" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label>Aadhar No</label>
                                        <input type="text" value="<?= $student_data['aadhar_no'] ?>" name="aadhar_no" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label>Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <?php if ($student_data['gender'] != '') { ?>

                                                <option value="<?= $student_data['gender'] ?>"><?= $student_data['gender'] ?></option>
                                            <?php } else { ?>
                                                <option selected disabled>Select</option>
                                            <?php } ?>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <label>Full Address <i class="fa fa-map" aria-hidden="true"></i> </label>
                                        <textarea type="date" placeholder="Full address of student" name="address" class="form-control"><?= $student_data['address'] ?></textarea>
                                    </div>
                                    <div class="col-4">
                                        <label>Date Of Admission </label>
                                        <input value="<?= $student_data['date_of_admission'] ?>" type="date" name="date_of_admission" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Profile photo <i class="fa fa-user" aria-hidden="true"></i> </label>
                                                <input type="file" name="tc" class="form-control">
                                            </div>
                                            <div class="col-7">
                                                <?= '<img class="img-fluid" src="data:image/jpeg;base64,' . base64_encode($student_data['tc']) . '"/>'  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Transfer Certificate <i class="fa fa-file" aria-hidden="true"></i></i></label>
                                                <input type="file" name="photo" class="form-control">
                                            </div>
                                            <div class="col-7">
                                                <?= '<img class="img-fluid" src="data:image/jpeg;base64,' . base64_encode($student_data['photo']) . '"/>'  ?>
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
                                                <input id="father_name" type="text" value="<?= $student_data['father_name'] ?>" name="father_name" class="form-control">
                                            </div>
                                            <div class="col-4">
                                                <label>Father Whatsapp No</label>
                                                <input type="text" name="father_whatsappno" value="<?= $student_data['father_whatsappno'] ?>" class="form-control">
                                            </div>
                                            <div class="col-4">
                                                <label>Mother Name</label>
                                                <input id="mother_name" type="text" name="mother_name" value="<?= $student_data['mother_name'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="loader_section"></div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" id="add_admission_button" class="btn btn-primary">Submit</button>
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
        function showdesg(dept) {
            $.ajax({
                url: 'ajaxdata_sec.php',
                type: 'POST',
                data: {
                    depart: dept
                },
                success: function(data) {
                    $("#sem").html(data);
                },
            });
        }
    </script>

</body>

</html>