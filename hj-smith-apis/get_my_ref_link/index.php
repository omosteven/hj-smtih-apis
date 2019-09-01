<?php
//user  authentication (registration and login) api
//header("Access-Control-Allow-Origin: /auth/");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../api_config.php'); //configuration file
include('fetch.php'); //configuration file

$x = DBCONNECTION();
$users = new CheckRef($db);

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


$users->email = $decdata['Email'];
if (!empty($users->email)) {
    if ($users->members() == "success") {
        http_response_code(200);
        $Time = gmdate('Y-m-d G:i:s');
        // display message: upload was created
        //echo 'hey';
        echo json_encode(array("type" => "get_my_ref_link","response" => true,"reason"=>"successful_query","dbconnection" => $x,"query_time" => $Time,"referral_link" => $users->refLink));
    } 
    elseif($users->members() == "invalid_email")
    {
        http_response_code(400);
        $Time = gmdate('Y-m-d G:i:s');
        // display message: upload was created
    
        echo json_encode(array("type" => "get_my_ref_link","response" => true,"reason"=>"invalid_email","dbconnection" => $x,"query_time" => $Time,"email" => $users->email));
    }else{
        http_response_code(400);
        $Time = gmdate('Y-m-d G:i:s');
        // display message: upload was created
    
        echo json_encode(array("type" => "get_my_ref_link","response" => true,"reason"=>"failed_query","dbconnection" => $x,"query_time" => $Time));
    
    }
}else{
    http_response_code(400);
    $Time = gmdate('Y-m-d G:i:s');
    // display message: upload was created

    echo json_encode(array("type" => "get_my_ref_link","response" => true,"reason"=>"invalid_em","dbconnection" => $x,"query_time" => $Time));

}
?>