<?php 
    $page_no = "7";
    $page_no_inside = "7_13";
    include "include/authentication.php"; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Print Receipt </title>
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }

    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include 'include/navbar.php'; ?>
    <?php include 'include/aside.php'; ?>
<?php 
    if(isset($_POST["paidId"])){ 
    $paidId = $_POST["paidId"];
    $sql = "SELECT *
            FROM `tbl_fee_paid`
            INNER JOIN `tbl_admission` ON `tbl_fee_paid`.`student_id` = `tbl_admission`.`admission_id`
            INNER JOIN `tbl_university_details` ON `tbl_fee_paid`.`university_details_id` = `tbl_university_details`.`university_details_id`
            INNER JOIN `tbl_course` ON `tbl_fee_paid`.`course_id` = `tbl_course`.`course_id`
            WHERE `tbl_fee_paid`.`status` = '$visible' && `tbl_fee_paid`.`feepaid_id` = '$paidId'
            ";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    //Define Variables Section Start
    //Numeric Veriables
    $arrayFee = array(); //In Amount or In Number
    $arrayFine = array(); //In Amount or In Number
    $arrayRemaining = array(); //In Amount or In Number
    $arrayRebate = array(); //In Amount or In Number
    $totalFee = 0; //In Amount or In Number
    $totalFine = 0; //In Amount or In Number
    $totalRemaining = 0; //In Amount or In Number
    $totalRemainings = 0; //In Amount or In Number
    $totalRebate = 0; //In Amount or In Number
    $totalPaid = 0; //In Amount or In Number
    //String Variables
    $arrayPerticular = array();
    $arrayTblFee = array();
    $objTblFee = "";
    $rebateOn = "";
    //Checking If Hostel If Available Or Not
    if(strtolower($row["admission_hostel"]) == "yes")
        $sqlTblFee = "SELECT *
                     FROM `tbl_fee`
                     WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' ORDER BY `fee_particulars` ASC
                     ";
    else
        $sqlTblFee = "SELECT *
                     FROM `tbl_fee`
                     WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees') ORDER BY `fee_particulars` ASC
                     ";
    $resultTblFee = $con->query($sqlTblFee);
    if($resultTblFee->num_rows > 0)
        while($rowTblFee = $resultTblFee->fetch_assoc()){
            $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
            if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
            else
                $noOfDays = 0;
            $completeArray = array(
                                "fee_id" => $rowTblFee["fee_id"],
                                "fee_particulars" => $rowTblFee["fee_particulars"],
                                "fee_amount" => $rowTblFee["fee_amount"],
                                "fee_paid" => 0,
                                "fee_fine" => $rowTblFee["fee_fine"],
                                "fee_rebate" => 0,
                                "fee_remaining" => $rowTblFee["fee_amount"],
                                "fee_fine_days" => $noOfDays
                            );
            array_push($arrayTblFee, $completeArray);
        }
    $arrayTblFee = json_decode(json_encode($arrayTblFee));
    $arrayPaidId = explode(",", $row["particular_id"]);
    $arrayPaidAmount = explode(",", $row["paid_amount"]);
    for($i=0; $i<count($arrayPaidId); $i++){
        foreach($arrayTblFee as $arrayTblFeeUpdate){
            if($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]){
                $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                if($row["rebate_amount"] != ""){
                    $arrayRebateAmount = explode(",", $row["rebate_amount"]);
                    if($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])){
                        $rebateOn = $arrayTblFeeUpdate->fee_particulars;
                        $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                        $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                    }
                }
                $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
            }
        }
    }
    if($row["fine"] != "") 
        $fineAmount = $row["fine"]; 
    else 
        $fineAmount = 0;
