<?php
    // Create connection
    include "include/config.php";
    include "include/PHPExcel/PHPExcel.php";
    if(isset($_POST["action"]) && $_POST["action"] == "export_hostelfees_details"){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $visible = md5("visible");
        $regNo = "";
        $studentName = "";
        $fees_details_fee_particulars = "";
        $fees_details_fee_amount = "";
        $fees_details_fee_paid = "";
        $fees_details_fee_rebate = "";
        $fees_details_fee_fine = "";
        $fees_details_fee_balance = "";
        $fee_status = "";
        $fees_details = array();
        $dataArray = array();
        //Here The Code
      if($course_id == "all" && $academic_year == "all")
                                 $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                              
                            elseif($academic_year == "all")
                                $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_course_name` = '$course_id' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";//
                            elseif($course_id == "all")
                                 $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                            else
                                $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";

   $result = $con->query($sql);
                    if($result->num_rows > 0){
                        $s_no = 1;
                     while($row = $result->fetch_assoc()){


                $regNo = "";
                $studentName = "";
                $fees_details = array();
                $temp_all_array = array();
                 $sql_course = "SELECT * FROM `tbl_course`
                WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                ";
                $result_course = $con->query($sql_course);
                $row_course = $result_course->fetch_assoc();
                 $sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '".$row["admission_session"]."' ";
                                   $result_session = $con->query($sql_session);
                                   $row_session = $result_session->fetch_assoc();
                $regNo = $row["admission_id"];
                $studentName = $row["admission_first_name"]." ".$row["admission_middle_name"]." ".$row["admission_last_name"];
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
                //Checking If Hostel If Available Or Not
                $sqlTblFee = "SELECT *
                FROM `tbl_fee`
                WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `fee_particulars` ASC
                ";

                $resultTblFee = $con->query($sqlTblFee);
                if($resultTblFee->num_rows > 0)
                    while($rowTblFee = $resultTblFee->fetch_assoc()){
                        $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                        if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                            $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                        else
                            $noOfDays = 0;
                    if($rowTblFee["fee_astatus"] == "Active")
                            $fine_particular = $rowTblFee["fee_fine"];
                        else
                            $fine_particular = 0;
                        $completeArray = array(
                                            "fee_id" => $rowTblFee["fee_id"],
                                            "fee_particulars" => $rowTblFee["fee_particulars"],
                                            "fee_amount" => $rowTblFee["fee_amount"],
                                            "fee_paid" => 0,
                                            "fee_fine" => $fine_particular,
                                            "fee_rebate" => 0,
                                            "fee_remaining" => $rowTblFee["fee_amount"],
                                            "fee_fine_days" => $noOfDays
                                        );
                        array_push($arrayTblFee, $completeArray);
                    }
                $arrayTblFee = json_decode(json_encode($arrayTblFee));
                $sqlTblFeePaid = "SELECT *
                                 FROM `tbl_fee_paid`
                                 WHERE `status` = '$visible' AND `student_id` = '".$row["admission_id"]."' AND `payment_status` IN ('cleared', 'pending')
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
                                $tmpSNo = 1;
                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                if((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) == 0){
                                $totalRemainings = $totalRemainings + 0;
                                $totalRemaining = $totalRemaining + 0;
                                $totalFine = $totalFine + 0;
                                }
                                else{
                                $totalRemainings = $totalRemainings + (($arrayTblFeeUpdate->fee_remaining) + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)) - ($arrayTblFeeUpdate->fee_rebate));
                                $totalRemaining = $totalRemaining + (($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate));
                                $totalFine = $totalFine + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days));
                                }


                        $fees_details_fee_particulars = $arrayTblFeeUpdate->fee_particulars;
                        $fees_details_fee_amount = number_format($arrayTblFeeUpdate->fee_amount);
                        $fees_details_fee_paid = number_format($arrayTblFeeUpdate->fee_paid);
                        $fees_details_fee_rebate = number_format($arrayTblFeeUpdate->fee_rebate);
                        //****************************************************************************
                        //****************************************************************************
                        //****************************************************************************
                        if((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) == 0){
                            $fees_details_fee_fine = 0;
                            $fees_details_fee_balance = 0; 
                            $sqlTblFeeStatus = "SELECT *
                            FROM `tbl_fee_status`
                            WHERE `particular_id` = '".$arrayTblFeeUpdate->fee_id."' AND `admission_id` = '".$row["admission_id"]."' AND `course_id` = '".$row["admission_course_name"]."' AND `academic_year` = '".$row["admission_session"]."'
                            ";

                            
                            $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                            if($resultTblFeeStatus->num_rows > 0){
                                $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                                if(strtolower($rowTblFeeStatus["fee_status"]) == "dues"){
				                    $fee_status = "Dues";
								} else{
									$fee_status = "No Dues";
								}
							} else{
								$fee_status = "Dues";
							} 
                        } else{
                             $fees_details_fee_fine = number_format(($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days));
                             $fees_details_fee_balance = number_format(($arrayTblFeeUpdate->fee_remaining) + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)) - ($arrayTblFeeUpdate->fee_rebate));
                            $sqlTblFeeStatus = "SELECT *
                                                 FROM `tbl_fee_status`
                                                 WHERE `particular_id` = '".$arrayTblFeeUpdate->fee_id."' AND `admission_id` = '".$row["admission_id"]."' AND `course_id` = '".$row["admission_course_name"]."' AND `academic_year` = '".$row["admission_session"]."'
                                                 ";
                            $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                            if($resultTblFeeStatus->num_rows > 0){
                                $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                                if(strtolower($rowTblFeeStatus["fee_status"]) == "dues"){
                                    $fee_status = "Dues";
                                } else{
                                    $fee_status = "No Dues";
                                }
                            } else{
                                $fee_status = "Dues";
                            }
                        }
                        $temp_fee_array = array(
                                            "fee_s_no"              =>      $tmpSNo,  
                                            "particular_name"       =>      $fees_details_fee_particulars,  
                                            "amount"                =>      $fees_details_fee_amount,  
                                            "paid"                  =>      $fees_details_fee_paid,  
                                            "rebate"                =>      $fees_details_fee_rebate,  
                                            "fine"                  =>      $fees_details_fee_fine,  
                                            "balance"               =>      $fees_details_fee_balance,  
                                            "fee_status"            =>      $fee_status
                                        );
                        array_push($fees_details, $temp_fee_array);
                        $tmpSNo++;
                    }
                    $temp_all_array = array(
                                        "s_no"              =>      $s_no,
                                        "reg_no"            =>      $regNo,
                                        "student_name"      =>      $studentName,
                                        "fees_details"      =>      $fees_details
                                    );
                    array_push($dataArray, $temp_all_array);
                $s_no++;
            }
        } else{
            echo "Something Went Wrong, Please try again.";
            exit(0);
        }
        //Set Filename
        $fileName = "Hostel-Fee-List-Report-".date('d-m-Y').".xlsx";
        //Set BackGround
        function cellColor($cells, $color){
            global $objPHPExcel;
        
            $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                     'rgb' => $color
                )
            ));
        }
        //Set Color
        function fontColor($cells, $color, $size, $style, $bold){
            global $objPHPExcel;
        
            $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
                'font'  => array(
                    'bold'  => $bold,
                    'color' => array('rgb' => $color),
                    'size'  => $size,
                    'name'  => $style
                )
            ));
        }
        //Thin Border
        $thinBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        //Thick Border
        $thickBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Nsucms")
        							 ->setLastModifiedBy("Nsucms")
        							 ->setTitle("$fileName")
        							 ->setSubject("$fileName")
        							 ->setDescription("Here is your $fileName.")
        							 ->setKeywords("$fileName")
        							 ->setCategory("$fileName");
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);	
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);		
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);		
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);		
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:L2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Hostel Fee List Report");
//         cellColor('B2', 'FFC107');
        cellColor('B2', 'DC3545');
        fontColor('B2', 'FFFFFF', '16', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('B2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2:L2')->applyFromArray($thinBorder);
        
        //Setting Header --------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "S. No.");
        fontColor('B4', 'DC3545', '10', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Reg. No.");
        fontColor('C4', 'DC3545', '10', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Student Name");
        fontColor('D4', 'DC3545', '10', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:L4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Fees Details");
//         cellColor('B2', '8A0410');
        cellColor('E4', '17A2B8');
        fontColor('E4', 'FFFFFF', '16', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('E4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E4:L4')->applyFromArray($thinBorder);
        
    
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', "S. No.");
        fontColor('E5', '000000', '10', 'serif', true);
        cellColor('E5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', "Particular Name");
        fontColor('F5', '000000', '10', 'serif', true);
        cellColor('F5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "Amount");
        fontColor('G5', '000000', '10', 'serif', true);
        cellColor('G5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', "Paid");
        fontColor('H5', '000000', '10', 'serif', true);
        cellColor('H5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I5', "Rebate");
        fontColor('I5', '000000', '10', 'serif', true);
        cellColor('I5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J5', "Fine");
        fontColor('J5', '000000', '10', 'serif', true);
        cellColor('J5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K5', "Balance");
        fontColor('K5', '000000', '10', 'serif', true);
        cellColor('K5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K5')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L5', "Fee Status");
        fontColor('L5', '000000', '10', 'serif', true);
        cellColor('L5', 'FFC107');
        $objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L5')->applyFromArray($thinBorder);
        
        // ----------------------------------------------------------------
        // Data Section Start
        // ----------------------------------------------------------------
        $inc = 6;
        $dataArray = json_decode(json_encode($dataArray));
        $grandTotalPaid = 0;
		$grandTotalRebate = 0;
		$grandTotalFine = 0;
		$grandTotalBalance = 0;
        foreach($dataArray as $completeInfoEach){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$inc, $completeInfoEach->s_no.". ")
                    ->setCellValue('C'.$inc, $completeInfoEach->reg_no)
                    ->setCellValue('D'.$inc, $completeInfoEach->student_name);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                fontColor('B'.$inc, '000000', '12', '', true);
                fontColor('C'.$inc, '000000', '12', '', true);
                fontColor('D'.$inc, '17A2B8', '12', '', true);
                $tempInc = $inc;
                foreach($completeInfoEach->fees_details as $completeInfoEachDetails){
                	$grandTotalPaid = $grandTotalPaid + intval(str_replace(",", "", $completeInfoEachDetails->paid));
					$grandTotalRebate = $grandTotalRebate + intval(str_replace(",", "", $completeInfoEachDetails->rebate));
					$grandTotalFine = $grandTotalFine + intval(str_replace(",", "", $completeInfoEachDetails->fine));
					$grandTotalBalance = $grandTotalBalance + intval(str_replace(",", "", $completeInfoEachDetails->balance));
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E'.$tempInc, $completeInfoEachDetails->fee_s_no.". ")
                        ->setCellValue('F'.$tempInc, $completeInfoEachDetails->particular_name)
                        ->setCellValue('G'.$tempInc, $completeInfoEachDetails->amount)
                        ->setCellValue('H'.$tempInc, $completeInfoEachDetails->paid)
                        ->setCellValue('I'.$tempInc, $completeInfoEachDetails->rebate)
                        ->setCellValue('J'.$tempInc, $completeInfoEachDetails->fine)
                        ->setCellValue('K'.$tempInc, $completeInfoEachDetails->balance)
                        ->setCellValue('L'.$tempInc, $completeInfoEachDetails->fee_status);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$tempInc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    fontColor('E'.$tempInc, '000000', '12', '', true);
                    fontColor('F'.$tempInc, '17A2B8', '12', '', true);  
                    fontColor('G'.$tempInc, '000000', '12', '', true);
                    fontColor('H'.$tempInc, 'DC3545', '12', '', true);
                    fontColor('I'.$tempInc, '000000', '12', '', true);
                    fontColor('J'.$tempInc, '000000', '12', '', true);
                    fontColor('K'.$tempInc, 'DC3545', '12', '', true);
                    fontColor('L'.$tempInc, 'FFFFFF', '12', '', true);
                    if($completeInfoEachDetails->fee_status == "Dues")
                        cellColor('L'.$tempInc, 'DC3545');
                    else
                        cellColor('L'.$tempInc, '28A745');
                    $tempInc++;
                }    
                // ----------------------------------------------------------------
                $objPHPExcel->getActiveSheet()->getStyle('E'.$inc.':L'.--$tempInc)->applyFromArray($thinBorder);
                // ----------------------------------------------------------------
                $inc = $tempInc;
                $inc++;
                $inc++;
        }
        // --$inc;
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G'.$inc, "Total")
                    ->setCellValue('H'.$inc, number_format($grandTotalPaid))
                    ->setCellValue('I'.$inc, number_format($grandTotalRebate))
                    ->setCellValue('J'.$inc, number_format($grandTotalFine))
                    ->setCellValue('K'.$inc, number_format($grandTotalBalance));
        $objPHPExcel->getActiveSheet()->getStyle('G'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        fontColor('G'.$inc, '000000', '12', '', true);
        fontColor('H'.$inc, '000000', '12', '', true);
        fontColor('I'.$inc, '000000', '12', '', true);
        fontColor('J'.$inc, '000000', '12', '', true);
        fontColor('K'.$inc, '000000', '12', '', true);
        ++$inc;
        // ----------------------------------------------------------------
        $objPHPExcel->getActiveSheet()->getStyle('B5:L'.--$inc)->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        // Data Section End
        // ----------------------------------------------------------------
        // Rename worksheet
        // $objPHPExcel->getActiveSheet()->setTitle("$fileName");
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit(0);
    }
?>