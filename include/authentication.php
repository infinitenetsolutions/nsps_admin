<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
<?php 
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    //Starting Session
    if(empty(session_start()))
        session_start();
    //Logger Type
    $logger_type = $_SESSION["logger_type"];
    if($logger_type == "subadmin")
        $autority = $_SESSION["authority"];

        // print_r($autority);

    //DataBase Connectivity
    include "config.php";
    $idle_time = 1200;
    $visible = md5("visible");
    $trash = md5("trash");
    if (time()-$_SESSION["logger_time"]>$idle_time){
        unset($_SESSION["logger_time"]);
        unset($_SESSION["logger_type"]);
        unset($_SESSION["logger_username"]);
        unset($_SESSION["logger_password"]);
        echo "<script> location.replace('index'); </script>";
    } else{
        $_SESSION["logger_time"] = time();
    }
    if(!isset($_SESSION["logger_type"]) && !isset($_SESSION["logger_username"]) && !isset($_SESSION["logger_password"]))
        echo "<script> location.replace('index'); </script>";
        
        
        
    
    $flag=0; 
    if(isset($autority)){
        $allAutority = json_decode($autority);
      //  echo $allAutority; exit;
        if($page_no != 1){
            if(isset($allAutority->$page_no)){
                $subMenus = explode("||", $allAutority->$page_no);
                for($i=0; $i<count($subMenus);$i++){ 
                    if($subMenus[$i] == $page_no_inside){ 
                        $flag++; 
                        break; 
                    } 
                } 
                if($flag == 0)
                { 
                   echo "<script>
                           location.replace('dashboard');
                       </script>"; 
                }
            } else
                echo "<script>
                           location.replace('dashboard');
                       </script>"; 
        }
    }
    
    
?>
<script>
    $(document).ready(function() {
        setInterval('refreshPage()', 1301000);
    });

    function refreshPage() {
        location.reload();
    }
</script>