<?php
// 'user' object
class CheckMembers{
 
    // database connection and table name
    private $conn;
    public $arrayResult;
    public $queryNo;

 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    function members(){
    $stmt = $this ->conn-> prepare("SELECT FIRSTNAME,LASTNAME,EMAIL,REFERRAL_LINK FROM users");
        
    //$stmt->bind_param("s",$this->email);
    if($stmt->execute()){
        $this->result = $stmt->get_result();
        $arrayName = array();
        if($this->result->num_rows > 1){
            while($this->res = $this->result->fetch_array()){
                array_push($arrayName,$this->res);
                }
                $this->arrayResult = $arrayName;
                $this->queryNo = $this->result->num_rows;
            }
            return true;
        }
    else{
        return false;
        }
    }
}
?>