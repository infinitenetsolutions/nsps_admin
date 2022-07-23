<?php

include '../../config.php';
session_start();
if (isset($_POST['edit_fees'])) {
    $id = $_POST['id'];
    $class = $_POST['class'];
    $section = $_POST['section'];
    $branch = $_POST['branch'];
    $particular = $_POST['particular'];
    $fee = $_POST['fee'];    
    $last_date = $_POST['last_date'];    
    $academic_year = $_POST['academic_year1'];    
    $fine = $_POST['fine'];    
    $tennure = $_POST['tennure'];    
    $url = $_SERVER['HTTP_REFERER'];
    
    $insert = "UPDATE `tbl_fee` SET `class`='$class',`section`='$section',`branch`='$branch',`particular`='$particular',
    `fee`='$fee',`last_date`='$last_date',`fee_academic_year`='$academic_year',`fine_amount`='$fine',`tennure`='$tennure' WHERE  `id`=$id";
   
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
