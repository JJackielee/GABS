<?php

//creating response array
	$response = array();
	if($_SERVER['REQUEST_METHOD']=='GET'){

    //getting values
    $gunid = $_GET['gunid'];


   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    if($db->downVote($gunid)){
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