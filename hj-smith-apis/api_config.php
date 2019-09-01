<?php
function DBCONNECTION() //connect to the DB
{
    /*$server = '85.90.247.83';
    $user = 'agrichai';
    $password = '5)+yij16k5BH5@Jy';
    $dbName = 'agrichai_agrichainxdb';
    $port = 3306;*/
    $server = 'localhost';
    $user = 'agrichainx';
    $password = 'adebomi1';
    $dbName = 'hjsmithdb';
    $port = 8080;
    global $db;
    $db = mysqli_connect($server,$user,$password,$dbName,$port);
     if($db) {
            return true;
            return '<p>Connection OK '. $db->host_info.'</p>';
            return '<p>Server '.$db->server_info.'</p>';
     } else {
            return false;
            die('CONNECTION REFUSED,PLEASE CHECK CONNECTION INFO WELL'. mysqli_connect_error());
            die('Connect Error (' . $db->connect_errno . ') '
                . $db->connect_error);
     }
}
DBCONNECTION();
function MEMBERS($db)
{  
    $table = "CREATE TABLE if not exists users(
    id INT(11) AUTO_INCREMENT,
    FIRSTNAME VARCHAR(255) NULL,
    LASTNAME VARCHAR(255) NULL,
    EMAIL VARCHAR(255) NOT NULL,
    PASSWORD VARCHAR(255)  NULL,
    REGTIME VARCHAR(255)  NULL,
    REFERRAL_LINK VARCHAR(255) NULL,
    AMOUNT INT(11) NULL,
    PRIMARY KEY(id)
    )";
    if(mysqli_query($db,$table)) {
        return 'TABLE SUCCESSFULLY CREATED FOR MEMBERS';
    } else {
        return 'TABLE UNSUCCESSFULLY CREATED for MEMBERS';
    }
}
MEMBERS($db);
function NEWS($db)
{  
    $table = "CREATE TABLE if not exists news(
    id INT(11) AUTO_INCREMENT,
    TITLE VARCHAR(255) NULL,
    CONTENT VARCHAR(255) NULL,
    PUBLISHER VARCHAR(255) NOT NULL,
    VIEWS INT(11)  NULL,
    PUBLISHEDTIME VARCHAR(255)  NULL,
    FILENAME VARCHAR(255) NULL,
    SIZE INT(11) NULL,
    TYPE VARCHAR(255) NULL,
    LINKURL VARCHAR(255) NULL,
    PRIMARY KEY(id)
    )";
    if(mysqli_query($db,$table)) {
        return 'TABLE SUCCESSFULLY CREATED FOR NEWS';
    } else {
        return 'TABLE UNSUCCESSFULLY CREATED for NEWS';
    }
}
NEWS($db);
?>