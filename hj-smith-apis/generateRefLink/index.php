<?php
header("Access-Control-Allow-Origin: /auth/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../api_config.php'); //configuration file
include('generate.php');
$x = DBCONNECTION();

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
$generate = new generate($db);
$decdata = cvf_convert_object_to_array($data);
$generate->emailToGenerateFor = $decdata["emailToGenerateFor"];
$generate->generator = $decdata["AdminEmail"];
//echo $generate->emailToGenerateFor;
//$generate->generateRef();
if(
    !empty($generate->emailToGenerateFor)
 )
 {
    if(
        $generate->generateRef() == "Success"
    ){
        http_response_code(400);
        $Time = gmdate('Y-m-d G:i:s');
        echo json_encode(array("type" => "referral_link_generation","response" => true, "reason" => "success","dbconnection" => $x,"emailToGenerateFor" => $generate->emailToGenerateFor,"time" => $Time, "generatedLink" => $generate->referralLink));
    }else if(
        $generate->generateRef() == "Failed_To_Update"
    ){
        http_response_code(400);
        $Time = gmdate('Y-m-d G:i:s');
        echo json_encode(array("type" => "referral_link_generation","response" =>false, "reason" => "failed_to_update_to_db","dbconnection" => $x,"emailToGenerateFor" => $generate->emailToGenerateFor,"time" => $Time));
    }else{
        http_response_code(400);
        $Time = gmdate('Y-m-d G:i:s');
        echo json_encode(array("type" => "referral_link_generation","response" =>false, "reason" => "failed_to_update_to_db","dbconnection" => $x,"emailToGenerateFor" => $generate->emailToGenerateFor,"time" => $Time));   
    }
}else{
    http_response_code(400);
    $Time = gmdate('Y-m-d G:i:s');
    echo json_encode(array("type" => "referral_link_generation","response" =>false, "reason" => "Incorrect_Email","dbconnection" => $x,"emailToGenerateFor" => $generate->emailToGenerateFor,"time" => $Time));
}
?>