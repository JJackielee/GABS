
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

if($_SERVER['REQUEST_METHOD']=='GET'){

    //getting values
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $location = $_GET['location'];
    $description = $_GET['description'];

   

    //including the db operation file
    require_once 'DbOperation.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createGunshot($lat, $lng, $location, $description)){
        $response['error']=false;
        $response['message']='Gunshot added successfully';
    }else{

        $response['error']=true;
        $response['message']='Could not add Gunshot';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);

?>