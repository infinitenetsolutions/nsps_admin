<?php

if (isset($_POST['add_emp'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $doc = date('Y-m-d');

    $sql = "SELECT * FROM `tbl_employee` WHERE `phone` = '$phone' && `email` = '$email'";
    $result = $con->query($sql);
    if ($result->num_rows > 0)
    echo '
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fas fa-exclamation-triangle"></i> This Employee is already exsits!!!
    </div>';
    else {
        $insert = "INSERT INTO `tbl_employee`( `name`, `address`, `phone`, `email`, `branch_id`, `user_id`, `password`, `doc`) VALUES
                                         ('$name','$address','$phone','$email','','','','$doc')";
    $result = mysqli_query($con, $insert);
    if ($result) {
        $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data successfully added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <script>
          setTimeout(function() {  window.location.replace("employee_view") },1000);
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

?>

<div id="add_employeees" class="w3-modal" style="z-index:2020;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
        <header class="w3-container" style="background:#343a40; color:white;">
            <span onclick="document.getElementById('add_employeees').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2 align="center">Add Employee</h2>
        </header>
        <form id="add_branch_form" role="form" method="POST">
            <div class="card-body">
                <div class="col-md-12" id="error_section"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>employee Name</label>
                            <input required type="text" placeholder="Enter employee name"  name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>employee Phone No</label>
                            <input required type="text" placeholder="Enter employee phone no "  name="phone" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>employee Email</label>
                            <input required type="text" placeholder="Enter email address"  name="email" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label>employee Address</label>
                            <textarea type="text" placeholder="Enter employee address" name="address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12" id="loader_section"></div>
                        <button type="submit" id="edit_employee_button" name="add_emp" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
