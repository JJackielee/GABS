// Sergey Kargopolov
// February 8th, 2016
// userRegister.php
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

$dao = new loginConnect();
$dao->openConnection();
$userDetails = $dao->getUserDetails($email);

if(!empty($userDetails))
{
$returnValue["status"] = "error";
$returnValue["message"] = "User already exists";
echo json_encode($returnValue);
return;
}

$secure_password = md5($password); // I do this, so that user password cannot be read even by me

$result = $dao->registerUser($email,$secure_password);

if($result)
{
$returnValue["status"] = "Success";
$returnValue["message"] = "User is registered";
echo json_encode($returnValue);
return;
}

$dao->closeConnection();

?>