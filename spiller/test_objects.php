<?php
header('Content-Type: application/json');

$stringo = "puler";

$arr = array($stringo => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);

echo json_encode($arr);
?>
