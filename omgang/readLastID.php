<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
 
// include database and object files
include_once '../config/database.php';
include_once '../objekter/omgang.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$omgang = new omgang($db);
 
// query
$stmt = $omgang->readLastID();
$value = $stmt->fetch(PDO::FETCH_ASSOC);
// siste rad
echo json_encode($value);
?>