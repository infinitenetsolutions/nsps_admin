<?php
    //Main Class
    class DBEVAL{
        //Variables ------------------------------------------------------------------------
        public $con;
        public $sql = "";
        public $tableName = "";
        public $colNames = "";
        public $where = "";
        public $result = "";
        public $row = "";
        public $data = "";
        //Local
//        public $hostName = "localhost";
//        public $userName = "root";
//        public $password = "";
//        public $dbName = "db_nsucms_updated";
        //Server
        //public $hostName = "localhost";
      //  public $userName = "root";
       // public $password = "";
       // public $dbName = "nsucms_demo_nsuniv";
        //Function --------------------------------------------------------------------------
        //Database Connection
       
    
        public function select($tableName){
            $this->tableName = $tableName;
            $this->sql .= "SELECT * FROM `$tableName`";
        }
       
        public function where($where){
            $this->sql .= " WHERE $where";
        }
        public function get(){
            $this->result = $this->con->query($this->sql);
            return $this->result;
        }
        public function get_row(){
            $this->row = $this->result->fetch_assoc();
            return $this->row;
        }
        public function insert($tableName, $data){
            $this->tableName = $tableName;
            $this->data = $data;
            $this->sql .= "INSERT INTO `$tableName` $data";
            if($this->result = $this->con->query($this->sql))
                return 1;
            else
                return 0;
        }
        public function update($tableName, $data){
            $this->tableName = $tableName;
            $this->data = $data;
            $this->sql .= "UPDATE `$tableName` SET $data";
            if($this->result = $this->con->query($this->sql))
                return 1;
            else
                return 0;
        }
        public function send_mail($to, $from, $fromName, $subject, $contents){
            $message = ' 
                <html> 
                <head> 
                    <title>Netaji Subhas Public School</title> 
                </head> 
                <body> 
                    '.$contents.'
                </body> 
                </html>'; 
            // Set content-type header for sending HTML email 
            $headers = "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
            // Additional headers 
            $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
            // Send email 
            mail($to, $subject, $message, $headers);
        }
        public function send_otp($phone, $message){
            $senderId="NSUJSR";
            $serverUrl="msg.msgclub.net";
            $authKey="6a4743a8355fb97aa42dc2452185a1cd";
            $routeId="1";
            $postData = array(
                'mobileNumbers' => $phone,
                'smsContent' => $message,
                'senderId' => $senderId,
                'routeId' => $routeId,
                "smsContentType" =>'english'
            );
            $data_json = json_encode($postData);
            $url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey;
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_json)),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ));
            curl_exec($ch);
        }
  
    }

?>
