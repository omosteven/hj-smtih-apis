<?php
//Hashing Algorithm Script written in php
function hashcube($plainText){
    //$hash1 = crypt($plainText,$options);
    $hash2salt = password_hash($plainText,PASSWORD_DEFAULT);
    /*$options = [
        'cost' => 15 //max time of processing
       // 'salt' => $hash2salt
                ];*/
    $hash3 = password_hash($plainText,PASSWORD_BCRYPT);
    return $hash3;
}

function linkUrlEncode($plainText){
    $encoded = base64_encode($plainText);
    $encoded = base64_encode($encoded);
    $encoded = base64_encode($encoded);
    return $encoded;
}

?>