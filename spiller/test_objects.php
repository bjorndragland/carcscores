<?php
header('Content-Type: application/json');

$stringo = "testos";
$arr0 = array('pacemaker' => 23, 'bodydouble' => "jensen");

$arr = array($stringo => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => $arr0);

$arr['e']['bodydouble']= 222;

echo json_encode($arr);
?>
