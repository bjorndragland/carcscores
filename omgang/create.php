<?php
// kopiert fra API_tester
// spillomganger.create
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objekter/omgang.php';

$database = new Database();
$db = $database->getConnection();

$omgang = new omgang($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));


// set product property values
$omgang->OmgangID = $data->OmgangID;
//$omgang->OmgangOpprettet = $data->OmgangOpprettet;

 
// opprett omgangen
if($omgang->create()){
    echo '{';
        echo '"message": "omgang was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create omgang."';
    echo '}';
}
?>