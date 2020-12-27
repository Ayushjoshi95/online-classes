<?php

//opne server error
ini_set('display_errors', 1);
error_reporting(1);

//select time zone
date_default_timezone_set('Asia/Kolkata');

//for the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cfclasses";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//google api key
$google_key="AIzaSyCl2Zq1Xr7l1qLT2INlKwvlpsFnlTa3D58";

// Check connection
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

//website link
 
 
//sms config
//function send_sms($numbers,$message)
//{
//    $sms_username ='shvetdhara';
//    $sendername = 'SVTDRA';
//    $smstype   = 'TRANS';
//    $apikey   = 'ca41b227-49b0-4c8f-b02c-201ced3b8a28';
//    $url="http://login.aquasms.com/sendSMS?username=$sms_username&message=".urlencode($message)."&sendername=$sendername&smstype=$smstype&numbers=$numbers&apikey=$apikey";
//    $ret = file_get_contents($url);
//    return $ret;
//}

 
?>