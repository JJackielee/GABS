 <?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $id = $_POST['id'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();
    $countC = $db->countcdd($id,"Confirm");
    $countD = $db->countcdd($id,"Deny");
    $countK = $db->countcdd($id,"DontKnow");
    $response['Confirm']= count($countC);
    $response['Deny']= count($countD);
    $response['DontKnow']= count($countK);
  }
  echo json_encode($response);
    
?>