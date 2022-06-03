<?php

include '../../config.php';
session_start();
if (isset($_POST['edit_section'])) {
  $id = $_POST['id'];
  $section_name = $_POST['section_name'];
  $course_id = $_POST['course_id'];
  $doc = date('Y-m-d h:m:s');
  $visible = md5('visible');
  $url = $_SERVER['HTTP_REFERER'];


   $insert = "UPDATE `tbl_section` SET `course_id`='$course_id',`section_name`='$section_name',`section_time`='$doc',`status`='$visible' WHERE `section_id`='$id'";
  $result = mysqli_query($con, $insert);
  if ($result) {
    $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Data successfully updated.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <script>
      setTimeout(function() {  window.location.replace("' . $url . '") },1000);
      </script>
      ';
    echo '   <script>
      window.location.replace("' . $url . '") ;
      </script>';
  } else {
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
}
