<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objekter/spiller.php';
 
$database = new Database();
$db = $database->getConnection();

$spiller = new spiller($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$spiller->SpillerFornavn = $data->SpillerFornavn;

 
// create the product
if($spiller->create()){
    echo '{';
        echo '"message": "Spiller opprettet."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Ikke mulig å opprette spiller."';
    echo '}';
}
?>