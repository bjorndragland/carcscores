<?php
// kopiert fra API_tester
header('Content-Type: text/html; charset=utf-8');

class resultat
{
    // database connection and table name
    private $conn;
    private $table_name = "resultat";
 
    // spiller attributter
    public $resultatID;
    public $omgangRef;
    public $spillerRef;
    public $omgang;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

// les spillresultater, hele tabellen
    function read()
    {
        $query = "SELECT
               ResultatID, ResOmgRef, ResSpillerRef, ResPoeng
            FROM
                resultat
            ORDER BY ResOmgRef";
 
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // execute query
        $stmt->execute();
        return $stmt;
    }



// opprett spillresultat
    function create()
    {

    }

// oppdater spillresultat
    function update()
    {

    }

// slett spillresultat
    function delete()
    {

    }

}

?>