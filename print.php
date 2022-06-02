<?php
$page_no = "7";
$page_no_inside = "7_13";
session_start();
//include "include/authentication.php";
include "include/config.php";
?>
<?php
$url = $_SERVER['HTTP_REFERER'];
$visible = md5('visible');
if (isset($_POST["paidId"])) {
    $paidId = $_POST["paidId"];
    $branch_id = $_SESSION['admin_branch'];

    $sql = "SELECT * FROM `tbl_fee_paid`
    INNER JOIN `tbl_student` ON `tbl_fee_paid`.`student_id` = `tbl_student`.`student_id`
    INNER JOIN `tbl_university_details` ON `tbl_fee_paid`.`university_details_id` = `tbl_university_details`.`university_details_id`
    INNER JOIN `tbl_class` ON `tbl_fee_paid`.`course_id` = `tbl_class`.`course_id`
    WHERE `tbl_fee_paid`.`status` = '$visible' && `tbl_fee_paid`.`feepaid_id` = '$paidId'  && `tbl_fee_paid`.`branch_id`='$branch_id'
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
    // if (strtolower($row["admission_hostel"]) == "yes")
    $branch_id = $_SESSION['admin_branch'];

    $sqlTblFee = "SELECT * FROM `tbl_fee`
                     WHERE `status` = '$visible' AND `class` = '" . $row["course_id"] . "' AND `section` = '" . $row["section_id"] . "' AND `fee_academic_year` = '" . $row["university_details_id"] . "'   ORDER BY `particular` ASC
                     ";
    // else
    //     $sqlTblFee = "SELECT *  FROM `tbl_fee`
    //                  WHERE `status` = '$visible' AND `course_id` = '" . $row["admission_course_name"] . "' AND `fee_academic_year` = '" . $row["admission_session"] . "' AND `particular` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `particular` ASC
    //                  ";
    $resultTblFee = $con->query($sqlTblFee);
    if ($resultTblFee->num_rows > 0) {
        while ($rowTblFee = $resultTblFee->fetch_assoc()) {
            $totalFee = $totalFee + intval($rowTblFee["fee"]);
            if (strtotime(date($rowTblFee["last_date"])) < strtotime(date("Y-m-d"))) {
                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["last_date"]))) / 60 / 60 / 24;
            } else {
                $noOfDays = 0;
            }

            $completeArray = array(
                "id" => $rowTblFee["id"],
                "particular" => $rowTblFee["particular"],
                "fee" => $rowTblFee["fee"],
                "fee_paid" => 0,
                "fine_amount" => $rowTblFee["fine_amount"],
                "fee_rebate" => 0,
                "fee_remaining" => $rowTblFee["fee"],
                "fee_fine_days" => $noOfDays,
            );
            array_push($arrayTblFee, $completeArray);
        }
    } else {

        echo '<script> window.location.replace("' . $url . '") </script>';
    }

    $arrayTblFee = json_decode(json_encode($arrayTblFee));
    $arrayPaidId = explode(",", $row["particular_id"]);
    $arrayPaidAmount = explode(",", $row["paid_amount"]);
    for ($i = 0; $i < count($arrayPaidId); $i++) {
        foreach ($arrayTblFee as $arrayTblFeeUpdate) {
            if ($arrayTblFeeUpdate->id == $arrayPaidId[$i]) {
                $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                if ($row["rebate_amount"] != "") {
                    $arrayRebateAmount = explode(",", $row["rebate_amount"]);
                    if ($arrayTblFeeUpdate->id == intval($arrayRebateAmount[1])) {
                        $rebateOn = $arrayTblFeeUpdate->particular;
                        $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                        $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                    }
                }
                $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
            }
        }
    }
    if ($row["fine"] != "") {
        $fineAmount = $row["fine"];
    } else {
        $fineAmount = 0;
    }

    if (!empty($row["extra_fine"])) {
        $show_extra = explode("|separator|", $row["extra_fine"]);
        $fineAmount = intval($fineAmount) + intval($show_extra[0]);
    }
