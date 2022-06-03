<?php

include '../../config.php';
session_start();
if (isset($_POST['edit_employee'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $doc = date('Y-m-d');
    $url = $_SERVER['HTTP_REFERER'];
    $insert = "UPDATE `tbl_employee` SET `name`='$name',`address`='$address',`phone`='$phone',`email`='$email',`doc`='$doc' WHERE  `id`=$id";
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
