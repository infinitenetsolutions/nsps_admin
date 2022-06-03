<?php
$page_no = "3";
$page_no_inside = "3_3";
include "include/authentication.php";
$msg = '';
include './include/crud/section/insert.php';

$sql_course1 = "SELECT * FROM `tbl_class` WHERE `status` = '$visible'  ";
$result_course1 = $con->query($sql_course1);


if (isset($_SESSION['massage'])) {
    echo $_SESSION['massage'];
    unset($_SESSION['massage']);
}


?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
                            <h1>section List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">sectiones</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-sm-right">
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('add_sectiones').style.display='block'">Add section</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="data_table">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Section Name</th>
                                            <th>Section class</th>
                                            <th class="project-actions text-center">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $s_no = 1;
                                        $sql = "SELECT * FROM `tbl_section`";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <!-- section delete Section Start -->
                                                <div class="modal fade" id="delete_section<?php echo $row['section_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                                <button data-dismiss="modal" aria-label="Close" class="  w3-button w3-display-topright">&times;</button>
                                                                <h2 align="center">Delete section</h2>
                                                            </header>
                                                            <div class="modal-body">
                                                                <h2 align="center">Are you sure???</h2>

                                                                <form action="./include/crud/section/delete.php" method="POST">
                                                                    <div class="card-body">

                                                                        <div class="col-md-12" id="error_section11"></div>
                                                                        <div class="row">
                                                                            <input type="hidden" name="id" value="<?= $row['section_id']; ?>">
                                                                            <div class="text-center col-md-12">
                                                                                <button data-dismiss="modal" aria-label="Close" class=" btn btn-secondary "> Cancel</button>

                                                                                <a href="./include/crud/section/delete?id=<?php echo $row['section_id']; ?>" class="btn btn-danger">Move To Trash</a>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- section delete Section End -->
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal<?php echo $row['section_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                                <button data-dismiss="modal" aria-label="Close" class="  w3-button w3-display-topright">&times;</button>
                                                                <h2 align="center">Edit Section</h2>
                                                            </header>
                                                            <div class="modal-body">
                                                                <form action="./include/crud/section/update.php" role="form" method="POST">
                                                                    <div class="card-body">
                                                                        <div class="col-md-12" id="error_section1"></div>
                                                                        <div class="row">
                                                                            <input type="hidden" name="id" value="<?= $row['section_id']; ?>">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Section Name</label>
                                                                                    <input required type="text" placeholder="Enter Section name" value="<?php echo $row["section_name"] ?>" name="section_name" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <?php

                                                                            $sql_course = "SELECT * FROM `tbl_class`
                                                                                              WHERE `status` = '$visible' && `course_id` = '" . $row["course_id"] . "' ";
                                                                            $result_course = $con->query($sql_course);
                                                                            $row_course = $result_course->fetch_assoc();
                                                                            ?>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Section class</label>
                                                                                    <select required type="text" placeholder="Enter Section Class " value="<?php echo $row_course["course_name"] ?>" name="course_id" class="form-control">
                                                                                        <option value="<?php echo $row_course['course_id'] ?>"> <?php echo $row_course['course_name'] ?> </option>

                                                                                        <?php while ($row_course1 = $result_course1->fetch_assoc()) { ?>
                                                                                            <option  value="<?php echo $row_course1['course_id'] ?>"> <?php echo $row_course1['course_name'] ?> </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="col-md-12" id="loader_section"></div>
                                                                                <button type="submit" id="edit_section_button" name="edit_section" class="btn btn-primary">Submit</button>
                                                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- edit section end -->

                                                <tr>
                                                    <td><?php echo $s_no; ?></td>
                                                    <td><?php echo $row["section_name"] ?></td>
                                                    <?php

                                                    $sql_course = "SELECT * FROM `tbl_class`
                                                       WHERE `status` = '$visible' && `course_id` = '" . $row["course_id"] . "';
                                                      ";
                                                    $result_course = $con->query($sql_course);
                                                    $row_course = $result_course->fetch_assoc();
                                                    ?>
                                                    <td><?php echo $row_course["course_name"]; ?></td>
                                                    <td class="project-actions text-center">
                                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal<?= $row['section_id'] ?>">
                                                            <i class="fas  fa-edit"></i>Edit
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_section<?= $row['section_id'] ?>">
                                                            <i class="fas fa-trash"></i>Delete
                                                        </button>
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
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <?php include 'include/footer.php'; ?>
    </div>



    <!-- edit section -->


    <!-- Add sectiones With Excel Modal End -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->

    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>

</body>

</html>