?>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="description" content="School Management 	" />
        <meta name="keywords" content="School Management   " />
        <title> NETAJI SUBHAS PUBLIC SCHOOL: Fee Payment</title>
        <!--<style media="print">-->
        <!-- @page {-->
        <!--  size: auto;-->
        <!--  margin: 0;-->
        <!--	   }-->
        <!--</style>-->
        <style type="text/css">
            .bgcolor_02 {
                background-color: #4DC8EE;
                border: 0 #f1f3f4;
                color: #000000;
                font-family: Tahoma;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
            }

            @font-face {
                font-family: Belwec;
                src: url('includes/fonts/Belwec.ttf');
            }

            .narmal {
                font-family: tahoma;
                padding: 2px;
                font-size: 12px;
                font-weight: normal;
                text-decoration: none;
                color: #000000;
            }

            txt_01 {
                font-family: verdaba;
                font-size: 14px;
                font-weight: 400;
            }

            .style1 {
                font-size: 22px;
                /*font-family: Verdana, Arial, Helvetica, sans-serif;*/
                font-family: Belwec;
                font-weight: bold;
                text-transform: uppercase;

            }

            .style2 {
                font-family: Verdana, Arial, Helvetica, sans-serif
            }

            .style3 {
                font-size: 11px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            .style4 {
                font-size: 12px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }

            .style5 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }

            .border1 {
                border-bottom: #4DC8EE;
                border-top: #4DC8EE;
            }

            .admin {
                font-family: tahoma;
                font-size: 14px;
                font-weight: bold;
                color: #333333;
                text-decoration: none;
            }

            .bgcolor_2 {
                background-color: #4DC8EE;
                color: #333333;
                text-align: left;
                font-weight: normal;
                font-family: Tahoma;
                font-size: 12px;
                text-decoration: none;
            }

            .text-lowercase {
                text-transform: lowercase;
            }
        </style>
        <script type="text/javascript">
            function PrintDiv() {
                var divToPrint = document.getElementById('divToPrint');
                var popupWin = window.open('', '_blank', 'width=300,height=300');
                popupWin.document.open();
                popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                popupWin.document.close();
            }
        </script>

    <body class="body_pop">
        <p style="position: fixed;right: 3%;">
            <a href="" id="printbutton" value="&nbsp;Print" onclick="return printing();"><img src="images/print.jpg" style="height: 80px;"></a>
        </p>
        <div id="divToPrint">
            <table width="645" align="center" class="tb2_grid" style=" border: 2px solid #4DC8EE;border-color: #4dc8ee !important;">
                <!--<p style="position: fixed;right: 3%;">
	<a href="" id="printbutton" value="&nbsp;Print" onclick="return printing();"><img src="images/print.jpg" style="height: 80px;" ></a>
	</p>-->
                <tr>
                    <td width="635">
                        <table width="100%" border="0" style="margin-top:12px;">
                            <tr>
                                <td align="right" valign="top" colspan="3">
                                    <table width="100%" border="0" style="border-color: #4dc8ee !important;">
                                        <!--<tr>
                                    <td colspan="2" align="center" valign="top">&nbsp;</td>
                                </tr>-->
                                        <tr>
                                            <td width="8%" rowspan="4" align="center" valign="top"><img src="images/nsu_logo_edit.png" class="logo" alt="Image" border="0" title="Images">&nbsp;</td>
                                            <td width="92%" align="center" valign="top"><span class="style1 " style="font-size:30px;"><?= $row['university_details_university_name'] ?></span></td>
                                        </tr>
                                        <tr style="font-size: 13px;">
                                            <td align="center" valign="top" style="padding-bottom: 25px; margin-top:-20px;  text-transform: uppercase; "><strong><?= $row['university_details_address'] ?> Ph.- <?= $row['university_details_contact'] ?> <br> <span class="text-lowercase"> Website : <?= $row['university_details_website_url']; ?> </span> </strong>
                                            <td>
                                        </tr>

                                        <tr>
                                            <td align="center" valign="top"></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" align="center" valign="top" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px;"><strong></strong></td>
                                        </tr>

                                    </table>
                            </tr>
                            <tr>
                                <td height="93" colspan="3">




                                    <script type="text/JavaScript">
                                        function validatecls(){
								if (document.getElementById('classid_t').value ==""){
									alert("Please Select Class");
									return false;
								}
							    }

								function newWindowOpen(href){

									window.open(href,null, 'width=900,height=900,scrollbars=yes,toolbar=no,directories=no,status=no,menubar=yes,left=140,top=30');
								}

							</script>
                                    <script type="text/javascript">
                                        function popup_letter(url) {
                                            var width = 700;
                                            var height = 500;
                                            var left = (screen.width - width) / 2;
                                            var top = (screen.height - height) / 2;
                                            var params = 'width=' + width + ', height=' + height;
                                            params += ', top=' + top + ', left=' + left;
                                            params += ', directories=no';
                                            params += ', location=no';
                                            params += ', menubar=no';
                                            params += ', resizable=no';
                                            params += ', scrollbars=yes';
                                            params += ', status=no';
                                            params += ', toolbar=no';
                                            newwin = window.open(url, 'windowname5', params);
                                            if (window.focus) {
                                                newwin.focus()
                                            }
                                            return false;
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        function GetXmlHttpObject(handler) {
                                            var objXmlHttp = null

                                            if (navigator.userAgent.indexOf("Opera") >= 0) {
                                                alert("This Site doesn't work in Opera")
                                                return
                                            }
                                            if (navigator.userAgent.indexOf("MSIE") >= 0) {
                                                var strName = "Msxml2.XMLHTTP"
                                                if (navigator.appVersion.indexOf("MSIE 5.5") >= 0) {
                                                    strName = "Microsoft.XMLHTTP"
                                                }
                                                try {
                                                    objXmlHttp = new ActiveXObject(strName)
                                                    objXmlHttp.onreadystatechange = handler
                                                    return objXmlHttp
                                                } catch (e) {
                                                    alert("Error. Scripting for ActiveX might be disabled")
                                                    return
                                                }
                                            }
                                            if (navigator.userAgent.indexOf("Mozilla") >= 0) {
                                                objXmlHttp = new XMLHttpRequest()
                                                objXmlHttp.onload = handler
                                                objXmlHttp.onerror = handler
                                                return objXmlHttp
                                            }
                                        }



                                        function getAllName(nameval) {

                                            url = "?pid=55&action=getallname&namev=" + nameval;
                                            url = url + "&sid=" + Math.random();

                                            xmlHttpObj = GetXmlHttpObject(nameChanged);

                                            xmlHttpObj.open("GET", url, true);
                                            xmlHttpObj.send(null);
                                        }

                                        function nameChanged() {
                                            if (xmlHttpObj.readyState == 4 || xmlHttpObj.readyState == "complete") {

                                                document.getElementById("retname").innerHTML = xmlHttpObj.responseText;
                                            }
                                        }
                                    </script>

                                    <script>
                                        function cal(amount_fine) {
                                            //alert(amount_fine);
                                            var q = 0;
                                            for (p = 0; p < document.getElementsByTagName("input").length; p++) {
                                                if (document.getElementsByTagName("input")[p].type == "checkbox") {
                                                    q++;
                                                }
                                            }
                                            var sub_total = 0;
                                            var fine_total = 0;
                                            for (i = 0; i < q; i++) {
                                                m = "chek_" + i;
                                                if (document.getElementById(m).checked == true) {
                                                    a = 'amount_' + i;

                                                    value1 = document.getElementById(a).value;

                                                    if (isNaN(value1)) {
                                                        value1 = 0;
                                                        document.getElementById(a).value = '';
                                                        document.getElementById(m).checked = false;
                                                    }
                                                    if (amount_fine - 1 >= i) {

                                                        ab = 'fine_' + i;
                                                        var value2 = document.getElementById(ab).value;
                                                        if (isNaN(value2) || value2 == '') {
                                                            value2 = 0;
                                                            document.getElementById(ab).value = '';
                                                        }
                                                        var fine_total = parseFloat(fine_total) + parseFloat(value2);
                                                    }

                                                    var sub_total = parseFloat(sub_total) + parseFloat(value1);
                                                }

                                            }
                                            var total = parseFloat(sub_total) + parseFloat(fine_total);
                                            document.getElementById('fee_total').innerHTML = total;
                                            //alert('Total selected Amount is Rs: '+total);
                                        }
                                    </script>

                                    <script language="javascript" type="text/javascript">
                                        function selectone() {


                                            var el = document.getElementsByName('selfeetypecheck[]');

                                            FCD = document.getElementsByName('finecharged[]');
                                            FP = document.getElementsByName('finepaid[]');
                                            FD = document.getElementsByName('finededucted[]');

                                            var count = 0;



                                            for (i = 0; i < el.length; i++) {
                                                FCD1 = FCD[i].value;
                                                FP1 = FP[i].value;
                                                FD1 = FD[i].value;
                                                if (el[i].checked) {
                                                    count = 1;
                                                    if (FCD1 != "") {
                                                        TOT = 0;
                                                        TOT = Number(FP1) + Number(FD1);
                                                        if (FCD1 != TOT) {
                                                            alert("Fine charged should be equal to finepaid+deduction allowed");
                                                            return false;
                                                        }
                                                    } else {
                                                        continue;
                                                    }
                                                }


                                            }

                                            if (count == 0) {
                                                alert("Please check at least one !");
                                                return false;
                                            } else {
                                                return true;
                                            }

                                        }
                                    </script>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: -25px;" style="border-color: #4dc8ee !important;">
                                        <tr>
                                            <td height="3" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td height="25" colspan="3" class="bgcolor_02">&nbsp;&nbsp;<span class="admin">Money Receipt</span></td>
                                        </tr>
                                        <tr>
                                            <td width="1" class="bgcolor_02"></td>
                                            <td align="left" valign="top">
                                                <table width="100%">
                                                    <tr>
                                                        <td>

                                                            <table width="95%" border="0" cellspacing="2" cellpadding="0" align="center" style="border-color: #4dc8ee !important;">
                                                                <tr>

                                                                    <td align="left" class="narmal">Admission No. </td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["course_name"]; ?><?php echo date("y", strtotime($row['university_details_academic_start_date'])) ?><?php echo date("y", strtotime($row['university_details_academic_end_date'])); ?><?php
                                                                                                                                                                                                                                                                                                            $admission_id = 1;
                                                                                                                                                                                                                                                                                                            printf("%03d", $row['student_id']);
                                                                                                                                                                                                                                                                                                            ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="narmal">Registration No.</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["student_id"]; ?></td>
                                                                    <td align="left" class="narmal">Receipt No</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["receipt_no"]; ?> </td>

                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="narmal">Course</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo strtoupper($row["course_name"]); ?></td>
                                                                    <td align="left" class="narmal">Payment Date</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo date("d-m-Y", strtotime($row["receipt_date"])); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="narmal">Academic Session</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["academic_session"]; ?></td>


                                                                    <td align="left" class="narmal">Receipt Date</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"> <?php echo date("d-m-Y", strtotime($row["transaction_date"])); ?></td>

                                                                </tr>


                                                                <tr>
                                                                    <td align="left" class="narmal" width="31%">Student Name </td>
                                                                    <td align="left" class="narmal" width="1%">:</td>
                                                                    <td align="left" class="narmal" width="27%"><?php echo strtoupper($row["student_name"]); ?> </td>

                                                                    <td align="left" class="narmal">Bank Name</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["bank_name"]; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="narmal">Father/Guardian Name </td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo strtoupper($row["father_name"]); ?></td>
                                                                    <td align="left" class="narmal">NEFT/Cheque No</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["transaction_no"]; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <!-- <td align="left" class="narmal">Hostel</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php //echo strtoupper($row["admission_hostel"]);
                                                                                                    ?></td> -->


                                                                    <td align="left" class="narmal"> Cash Deposit To</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["cash_deposit_to"]; ?></td>

                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="narmal"> Notes</td>
                                                                    <td align="left" class="narmal">:</td>

                                                                    <td align="left" class="narmal"><?php echo $row["notes"]; ?></td>

                                                                    <td align="left" class="narmal">Payment Mode</td>
                                                                    <td align="left" class="narmal">:</td>
                                                                    <td align="left" class="narmal"><?php echo $row["payment_mode"]; ?></td>
                                                                </tr>


                                                            </table>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>
                                                                <tr>
                                                                    <td align="left" class="adminfont" colspan="7">&nbsp;<b>Fee Details for Course : <?php echo $row["course_name"]; ?></b> </td>
                                                                </tr>
                                                                <tr class="bgcolor_02" height="25">
                                                                    <td align="center" class="admin" width="14%">&nbsp;S No</td>
                                                                    <td align="center" class="admin" width="40%">Particulars</td>
                                                                    <td align="center" class="admin" width="17%">Total</td>
                                                                    <!--<td align="center" class="admin" width="29%">  Fee Type</td>-->
                                                                </tr>

                                                                <?php
                                                                $tmpSNo = 1;
                                                                foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                                ?>
                                                                    <tr>
                                                                        <td align="center" class="narmal"><?php echo $tmpSNo; ?></td>
                                                                        <td align="center" class="narmal"><?php echo strtoupper($arrayTblFeeUpdate->particular); ?></td>
                                                                        <td align="center" class="narmal"><span class="text-bold">Rs. <?php echo $arrayTblFeeUpdate->fee; ?>.00</span></td>
                                                                    </tr>
                                                                <?php
                                                                    $tmpSNo++;
                                                                }
                                                                ?>
                                                                <!-- TOTAL AMOUNT -->
                                                                <tr>
                                                                    <td align="center"></td>
                                                                    <td align="center">Total</td>
                                                                    <td align="center">Rs. <strong><?php echo $totalFee; ?>.00</strong></td>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>
                                                                <tr>
                                                                    <td align="left" class="adminfont" colspan="7" style="border-color: #4dc8ee !important;">&nbsp;<b>Total Fee Paid</b></td>
                                                                </tr>

                                                                <tr class="bgcolor_02" height="25">
                                                                    <td width="33%" align="center" valign="middle" class="admin">&nbsp;S.No.</td>
                                                                    <td width="37%" align="center" valign="middle" class="admin">Particulars</td>

                                                                    <td width="30%" align="center" valign="middle" class="admin">Amount (Paid)</td>
                                                                </tr>

                                                                <?php
                                                                $tmpSNo = 1;
                                                                foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                                    if ($arrayTblFeeUpdate->fee_paid != 0) {
                                                                ?>
                                                                        <tr>
                                                                            <td width="33%" align="center" valign="middle" class="admin"><?php echo $tmpSNo; ?></td>
                                                                            <td width="37%" align="right" valign="right" class="admin"><?php echo strtoupper($arrayTblFeeUpdate->particular); ?></td>
                                                                            <td width="30%" align="right" valign="right" class="admin"><span class="text-bold">Rs. <?php echo $arrayTblFeeUpdate->fee_paid; ?>.00</span></td>
                                                                        </tr>
                                                                <?php
                                                                        $tmpSNo++;
                                                                    }
                                                                }
                                                                ?>
                                                                <!-- TOTAL AMOUNT -->
                                                                <tr>
                                                                    <td align="right"></td>
                                                                    <td align="right">Total</td>
                                                                    <td align="right">Rs. <strong><?php echo $totalPaid; ?>.00</strong></td>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>
                                                                <tr>
                                                                    <td align="left" class="adminfont" colspan="7">&nbsp;<b>Summary</b> </td>
                                                                </tr>
                                                                <tr class="bgcolor_02" height="25">
                                                                    <!--	<td width="33%" align="center" valign="middle" class="admin">&nbsp;Total Amount(Fee+Hostel)</td> -->
                                                                    <!--<td width="30%" align="center" valign="middle" class="admin">REBATE ON</td>-->
                                                                    <td width="30%" align="center" valign="middle" class="admin">TOTAL PAID</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">REBATE AMOUNT</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">TOTAL FINE</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">BALANCE DUE</td>
                                                                </tr>

                                                                <tr height="25">
                                                                    <!-- <td width="30%" align="center" valign="middle" class="admin"><?php // echo $rebateOn;
                                                                                                                                        ?></td>-->
                                                                    <td width="30%" align="center" valign="middle" class="admin">Rs. <?php echo $totalPaid + $fineAmount; ?>.00</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">Rs. <?php echo $totalRebate; ?>.00</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">Rs. <?php echo $fineAmount ?>.00</td>
                                                                    <td width="30%" align="center" valign="middle" class="admin">Rs. <?php echo $row["balance"]; ?>.00</td>
                                                                </tr>

                                                                <tr height="70">
                                                                    <td align="left" colspan="6"></td>

                                                                </tr>
                                                                <tr height="25">
                                                                    <td align="right" colspan="6" style="padding-right:25px;" class="admin">Authorised Signatory</td>
                                                                </tr>
                                                                <tr height="25">
                                                                    <td align="left" colspan="6" style="padding-right:25px;" class="admin">Note:- Fee once paid will not be refunded and Please keep this slip for your reference</td>
                                                                </tr>


                                                            </table>
                                                        </td>

                                                    </tr>


                                                </table>



                                            </td>
                                            <td width="1" class="bgcolor_02"></td>
                                        </tr>
                                        <tr>
                                            <td width="1" class="bgcolor_02"></td>
                                            <td height="10">&nbsp;</td>
                                            <td width="1" class="bgcolor_02"></td>
                                        </tr>
                                        <tr>
                                            <td height="1" colspan="3" class="bgcolor_02"></td>
                                        </tr>
                                    </table>

                                    <style>
                                        .fee_card {
                                            font-family: Verdana, Arial, Helvetica, sans-serif;
                                            font-size: 9px;
                                        }
                                    </style>

                                </td>
                            </tr>

                            <!--<tr>-->
                            <!--     <td colspan="3" align="right"><input type="button" id="printbutton" value="&nbsp;Print" onclick="return printing();" class="bgcolor_02" /></td>-->
                            <!-- </tr>-->

                        </table>
                    </td>
                </tr>
                <script type="text/javaScript">
                    function printing(){
	  document.getElementById("printbutton").style.display = "none";
	  window.print();
	  window.close();
	 }

  </script>

            </table>
        </div>
    </body>

    </html>
