<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $regTime;
    public $refcode;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        if($this->password == $this->cpassword){
            if(strlen($this->password) > 7) {
                $this->check = "SELECT * FROM users WHERE EMAIL = '$this->email'";
                $this->check = $this->conn->query($this->check);
                if($this->check->num_rows == 0){
                    $this->query = "INSERT INTO users (FIRSTNAME,LASTNAME,EMAIL,PASSWORD,REGTIME,USED_REF_LINK) VALUES (?,?,?,?,?,?)";
                    
                    // prepare the query
                    $stmt = $this->conn->prepare($this->query);
                    

                    $stmt -> bind_param("ssssss",$this->firstname,$this->lastname,$this->email,$this->password,$this->regTime,$this->refcode);
                    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
                    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
                    $this->email=htmlspecialchars(strip_tags($this->email));
                    $this->password=htmlspecialchars(strip_tags($this->password));
                    $this->regTime = gmdate('Y-m-d G:i:s');
                    $this->refcode = htmlspecialchars(strip_tags($this->refcode));
                    // hash the password before saving to database
                    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                    $this->password= $password_hash;
        
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return "acct_created";
        }else{
     
        return false;
        //$stmt->close();
        }
    }else{
        return "acct_existed_already";

    }
}else{
    return "password_length_error";
}
    }else{
        return "passwords_unmatched";
    }
}
    function authenticate(){
        $stmt = $this ->conn-> prepare("SELECT * FROM users WHERE EMAIL = ?");
        
        $stmt->bind_param("s",$this->email);
        $stmt->execute();
        $this->result = $stmt->get_result();
        if($this->result->num_rows == 1){
            $this->password = htmlspecialchars(strip_tags($this->password));
            $res = $this->result->fetch_array();
           if(password_verify($this->password,$res['PASSWORD'])){
               return true;
           }else{
            return false;
           }
        }else{
            return false;
        }
    }
}
?>