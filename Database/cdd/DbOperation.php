
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
 
    
   public function createinput($id, $userid, $input)
    {
        $stmt = $this->conn->prepare("INSERT INTO cdd_input(gunshot, user_id, cdd_input) values(?, ?, ? )");
        $stmt->bind_param('iis', $id, $userid, $input);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function countcdd($id,$input){
        $sql = "SELECT * from cdd_input where gunshot='" . $id . "' and cdd_input='" .$input . "'";
        $returnValue = array();
        $result = $this->conn->query($sql);
        for ($returnValue = array (); $row = $result->fetch_assoc(); $returnValue[] = $row);
        return $returnValue;

    }
	 public function createComment($gunid, $userid, $comment,$username)
    {
        $stmt = $this->conn->prepare("INSERT INTO comments(gunshot_id, user_id, user_comment, user_name) values(?, ?, ?, ?)");
        $stmt->bind_param('iiss', $gunid, $userid, $comment,$username);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
	 public function getComment($id){
        $sql = "SELECT * from comments where gunshot_id='" . $id . "'";
        $returnValue = array();
        $result = $this->conn->query($sql);
        for ($returnValue = array (); $row = $result->fetch_assoc(); $returnValue[] = $row);
        return $returnValue;

    }
	public function upVote($id){
		
		$stmt = $this->conn->prepare("UPDATE comments set vote=vote+1 where gunshot_id='" . $id . "'");
        $result = $stmt->execute();
        $stmt->close();
		 if ($result) {
            return true;
        } else {
            return false;
        }

    }
	public function downVote($id){
		
		$stmt = $this->conn->prepare("UPDATE comments set vote=vote-1 where gunshot_id='" . $id . "'");
        $result = $stmt->execute();
        $stmt->close();
		 if ($result) {
            return true;
        } else {
            return false;
        }

    }
 
    public function usercdd($gunid,$userid){
        $sql = "SELECT * from cdd_input where gunshot='" . $gunid . "' and user_id ='" . $userid . "'";
        $returnValue = array();
        $result = $this->conn->query($sql);
        for ($returnValue = array (); $row = $result->fetch_assoc(); $returnValue[] = $row);
        return $returnValue;

    }

 
}