<?php
} elseif (isset($_GET["studentId"])) {
    $studentRegistrationNo = $_GET["studentId"];
    $sql = "SELECT *
                FROM `tbl_student`
                INNER JOIN `tbl_university_details` ON `tbl_student`.`university_details_id` = `tbl_university_details`.`university_details_id`
                INNER JOIN `tbl_class` ON `tbl_student`.`course_id` = `tbl_class`.`course_id`
                WHERE `tbl_student`.`student_id` = '$studentRegistrationNo' && `tbl_student`.`status` = '$visible' && `tbl_class`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'
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
    //  if (strtolower($row["admission_hostel"]) == "yes")
    // $sqlTblFee = "SELECT *
    //                  FROM `tbl_fee`
    //                  WHERE `status` = '$visible' AND `course_id` = '" . $row["admission_course_name"] . "' AND `fee_academic_year` = '" . $row["admission_session"] . "' ORDER BY `particular` ASC
    //                  ";
    //else
    $sqlTblFee = "SELECT *
                         FROM `tbl_fee`
                         WHERE `status` = '$visible' AND `class` = '" . $row["course_id"] . "' AND `section` = '" . $row["section_id"] . "' AND `fee_academic_year` = '" . $row["university_details_id"] . "' AND `particular` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `particular` ASC
                         ";
    $resultTblFee = $con->query($sqlTblFee);
    if ($resultTblFee->num_rows > 0) {
        while ($rowTblFee = $resultTblFee->fetch_assoc()) {
            $totalFee = $totalFee + intval($rowTblFee["fee"]);
            if (strtotime(date($rowTblFee["last_date"])) < strtotime(date("Y-m-d"))) {
                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["last_date"]))) / 60 / 60 / 24;
            } else {
                $noOfDays = 0;
            }

            $completeArray = array(
                "id" => $rowTblFee["id"],
                "particular" => $rowTblFee["particular"],
                "fee" => $rowTblFee["fee"],
                "fee_paid" => 0,
                "fine_amount" => $rowTblFee["fine_amount"],
                "fee_rebate" => 0,
                "fee_remaining" => $rowTblFee["fee"],
                "fee_fine_days" => $noOfDays,
                "fee_paid_on" => "",
                "fee_receipt_date" => "",
                "fee_transaction_no" => "",
                "fee_bank_name" => "",
                "fee_balance" => "",
            );
            array_push($arrayTblFee, $completeArray);
        }
    }

    $arrayTblFee = json_decode(json_encode($arrayTblFee));
    $branch_id = $_SESSION['admin_branch'];

    $sqlTblFeePaid = "SELECT *
                         FROM `tbl_fee_paid`
                         WHERE `status` = '$visible' AND `branch_id`='$branch_id' AND `student_id` = '" . $studentRegistrationNo . "'  AND `payment_status` IN ('cleared', 'pending')
                         ";
    $resultTblFeePaid = $con->query($sqlTblFeePaid);
    if ($resultTblFeePaid->num_rows > 0) {
        while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {
            $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
            $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
            for ($i = 0; $i < count($arrayPaidId); $i++) {
                foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                    if ($arrayTblFeeUpdate->id == $arrayPaidId[$i]) {
                        $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                        if ($rowTblFeePaid["rebate_amount"] != "") {
                            $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                            if ($arrayTblFeeUpdate->id == intval($arrayRebateAmount[1])) {
                                $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                                $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                            }
                        }
                        $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                        $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
                        $arrayTblFeeUpdate->fee_paid_on = $rowTblFeePaid["paid_on"];
                        $arrayTblFeeUpdate->fee_receipt_date = $rowTblFeePaid["receipt_date"];
                        $arrayTblFeeUpdate->fee_transaction_no = $rowTblFeePaid["transaction_no"];
                        $arrayTblFeeUpdate->fee_bank_name = $rowTblFeePaid["bank_name"];
                        $arrayTblFeeUpdate->fee_balance = $rowTblFeePaid["balance"];
                    }
                }
            }
        }
    } else {

        echo '<script> window.location.replace("' . $url . '") </script>';
    }

