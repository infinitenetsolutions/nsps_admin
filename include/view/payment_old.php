<?php
/* ------------------------------------------------- Fee Payment Start -------------------------------------------------- */
// Student fee start
// Student fee start
if ($_GET["action"] == "fetch_student_fee_details") {
    $studentRegistrationNo = $_POST["studentRegistrationNo"];
    $branch_id = $_SESSION['admin_branch'];
    if (!empty($studentRegistrationNo)) {
        if ($_SESSION["logger_type"] != "admin") {
            $sql = "SELECT * FROM `tbl_student`
                        INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
                        INNER JOIN `tbl_class` ON `tbl_student`.`course_id` = `tbl_class`.`course_id`
                        WHERE `student_id` = '$studentRegistrationNo' && `tbl_student`.`status` = '$visible' && `tbl_class`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible' && `branch_id`='$branch_id'";
        } else {
            $sql = "SELECT * FROM `tbl_student`
                        INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
                        INNER JOIN `tbl_class` ON `tbl_student`.`course_id` = `tbl_class`.`course_id`
                        WHERE `student_id` = '$studentRegistrationNo' && `tbl_student`.`status` = '$visible' && `tbl_class`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'";
        }
        $result = $con->query($sql);
        if (!empty($result) && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cll = $row['course_id'];
            $branch_id = $row['branch_id'];
            $class = "SELECT * FROM `tbl_class` WHERE course_id = $cll";
            $class_id = $con->query($class);
            $row_cls = mysqli_fetch_assoc($class_id);

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
            $noOfDays;
            $total_fine_payment = 0;
            $total_rebate_fine_payment = 0;
            $total_fine_payment_remaining = 0;
            $overall_total_paid = 0;
            $fee_remaining_from_database = 0;
            //Checking If Hostel If Available Or Not
            // if(strtolower($row["admission_hostel"]) == "yes")

            // rebate fine calculator function start
            function rebate_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
            {
                $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND rebate_amount!='' ORDER BY `rebate_amount` ASC ";
                $resultTblFeePaid = $con->query($sqlTblFeePaid);

                if ($resultTblFeePaid->num_rows > 0) {

                    while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                        if ($rowTblFeePaid['rebate_amount'] > 0) {

                            $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                            $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                            // echo "<pre>";
                            //  print_r($after_expoide_id);
                            for ($i = 0; $i < count($after_expoide_id); $i++) {
                                if ($after_PaidAmount[$i] != '') {
                                    if ($particular_id == $after_expoide_id[$i]) {
                                        $rebate_fine =  explode(",", $rowTblFeePaid['rebate_amount']);
                                        if ($rebate_fine[1] === 'fine') {
                                            $fine = $fine + $rebate_fine[0];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return $fine;
            }

            // rebate fine calculator function end

            // fine particular function start
            function fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
            {
                $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND fine!=''";
                $resultTblFeePaid = $con->query($sqlTblFeePaid);

                if ($resultTblFeePaid->num_rows > 0) {

                    while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                        if ($rowTblFeePaid['fine'] > 0) {

                            $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                            $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);

                            for ($i = 0; $i < count($after_expoide_id); $i++) {
                                if ($after_PaidAmount[$i] != '') {
                                    if ($particular_id == $after_expoide_id[$i]) {
                                        $fine = $fine + $rowTblFeePaid['fine'];
                                    }
                                }
                            }
                        }
                    }
                }
                return $fine;
            }
            // fine particular function end


            // remaining fine calculator function start
            function remaining_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
            {
                $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                 $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND remaining_fine!='' ORDER BY `remaining_fine` ASC ";
                $resultTblFeePaid = $con->query($sqlTblFeePaid);

                if ($resultTblFeePaid->num_rows > 0) {

                    while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                        if ($rowTblFeePaid['remaining_fine'] > 0) {

                            $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                            $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                            for ($i = 0; $i < count($after_expoide_id); $i++) {
                                if ($after_PaidAmount[$i] != '') {
                                    if ($particular_id == $after_expoide_id[$i]) {
                                        $fine = $rowTblFeePaid['remaining_fine'];
                                    }
                                }
                            }
                        }
                    }
                }
                return $fine;
            }

            // remaining fine calculator function ends


            $sqlTblFee = "SELECT * FROM `tbl_fee`
                                     WHERE `class` = '" . $row["course_id"] . "' AND `section` = '" . $row["section_id"] . "' AND `fee_academic_year` = '" . $row["university_details_id"] . "' AND `branch`='$branch_id'  ORDER BY `particular` ASC
                                     ";


            $resultTblFee = $con->query($sqlTblFee);
            if ($resultTblFee->num_rows > 0)
                while ($rowTblFee = $resultTblFee->fetch_assoc()) {
                    $totalFee = $totalFee + intval($rowTblFee["fee"]);
                    if (strtotime(date($rowTblFee["last_date"])) < strtotime(date("Y-m-d")))
                        $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["last_date"]))) / 60 / 60 / 24;
                    else
                        $noOfDays = 0;
                    if ($rowTblFee["status"] == "$visible")
                        $fine_particular = $rowTblFee["fine_amount"];
                    else
                        $fine_particular = 0;
                    $completeArray = array(
                        "fee_id" => $rowTblFee["id"],
                        "fee_particulars" => $rowTblFee["particular"],
                        "fee_amount" => $rowTblFee["fee"],
                        "fee_paid" => 0,
                        "fee_fine" => $fine_particular,
                        "fee_rebate" => 0,
                        "fee_remaining" => $rowTblFee["fee"],
                        "fee_fine_days" => $noOfDays,
                        "fee_last_date" => $rowTblFee["last_date"]
                    );
                    array_push($arrayTblFee, $completeArray);
                }
            $arrayTblFee = json_decode(json_encode($arrayTblFee));
            $sqlTblFeePaid = "SELECT * FROM `tbl_fee_paid`
                                     WHERE `status` = '$visible' AND `student_id` = '" . $studentRegistrationNo . "' AND `payment_status` IN ('cleared', 'pending')";
            $resultTblFeePaid = $con->query($sqlTblFeePaid);
            if ($resultTblFeePaid->num_rows > 0)
                while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {
                    $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                    $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                    for ($i = 0; $i < count($arrayPaidId); $i++) {
                        foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                            if ($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]) {
                                $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                                if ($rowTblFeePaid["rebate_amount"] != "") {
                                    $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                                    if ($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])) {
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
            //Define Variables Section End
?>
            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?php

                                if (!empty($row["photo"])) {
                                    echo '<img class="profile-user-img img-fluid img-circle" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '"  alt="Student profile picture"/>';
                                } else {


                                    if (strtolower($row["gender"]) == "female") {
                                ?>
                                        <img class="profile-user-img img-fluid img-circle" src="images/womenIcon.png" alt="Student profile picture">
                                    <?php } else {   ?>
                                        <img class="profile-user-img img-fluid img-circle" src="images/menIcon.png" alt="Student profile picture">
                                <?php }
                                } ?>
                            </div>

                            <h3 class="profile-username text-center"><?php echo $row["student_name"]; ?></h3>
                            <?php
                            $completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
                            $completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
                            $completeSessionOnlyYear = $completeSessionStart[0] . "-" . $completeSessionEnd[0];
                            ?>
                            <p class="text-white text-center">( <?php echo $row_cls["course_name"] . " | " . $completeSessionOnlyYear; ?> )</p>

                            <p>
                                <b>Reg. No</b> <a class="float-right"><?php echo $row["reg_no"]; ?></a></br>

                                <b>Course Name</b> <a class="float-right"><?php echo $row_cls["course_name"]; ?></a></br>

                                <b>Status</b> <a class="float-right">Active</a>
                            </p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About <?php echo $row["student_name"]; ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Personal Details</strong>
                            <p class="text-white">
                                <b>Name - </b><?php echo $row["student_name"]; ?><br />
                                <b>Gender - </b><?php echo $row["gender"]; ?><br />
                                <b>DOB - </b><?php echo $row["dob"]; ?><br />
                                <b>Father's Name - </b><?php echo $row["father_name"]; ?><br />
                                <b>Parent's Contact - </b><?php echo $row["parent_contactno"]; ?><br />
                                <b>Mother's Name - </b><?php echo $row["mother_name"]; ?><br />
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">More Informations</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h6><i class="fas fa-book mr-1"></i> School Details</h6>
                            <?php
                            $br_id = $row["branch_id"];
                            $sql_brn = "SELECT * FROM `tbl_branch`                                   
                                            WHERE `id` = $br_id";
                            $result_brn = $con->query($sql_brn);
                            if (!empty($result_brn) && $result_brn->num_rows > 0)
                                $row_brn = $result_brn->fetch_assoc();
                            ?>
                            <p class="text-white">
                                School - <?php echo $row["university_details_university_name"]; ?><br />
                                Branch - <?php echo $row_brn["branch_name"]; ?><br />
                                <!-- Passing Year - <?php echo $row["admission_high_school_passing_year"]; ?><br/> -->
                                <!-- Percentage - <?php echo $row["admission_high_school_per"]; ?> %<br/> -->
                            </p>

                            <h6><i class="fas fa-map-marker-alt mr-1"></i> Location</h6>
                            <p class="text-white">
                                <?php echo $row["university_details_address"]; ?>,<br />
                                <?php echo $row["university_details_contact"]; ?>
                            </p>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#payfee" data-toggle="tab">Fee Payment</a></li>
                                <li class="nav-item"><a class="nav-link" href="#paidfee" data-toggle="tab">Paid Info</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="payfee">
                                    <form method="POST" id="PayFeeForm">
                                        <!-- Table row -->
                                        <div class="row">
                                            <input type="hidden" name="registrationNumber" value="<?php echo $studentRegistrationNo; ?>" readonly />
                                            <input type="hidden" name="courseId" value="<?php echo $row["course_id"]; ?>" readonly />
                                            <input type="hidden" name="academicYear" value="<?php echo $row["university_details_id"]; ?>" readonly />
                                            <div class="col-12 table-responsive">
                                                <h5>Fee Details of <b><a href="javascript:void(0);"><?php echo $row["course_name"] . " | " . $completeSessionOnlyYear; ?></a></b></h5>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Particulars</th>
                                                            <th>Last Date</th>
                                                            <th>Amount</th>
                                                            <th>Paid</th>
                                                            <th>Rebate</th>
                                                            <th>Remaining</th>
                                                            <th>Fine</th>
                                                            <th>Fine paid</th>
                                                            <th>Fine Rebate </th>
                                                            <th>Fine Remaining</th>
                                                            <th><span class="text-red">Total Paid</th>
                                                            <th><span class="text-red">Total Due</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $Idno = 0;
                                                        $tmpSNo = 1;
                                                        $fine_array = 0;
                                                        foreach ($arrayTblFee as $arrayTblFeeUpdate) {

                                                            if (($arrayTblFeeUpdate->fee_remaining - $arrayTblFeeUpdate->fee_rebate) === 0) {
                                                                $arrayTblFeeUpdate->fee_fine_days = 0;
                                                                $arrayTblFeeUpdate->fee_fine = 0;
                                                                $fee_remaining_from_database = remaining_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id);
                                                            } else {

                                                                $fee_remaining_from_database = 0;
                                                            }



                                                        ?>
                                                            <tr>
                                                                <td><?php echo $tmpSNo; ?></td> <!-- serial number -->
                                                                <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td> <!-- particular -->
                                                                <td><?php echo  date("d-m-Y", strtotime($arrayTblFeeUpdate->fee_last_date))  ?></td> <!--  last date -->
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_amount); ?></td> <!-- amount -->
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_paid); ?></td> <!-- paid -->
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_rebate); ?></td> <!-- rebate -->

                                                                <!-- Remaining -->
                                                                <td>&#8377; <?php echo $total_remaining_amount = ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate); ?></td>
                                                                <?php $totalRemaining = $totalRemaining + $total_remaining_amount;


                                                                ?>

                                                                <!-- Fine -->
                                                                <td>&#8377; <?php echo $all_fine = ($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days) + $fee_remaining_from_database ?></td>
                                                                <!-- total fine -->
                                                                <?php $totalFine = $totalFine + $all_fine ?>
                                                                <!-- Fine paid -->
                                                                <td>&#8377; <?php echo $fine_by_particular = fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id) ?></td>
                                                                <!-- total fine paid -->
                                                                <?php $total_fine_payment = $total_fine_payment + $fine_by_particular;   ?>
                                                                <!-- fine rebate -->
                                                                <td>&#8377; <?php
                                                                            echo $rebate_fine_by_particular =  rebate_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id); ?></td>
                                                                <!-- total fine paid -->
                                                                <?php

                                                                $total_rebate_fine_payment = $total_rebate_fine_payment + $rebate_fine_by_particular;   ?>

                                                                <!-- fine remaining  -->
                                                                <td>&#8377; <?php
                                                                            echo $fine_by_particular_remaning =  $all_fine - $fine_by_particular - $rebate_fine_by_particular;
                                                                            ?></td>

                                                                <!-- total fine remaining -->
                                                                <?php $total_fine_payment_remaining = $total_fine_payment_remaining + $fine_by_particular_remaning ?>

                                                                <!-- Total paid particular -->
                                                                <td>&#8377; <?php echo $overall_total_paid_particular =  ($arrayTblFeeUpdate->fee_paid) + fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id) + $arrayTblFeeUpdate->fee_rebate + $rebate_fine_by_particular ?></td>

                                                                <!-- total paid -->
                                                                <?php $overall_total_paid = $overall_total_paid + $overall_total_paid_particular ?>


                                                                <!-- total remaining including fine -->

                                                                <td><span class="text-red text-bold">&#8377; <?php echo  $total_remaing_amount_final = $total_remaining_amount + $fine_by_particular_remaning  ?></span></td>
                                                                <?php $totalRemainings = $totalRemainings + $total_remaing_amount_final;  ?>
                                                                <?php //} 
                                                                ?>
                                                                <!--check last payment date -->
                                                                <input type="hidden" id="particular_fine_paid[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_paid[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular  ?>" />
                                                                <input type="hidden" id="particular_fine_remaining[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_remaining[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular_remaning  ?>" />
                                                                <input type="hidden" id="particular_paid_id[<?php echo $Idno; ?>]" name="particular_paid_id[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_id; ?>" />
                                                                <input type="hidden" id="particular_paid_lastDate[<?php echo $Idno; ?>]" name="particular_paid_lastDate[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_last_date; ?>" />
                                                                <input type="hidden" id="particular_paid_fineAmount[<?php echo $Idno; ?>]" name="particular_paid_fineAmount[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_fine; ?>" />
                                                                <input type="hidden" id="particular_paid_amount1[<?php echo $Idno; ?>]" name="particular_paid_amount1[<?php echo $Idno; ?>]" value="<?php echo ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate) ?>" />
                                                                <input type="hidden" id="fine_by_particular[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="fine_by_particular[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular  ?>" />

                                                                <input type="hidden" id="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" value="<?php echo $all_fine  ?>" />

                                                                <?php
                                                                //} 
                                                                ?>

                                                            </tr>
                                                        <?php
                                                            $tmpSNo++;
                                                            $fine_array++;
                                                            $Idno++;
                                                        }
                                                        ?>
                                                        <input type="hidden" id="total_fine_payment_remaining" value="<?php echo $total_fine_payment_remaining  ?>" />

                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right text-bold"></td>

                                                            <td class="text-right text-bold">Total</td>

                                                            <td class="text-bold">&#8377; <?php echo number_format($totalFee); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($totalPaid); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($totalRebate); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($totalRemaining); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($totalFine); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($total_fine_payment); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($total_rebate_fine_payment); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($total_fine_payment_remaining); ?></td>
                                                            <td class="text-bold">&#8377; <?php echo number_format($overall_total_paid); ?></td>

                                                            <td class="text-bold"><span class="text-red"> &#8377; <?php echo number_format($totalRemainings); ?></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-md-6" style="float:right">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Payment Date</span>
                                                            </div>
                                                            <input type="date" name="paymentDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" onkeyup="completeCalculation();" onclick="completeCalculation();" onchange="completeCalculation();" />
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>
                                                <h5>Pay Remaining<b><a href="javascript:void(0);"> Fee</a></b></h5>
                                                <p id="errorMessage" class="text-red"></p>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>S. No</th>
                                                            <th>Particulars</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $tmpSNo = 1;
                                                        $Idno = 0;


                                                        foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $tmpSNo; ?></td>
                                                                <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td>
                                                                <td>
                                                                    <input type="hidden" name="particular_paid_id[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_id; ?>" />
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">&#8377;</span>
                                                                        </div>
                                                                        <input id="particular_paid_amount[<?php echo $Idno; ?>]" name="particular_paid_amount[<?php echo $Idno; ?>]" min="0" max="<?php echo (($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)); ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php if ((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) <= 0) echo "readonly"; ?>>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $Idno++;
                                                            $tmpSNo++;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $tmpSNo; ?></td>
                                                            <td>Fine</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">&#8377;</span>
                                                                    </div>
                                                                    <input id="fine_amount" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="number" class="form-control " onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php if ($totalFine <= 0) echo "readonly"; ?>>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo ++$tmpSNo; ?></td>
                                                            <td>Extra Fine</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">&#8377;</span>
                                                                    </div>
                                                                    <input id="extra_fine" name="extra_fine" min="0" max="" type="number" class="form-control">
                                                                    <div class="input-group-prepend">
                                                                        <input type="text" name="extra_fine_description" placeholder="Extra Fine Description" class="form-control" style="border: 2px solid #dc3545; width: 400px" />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo ++$tmpSNo; ?></td>
                                                            <td>Rebate</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">&#8377;</span>
                                                                    </div>
                                                                    <input id="rebate_amount" name="rebate_amount" min="0" max="" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();">
                                                                    <div class="input-group-prepend">
                                                                        <select id="rebate_from" name="rebate_from" class="btn btn-danger btn-block form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();">
                                                                            <option value="">Rebate From</option>
                                                                            <?php
                                                                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                                            ?>
                                                                                <option value="<?php echo $arrayTblFeeUpdate->fee_id; ?>">From - <?php echo $arrayTblFeeUpdate->fee_particulars; ?></option>
                                                                            <?php } ?>
                                                                            <option value="fine">From - Fine</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <small class="text-red" id="rebateErr"></small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right text-bold">Total</td>
                                                            <td class="text-bold">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">&#8377;</span>
                                                                    </div>
                                                                    <input id="total_amount" name="total_amount" min="0" max="<?php echo $totalRemainings ?>" type="number" class="form-control" readonly>
                                                                </div>
                                                                <small class="text-red" id="totalErr"></small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right text-bold">Remaining</td>
                                                            <td class="text-bold">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">&#8377;</span>
                                                                    </div>
                                                                    <input id="remaining_amount" name="remaining_amount" min="0" value="<?php echo $totalRemainings ?>" type="number" style="font-weight: 900;color: #dc3545;" class="form-control" readonly>
                                                                </div>
                                                                <small class="text-red" id="remainingErr"></small>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </div>
                                            <!-- /.col -->

                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Payment Mode</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-university"></i></span>
                                                        </div>
                                                        <select id="PaymentMode" name="PaymentMode" class="form-control" onchange="PaymentModeSelect(this.value);">
                                                            <option value="0">Select</option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="DD">DD</option>
                                                            <option value="Online">Online</option>
                                                            <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                        </select>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3" id="cash_div" style="display:none">
                                                <label>Cash Deposit To</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                        </div>
                                                        <select id="cashDepositTo" name="cashDepositTo" class="form-control">
                                                            <option value="0">Select</option>
                                                            <option value="University Office">School Office</option>
                                                            <option value="Deposit to Bank">Deposit to Bank</option>
                                                            <option value="City Office">City Office</option>
                                                        </select>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3" id="bankName_div" style="display:none">
                                                <label>Bank Name</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                        </div>
                                                        <input id="bankName" name="bankName" type="text" class="form-control" />
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="chequeNo_div" style="display:none">
                                                <label>Cheque/DD/NEFT/IMPS/RTGS No</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                        </div>
                                                        <input id="chequeAndOthersNumber" name="chequeAndOthersNumber" type="text" class="form-control" />
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="receiptDate_div" style="display:none">
                                                <label>Receipt Date</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input id="paidDate" name="paidDate" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="notes_div" style="display:none">
                                                <label>Notes</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                                        </div>
                                                        <textarea id="NotesByAdmin" name="NotesByAdmin" type="text" class="form-control"></textarea>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-12"></div>
                                            <div class="col-md-12" id="error_on_pay_fee" style="margin-top:20px;"></div>
                                            <div class="col-md-3" id="pay_div" style="display:none; margin-top:20px;">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="hidden" name="action" value="pay_fees" />
                                                        <button id="PayFeeButton" name="PayFeeButton" class="btn btn-primary btn-lg btn-block"><span id="loader_section_on_pay_fee"></span> <span id="PayText">Pay</span></button>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>



                                            <div class="col-md-3" id="reset_div" style="margin-top:20px;">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <button class="btn btn-danger btn-lg btn-block" type="reset" onclick="return confirm('Are you sure you want to reset all Informations???');">Reset</button>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>


                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <?php
                                    $sql = "SELECT * FROM `tbl_fee_paid` WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo'
                                                  ORDER BY `feepaid_id` DESC";
                                    $result = $con->query($sql);
                                    $row = $result->fetch_assoc();
                                    ?>
                                    <form action="print" method="POST">
                                        <input type="hidden" name="paidId" value="<?php echo $row["feepaid_id"]; ?>" />
                                        <div class="col-md-3" id="" style="margin-top:20px ; float:right; margin-top:-5rem">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <button class="btn btn-primary btn-lg btn-block" type="">Print Receipt</button>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                    </form>
                                    <script>
                                        function completeCalculation() {
                                            var totalPaid = 0;
                                            var totalParticular = 0;
                                            var fineAmount = 0;
                                            var rebateAmount = Number(document.getElementById("rebate_amount").value);
                                            if (rebateAmount > 0) {
                                                if (document.getElementById("rebate_from").value == "") {
                                                    $("#rebate_amount").addClass("is-invalid");
                                                    $("#rebateErr").html("~ Please select 'Rebate From'");
                                                } else {
                                                    $("#rebate_amount").removeClass("is-invalid");
                                                    $("#rebateErr").html("");
                                                }
                                            } else {
                                                $("#rebate_amount").removeClass("is-invalid");
                                                $("#rebateErr").html("");
                                            }
                                            var remainingAmount = 0;
                                            <?php
                                            $Idno = 0;
                                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                            ?>
                                                if (document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value != "")
                                                    totalParticular = totalParticular + parseInt(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value);
                                            <?php
                                                $Idno++;
                                            }
                                            ?>
                                            if (document.getElementById("fine_amount").value != "")
                                                fineAmount = parseInt(document.getElementById("fine_amount").value);
                                            totalPaid = totalPaid + parseInt(totalParticular);
                                            totalPaid = totalPaid + parseInt(fineAmount);
                                            remainingAmount = parseInt(<?php echo $totalRemainings; ?>) - parseInt(totalPaid) - parseInt(rebateAmount);
                                            $("#total_amount").val(totalPaid);
                                            $("#remaining_amount").val(remainingAmount);
                                            if (0 > parseInt(remainingAmount)) {
                                                $("#remaining_amount").addClass("is-invalid");
                                                $("#remainingErr").html("~ Cannot use negative value, Remaining value must be 'greater than or equal to 0'");
                                                $("#totalErr").html("~ Total value must be 'less than or equal to <?php echo $totalRemainings; ?>'");
                                                $("#total_amount").addClass("is-invalid");
                                            } else {
                                                $("#remaining_amount").removeClass("is-invalid");
                                                $("#total_amount").removeClass("is-invalid");
                                                $("#remainingErr").html("");
                                                $("#totalErr").html("");
                                            }
                                        }
                                    </script>
                                    <script>
                                        function PaymentModeSelect(PaymentMode) {
                                            var cash_div = document.getElementById('cash_div');
                                            var bankName_div = document.getElementById('bankName_div');
                                            var chequeNo_div = document.getElementById('chequeNo_div');
                                            var receiptDate_div = document.getElementById('receiptDate_div');
                                            var notes_div = document.getElementById('notes_div');
                                            var pay_div = document.getElementById('pay_div');
                                            if (PaymentMode == "Cash") {
                                                cash_div.style.display = "block";
                                                bankName_div.style.display = "none";
                                                chequeNo_div.style.display = "none";
                                                receiptDate_div.style.display = "block";
                                                notes_div.style.display = "block";
                                                pay_div.style.display = "block";
                                            } else if (PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS") {
                                                cash_div.style.display = "none";
                                                bankName_div.style.display = "block";
                                                chequeNo_div.style.display = "block";
                                                receiptDate_div.style.display = "block";
                                                notes_div.style.display = "block";
                                                pay_div.style.display = "block";
                                            } else {
                                                cash_div.style.display = "none";
                                                bankName_div.style.display = "none";
                                                chequeNo_div.style.display = "none";
                                                receiptDate_div.style.display = "none";
                                                notes_div.style.display = "none";
                                                pay_div.style.display = "none";
                                            }
                                        }
                                    </script>
                                    <script>
                                        $(document).ready(function() {
                                            $('#PayFeeForm').submit(function(event) {
                                                $('#PayText').hide();
                                                $('#loader_section_on_pay_fee').append('<img id = "loading" width="30px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                $('#PayFeeButton').prop('disabled', true);
                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: $('#PayFeeForm').serializeArray(),
                                                    success: function(result) {
                                                        $('#response_on_pay_fee').remove();
                                                        if (result == "success") {
                                                            $('#error_on_pay_fee').append('<div id = "response_on_pay_fee"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Paid Successfully!!!</div></div>');
                                                            $('#PayFeeForm')[0].reset();
                                                            $('#loading').fadeOut(1000, function() {
                                                                $(this).remove();
                                                                $('#PayText').show();
                                                                $('#PayFeeButton').prop('disabled', false);
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_student_fee_details',
                                                                    type: 'POST',
                                                                    data: $('#fetchStudentDataForm').serializeArray(),
                                                                    success: function(result) {
                                                                        //$("#data_table").html(result);
                                                                        $('#response').remove();
                                                                        if (result == 0) {
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                        } else if (result == 1) {
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                        } else {
                                                                            //$('#fetchStudentDataForm')[0].reset();
                                                                            $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                        }
                                                                        $('#loading').fadeOut(500, function() {
                                                                            $(this).remove();
                                                                        });
                                                                        $('#fetchStudentDataButton').prop('disabled', false);
                                                                    }
                                                                });
                                                            });
                                                        } else
                                                            $('#error_on_pay_fee').append('<div id = "response_on_pay_fee">' + result + '</div>');
                                                        $('#loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('#PayText').show();
                                                            $('#PayFeeButton').prop('disabled', false);
                                                        });
                                                    }
                                                });
                                                event.preventDefault();
                                            });
                                        });
                                    </script>
                                </div>

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="paidfee">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <?php
                                        $sql_paid_time = "SELECT * FROM `tbl_fee_paid`
                                                        WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo' && `payment_status` != 'deleted'
                                                        ORDER BY `receipt_date` DESC
                                                        ";
                                        $result_paid_time = $con->query($sql_paid_time);
                                        if ($result_paid_time->num_rows > 0) {
                                            while ($row_paid_time = $result_paid_time->fetch_assoc()) {
                                                $allPerticulars = explode(",", $row_paid_time["paid_amount"]);
                                                $totalPerticular = 0;
                                                for ($i = 0; $i < count($allPerticulars); $i++)
                                                    $totalPerticular = $totalPerticular + intval($allPerticulars[$i]);
                                                $totalAmount = $totalPerticular + intval($row_paid_time["fine"]) - intval($row_paid_time["rebate_amount"]);

                                        ?>
                                                <!-- Timeline Section Start -- >
                                          <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-success">
                                                        <?php echo date("d M, Y", strtotime($row_paid_time["receipt_date"])); ?>
                                                    </span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-money-check bg-info"></i>

                                                    <div id="fee_Status_section_full<?php echo $row_paid_time["feepaid_id"]; ?>" class="timeline-item" style="background-color:<?php if (strtolower($row_paid_time["payment_status"]) == "bounced") echo '#ffcccb';
                                                                                                                                                                                if (strtolower($row_paid_time["payment_status"]) == "pending") echo '#ffffed';
                                                                                                                                                                                if (strtolower($row_paid_time["payment_status"]) == "refunded") echo '#ffa7a7'; ?>;">
                                                        <span class="time"><i class="far fa-clock"></i> <?php echo $row_paid_time["fee_paid_time"]; ?> </span>

                                                        <h3 class="timeline-header"><a href="javascript:void(0);">Payment Information</a></h3>

                                                        <div class="timeline-body">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Total Perticular</th>
                                                                        <th>Fine</th>
                                                                        <th>Extra Fine</th>
                                                                        <th>Rebate</th>
                                                                        <th>Total Paid</th>
                                                                        <th><span class="text-red">Remaining</span></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>&#8377; <?php echo number_format(intval($totalPerticular)); ?></td>
                                                                        <td>&#8377; <?php echo number_format(intval($row_paid_time["fine"])); ?></td>
                                                                        <?php
                                                                        $show_extra_fine = 0;
                                                                        $show_extra_fine_msg = "";
                                                                        if (!empty($row_paid_time["extra_fine"])) {
                                                                            $show_extra = explode("|separator|", $row_paid_time["extra_fine"]);
                                                                            $show_extra_fine = $show_extra[0];
                                                                            if (isset($show_extra[1])) {
                                                                                $show_extra_fine_msg = $show_extra[1];
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if (empty($show_extra_fine_msg)) :
                                                                        ?>
                                                                            <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?></td>
                                                                        <?php
                                                                        else :
                                                                        ?>
                                                                            <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?> <br /> <small class="text-danger"><?= htmlspecialchars_decode($show_extra_fine_msg) ?></small></td>
                                                                        <?php
                                                                        endif;
                                                                        ?>
                                                                        <td>&#8377; <?php echo number_format(intval($row_paid_time["rebate_amount"])); ?></td>
                                                                        <td>&#8377; <?php echo number_format(intval($totalAmount) + intval($row_paid_time["rebate_amount"]) + intval($show_extra_fine)); ?></td>
                                                                        <td>&#8377; <?php echo number_format(intval($row_paid_time["balance"])); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <h5 class="timeline-header"><a href="javascript:void(0);">Payment Mode</a> ~ <?php echo $row_paid_time["payment_mode"]; ?></h5>
                                                            <h5 class="timeline-header"><a href="javascript:void(0);">Payment Status</a> ~ <span id="fee_Status_section<?php echo $row_paid_time["feepaid_id"]; ?>"><span class="<?php if (strtolower($row_paid_time["payment_status"]) == "bounced") echo 'bg-danger';
                                                                                                                                                                                                                                    if (strtolower($row_paid_time["payment_status"]) == "refunded") echo 'bg-danger';
                                                                                                                                                                                                                                    else if (strtolower($row_paid_time["payment_status"]) == "pending") echo 'bg-warning'; ?>"><?php echo strtoupper($row_paid_time["payment_status"]); ?></span></span> </h5>
                                                        </div>
                                                        <div class="timeline-footer" align="right">
                                                            <h5 class="timeline-header"><a href="javascript:void(0);">Give Status Here</a></h5>
                                                            <?php if ($row_paid_time["payment_status"] == "refunded") { ?>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-info btn-sm">Add this Fee</a>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                            <?php } else {
                                                            ?>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'refunded')" class="btn btn-info btn-sm">Refund</a>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                            <?php
                                                            } ?>
                                                            <?php if ($row_paid_time["payment_mode"] == "Cheque") { ?>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-success btn-sm">Cleared</a>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'pending')" class="btn btn-warning btn-sm">Pending</a>
                                                                <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'bounced')" class="btn btn-danger btn-sm">Bounced</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                <!-- Timeline Section End -->
                                            <?php }
                                        } else {
                                            ?>
                                            <center><b class="text-red">No any Payment Yet!!!</b></center>
                                        <?php
                                        } ?>
                                        <div>
                                            <i class="fas fa-money-bill-alt bg-danger"></i>
                                        </div>
                                        <script>
                                            function statusChange(feepaid_id, statusUpdate) {
                                                $('#paidfee').css("opacity", "0.4");
                                                $('#paidfee').css("pointer-events", "none");
                                                var action = "change_Fee_Status";
                                                var dataString = 'action=' + action + '&feepaid_id=' + feepaid_id + '&status=' + statusUpdate;
                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        if (result != "error" && result != "empty") {
                                                            console.log(result);
                                                            var fullinfo = result.split(',');
                                                            $('#fee_Status_section' + feepaid_id).html(fullinfo[0]);
                                                            $('#fee_Status_section_full' + feepaid_id).css("background-color", fullinfo[1]);
                                                            $.ajax({
                                                                url: 'include/view.php?action=fetch_student_fee_details',
                                                                type: 'POST',
                                                                data: $('#fetchStudentDataForm').serializeArray(),
                                                                success: function(result) {
                                                                    //$("#data_table").html(result);
                                                                    $('#response').remove();
                                                                    if (result == 0) {
                                                                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                    } else if (result == 1) {
                                                                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                    } else {
                                                                        //$('#fetchStudentDataForm')[0].reset();
                                                                        $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                    }
                                                                    $('#loading').fadeOut(500, function() {
                                                                        $(this).remove();
                                                                    });
                                                                    $('#fetchStudentDataButton').prop('disabled', false);
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
<?php
        } else
            echo '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  No Student Found!!!</div>';
    } else
        echo "0";
}
        //Student fee End