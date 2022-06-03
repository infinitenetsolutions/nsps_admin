<?php
    // Create connection
    include "include/config.php";
    include "include/PHPExcel/PHPExcel.php";
    if(isset($_POST["startDate"])){
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $totalIncome = intval($_POST["totalIncome"]);
        $totalExpence = intval($_POST["totalExpence"]);
        $hereIncome = 0;
        $hereExpence = 0;
        $openingBalance = 0;
        $closingBalance = 0;
        $particularName = "";
        $begin = new DateTime(date("Y-m-d", strtotime($startDate)));
        $end = new DateTime(date("Y-m-d", strtotime($endDate)));
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $completeInfo = array();
        $leftDates = array();
        $income = "SELECT * FROM `tbl_income` WHERE `post_at` >= '".date("Y-m-d", strtotime($startDate))."' && `post_at` <= '".date("Y-m-d", strtotime($endDate))."'";
        $expence = "SELECT * FROM `tbl_expenses` WHERE `payment_date` >= '".date("Y-m-d", strtotime($startDate))."' && `payment_date` <= '".date("Y-m-d", strtotime($endDate))."'";
        $incomeGetPrevious = "SELECT SUM(`amount`) AS sumIncome FROM `tbl_income` WHERE `post_at` < '".date("Y-m-d", strtotime($startDate))."'";
        $expenceGetPrevious = "SELECT SUM(`amount`) AS sumExpence FROM `tbl_expenses` WHERE `payment_date` < '".date("Y-m-d", strtotime($startDate))."'";
        $preIncomeResult = $con->query($incomeGetPrevious);
        $preIncomeRow = $preIncomeResult->fetch_assoc();
        $preIncome = $preIncomeRow["sumIncome"];
        $preExpenceResult = $con->query($expenceGetPrevious);
        $preExpenceRow = $preExpenceResult->fetch_assoc();
        $preExpence = $preExpenceRow["sumExpence"];
        $openingBalance = $preIncome - $preExpence;
        $incomeResult = $con->query($income);
        $expenceResult = $con->query($expence);
        if(date("Y-m-d", strtotime($startDate)) == date("Y-m-d", strtotime($endDate))){
            $completeInfo = array(date("Y-m-d", strtotime($startDate)) => array());
        } else{
            foreach($period as $allDates){
                array_push($completeInfo[$allDates->format("Y-m-d")]);
                $completeInfo[$allDates->format("Y-m-d")] = array();
            }
            $completeInfo[date("Y-m-d", strtotime($endDate))] = array();
        }
        if ($incomeResult->num_rows > 0) {
            while($incomeRow = $incomeResult->fetch_assoc()) {
                if(strpos(strtolower(str_replace(" ", "", $incomeRow["reg_no"])), "extraincome") !== false){
                    $particularName = $incomeRow["particulars"]." from ".ucwords(str_replace(")", "", str_replace("(", "", str_replace("extra income", "", strtolower($incomeRow["reg_no"])))));
                } elseif(strpos(strtolower(str_replace(" ", "", $incomeRow["particulars"])), "prospectus") !== false){
                    $prospectus = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '".str_replace("(form no)", "", strtolower($incomeRow["reg_no"]))."'";
                    $prospectusResult = $con->query($prospectus);
                    if ($prospectusResult->num_rows > 0) {
                        $prospectusRow = $prospectusResult->fetch_assoc();
                        $particularName = $incomeRow["particulars"]." from ".ucwords(strtolower($prospectusRow["prospectus_applicant_name"]));
                    } else
                        $particularName = $incomeRow["particulars"];
                } else{
                    $admission = "SELECT * FROM `tbl_admission` WHERE `admission_id` = '".str_replace("(reg no)", "", strtolower($incomeRow["reg_no"]))."'";
                    $admissionResult = $con->query($admission);
                    if ($admissionResult->num_rows > 0) {
                        $admissionRow = $admissionResult->fetch_assoc();
                        $particularName = $incomeRow["particulars"]." from ".ucwords(strtolower($admissionRow["admission_first_name"]." ".$admissionRow["admission_middle_name"]." ".$admissionRow["admission_last_name"]));
                    } else
                        $particularName = $incomeRow["particulars"];
                }
                
                $infoNow = "";
                $infoNow = array(
                                "type"                  =>      "income",
                                "incomeParticular"      =>      $particularName,
                                "recieptsCash"          =>      str_replace(".0", "", $incomeRow["amount"]),
                                "bankDeposit"           =>      "",
                            );
                array_push($completeInfo[date("Y-m-d", strtotime($incomeRow["post_at"]))], $infoNow);
            }
        }
        if ($expenceResult->num_rows > 0) {
            while($expenceRow = $expenceResult->fetch_assoc()) {
                $particularForExpence = "";
                if($expenceRow["paid_to"] == "")
                    $particularForExpence = $expenceRow["particulars"];
                else
                    $particularForExpence = $expenceRow["particulars"]." to ".$expenceRow["paid_to"];
                $infoNow = "";
                $infoNow = array(
                                "type"                  =>      "expence",
                                "expenceParticular"     =>      $particularForExpence,
                                "paymentsCash"          =>      $expenceRow["amount"],
                                "bankWithdrawals"       =>      "",
                            );
                array_push($completeInfo[date("Y-m-d", strtotime($expenceRow["payment_date"]))], $infoNow);
            }
        }
        // echo "<pre>";
        // print_r($completeInfo);
        //Set Filename
        if($startDate == $endDate)
            $fileName = "Balance-Sheet-".date('d-m-Y', strtotime($startDate)).".xlsx";
        else
            $fileName = "Balance-Sheet-From-".date('d-m-Y', strtotime($startDate))."-To-".date('d-m-Y', strtotime($endDate)).".xlsx";
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
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:J2');
        // $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('B2:J2')->setRowHeight(100);
        // $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(100);
        // $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(2)->setRowHeight(50);
        if($startDate == $endDate)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Balance Sheet ($startDate)");
        else
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Balance Sheet ($startDate to $endDate)");
        // cellColor('B2', '8A0410');
        cellColor('B2', '0000FF');
        fontColor('B2', 'FFFFFF', '18', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('B2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2:J2')->applyFromArray($thinBorder);
        
        //Setting Header --------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Date");
        fontColor('B4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Particulars");
        fontColor('C4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Receipts");
        fontColor('D4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Bank Deposit");
        fontColor('E4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Date");
        fontColor('F4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Particulars");
        fontColor('G4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Payments");
        fontColor('H4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Bank Withdrawals");
        fontColor('I4', 'FF0000', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        // Data Section Start
        // ----------------------------------------------------------------
        $inc = 5;
        foreach($completeInfo as $completeInfoDate => $completeInfoEach){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$inc, date('d-m-Y', strtotime($completeInfoDate)))
                    ->setCellValue('F'.$inc, date('d-m-Y', strtotime($completeInfoDate)))
                    ->setCellValue('C'.$inc, "Opening Balance");
                $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D'.$inc, $openingBalance);
                fontColor('D'.$inc, '0000FF', '12', '', true);
                fontColor('B'.$inc, '000000', '12', '', true);
                fontColor('F'.$inc, '000000', '12', '', true);
                fontColor('C'.$inc, '0000FF', '12', '', true);
                $countExpence = $inc;
                $countIncome = $inc;
                $totalIncome = 0;
                $totalExpense = 0;
                foreach($completeInfoEach as $completeInfoEachVal){
                    if($completeInfoEachVal["type"] == "income"){
                        $countIncome++;
                        $totalIncome = $totalIncome + $completeInfoEachVal["recieptsCash"];
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('C'.$countIncome, $completeInfoEachVal["incomeParticular"])
                            ->setCellValue('D'.$countIncome, $completeInfoEachVal["recieptsCash"])
                            ->setCellValue('E'.$countIncome, $completeInfoEachVal["bankDeposit"]);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$countIncome)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        fontColor('D'.$countIncome, '000000', '12', '', true);
                    } elseif($completeInfoEachVal["type"] == "expence"){
                        $countExpence++;
                        $totalExpense = $totalExpense + $completeInfoEachVal["paymentsCash"];
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('G'.$countExpence, $completeInfoEachVal["expenceParticular"])
                            ->setCellValue('H'.$countExpence, $completeInfoEachVal["paymentsCash"])
                            ->setCellValue('I'.$countExpence, $completeInfoEachVal["bankWithdrawals"]);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$countExpence)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        fontColor('H'.$countExpence, '000000', '12', '', true);
                    }
                }
                $closingBalance = $openingBalance + ($totalIncome - $totalExpense);
                $openingBalance = $closingBalance;
                if($countIncome > $countExpence)
                    $inc = $countIncome;
                else
                    $inc = $countExpence;
                $inc++;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G'.$inc, "Closing Balance")
                    ->setCellValue('H'.$inc, $closingBalance);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                fontColor('G'.$inc, '0000FF', '12', '', true);
                fontColor('H'.$inc, '0000FF', '12', '', true);
                
                $inc++;
        }
        // ----------------------------------------------------------------
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Last Closing - ".$closingBalance);
        fontColor('J4', '0000FF', '12', 'serif', true);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($thinBorder);
        // ----------------------------------------------------------------
        $objPHPExcel->getActiveSheet()->getStyle('B5:J'.--$inc)->applyFromArray($thinBorder);
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
        exit;
    }
?>