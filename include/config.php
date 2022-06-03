<?php
    // Create connection
    //$con = new mysqli("localhost", "", "", "");

    if($_SERVER['HTTP_HOST']=='localhost'){
    $con = new mysqli("localhost", "root", "", "nspsjsr_db");
    }
    else{
        $con = new mysqli("localhost", "nspsjsr_db", "P9jSBx1q8", "nspsjsr_db");
    }
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
