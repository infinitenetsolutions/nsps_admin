<?php
    session_start();
    include "include/config.php";
    include "include/db_class.php";

// fee_details of other branch start
        // if(isset($_POST["fee_detail"]) && ($_POST['fee_detail']=='Add')){
            if($_POST["action"] == "fee_test"){
                $class_id = $_POST["class_name"];
                $section_id = $_POST["section_name"];
                $branch = $_POST["branch"];
                $fee_name = str_replace("'", "&#39;", $_POST["particular"]);
                $fee = $_POST["fee"];          
                $last_date = $_POST["last_date"];
                $fine = $_POST["fine"];
                $tennure = $_POST["tennure"];
               
                // $branch = count($_POST["branch"]);
                // $j = count($branch);
                // echo "<pre>";
                // print_r($_POST);
               // exit();
                
                if(!empty($fee != "" && $fine!= ""))
                {
                    $allParticulars = count($fee);    
                    // echo "<pre>";
                    // print_r($section_id);
                    // exit();
                        // $sql = "";
                        
                       
                 if($section_id[0] == 0)
                   {
                    
                    $sql_sect = "SELECT * FROM tbl_section WHERE course_id=".$class_id[0];
                    $result_sect = mysqli_query($con,$sql_sect);
                    while( $row_sect = mysqli_fetch_array($result_sect) )
                    {
                        $sectt = $row_sect['section_id'];
                        for($i = 0; $i<$allParticulars; $i++)
                        {
                       
                            $sql= "INSERT INTO `tbl_fee`
                                        (`class`, `section`, `particular`, `fee`, `last_date`,`fee_academic_year`, `fine_amount`, `tennure`, `branch`) 
                                        VALUES 
                                        ('$class_id[0]','$sectt','$fee_name[$i]','$fee[$i]','$last_date[$i]','$academic_year[$i]' ,'$fine[$i]','$tennure[$i]','$branch[0]');";
                                
                                echo $sql;
                                $success = $con->query($sql);

                        }
                    } 
                   }
                    else {
                    //     echo "<pre>";
                    // print_r($section_id);
                    // exit();
                        for($i = 0; $i<$allParticulars; $i++)
                        {
                           
                            $sql= "INSERT INTO `tbl_fee`
                                        (`class`, `section`, `particular`, `fee`, `last_date`,`fee_academic_year`, `fine_amount`, `tennure`, `branch`) 
                                        VALUES 
                                        ('$class_id[$i]','$section_id[$i]','$fee_name[$i]','$fee[$i]','$last_date[$i]','$academic_year[$i]','$fine[$i]','$tennure[$i]','$branch[$i]');";
                                
                            $success = $con->query($sql);
                        }
                    }
                        if($success)
                            {
                                $_SESSION['MSG']="success";
                                Header( 'Location: add_fee.php');
                                // echo "<script>alert('Fee details for all branches are submitted');</script>";

                            }
                }
                        else
                        {
                            echo "<script>alert('Please fill all branches fee');</script>";
                        }
             }
            // fee_details of other branch end
?>