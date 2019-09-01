<?php
//user  authentication (registration and login) api
//header("Access-Control-Allow-Origin: /auth/");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../api_config.php'); //configuration file
include('user.php'); //configuration file

$x = DBCONNECTION();
$user = new User($db);
//$data = json_encode(array("firstname" => $_POST['firstname'],"lastname" => $_POST['lastname'],"email" => $_POST['email'],"password" => $_POST['password']));
//$json = '{"Peter" => 65,"Harry"=> 80,"John"=> 78,"Clark"=> 90}';

//$json = json_encode(array("email" => $_POST['email'],"password" => $_POST['password']));
//$json = file_get_contents('php://input');

// Converts it into a PHP object
//$data = json_decode($json)[0];

//$data = json_decode($json);
// set product property values


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

$user->email = $decdata['Email'];
$user->password = $decdata['Password'];


 // log in user
 if(
    !empty($user->password) &&
    !empty($user->email)
 )
 {
    if(
        !empty($user->password) &&
        !empty($user->email) &&
        $user->authenticate() == true
    ){
    

         // set response code
        http_response_code(200);
        $regTime = gmdate('Y-m-d G:i:s');
        require('lib/php-jwt-master/src/BeforeValidException.php');
        require('lib/php-jwt-master/src/ExpiredException.php');
        require('lib/php-jwt-master/src/SignatureInvalidException.php');
        require('lib/php-jwt-master/src/JWT.php');

        $tokenId    = base64_encode($user->email);
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;             //Adding 10 seconds
        $expire     = $notBefore + 60;            // Adding 60 seconds
        $serverName = "hj-smith"; //
        $header = json_encode(
            ['typ' => 'JWT', 'alg' => 'HS256'
            ]
        );
        $key = password_hash($user->email, PASSWORD_BCRYPT);
        $secret = base64_encode($key);
        // Create token payload as a JSON string
        $payload = json_encode(['email' => $user->email,'exp' => $expire,
        'iat'  => $issuedAt,         // Issued at: time when the token was generated
        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
        'iss'  => $serverName,       // Issuer
        'nbf'  => $notBefore,  
        ]);
        // Encode Header to Base64Url String
        $base64UrlHeader = base64_encode($header);

        // Encode Payload to Base64Url String
        $base64UrlPayload = base64_encode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        // Encode Signature to Base64Url String
        $base64UrlSignature =  base64_encode($signature);
        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $jwtOuput = (array("jwt" => $jwt, 
        "payload" => [
            'email' => $user->email,
            'exp' => $expire,
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => $serverName,       // Issuer
            'nbf'  => $notBefore
            ], 
        "header" =>         
                [
                    'typ' => 'JWT', 
                    'alg' => 'HS256'
            ]
            )
        );
    echo json_encode(array("type" => "login","response" => true,"reason"=>"correct_login_details","dbconnection" => $x,"email" => $user->email,"loggedin_date_inGMT" => $regTime,"jwtdata" => $jwtOuput));
    }else{
        http_response_code(400);
    
        // display message: user was authenticate()        
        echo json_encode(array("type" => "login","response" => false,"reason"=>"incorrect_login_details","dbconnection" => $x,"email" => $user->email));
    }

}else{
                // set response code
        http_response_code(400);
    
                // display message: unable to authenticate()ser
        echo json_encode(array("type" => "login","response"=>false,"reason"=>"incomplete_details","dbconnection" => $x,"email" => $user->email));
}
?>