?>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="description" content="School Management 	" />
        <meta name="keywords" content="School Management   " />
        <title> NETAJI SUBHAS PUBLIC SCHOOL : Fee Payment</title>
        <style type="text/css">
            .bgcolor_02 {
                background-color: #4DC8EE !important;
                border: 0 #4DC8EE;
                color: #000000;
                font-family: Tahoma;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
            }

            @font-face {
                font-family: Belwec;
                src: url('includes/fonts/Belwec.ttf');
            }

            .narmal {
                font-family: tahoma;
                padding: 2px;
                font-size: 14px;
                font-weight: normal;
                text-decoration: none;
                color: #000000;
            }

            txt_01 {
                font-family: verdaba;
                font-size: 14px;
                font-weight: 400;
            }

            .style1 {
                font-size: 22px;
                /*font-family: Verdana, Arial, Helvetica, sans-serif;*/
                font-family: Belwec;
                font-weight: bold;
            }

            .style2 {
                font-family: Verdana, Arial, Helvetica, sans-serif
            }

            .style3 {
                font-size: 11px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            .style4 {
                font-size: 12px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }

            .style5 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }

            .border1 {
                border-bottom: #4DC8EE !important;
                border-top: #4DC8EE !important;
            }

            .admin {
                font-family: tahoma;
                font-size: 14px;
                font-weight: bold;
                color: #333333;
                text-decoration: none;
            }

            .bgcolor_2 {
                background-color: #4DC8EE !important;
                color: #333333;
                text-align: left;
                font-weight: normal;
                font-family: Tahoma;
                font-size: 12px;
                text-decoration: none;
            }
        </style>

    <body class="body_pop">
        <table width="645" align="center" class="tb2_grid" style="border-color: #4dc8ee !important; border: 2px solid #4dc8ee;">
            <p style="position: fixed;right: 3%;">
                <a href="" id="printbutton" value="&nbsp;Print" onclick="return printing();"><img src="images/print.jpg" style="height: 80px;"></a>
            </p>
            <tr>
                <td width="635">
                    <table width="100%" border="0" style="border-color: #4dc8ee !important;margin-top:12px;">
                        <tr>
                            <td align="right" valign="top" colspan="3">
                                <table width="100%" border="0" style="border-color: #4dc8ee !important;">
                                    <!--<tr>
                                    <td colspan="2" align="center" valign="top">&nbsp;</td>
                                </tr>-->
                                    <tr>
                                        <td width="8%" rowspan="4" align="center" valign="top"><img src="images/nsu_logo_edit.png" class="logo" alt="Image" border="0" title="Images">&nbsp;</td>
                                        <td width="92%" align="center" valign="top"><span class="style1" style="font-size:30px;">NETAJI SUBHAS PUBLIC SCHOOL</span></td>
                                    </tr>
                                    <tr style="font-size: 13px;">
                                        <td align="center" valign="top" style="padding-bottom: 25px;"><strong>POKHARI, P.O : BHILAI PAHARI, P.S : M.G.M Dist : EAST SINGHBHUM,<br> JAMSHEDPUR - 831012 Jharkhand Ph. +91 9835203429 <br>Website : https://nsuniv.ac.in/</td>

                                    </tr>

                                    <tr>
                                        <td align="center" valign="top"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="center" valign="top" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px;"><strong></strong></td>
                                    </tr>

                                </table>
                        </tr>
                        <tr>
                            <td height="93" colspan="3">




                                <script type="text/JavaScript">
                                    function validatecls(){
		if (document.getElementById('classid_t').value ==""){
			alert("Please Select Class");
			return false;
		}
	}

	function newWindowOpen(href){

		window.open(href,null, 'width=900,height=900,scrollbars=yes,toolbar=no,directories=no,status=no,menubar=yes,left=140,top=30');
	}

