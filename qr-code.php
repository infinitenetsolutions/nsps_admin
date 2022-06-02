<?php 
    // Include the qrlib file 
    include 'include/qr-lib/qrlib.php'; 
    $data = array(
                "university"        =>  "nsuniv.ac.in",
                "regNo"             =>  "106",
                "academicSession"   =>  "2019-2022",
                "courseName"        =>  "BBA",
                "studentName"       =>  "Ehtesham Azad",
                "fathersName"       =>  "Md Akram",
//                "result"            =>  "FAIL"
                "result"            =>  "PASS"
            );
    $path = 'images/qr-code/'; 
    $file = $path.uniqid().uniqid().".png"; 
    // $ecc stores error correction capability('L') (LOW)
    // $ecc stores error correction capability('H') (HIGH)
    $ecc = 'H'; 
    $pixel_Size = 10; 
    $frame_Size = 1;
    // Generates QR Code and Stores it in directory given 
    QRcode::png(json_encode($data), $file, $ecc, $pixel_Size, $frame_Size);



    // Displaying the stored QR code from directory 
    echo "<center><img width='100px' src='".$file."'></center>"; 
?> 