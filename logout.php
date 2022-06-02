<?php
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
    unset($_SESSION["logger_time"]);
    unset($_SESSION["logger_type"]);
    unset($_SESSION["logger_username"]);
    unset($_SESSION["logger_password"]);
    if(!isset($_SESSION["logger_type"]) && !isset($_SESSION["logger_username"]) && !isset($_SESSION["logger_password"]))
        echo "<script> location.replace('index'); </script>";
?>