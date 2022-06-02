<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(isset($_POST["importExcelButton"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "nsucms_cms");
        $file = $_FILES['importExcelFile']['tmp_name'];
        $handle = fopen($file, "r");
        if ($file == NULL) {
            echo "<script>
                    alert('Please first select an Excel file!!!');
                    location.replace('import-excel');
                </script>";
        }
        else {
            $c = 0;
            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
                $id = $filesop[0];
                $first_name = $filesop[1];
                $second_name = $filesop[2];
                $last_name = $filesop[3];
                $father_name = $filesop[4];
                $mother_name = $filesop[5];
                $dob = date("Y-m-d", strtotime($filesop[6]));
                $number = $filesop[7];
                $address = $filesop[8];
                $gender = $filesop[9];
                $user_id = $filesop[10];
                $password = $filesop[11];
                if(strtolower($gender) == "m")
                    $org_gender = "male";
                else
                    $org_gender = "female";
                
                $sql = "INSERT INTO `tbl_admission`(`admission_id`, `admission_first_name`, `admission_middle_name`, `admission_last_name`, `admission_course_name`, `admission_session`, `admission_father_name`, `admission_mother_name`, `admission_dob`, `admission_mobile_student`, `admission_father_phoneno`, `admission_residential_address`, `admission_gender`, `admission_username`, `admission_password`, `status`) 
                VALUES ('$id', '$first_name', '$second_name', '$last_name', '17', '10', '$father_name', '$mother_name', '$dob', '$number', '$number', '$address', '$org_gender', '$user_id', '$password', '46cf0e59759c9b7f1112ca4b174343ef')";  
                $stmt = mysqli_prepare($conn,$sql);
                mysqli_stmt_execute($stmt);
                $c = $c + 1;
            }
            if($sql){
              echo "<script>
                        alert('Excel Imported Successfully!!!');
                        location.replace('import-excel');
                    </script>";
            } 
            else
            {
                echo "<script>
                        alert('Something went wrong please try again!!!');
                        location.replace('import-excel');
                    </script>";
            }
        }
    }
?>
<html>
    <body>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="importExcelFile" required /><br/>
            <input type="submit" name="importExcelButton" value="Import"/>
        </form>
    </body>
</html>