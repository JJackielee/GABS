// Belal Khan
// August 12, 2016
// DbConnect.php
// Connecting iOS App to MySQL Database
// Code version : N/A 
// PHP
// https://www.simplifiedios.net/swift-php-mysql-tutorial/
<?php
 
class DbOperation
{
    private $conn;
 
    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 
    //Function to create a new user
    public function createGunshot($lat, $lng, $location, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO shots_data(lat, lng, location_name, description) values(?, ?, ? ,?)");
        $stmt->bind_param('ddss', $lat, $lng, $location, $description);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
 
}