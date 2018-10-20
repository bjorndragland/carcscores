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
include_once '../objekter/understandobj.php';

$understandobj = new understandobj();
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
//$understandobj->understandID = $data->understandID;
//$understandobj->understandSoup = $data->understandSoup;

//echo $understandobj->understandSoup;
$understandobj->createunderstand($data);

?>