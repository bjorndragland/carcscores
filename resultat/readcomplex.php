<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objekter/resultat.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$resultat = new resultat($db);

$spillerHeader = $resultat->getPlayerHeaders();
//$resultattabell = $resultat->getIts($spillerHeader);
$resultattabell = $resultat->getIts2($spillerHeader);
echo json_encode($resultattabell);
//echo json_encode($spillerHeader);


?>