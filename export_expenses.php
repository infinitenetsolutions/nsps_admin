<?php  
include 'include/config.php';
mysqli_select_db($con, 'crud');  
$sql = "SELECT * FROM `tbl_expenses`";  
$setRec = mysqli_query($con, $sql);  
$columnHeader = '';  
$columnHeader = "S.No" . "\t" . "Payment Date" . "\t" ."Particulars" . "\t" . "Amount" . "\t" . "Payment Mode" . "\t" . "Paid To" . "\t" . "Remarks" . "\t" . "Post Date";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=Nsu_Expenses.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
 ?>