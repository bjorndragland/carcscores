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
include_once '../objekter/resultat.php';

$database = new Database();
$db = $database->getConnection();

$resultat = new resultat($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$resultat->ResultatID = $data->ResultatID;
$resultat->ResOmgRef = $data->ResOmgRef;
$resultat->ResSpillerRef = $data->ResSpillerRef;
$resultat->ResPoeng = $data->ResPoeng;
//$omgang->OmgangOpprettet = $data->OmgangOpprettet;

// opprett omgangen
if($resultat->create()){
    echo '{';
        echo '"message": "resultat was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create resultat."';
    echo '}';
}
?>