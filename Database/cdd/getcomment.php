 <?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='GET'){

    //getting values
    $id = $_GET['gunid'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();
    $countC = $db->getComment($id);
    $response['Comments']= $countC;

  }
  echo "<pre>";
  echo json_encode($response,JSON_PRETTY_PRINT);
  echo "</pre>";
    
?>