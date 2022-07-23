<?php
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "config.php";
    include "db_class.php";
    // Setting Time Zone in India Standard Timing
    $random_number = rand(111111,999999); // Random Number
    $s_no = 1; //Serial Number
    $visible = md5("visible");
    $trash = md5("trash");
	date_default_timezone_set("Asia/Calcutta");
    $date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
    //All File Directries Start
    $university_logos_dir = "../images/university_logos";
    $admission_profile_image_dir = "images/student_images";
	$certificates = "images/student_certificates";
    //Creating Object NSUNIV
    $objectDefault = new DBEVAL();
    $objectDefault->sql = "";
    $objectDefault->hostName = "";
    $objectDefault->userName = "";
    $objectDefault->password = "";
    $objectDefault->dbName =   "";
    $objectDefault->new_db("localhost", "root", "", "nsucms_demo_nsuniv");
    //Creating Object NSUCMS
    $objectSecond = new DBEVAL();
    $objectSecond->sql = "";
    $objectSecond->hostName = "";
    $objectSecond->userName = "";
    $objectSecond->password = "";
    $objectSecond->dbName =   "";
    $objectSecond->new_db("localhost", "root", "", "nsucms_cms");
    //All File Directries End
    if(isset($_GET["action"])){
    //Action Section Start
        //  fee Calculations Details start
        if($_GET["action"] == "completeCalculationForFees"){
            $completeCalculationArray = array();
            $totalAmountArry = array();
            $totalPerticularArry = array();
            $completeCalculation = "";
            $paid_perticular_amount = 0;
            $remaining_perticular_amount = 0;
            $fine_perticular_amount = 0;
            $total_perticular_amount = 0;
            $total_paid_perticular_amount = 0;
            $total_remaining_perticular_amount = 0;
            $total_fine_perticular_amount = 0;
            $total_total_perticular_amount = 0;
            $particular_paid_amount = 0;
            $fine_amount = 0;
            $rebate_amount = 0;
            $total_amount = 0;
            $remaining_amount = 0;
            $last_fine = 0;
            $errorMessage = "";
            $registrationNumber = $_POST["registrationNumber"];
            $academicYear = $_POST["academicYear"];
            $courseId = $_POST["courseId"];
            $hostelCheck = $_POST["hostelCheck"];
            $paymentDate = $_POST["paymentDate"];
            $sql_paid = "SELECT * FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' && `student_id` = '$registrationNumber' && `university_details_id` = '$academicYear'
                        ";
            $result_paid = $con->query($sql_paid);
            while($row_paid = $result_paid->fetch_assoc()){
                $last_balance = $row_paid["balance"];
                $last_fine = intval($row_paid["fine"]);
                $amountsPaid = explode(",",$row_paid["paid_amount"]);
                $totalPerticularArry = explode(",",$row_paid["particular_id"]);
                $totalAmountVal = 0;
                for($i=0; $i<count($amountsPaid); $i++){
                    if(!isset($totalAmountArry[$i]) && empty($totalAmountArry[$i]))
                        $totalAmountArry[$i] = 0;
                    $totalAmountArry[$i] = $totalAmountArry[$i] + intval($amountsPaid[$i]);
                }
                if($last_balance == 0)
                    $submitClose = "";
            }
            $sql_fee = "SELECT * FROM `tbl_fee`
                        WHERE `status` = '$visible' && `course_id` = '$courseId' && `fee_academic_year` = '$academicYear'
                       ";
            $result_fee = $con->query($sql_fee);
            $sno = 0;
            $Idno = 0;
            $total_fees = 0;
            $total_paid = 0;
            $total_remaining = 0;
            $total_fine = 0;
            while($row_fee = $result_fee->fetch_assoc()){
                $fee_perticular = 0;
                if(strtolower($hostelCheck) == "yes"){
                    $sno++;
                    $total_fees = $total_fees + $row_fee["fee_amount"];
                    $fine_perticular_amountArray[$Idno] = 0;
                    $total_perticular_amountArray[$Idno] = 0;
                    if(isset($totalAmountArry[$Idno])){ 
                        $total_paid = $total_paid + $totalAmountArry[$Idno];
                        if($totalAmountArry[$Idno] == $row_fee["fee_amount"]){
                            $total_fine = $total_fine + 0;
                            $fee_perticular = 0;
                            $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                            $total_perticular_amountArray[$Idno] = $fee_perticular; 
                        } else{
                            $beforeDate = date($row_fee["fee_lastdate"]);
                            if( $paymentDate > $beforeDate){
                                if($row_fee["fee_astatus"] == "Active"){
                                    $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                    $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fine_perticular_amountArray[$Idno] = $fee_perticular;  
                                }   
                            }
                            $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular - $totalAmountArry[$Idno]); 
                        }
                    } else{ 
                        $beforeDate = date($row_fee["fee_lastdate"]);
                        if( $paymentDate > $beforeDate){
                            if($row_fee["fee_astatus"] == "Active"){
                                $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                            }
                        }
                        $total_perticular_amountArray[$Idno] = $fee_perticular + $row_fee["fee_amount"];
                    } 
                    $Idno++; 
                }   
                else{
                    if(strtolower($row_fee["fee_particulars"]) != "hostel fee"){
                        $sno++;
                        $total_fees = $total_fees + $row_fee["fee_amount"];
                        $fine_perticular_amountArray[$Idno] = 0;
                        if(isset($totalAmountArry[$Idno])){ 
                            $total_paid = $total_paid + $totalAmountArry[$Idno];
                            if($totalAmountArry[$Idno] == $row_fee["fee_amount"]){
                                $total_fine = $total_fine + 0;
                                $fee_perticular = 0;
                                $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                $total_perticular_amountArray[$Idno] = $fee_perticular; 
                            } else{
                                $beforeDate = date($row_fee["fee_lastdate"]);
                                if( $paymentDate > $beforeDate){
                                    if($row_fee["fee_astatus"] == "Active"){
                                        $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                        $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                        $fee_perticular = $numberOfDays * intval($row_fee["fee_fine"]);
                                        $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                        $total_perticular_amountArray[$Idno] = $fee_perticular + $totalAmountArry[$Idno]; 
                                    }
                                }
                                $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular - $totalAmountArry[$Idno]); 
                            }
                        } else{ 
                            $beforeDate = date($row_fee["fee_lastdate"]);
                            if( $paymentDate > $beforeDate){
                                if($row_fee["fee_astatus"] == "Active"){
                                    $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                    $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                }
                                    
                            }
                            $total_perticular_amountArray[$Idno] = $fee_perticular + $row_fee["fee_amount"]; 
                        }
                        $Idno++;
                    }
                } 
            }
            $total_remaining = $total_fine + ($total_fees-$total_paid);
            
            if(!empty($_POST["fine_amount"]))
                $fine_amount = $_POST["fine_amount"];
            if(!empty($_POST["rebate_amount"]))
                $rebate_amount = $_POST["rebate_amount"];
            for($i=0; $i<count($_POST["particular_paid_amount"]); $i++)
            {
                if(!empty($_POST["particular_paid_amount"][$i]))
                    $total_amount = $total_amount + intval($_POST["particular_paid_amount"][$i]);
            }
            //Total Amount With Fee
            $total_amount = $total_amount + $fine_amount;
            //Total Amount With Rebate
