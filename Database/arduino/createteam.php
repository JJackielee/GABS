// Belal Khan
// August 12, 2016
// DbConnect.php
// Connecting iOS App to MySQL Database
// Code version : N/A 
// PHP
// https://www.simplifiedios.net/swift-php-mysql-tutorial/

<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $location = $_POST['location'];
    $description = $_POST['description'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createTeam($lat, $lng, $location, $description)){
        $response['error']=false;
        $response['message']='Team added successfully';
    }else{

        $response['error']=true;
        $response['message']='Could not add team';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);

?>