?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Print Receipt</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Print Receipt</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info mr-2"></i> Please check the Informations and Calculations if they are currect then only print this Receipt.</h5>
                            </div>


                            <!-- Main content -->
                            <div class="invoice p-3 mb-2">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-3">
                                        <h4 class="text-center">
                                            <img src="images/logo.png" width="85%" alt="Image" border="0" title="Images" style="-webkit-filter: drop-shadow(5px 5px 5px #222 ); filter: drop-shadow(5px 5px 5px #222);">
                                        </h4>
                                    </div>
                                    <div class="col-7">
                                        <div class="text-center mt-5" style="font-family: Times New Roman;">
                                            <h1 class="text-bold">NETAJI SUBHAS PUBLIC SCHOOL</h1>
                                            <p>POKHARI, P.O : BHILAI PAHARI, P.S : M.G.M Dist : EAST SINGHBHUM,<br /> JAMSHEDPUR - 831012 Jharkhand. Contact - (+91) 9835203429 <br />Visit : https://nsuniv.ac.in/</p>
                                        </div>
                                    </div>
                                    <div class="col-2 pt-1">
                                        <h4>
                                            <small class="float-right">Date: <?php echo date("d/m/Y"); ?></small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <hr class="mt-0 mb-3" />
                                <!-- info row -->
                                <div class="row invoice-info mb-3 pr-4 pl-4">
                                    <div class="col-sm-12 invoice-col">
                                        <h4 class="text-bold" style="font-family: Times New Roman;">MONEY RECEIPT ~</h4>
                                    </div>
                                    <div class="col-sm-2 invoice-col">
                                        <p style="font-family: Times New Roman;">
                                            <strong>Registration No.</strong><br>
                                            <strong>Admission No.</strong><br>
                                            <strong>Course</strong><br>
                                            <strong>Academic Session</strong><br>
                                            <strong>Father's Name</strong><br>
                                            <strong>Student Name</strong><br>
                                            <strong>Hostel</strong><br>
<!--                                            <strong>Notes</strong><br>-->
                                        </p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <p style="font-family: Times New Roman;">
                                            ~<span class="ml-3"> <?php echo $row["admission_id"]; ?></span><br>
                                            ~<span class="ml-3"> <?php echo $row["admission_no"]; ?></span><br>
                                            ~<span class="ml-3"> <?php echo strtoupper($row["course_name"]); ?></span><br>
                                            ~<span class="ml-3"> <?php echo date("Y", strtotime($row["university_details_academic_start_date"]))." to ".date("Y", strtotime($row["university_details_academic_end_date"])); ?></span><br>
                                            ~<span class="ml-3"> <?php echo strtoupper($row["admission_father_name"]); ?></span><br>
                                            ~<span class="ml-3"> <?php echo strtoupper($row["admission_first_name"]); ?> <?php echo strtoupper($row["admission_middle_name"]); ?> <?php echo strtoupper($row["admission_last_name"]); ?></span><br>
                                            ~<span class="ml-3"> <?php echo strtoupper($row["admission_hostel"]); ?></span><br>
