<?php
header('Content-Type: text/html; charset=utf-8');

class understandobj
{
    public $understandID;
    public $understandSoup;
    
    function readunderstand()
    {
        $test_svar = "stringo pingo";
        return $test_svar;
    }
    function createunderstand($data_fra)
    {
        //$this->$understandSoup;
        echo json_encode($data_fra);
        //echo "hallo";
        return true;
    }
}

?>