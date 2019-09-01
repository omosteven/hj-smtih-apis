<?php
// 'user' object
class CheckRef
{
 
    // database connection and table name
    private $conn;
    public $arrayResult;
    public $queryNo;
    public $email;
    public $refLink;

 
    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }
 
    public function members()
    {
        $stmt = $this ->conn-> prepare("SELECT EMAIL, REFERRAL_LINK FROM users WHERE EMAIL = '$this->email'");
        
        //$stmt->bind_param("s",$this->email);
        if ($stmt->execute()) {
           
            $this->result = $stmt->get_result();
            $arrayName = array();
            if ($this->result->num_rows == 1) {
                
                
                $this->res = $this->result->fetch_array();
                $ref = $this->res['REFERRAL_LINK'];
                //$this->refLink = $ref;
                //return "success";
                $stmt1 = $this->conn->prepare("SELECT * FROM users WHERE USED_REF_LINK = '$ref'");
                //if ($stmt1->execute()) {
                    
                    $this->result1 = $stmt1->get_result();
                    $this->refLink = $ref;
                    //if ($this->result1->num_rows > 0) {
                        /*while ($this->res1 = $this->result1->fetch_array()) {
                           array_push($arrayName, $this->res1);
                        }*/
                        $this->arrayResult = $arrayName;
                        $this->queryNo = $this->result1->num_rows;
                        return "success";
                    /*} else {
                        return "no_referral";
                    }*/
                /*} else {
                      return false;
                }*/
            } else {
                return "invalid_email";
            }
        } else {
            return false;
        }
    }
}
?>