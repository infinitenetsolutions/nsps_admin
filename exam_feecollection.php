<?php 
    $page_no = "7";
    $page_no_inside = "7_6";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NETAJI SUBHAS PUBLIC SCHOOL | Exam Fee Collection </title>
  <!-- Fav Icon -->
  <link rel="icon" href="images/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
            <h1>Exam Fee Collection</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin</li>
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
              <h3 class="card-title">Exam Fee Collection</h3>
            </div>
			 
			   <!-- /.card-header -->
		<form role="form" action="" method="POST" id=""> 
            <div class="card-body">
                <div class="row">
			  
			  <div class="col-4">
			  <label>Fee Charged From</label>
				<input type="date" name="" class="form-control">
			  </div>
              <div class="col-4">
			  <label>To</label>
				<input type="date" name="" class="form-control">
			  </div>
			   
			   <div class="col-4">
			  </div>
			  
			  <div class="col-4">
			  <label>Registration No</label>
				<input type="text" name="" class="form-control">
			  </div>
			  
			  <div class="col-4">
			  <label>Exam Name</label>
				<input type="text" name="" class="form-control">
			  </div>
			  
			  <div class="col-4">
			  </div>
			  
				<div class="col-4" style="margin-top: 20px;">
				<input type="submit" name="submit" class="btn btn-primary" value="Search">
                </div>
			  
              </div>
			  
            </div>			
           
			
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>Student</th>
                  <th>Exam Info</th>
                  <th>Fee Charged</th>
                  <th>Fee Paid </th>
				  <th>Paid On </th>
				  <th>Fee Waived </th>
				  <th class="project-actions text-center">Action </th>
                </tr>
                </thead>
                <tbody>
                 <!-- populate table from mysql database -->
                <tr>
                    <td></td>
                    <td></td>
					<td></td>
					<td></td>
					<td></td> 
                    <td></td>
					<td></td> 					
				    <td class="project-actions text-center">
                          <a class="btn btn-info btn-sm" href="#">
                              <i class="fas  fa-edit">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>					   
                </tr>
                </tfoot>
              </table>
            </div>
		</form>
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

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
  $(function () {
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
