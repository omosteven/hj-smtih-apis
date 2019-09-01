<?php
//user  authentication (registration and login) api
header("Access-Control-Allow-Origin: /auth/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../api_config.php'); //configuration file
include('user.php'); //configuration file
$x = DBCONNECTION();
$user = new User($db);
//$json = json_encode(array("firstname" => $_POST['firstname'],"lastname" => $_POST['lastname'],"email" => $_POST['email'],"password" => $_POST['password'],"confirm_password" => $_POST["confirm_password"]));

$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

function cvf_convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }
}
$decdata = cvf_convert_object_to_array($data);

//$data = json_decode($json);
// set product property values
$user->firstname = $decdata['firstName'];
$user->lastname = $decdata['lastName'];
$user->email = $decdata['Email'];
$user->password = $decdata['Password'];
$user->cpassword = $decdata['Confirm_password'];
$user->refcode = $decdata['refCode'];
$regTime = gmdate('Y-m-d G:i:s');

 // create the user
 if(
    !empty($user->firstname) &&
    !empty($user->email) &&
    !empty($user->password) &&
    !empty($user->lastname) &&
    !empty($user->cpassword)
 )
 {
    if(
        !empty($user->firstname) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->lastname) &&
        !empty($user->cpassword) &&
        $user->create() == "acct_created"
    ){
    
        // set response code
        http_response_code(200);
    
        // display message: user was created
        
        echo json_encode(array("type" => "signup","response" => true,"reason"=>"complete_details","dbconnection" => $x,"email" => $user->email,"registration_date" => $regTime, "usedRefCode" => $user->refcode ));
    }
    
    // message if unable to create user
    else if(    
        !empty($user->firstname) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->lastname) &&
        !empty($user->cpassword) &&
        $user->create() == "acct_existed_already")

    {
    
        // set response code
        http_response_code(200);
    
        // display message: unable to create user
        echo json_encode(array("type" => "signup","response"=>false,"reason"=>"Email_Already_Used","dbconnection" => $x,"email" => $user->email));
    }else if(
        !empty($user->firstname) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->lastname) &&
        !empty($user->cpassword) &&
        $user->create() == "passwords_unmatched"
    ){
        http_response_code(200);
    
        // display message: unable to create user
        echo json_encode(array("type" => "signup","response"=>false,"reason"=>"Passwords_Unmatched","dbconnection" => $x,"email" => $user->email));

        
    }else if(
        !empty($user->firstname) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->lastname) &&
        !empty($user->cpassword) &&
        $user->create() == "password_length_error"
    ){
        http_response_code(200);
    
        // display message: unable to create user
        echo json_encode(array("type" => "signup","response"=>false,"reason"=>"Atleast_Eight_Char_Password_Needed","dbconnection" => $x,"email" => $user->email));

    }
    else{
            // set response code
        http_response_code(400);
    
            // display message: unable to create user
        echo json_encode(array("type" => "signup","response"=>false,"reason"=>"Network_Error","dbconnection" => $x,"email" => $user->email));
    }
}else{
                // set response code
        http_response_code(200);
    
                // display message: unable to create user
        echo json_encode(array("type" => "signup","response"=>false,"reason"=>"Incomplete_Details","dbconnection" => $x,"email" => $user->email));
}
?>