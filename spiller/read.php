<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objekter/spiller.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$spiller = new spiller($db);
 
// query spiller
$stmt = $spiller->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // spiller array
    $spiller_arr=array();
    $spiller_arr["spiller"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $spiller_item=array(
            "SpillerID" => $SpillerID,
            "SpillerFornavn" => $SpillerFornavn,
            "SpillerOmgang" => 0,
            "SpillerResultat" => 0,
        );
        array_push($spiller_arr["spiller"], $spiller_item);
    }
    echo json_encode($spiller_arr);
}

else{
    echo json_encode(
        array("message" => "Ingen spillere funnet")
    );
}
?>