//            $total_amount = $total_amount - $rebate_amount;
            //Remaining Total
            $remaining_amount = $total_remaining - $total_amount;
            //Remaining Total Amount With Rebate
            $remaining_amount = $remaining_amount - $rebate_amount;
            //Fine Arrays
            $fine_perticular_amount = implode("|", $fine_perticular_amountArray);
            $total_perticular_amount = implode("|", $total_perticular_amountArray);
            //Set Negative Error
            if($total_amount<0 || $remaining_amount<0 || $fine_perticular_amount<0)
                $errorMessage .= " Connot Use Negative Values.";
            if($total_amount>$total_remaining)
                $errorMessage .= " Your total amount Should be less than or equal to ~ $total_remaining.";
            //Complete Calculation
            $completeCalculationArray[] = $total_remaining;
            $completeCalculationArray[] = $total_amount;
            $completeCalculationArray[] = $remaining_amount;
            $completeCalculationArray[] = $fine_perticular_amount;
            $completeCalculationArray[] = $total_perticular_amount;
            $completeCalculationArray[] = $errorMessage;
            //Implode all the Calculations
            $completeCalculation = implode(",", $completeCalculationArray);
            echo $completeCalculation;
        }
        // fee Calculations Details End
        /* ------------------------------------------------ Fee Payment End ------------------------------------------------------- */
    //Action Section End   
    }
?>