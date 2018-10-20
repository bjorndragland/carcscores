<?php
header('Content-Type: text/html; charset=utf-8');

class understandobj
{
    public $ResultatID;

    function readunderstand()
    {
        $test_svar = "stringo pingo";
        return $test_svar;
    }
    function createunderstand()
    {
        $this->understandID = htmlspecialchars(strip_tags($this->understandID));
        //$stmt->bindParam(":ResultatID", $this->understandID);

    }
}

?>