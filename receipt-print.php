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
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .table td, .table th {
            padding: 0.5rem !important;
        }
    </style>
</head>

<body>
<?php 
    if(isset($_GET["paidId"])){ 
    $paidId = $_GET["paidId"];
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
    <div class="wrapper" style="padding: 20px;">
        <!-- Main content -->
        <section class="invoice" style="border: 5px solid #c70013; position: relative;">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-2">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-3">
                                <h4 class="text-center">
                                    <img src="images/logo.png" width="100%" alt="Image" border="0" title="Images" style="-webkit-filter: drop-shadow(5px 5px 5px #222 ); filter: drop-shadow(5px 5px 5px #222);">
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
                            <div class="col-sm-12 mb-3 invoice-col">
                                <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">MONEY RECEIPT ~</h4>
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
<!--                                    <strong>Notes</strong><br>-->
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
<!--                                    ~<span class="ml-3"> <?php echo strtoupper($row["notes"]); ?></span><br>-->
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
                                <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">FEE DETAILS FOR COURSE ~ <?php echo strtoupper($row["course_name"]); ?></h4>
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
                                <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">TOTAL FEE PAID ~</h4>
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
                            <div class="col-sm-12 invoice-col">
                               <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">SUMMARY ~</h4>
                            </div>
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
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
<?php 
    } 
    
    elseif(isset($_GET["studentId"])){
        $studentRegistrationNo = $_GET["studentId"];
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
        <div class="wrapper" style="padding: 20px;">
            <!-- Main content -->
            <section class="invoice" style="border: 5px solid #c70013; position: relative;">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-2">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-3">
                                    <h4 class="text-center">
                                        <img src="images/logo.png" width="100%" alt="Image" border="0" title="Images" style="-webkit-filter: drop-shadow(5px 5px 5px #222 ); filter: drop-shadow(5px 5px 5px #222);">
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
                                <div class="col-sm-12 mb-3 invoice-col">
                                    <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">STUDENT FEE CARD ~</h4>
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
                                    <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">FEE DETAILS FOR COURSE ~ <?php echo strtoupper($row["course_name"]); ?></h4>
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
                                    <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">TOTAL FEE PAID ~</h4>
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
                                <div class="col-sm-12 invoice-col">
                                   <h4 class="text-bold" style="font-family: Times New Roman;background: #c70013;padding: 5px 10px;color: white;">SUMMARY ~</h4>
                                </div>
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
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
    <?php 
    } else{
        echo "<script> location.replace('print_receipt'); </script>";
    }
?>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>