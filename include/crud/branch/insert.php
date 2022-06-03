<?php


if (isset($_POST['add_branch'])) {

    $name = $_POST['add_branch_name'];
    $phone = $_POST['add_branch_phone'];
    $address = $_POST['add_branch_address'];
    $doc = date('Y-m-d');

    $insert = "INSERT INTO `tbl_branch`( `branch_name`, `branch_address`, `branch_phone`, `doc`) VALUES
     ('$name','$phone','$address','$doc')";
    $result = mysqli_query($con, $insert);
    if ($result) {
        $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data successfully added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <script>
          setTimeout(function() {  window.location.replace("branch_view") },1000);
          </script>
          
          ';
    }else{
        $_SESSION['massage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning! </strong> '.$con->error.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
     
      
      ';
    }
}

?>

<div id="add_branches" class="w3-modal" style="z-index:2020;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
        <header class="w3-container" style="background:#343a40; color:white;">
            <span onclick="document.getElementById('add_branches').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2 align="center">Add Branch</h2>
        </header>
        <form id="add_branch_form" role="form" method="POST">
            <div class="card-body">
                <div class="col-md-12" id="error_section"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input required type="text" placeholder="Enter Branch name" name="add_branch_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Phone No</label>
                            <input required type="text" placeholder="Enter branch phone no " name="add_branch_phone" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group">
                            <label>Branch Address</label>
                            <textarea type="text" placeholder="Enter branch address" name="add_branch_address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type='hidden' name='action' value='add_branches' />
                        <div class="col-md-12" id="loader_section"></div>
                        <button type="submit" id="add_branch_button" name="add_branch" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>