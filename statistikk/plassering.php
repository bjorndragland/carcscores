<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objekter/statistikk.php';

$database = new Database();
$db = $database->getConnection();
 
// initialize object
$statistikk = new statistikk($db);

$stmt = $statistikk->plassering();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
 
    // resultat array
    $statistikk_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $statistikk_item = array(
            'ResOmgRef' => $ResOmgRef,
            'ResSpillerRef' => $ResSpillerRef,
            'ResPoeng' => $ResPoeng
        );
/*
        $stat_toparray = array(
            $ResOmgRef => $statistikk_item
            
        ); */
        array_push($statistikk_arr, $statistikk_item);

    }

} else {
    echo json_encode(
        array('message' => 'Ingen resultat funnet')
    );
}



// samle opp vinnere:
$omgang_arr = [];
$omgangstats = array('score1' => 0, 'spiller1' => 0);

for ($x = 0; $x <= count($statistikk_arr) - 1; $x++) {

    if (array_key_exists($statistikk_arr[$x]['ResOmgRef'], $omgang_arr)) {
        // sjekk om poengsum er høyere
        if ($statistikk_arr[$x]['ResPoeng'] > $omgangstats['score1']) {
            $omgangstats['score1'] = $statistikk_arr[$x]['ResPoeng'];
            $omgangstats['spiller1'] = $statistikk_arr[$x]['ResSpillerRef'];
            $omgang_arr[$statistikk_arr[$x]['ResOmgRef']] = $omgangstats;

            //echo $statistikk_arr[$x]['ResOmgRef'];
            //echo '-';
            //echo $statistikk_arr[$x]['ResPoeng'];
            //echo ' ';

        } else {

            //echo 'lower ';

        };

    } else {
        //$omgang_arr[$statistikk_arr[$x]['ResOmgRef']] = $statistikk_arr[$x]['ResPoeng'];
        $omgangstats['score1'] = $statistikk_arr[$x]['ResPoeng'];
        $omgangstats['spiller1'] = $statistikk_arr[$x]['ResSpillerRef'];
        $omgang_arr[$statistikk_arr[$x]['ResOmgRef']] = $omgangstats;

    }


};
echo json_encode($omgang_arr);

?>