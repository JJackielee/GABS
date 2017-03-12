<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='GET'){

    //getting values
    $gunid = $_GET['gunid'];
    $userid = $_GET['userid'];
    $comment = $_GET['comment'];
	$username = $_GET['username'];
	

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createComment($gunid,$userid,$comment,$username)){
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