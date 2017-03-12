// Sergey Kargopolov
// February 8th, 2016
// loginViewController
// Store user information in MySQL database
// Code version : N/A 
// PHP
// http://swiftdeveloperblog.com/store-user-information-in-mysql-database/
<?php 
//requires another file 
require("loginConnect.php");
//post requests
$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);
$name = htmlentities($_POST["name"]);
$username = htmlentities($_POST["username"]);
//creates an array
$returnValue = array();
//checks if post are empty or not
//if so kills/returns
if(empty($email) || empty($password))
{
$returnValue["status"] = "error";
$returnValue["message"] = "Missing required field";
echo json_encode($returnValue);
return;
}
//uses loginConnect to open connection to database
//uses function in class to get data from database through entered email
$dao = new loginConnect();
$dao->openConnection();
$userDetails = $dao->getUserDetails($email);
$usernameCheck = $dao->getUserr($username);
//if data returns kills and output error
if( !empty($userDetails) || !empty($usernameCheck))
{
$returnValue["status"] = "error";
$returnValue["message"] = "Username or Email already exists";
echo json_encode($returnValue);
return;
}

//hashes password
//input email and password into database through function in loginConnect
$secure_password = password_hash($password,PASSWORD_BCRYPT); 
$result = $dao->registerUser($email,$secure_password,$name,$username);

//if success then prints out message
if($result)
{
$returnValue["status"] = "Success";
$returnValue["message"] = "User is registered";
echo json_encode($returnValue);
return;
}

$dao->closeConnection();

?>