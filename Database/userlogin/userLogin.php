// Sergey Kargopolov
// February 8th, 2016
// loginViewController
// Store user information in MySQL database
// Code version : N/A 
// PHP
// http://swiftdeveloperblog.com/store-user-information-in-mysql-database/
<?php

require("loginConnect.php");
$email = htmlentities($_POST["username"]);
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
$userDetails = $dao->getUserr($email);

if(password_verify($password,$userDetails[password]))
{
$returnValue["status"] = "Success";
$returnValue["message"] = "Welcome Back!";
$returnValue["id"] = $userDetails[id];
$returnValue["username"] = $userDetails[username];
echo json_encode($returnValue);
} else {

$returnValue["status"] = "error";
$returnValue["message"] = "Wrong password or Username";
echo json_encode($returnValue);
}

$dao->closeConnection();

?>