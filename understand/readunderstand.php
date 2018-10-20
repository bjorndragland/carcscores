<?php
// kopiert fra API_tester
// spillomganger.read
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objekter/understandobj.php';


// instantiate database and product object
//$database = new Database();
//$db = $database->getConnection();
 
// initialize object
$understandobj = new understandobj($db);
 
// query products
$stmt = $understandobj->readunderstand();
echo json_encode($stmt);
?>