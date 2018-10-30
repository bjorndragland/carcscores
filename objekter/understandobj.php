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
        //$datajson =  json_encode($data_fra);
        //echo $datajson->understands[1]->understandID;
        echo $data_fra->understands[1]->understandID;

        return true;
    }
}

?>