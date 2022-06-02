<?php 
    $page_no = "13";
    $page_no_inside = "13_1";
    include "include/authentication.php"; 
	//error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Complaint Details </title>
    <!-- Fav Icon -->
    <link rel="icon" href="images/logo.png" />
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
                            <h1>Complaint</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Complaint</li>
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
						        <div class="card-body">
                    
                               
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="data_table">
                                
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
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'include/view.php?action=get_complaint',
                type: 'GET',
                success: function(result) {
                    $("#data_table").html(result);
                }
            });
        });
    </script>
    <script>
        function PaymentModeSelect(PaymentMode){
            var bankName_div = document.getElementById('bankName_div');
            var chequeNo_div = document.getElementById('chequeNo_div');
            var receiptDate_div = document.getElementById('receiptDate_div');
            if(PaymentMode == "Cash"){
                // cash_div.style.display = "block";
                bankName_div.style.display = "none";
                chequeNo_div.style.display = "none";
                receiptDate_div.style.display = "block";
            } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                        bankName_div.style.display = "block";
                        chequeNo_div.style.display = "block";
                        receiptDate_div.style.display = "block";
                    } else{
                        bankName_div.style.display = "none";
                        chequeNo_div.style.display = "none";
                        receiptDate_div.style.display = "none";
                    }
        }
    </script>
</body>

</html>