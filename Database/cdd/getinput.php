

<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $id = $_POST['id'];
    $userid = $_POST['user'];
    $cddinput = $_POST['input'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createInput($id,$userid,$cddinput)){
        $response['error']=false;
        $response['message']='Input added successfully';
    }else{

        $response['error']=true;
        $response['message']='Could not add Input';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);

?>