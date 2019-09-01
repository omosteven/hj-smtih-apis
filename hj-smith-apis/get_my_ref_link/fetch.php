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
        $stmt = $this ->conn-> prepare("SELECT EMAIL,REFERRAL_LINK FROM users WHERE EMAIL = '$this->email'");
        
        //$stmt->bind_param("s",$this->email);
        if ($stmt->execute()) {
           
            $this->result = $stmt->get_result();
            $arrayName = array();
            if ($this->result->num_rows == 1) {
                
                
                $this->res = $this->result->fetch_array();
                $ref = $this->res['REFERRAL_LINK'];
                $this->refLink = $ref;
                return "success";
            } else {
                return "invalid_email";
            }
        } else {
            return false;
        }
    }
}
?>