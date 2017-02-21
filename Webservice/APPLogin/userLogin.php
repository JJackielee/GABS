// Sergey Kargopolov
// February 8th, 2016
// userLogin.php
// Store user information in MySQL database
// Code version : N/A 
// PHP
// http://swiftdeveloperblog.com/store-user-information-in-mysql-database/

<?php

require("loginConnect.php");
$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);
$returnValue = array();

if(empty($email) || empty($password))
{
$returnValue["status"] = "error";
$returnValue["message"] = "Missing required field";
echo json_encode($returnValue);
return;
}

$secure_password = md5($password);

$dao = new loginConnect();
$dao->openConnection();
$userDetails = $dao->getUserDetailsWithPassword($email,$secure_password);

if(!empty($userDetails))
{
$returnValue["status"] = "Success";
$returnValue["message"] = "User is registered";
echo json_encode($returnValue);
} else {

$returnValue["status"] = "error";
$returnValue["message"] = "User is not found or wrong password";
echo json_encode($returnValue);
}

$dao->closeConnection();

?>