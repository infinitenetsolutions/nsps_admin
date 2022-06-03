<?php


if (isset($_POST['add_section'])) {

    $section_name = $_POST['section_name'];
    $course_id = $_POST['course_id'];

    $doc = date('Y-m-d h:m:s');
    $visible = md5('visible');
    $sql = "SELECT * FROM `tbl_section` WHERE `status` = '$visible' && `course_id` = '$course_id' && `section_name` = '$section_name'";
    $result = $con->query($sql);
    if ($result->num_rows > 0)
    echo '
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fas fa-exclamation-triangle"></i> This section is already exsits!!!
    </div>';
    else {
    $insert = "INSERT INTO `tbl_section`( `course_id`, `section_name`, `section_time`, `status`) VALUES
                                         ('$course_id','$section_name','$doc','$visible')";
    $result = mysqli_query($con, $insert);
    if ($result) {
        $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data successfully added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <script>
          setTimeout(function() {  window.location.replace("subject_view") },1000);
          </script>
          
          ';
    } else {
        $_SESSION['massage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning! </strong> ' . $con->error . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
     
      
      ';
    }
}
}
$sql_course2 = "SELECT * FROM `tbl_class` WHERE `status` = '$visible'  ";
$result_course2 = $con->query($sql_course2);

?>

<div id="add_sectiones" class="w3-modal" style="z-index:2020;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
        <header class="w3-container" style="background:#343a40; color:white;">
            <span onclick="document.getElementById('add_sectiones').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2 align="center">Add section</h2>
        </header>
        <form id="add_section_form" role="form" method="POST">
            <div class="card-body">
                <div class="col-md-12" id="error_section"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>section Name</label>
                            <input required type="text" placeholder="Enter section name" name="section_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>section Class</label>
                            <select required type="text" placeholder="Enter section Class " name="course_id" class="form-control">
                                <option selected disabled> - Select - </option>

                                <?php while ($row_course2 = $result_course2->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_course2['course_id'] ?> "> <?php echo $row_course2['course_name'] ?> </option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type='hidden' name='action' value='add_sectiones' />
                        <div class="col-md-12" id="loader_section"></div>
                        <button type="submit" id="add_section_button" name="add_section" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>