</script>
                                <script type="text/javascript">
                                    function popup_letter(url) {
                                        var width = 700;
                                        var height = 500;
                                        var left = (screen.width - width) / 2;
                                        var top = (screen.height - height) / 2;
                                        var params = 'width=' + width + ', height=' + height;
                                        params += ', top=' + top + ', left=' + left;
                                        params += ', directories=no';
                                        params += ', location=no';
                                        params += ', menubar=no';
                                        params += ', resizable=no';
                                        params += ', scrollbars=yes';
                                        params += ', status=no';
                                        params += ', toolbar=no';
                                        newwin = window.open(url, 'windowname5', params);
                                        if (window.focus) {
                                            newwin.focus()
                                        }
                                        return false;
                                    }
                                </script>
                                <script type="text/javascript">
                                    function GetXmlHttpObject(handler) {
                                        var objXmlHttp = null

                                        if (navigator.userAgent.indexOf("Opera") >= 0) {
                                            alert("This Site doesn't work in Opera")
                                            return
                                        }
                                        if (navigator.userAgent.indexOf("MSIE") >= 0) {
                                            var strName = "Msxml2.XMLHTTP"
                                            if (navigator.appVersion.indexOf("MSIE 5.5") >= 0) {
                                                strName = "Microsoft.XMLHTTP"
                                            }
                                            try {
                                                objXmlHttp = new ActiveXObject(strName)
                                                objXmlHttp.onreadystatechange = handler
                                                return objXmlHttp
                                            } catch (e) {
                                                alert("Error. Scripting for ActiveX might be disabled")
                                                return
                                            }
                                        }
                                        if (navigator.userAgent.indexOf("Mozilla") >= 0) {
                                            objXmlHttp = new XMLHttpRequest()
                                            objXmlHttp.onload = handler
                                            objXmlHttp.onerror = handler
                                            return objXmlHttp
                                        }
                                    }



                                    function getAllName(nameval) {

                                        url = "?pid=55&action=getallname&namev=" + nameval;
                                        url = url + "&sid=" + Math.random();

                                        xmlHttpObj = GetXmlHttpObject(nameChanged);

                                        xmlHttpObj.open("GET", url, true);
                                        xmlHttpObj.send(null);
                                    }

                                    function nameChanged() {
                                        if (xmlHttpObj.readyState == 4 || xmlHttpObj.readyState == "complete") {

                                            document.getElementById("retname").innerHTML = xmlHttpObj.responseText;
                                        }
                                    }
                                </script>

                                <script>
                                    function cal(amount_fine) {
                                        //alert(amount_fine);
                                        var q = 0;
                                        for (p = 0; p < document.getElementsByTagName("input").length; p++) {
                                            if (document.getElementsByTagName("input")[p].type == "checkbox") {
                                                q++;
                                            }
                                        }
                                        var sub_total = 0;
                                        var fine_total = 0;
                                        for (i = 0; i < q; i++) {
                                            m = "chek_" + i;
                                            if (document.getElementById(m).checked == true) {
                                                a = 'amount_' + i;

                                                value1 = document.getElementById(a).value;

                                                if (isNaN(value1)) {
                                                    value1 = 0;
                                                    document.getElementById(a).value = '';
                                                    document.getElementById(m).checked = false;
                                                }
                                                if (amount_fine - 1 >= i) {

                                                    ab = 'fine_' + i;
                                                    var value2 = document.getElementById(ab).value;
                                                    if (isNaN(value2) || value2 == '') {
                                                        value2 = 0;
                                                        document.getElementById(ab).value = '';
                                                    }
                                                    var fine_total = parseFloat(fine_total) + parseFloat(value2);
                                                }

                                                var sub_total = parseFloat(sub_total) + parseFloat(value1);
                                            }

                                        }
                                        var total = parseFloat(sub_total) + parseFloat(fine_total);
                                        document.getElementById('fee_total').innerHTML = total;
                                        //alert('Total selected Amount is Rs: '+total);
                                    }
                                </script>




                                <script language="javascript" type="text/javascript">
                                    function selectone() {


                                        var el = document.getElementsByName('selfeetypecheck[]');

                                        FCD = document.getElementsByName('finecharged[]');
                                        FP = document.getElementsByName('finepaid[]');
                                        FD = document.getElementsByName('finededucted[]');

                                        var count = 0;



                                        for (i = 0; i < el.length; i++) {
                                            FCD1 = FCD[i].value;
                                            FP1 = FP[i].value;
                                            FD1 = FD[i].value;
                                            if (el[i].checked) {
                                                count = 1;
                                                if (FCD1 != "") {
                                                    TOT = 0;
                                                    TOT = Number(FP1) + Number(FD1);
                                                    if (FCD1 != TOT) {
                                                        alert("Fine charged should be equal to finepaid+deduction allowed");
                                                        return false;
                                                    }
                                                } else {
                                                    continue;
                                                }
                                            }


                                        }

                                        if (count == 0) {
                                            alert("Please check at least one !");
                                            return false;
                                        } else {
                                            return true;
                                        }

                                    }
                                </script>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: -25px;" style="border-color: #4dc8ee !important;">
                                    <tr>
                                        <td height="3" colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="3" class="bgcolor_02">&nbsp;&nbsp;<span class="admin"><b>STUDENT FEE CARD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td width="1" class="bgcolor_02"></td>
                                        <td align="left" valign="top">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <table width="95%" border="0" cellspacing="2" cellpadding="0" align="center">

                                                            <tr>

                                                                <td align="left" class="narmal">Admission No. </td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php echo $row["course_name"]; ?><?php echo date("y", strtotime($row['university_details_academic_start_date'])) ?><?php echo date("y", strtotime($row['university_details_academic_end_date'])); ?><?php
                                                                                                                                                                                                                                                                                                        $admission_id = 1;
                                                                                                                                                                                                                                                                                                        printf("%03d", $row['student_id']); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="narmal">Registration No.</td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php echo $row["student_id"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="narmal">Academic Session</td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php echo date("Y", strtotime($row["university_details_academic_start_date"])) . " to " . date("Y", strtotime($row["university_details_academic_end_date"])); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="narmal">Course</td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php echo $row["course_name"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="narmal" width="31%">Student Name </td>
                                                                <td align="left" class="narmal" width="1%">:</td>
                                                                <td align="left" class="narmal" width="27%"><?php echo $row["student_name"] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="narmal">Father/Guardian Name </td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php echo $row["father_name"]; ?></td>
                                                            <tr>
                                                                <!-- <tr>
                                                                <td align="left" class="narmal">Hostel</td>
                                                                <td align="left" class="narmal">:</td>
                                                                <td align="left" class="narmal"><?php // echo $row["admission_hostel"];
                                                                                                ?></td>
                                                            <tr> -->
                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td>
                                                        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>
                                                            <tr>
                                                                <td align="left" class="adminfont" colspan="7">&nbsp;Fee Details for Course : <?php echo $row["course_name"]; ?> </td>
                                                            </tr>
                                                            <tr class="bgcolor_02" height="25">
                                                                <td align="center" class="admin" width="14%">&nbsp;S No</td>
                                                                <td align="center" class="admin" width="40%">Particulars</td>
                                                                <td align="center" class="admin" width="17%">Total</td>
                                                                <!--<td align="center" class="admin" width="29%">  Fee Type</td>-->
                                                            </tr>

                                                            <?php
                                                            $tmpSNo = 1;
                                                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                            ?>
                                                                <tr>
                                                                    <td align="left" class="narmal"><?php echo $tmpSNo; ?></td>
                                                                    <td align="left" class="narmal"><?php echo strtoupper($arrayTblFeeUpdate->particular); ?></td>
                                                                    <td align="left" class="narmal">Rs. <?php echo $arrayTblFeeUpdate->fee; ?>.00</td>
                                                                </tr>
                                                            <?php
                                                                $tmpSNo++;
                                                            }
                                                            ?>
                                                            <!-- TOTAL AMOUNT -->
                                                            <tr>
                                                                <td></td>
                                                                <td align="left"><strong>TOTAL</strong></td>
                                                                <td align="left"><strong>Rs. <?php echo $totalFee; ?>.00</strong></td>
                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>
                                                            <tr>
                                                                <td align="left" class="adminfont" colspan="7">&nbsp;Total Fee Paid</td>
                                                            </tr>

                                                            <tr class="bgcolor_02" height="25">
                                                                <td width="10%" align="center" valign="middle" class="admin">S. No.</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">Payment Date</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">RECEIPT Date</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">CHEQUE/DD NO/ONLINE NO</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">Bank Name</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">PARTICULARS</td>

                                                                <td width="10%" align="center" valign="middle" class="admin">Rebate.</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">Paid Amount</td>
                                                                <td width="10%" align="center" valign="middle" class="admin">Balance</td>

                                                            </tr>
                                                            <tbody>
                                                                <?php
                                                                $tmpSNo = 1;
                                                                foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                                    if ($arrayTblFeeUpdate->fee_paid != 0) {
                                                                ?>
                                                                        <tr>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo $tmpSNo; ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo $arrayTblFeeUpdate->fee_paid_on; ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo $arrayTblFeeUpdate->fee_receipt_date; ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo $arrayTblFeeUpdate->fee_transaction_no; ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo $arrayTblFeeUpdate->fee_bank_name; ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><?php echo strtoupper($arrayTblFeeUpdate->particular); ?></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $arrayTblFeeUpdate->fee_rebate; ?>.00</span></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $arrayTblFeeUpdate->fee_paid; ?>.00</span></td>
                                                                            <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $arrayTblFeeUpdate->fee_balance; ?>.00</span></td>
                                                                        </tr>
                                                                <?php
                                                                        $totalRemaining = $totalRemaining + $arrayTblFeeUpdate->fee_balance;
                                                                    }
                                                                    $tmpSNo++;
                                                                }
                                                                ?>
                                                                <!-- TOTAL AMOUNT -->
                                                                <tr>
                                                                    <td width="10%" align="center" valign="middle" class="admin"></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"><span class="float-right mr-3 text-bold">Total</span></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $totalRebate; ?>.00</span></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $totalPaid; ?>.00</span></td>
                                                                    <td width="10%" align="center" valign="middle" class="admin"><span class="text-bold">Rs.<?php echo $totalRemaining; ?>.00</span></td>
                                                                </tr>

                                                        </table>

                                                    </td>
                                                </tr>

                                                <!--                              <tr>-->
                                                <!--                                 <td>-->
                                                <!--                                     <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;"><br>-->
                                                <!--                                         <tr>-->
                                                <!--                                             <td align="left" class="adminfont" colspan="7" >&nbsp;Summary</td>-->
                                                <!--                                         </tr>-->

                                                <!--                                         <tr class="bgcolor_02" height="25">-->
                                                <!--                                             <td width="30%" align="center" valign="middle" class="admin">&nbsp;TOTAL REBATE</td>-->
                                                <!--<td width="30%" align="center" valign="middle" class="admin">TOTAL FINE</td>-->
                                                <!--                                             <td width="30%" align="center" valign="middle" class="admin">TOTAL PAID</td>-->
                                                <!--                                             <td width="30%" align="center" valign="middle" class="admin">BALANCE DUE</td>-->

                                                <!--                                         </tr>-->

                                                <!--                                         <tr>-->
                                                <!--                                             <td width="30%" align="left" valign="middle" class="admin"><span class="text-bold"><?php echo $totalRebate; ?>.00</span></td>-->
                                                <!--                                             <td width="30%" align="left" valign="middle" class="admin"><span class="text-bold"><?php echo $totalFine ?>.00</span></td>-->
                                                <!--                                             <td width="30%" align="left" valign="middle" class="admin"><span class="text-bold">Rs. <?php echo $totalPaid + $totalFine; ?>.00</span></td>-->
                                                <!--                                             <td width="30%" align="left" valign="middle" class="admin"><span class="text-bold">Rs. <?php echo $totalRemaining; ?>.00</span></td>-->
                                                <!--                                         </tr>-->

                                                <!-- TOTAL AMOUNT -->


                                                <!--                                     </table>-->

                                                <!--                                 </td>-->
                                                <!--                             </tr>-->


                                                <tr>
                                                    <td>
                                                        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl_grid" style="border-color: #4dc8ee !important;">
                                                            <tr height="50">
                                                                <td align="left" colspan="4"></td>

                                                            </tr>
                                                            <tr height="25">
                                                                <td align="right" colspan="4" style="padding-right:25px;" class="admin">Authorised Signatory</td>
                                                            </tr>
                                                            <tr height="25">
                                                                <td align="left" colspan="4" style="padding-right:25px;" class="admin">Note:- Fee once paid will not be refunded and Please keep this slip for your reference</td>
                                                            </tr>


                                                        </table>
                                                    </td>

                                                </tr>


                                            </table>



                                        </td>
                                        <td width="1" class="bgcolor_02"></td>
                                    </tr>
                                    <tr>
                                        <td width="1" class="bgcolor_02"></td>
                                        <td height="10">&nbsp;</td>
                                        <td width="1" class="bgcolor_02"></td>
                                    </tr>
                                    <tr>
                                        <td height="1" colspan="3" class="bgcolor_02"></td>
                                    </tr>
                                </table>





                                <style>
                                    .fee_card {
                                        font-family: Verdana, Arial, Helvetica, sans-serif;
                                        font-size: 9px;
                                    }
                                </style>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <script type="text/javaScript">
                function printing(){
	  document.getElementById("printbutton").style.display = "none";
	  window.print();
	  window.close();
	 }

  </script>

        </table>
    </body>

    </html>
<?php
} else {
    echo "<script> location.replace('payfee'); </script>";
}
?>

<style>
    .logo {
        width: 150px !important;
        margin-top: -19px !important;
        padding: 10px !important;
    }
</style>