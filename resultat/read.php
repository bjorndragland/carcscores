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

//    *** **** IKKE FERDIG
$stmt = $resultat->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
 
    // products array
    $resultat_arr = array();
    $resultat_arr['resultat'] = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $resultat_item = array(
            'ResultatID' => $ResultatID,
            'ResOmgRef' => $ResOmgRef,
            'ResSpillerRef' => $ResSpillerRef,
            'ResPoeng' => $ResPoeng
            //'navnEtter' => $navnEtter
        );

        $res_toparray = array(
            $ResOmgRef => $resultat_item
        );
        array_push($resultat_arr['resultat'], $res_toparray);

        //array_push($resultat_arr['resultat'], $resultat_item);
    }

    echo json_encode($resultat_arr);
} else {
    echo json_encode(
        array('message' => 'Ingen resultat funnet')
    );
}
?>