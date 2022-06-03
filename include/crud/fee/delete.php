<?php 

include '../../config.php';
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];

 $url=$_SERVER['HTTP_REFERER'];
    $insert = "DELETE FROM `tbl_fee` WHERE  `id`=$id";
    $result = mysqli_query($con, $insert);
    if ($result) {
        $_SESSION['massage']= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Data successfully deleted.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <script>
      setTimeout(function() {  window.location.replace("'.$url.'") },1000);
      </script>
      ';
      echo '   <script>
      window.location.replace("'.$url.'") ;
      </script>';


    }
    else{
        $_SESSION['massage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning! </strong> '.$con->error.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}
