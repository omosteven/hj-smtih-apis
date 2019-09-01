<?php
class generate{
    private $conn;
    public $emailToGenerateFor;
    public $generator;
    public  $referralLink;
    public function __construct($db){
        $this->conn = $db;
    }
    function generateRef(){
        $timeStamp = gmdate('Y-m-d G:i:s');
        include('../hashing.php');
        $this->referralLink = substr(hashcube($timeStamp.$this->emailToGenerateFor),2,12);
        //echo $referralLink;
        $stmt = $this ->conn-> prepare("SELECT * FROM users WHERE EMAIL = ?");
        
        $stmt->bind_param("s",$this->emailToGenerateFor);
        $stmt->execute();
        $this->result = $stmt->get_result();
        if($this->result->num_rows == 1){
            //echo $this->referralLink;
            $this->query = $this->conn->prepare("UPDATE users SET REFERRAL_LINK = '$this->referralLink' WHERE EMAIL = '$this->emailToGenerateFor'");
            if($this->query->execute()){
                return "Success";
            }else {
                return "Failed_To_Update";
            }
        }else{
            return false;
        }
}
}
?>