<!--                                            ~<span class="ml-3"> <?php echo strtoupper($row["notes"]); ?></span><br>-->
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 invoice-col">
                                        <p style="font-family: Times New Roman;">
                                            <strong>Receipt No.</strong><br>
                                            <strong>Receipt Date</strong><br>
                                            <strong>Payment Date</strong><br>
                                            <strong>Payment Mode</strong><br>
                                            <strong>Cash Deposit To</strong><br>
                                            <strong>Bank Name</strong><br>
                                            <strong>NEFT/Cheque No</strong><br>
                                        </p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <p style="font-family: Times New Roman;">
                                            ~<span class="ml-3"> <?php echo $row["receipt_no"]; ?></span><br>
                                            ~<span class="ml-3"> <?php echo date("d-m-Y", strtotime($row["transaction_date"])); ?></span><br>
                                            ~<span class="ml-3"> <?php echo date("d-m-Y", strtotime($row["receipt_date"])); ?></span><br>
                                            ~<span class="ml-3"> <?php echo strtoupper($row["payment_mode"]); ?></span><br>
                                            ~<span class="ml-3"> <?php echo $row["cash_deposit_to"]; ?></span><br>
                                            ~<span class="ml-3"> <?php echo $row["bank_name"]; ?></span><br>
                                            ~<span class="ml-3"> <?php echo $row["transaction_no"]; ?></span><br>
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row pr-4 pl-4">
                                    <div class="col-sm-12 invoice-col">
                                        <h4 class="text-bold" style="font-family: Times New Roman;">FEE DETAILS FOR COURSE ~ <?php echo strtoupper($row["course_name"]); ?></h4>
                                    </div>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.NO</th>
                                                    <th>PARTICULARS</th>
                                                    <th>AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $tmpSNo = 1;
                                                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                ?>
                                                <tr>
                                                    <td><?php echo $tmpSNo; ?></td>
                                                    <td><?php echo strtoupper($arrayTblFeeUpdate->fee_particulars); ?></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $arrayTblFeeUpdate->fee_amount; ?>.00</span></td>
                                                </tr>
                                                <?php 
                                                        $tmpSNo++;    
                                                    } 
                                                ?>
                                                <!-- TOTAL AMOUNT -->
                                                <tr>
                                                    <td></td>
                                                    <td><span class="float-right mr-3 text-bold">TOTAL</span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $totalFee; ?>.00</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- Table row -->
                                <div class="row pr-4 pl-4 pt-0 mt-0">
                                    <div class="col-sm-12 invoice-col">
                                        <h4 class="text-bold" style="font-family: Times New Roman;">TOTAL FEE PAID ~</h4>
                                    </div>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.NO</th>
                                                    <th>PARTICULARS</th>
                                                    <th>PAID</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php 
                                                    $tmpSNo = 1;
                                                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                        if($arrayTblFeeUpdate->fee_paid != 0){
                                                ?>
                                                            <tr>
                                                                <td><?php echo $tmpSNo; ?></td>
                                                                <td><?php echo strtoupper($arrayTblFeeUpdate->fee_particulars); ?></td>
                                                                <td><span class="text-bold">&#8377; <?php echo $arrayTblFeeUpdate->fee_paid; ?>.00</span></td>
                                                            </tr>
                                                <?php 
                                                            $tmpSNo++;
                                                        }
                                                        
                                                    } 
                                                ?>
                                                <!-- TOTAL AMOUNT -->
                                                <tr>
                                                    <td></td>
                                                    <td><span class="float-right mr-3 text-bold">TOTAL</span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $totalPaid; ?>.00</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row pr-4 pl-4">
                                    <div class="col-12">
                                        <div class="table-responsive table-striped">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>REBATE ON</th>
                                                        <th>REBATE AMOUNT</th>
                                                        <th>TOTAL FINE</th>
                                                        <th>TOTAL PAID</th>
                                                        <th>BALANCE DUE</th>

                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <td><span class="text-bold"><?php echo $rebateOn; ?></span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $totalRebate; ?>.00</span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $fineAmount ?>.00</span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $totalPaid + $fineAmount; ?>.00</span></td>
                                                    <td><span class="text-bold">&#8377; <?php echo $row["balance"]; ?>.00</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row pr-4 pl-4" style="margin-top:100px;">
                                    <div class="col-12">
                                        <div class="table-responsive table-striped">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td><span class="float-right">AUTHORISED SIGNATURE</span></td>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <th>NOTE ~ Please keep this slip for your reference.
                                                    <th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- this row will not appear when printing -->
                                <div class="row no-print mt-5">
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        <a href="receipt-print?paidId=<?php echo $paidId; ?>" target="_blank" class="btn btn-warning float-right btn-block"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
<?php 
    } 
    elseif(isset($_POST["studentId"]) && isset($_POST["action"])){
        $studentRegistrationNo = $_POST["studentId"];
        $sql = "SELECT *
                FROM `tbl_admission`
                INNER JOIN `tbl_university_details` ON `tbl_admission`.`admission_session` = `tbl_university_details`.`university_details_id`
                INNER JOIN `tbl_course` ON `tbl_admission`.`admission_course_name` = `tbl_course`.`course_id`
                WHERE `tbl_admission`.`admission_id` = '$studentRegistrationNo' && `tbl_admission`.`status` = '$visible' && `tbl_course`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'
                ";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        //Define Variables Section Start
        //Numeric Veriables
        $arrayFee = array(); //In Amount or In Number
        $arrayFine = array(); //In Amount or In Number
        $arrayRemaining = array(); //In Amount or In Number
        $arrayRebate = array(); //In Amount or In Number
        $totalFee = 0; //In Amount or In Number
        $totalFine = 0; //In Amount or In Number
        $totalRemaining = 0; //In Amount or In Number
        $totalRemainings = 0; //In Amount or In Number
        $totalRebate = 0; //In Amount or In Number
        $totalPaid = 0; //In Amount or In Number
        //String Variables
        $arrayPerticular = array();
        $arrayTblFee = array();
        $objTblFee = "";
        $rebateOn = "";
        //Checking If Hostel If Available Or Not
        if(strtolower($row["admission_hostel"]) == "yes")
            $sqlTblFee = "SELECT *
                         FROM `tbl_fee`
                         WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' ORDER BY `fee_particulars` ASC
                         ";
        else
            $sqlTblFee = "SELECT *
                         FROM `tbl_fee`
                         WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees') ORDER BY `fee_particulars` ASC
                         ";
        $resultTblFee = $con->query($sqlTblFee);
        if($resultTblFee->num_rows > 0)
            while($rowTblFee = $resultTblFee->fetch_assoc()){
                $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                    $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                else
                    $noOfDays = 0;
                $completeArray = array(
                                    "fee_id" => $rowTblFee["fee_id"],
                                    "fee_particulars" => $rowTblFee["fee_particulars"],
                                    "fee_amount" => $rowTblFee["fee_amount"],
                                    "fee_paid" => 0,
                                    "fee_fine" => $rowTblFee["fee_fine"],
                                    "fee_rebate" => 0,
                                    "fee_remaining" => $rowTblFee["fee_amount"],
                                    "fee_fine_days" => $noOfDays
                                );
                array_push($arrayTblFee, $completeArray);
            }
        $arrayTblFee = json_decode(json_encode($arrayTblFee));
        $sqlTblFeePaid = "SELECT *
                         FROM `tbl_fee_paid`
                         WHERE `status` = '$visible' AND `student_id` = '".$studentRegistrationNo."' AND `payment_status` IN ('cleared', 'pending')
                         ";
        $resultTblFeePaid = $con->query($sqlTblFeePaid);
        if($resultTblFeePaid->num_rows > 0)
            while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
                $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                for($i=0; $i<count($arrayPaidId); $i++){
                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                        if($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]){
                            $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                            if($rowTblFeePaid["rebate_amount"] != ""){
                                $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                                if($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])){
                                    $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                                    $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                                }
                            }
                            $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                            $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
                        }
                    }
                }
            }
    ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Print Receipt</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Print Receipt</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info mr-2"></i> Please check the Informations and Calculations if they are currect then only print this Receipt.</h5>
                                </div>


                                <!-- Main content -->
                                <div class="invoice p-3 mb-2">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-3">
                                            <h4 class="text-center">
                                                <img src="images/logo.png" width="85%" alt="Image" border="0" title="Images" style="-webkit-filter: drop-shadow(5px 5px 5px #222 ); filter: drop-shadow(5px 5px 5px #222);">
                                            </h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="text-center mt-5" style="font-family: Times New Roman;">
                                                <h1 class="text-bold">NETAJI SUBHAS PUBLIC SCHOOL</h1>
                                                <p>POKHARI, P.O : BHILAI PAHARI, P.S : M.G.M Dist : EAST SINGHBHUM,<br /> JAMSHEDPUR - 831012 Jharkhand. Contact - (+91) 9835203429 <br />Visit : https://nsuniv.ac.in/</p>
                                            </div>
                                        </div>
                                        <div class="col-2 pt-1">
                                            <h4>
                                                <small class="float-right">Date: <?php echo date("d/m/Y"); ?></small>
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <hr class="mt-0 mb-3" />
                                    <!-- info row -->
                                    <div class="row invoice-info mb-3 pr-4 pl-4">
                                        <div class="col-sm-12 invoice-col">
                                            <h4 class="text-bold" style="font-family: Times New Roman;">STUDENT FEE CARD ~</h4>
                                        </div>
                                        <div class="col-sm-2 invoice-col">
                                            <p style="font-family: Times New Roman;">
                                                <strong>Registration No.</strong><br>
                                                <strong>Admission No.</strong><br>
                                                <strong>Course</strong><br>
                                                <strong>Academic Session</strong><br>
                                            </p>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <p style="font-family: Times New Roman;">
                                                ~<span class="ml-3"> <?php echo $row["admission_id"]; ?></span><br>
                                                ~<span class="ml-3"> <?php echo $row["admission_no"]; ?></span><br>
                                                ~<span class="ml-3"> <?php echo strtoupper($row["course_name"]); ?></span><br>
                                                ~<span class="ml-3"> <?php echo date("Y", strtotime($row["university_details_academic_start_date"]))." to ".date("Y", strtotime($row["university_details_academic_end_date"])); ?></span><br>
                                            </p>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-2 invoice-col">
                                            <p style="font-family: Times New Roman;">
                                                <strong>Father's Name</strong><br>
                                                <strong>Father's Number</strong><br>
                                                <strong>Student Name</strong><br>
                                                <strong>Hostel</strong><br>
                                            </p>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <p style="font-family: Times New Roman;">
                                                ~<span class="ml-3"> <?php echo strtoupper($row["admission_father_name"]); ?></span><br>
                                                ~<span class="ml-3"> <?php echo strtoupper($row["admission_father_phoneno"]); ?></span><br>
                                                ~<span class="ml-3"> <?php echo strtoupper($row["admission_first_name"]); ?> <?php echo strtoupper($row["admission_middle_name"]); ?> <?php echo strtoupper($row["admission_last_name"]); ?></span><br>
                                                ~<span class="ml-3"> <?php echo strtoupper($row["admission_hostel"]); ?></span><br>
    <!--                                            ~<span class="ml-3"> <?php echo strtoupper($row["notes"]); ?></span><br>-->
                                            </p>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row pr-4 pl-4">
                                        <div class="col-sm-12 invoice-col">
                                            <h4 class="text-bold" style="font-family: Times New Roman;">FEE DETAILS FOR COURSE ~ <?php echo strtoupper($row["course_name"]); ?></h4>
                                        </div>
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S.NO</th>
                                                        <th>PARTICULARS</th>
                                                        <th>AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $tmpSNo = 1;
                                                        foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $tmpSNo; ?></td>
                                                        <td><?php echo strtoupper($arrayTblFeeUpdate->fee_particulars); ?></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $arrayTblFeeUpdate->fee_amount; ?>.00</span></td>
                                                    </tr>
                                                    <?php 
                                                            $tmpSNo++;    
                                                        } 
                                                    ?>
                                                    <!-- TOTAL AMOUNT -->
                                                    <tr>
                                                        <td></td>
                                                        <td><span class="float-right mr-3 text-bold">TOTAL</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalFee; ?>.00</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                    <!-- Table row -->
                                    <div class="row pr-4 pl-4 pt-0 mt-0">
                                        <div class="col-sm-12 invoice-col">
                                            <h4 class="text-bold" style="font-family: Times New Roman;">TOTAL FEE PAID ~</h4>
                                        </div>
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S.NO</th>
                                                        <th>PARTICULARS</th>
                                                        <th>REBATE</th>
                                                        <th>PAID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php 
                                                        $tmpSNo = 1;
                                                        foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                            if($arrayTblFeeUpdate->fee_paid != 0){
                                                    ?>
                                                                <tr>
                                                                    <td><?php echo $tmpSNo; ?></td>
                                                                    <td><?php echo strtoupper($arrayTblFeeUpdate->fee_particulars); ?></td>
                                                                    <td><span class="text-bold">&#8377; <?php echo $arrayTblFeeUpdate->fee_rebate; ?>.00</span></td>
                                                                    <td><span class="text-bold">&#8377; <?php echo $arrayTblFeeUpdate->fee_paid; ?>.00</span></td>
                                                                </tr>
                                                    <?php 
                                                            }
                                                            $tmpSNo++;
                                                        } 
                                                    ?>
                                                    <!-- TOTAL AMOUNT -->
                                                    <tr>
                                                        <td></td>
                                                        <td><span class="float-right mr-3 text-bold">TOTAL</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalRebate; ?>.00</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalPaid; ?>.00</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                    <div class="row pr-4 pl-4">
                                        <div class="col-12">
                                            <div class="table-responsive table-striped">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>TOTAL REBATE</th>
                                                            <th>TOTAL FINE</th>
                                                            <th>TOTAL PAID</th>
                                                            <th>BALANCE DUE</th>

                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalRebate; ?>.00</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalFine ?>.00</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalPaid + $totalFine; ?>.00</span></td>
                                                        <td><span class="text-bold">&#8377; <?php echo $totalRemaining; ?>.00</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                    <div class="row pr-4 pl-4" style="margin-top:100px;">
                                        <div class="col-12">
                                            <div class="table-responsive table-striped">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td></td>
                                                            <td><span class="float-right">AUTHORISED SIGNATURE</span></td>
                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <th>NOTE ~ Please keep this slip for your reference.
                                                        <th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print mt-5">
                                        <div class="col-3"></div>
                                        <div class="col-3"></div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <a href="receipt-print?studentId=<?php echo $studentRegistrationNo; ?>" target="_blank" class="btn btn-warning float-right btn-block"><i class="fas fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.invoice -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
    <?php
    } else{
        echo "<script> location.replace('print_receipt'); </script>";
    }
?>
  <?php include 'include/footer.php'; ?>

  <!-- Control Sidebar -->
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
