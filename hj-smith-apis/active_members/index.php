<?php
//user  authentication (registration and login) api
//header("Access-Control-Allow-Origin: /auth/");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../api_config.php'); //configuration file
include('checkmembers.php'); //configuration file

$x = DBCONNECTION();
$users = new CheckMembers($db);
$users->members();
if($users->members()){
    http_response_code(200);
    $Time = gmdate('Y-m-d G:i:s');
    // display message: upload was created
    //echo 'hey';
    echo json_encode(array("type" => "active_members","response" => true,"reason"=>"successful_query","dbconnection" => $x,"query_time" => $Time,"no_of_results" => $users->queryNo, "query_results" => $users->arrayResult));

}else{
    http_response_code(400);
    $Time = gmdate('Y-m-d G:i:s');
    // display message: upload was created
    
    echo json_encode(array("type" => "active_members","response" => true,"reason"=>"failed_query","dbconnection" => $x,"query_time" => $Time));

}
?>