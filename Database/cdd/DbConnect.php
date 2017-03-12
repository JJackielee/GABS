// Belal Khan
// August 12, 2016
// DbConnect.php
// Connecting iOS App to MySQL Database
// Code version : N/A 
// PHP
// https://www.simplifiedios.net/swift-php-mysql-tutorial/
<?php
 
class DbConnect
{
    private $conn;
 
    function __construct()
    {
    }
 
    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect()
    {
 
        // Connecting to mysql database
        $this->conn = new mysqli('vergil.u.washington.edu', 'root', 'Newport1000', 'shots_community', '1666');
 
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
 
        // returing connection resource
        return $this->conn;
    }
}
?>