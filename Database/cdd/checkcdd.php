

<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $id = $_POST['id'];
    $userid = $_POST['user'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    $results = $db->usercdd($id,$userid);

    
    if(!(empty($results))){
        $response['empty']=false;
        $response['message']=$results[0][cdd_input];
    }else{

        $response['empty']=true;
        $response['message']='no input';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);


?>