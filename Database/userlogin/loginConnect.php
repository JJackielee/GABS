// Sergey Kargopolov
// February 8th, 2016
// loginViewController
// Store user information in MySQL database
// Code version : N/A 
// PHP
// http://swiftdeveloperblog.com/store-user-information-in-mysql-database/
<?php
class loginConnect {
var $dbhost = null;
var $dbuser = null;
var $dbpass = null;
var $conn = null;
var $dbname = null;
var $result = null;

function __construct() {
$this->dbhost = "vergil.u.washington.edu";
$this->dbuser = "root";
$this->dbpass = "Newport1000";
$this->dbname = "shots_community";
}

public function openConnection() {
$this->conn = new mysqli('vergil.u.washington.edu', 'root', 'Newport1000', 'shots_community', '1666');
if (mysqli_connect_errno())
echo new Exception("Could not establish connection with database");
}

public function getConnection() {
return $this->conn;
}

public function closeConnection() {
if ($this->conn != null)
$this->conn->close();
}

public function getUserDetails($email)
{
$returnValue = array();
$sql = "select * from users where email='" . $email . "'";

$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function getUserr($username)
{
	$returnValue = array();
	$sql = "select * from users where username='" . $username . "'";

	$result = $this->conn->query($sql);
	if ($result != null && (mysqli_num_rows($result) >= 1)) {
	$row = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($row)) {
		$returnValue = $row;
		}
	}
	return $returnValue;
}

public function getUserDetailsWithPassword($email, $userPassword)
{
$returnValue = array();
$sql = "select id,email from users where email='" . $email . "' and password='" .$userPassword . "'";

$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function registerUser($email, $password,$name,$username)
{
$sql = "insert into users set email=?, password=?, name=?, username=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("ssss", $email, $password,$name,$username);
$returnValue = $statement->execute();

return $returnValue;
}

}


?>