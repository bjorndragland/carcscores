<?php
// kopiert fra API_tester
header('Content-Type: text/html; charset=utf-8');

class resultat
{
    // database connection and table name
    private $conn;
    private $table_name = "resultat";
 
    // spiller attributter
    public $ResultatID;
    public $ResOmgangRef;
    public $ResSpillerRef;
    public $ResPoeng;


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


// ****************** SKRIV OM *****************
// opprett spillresultat
    function create()
    {
        // query
        $query = "INSERT INTO
                    " . $this->table_name . "
             SET
             ResultatID=:ResultatID, ResOmgRef=:ResOmgRef, ResSpillerRef=:ResSpillerRef, ResPoeng=:ResPoeng";
  
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->ResultatID = htmlspecialchars(strip_tags($this->ResultatID));
        $this->ResOmgRef = htmlspecialchars(strip_tags($this->ResOmgRef));
        $this->ResSpillerRef = htmlspecialchars(strip_tags($this->ResSpillerRef));
        $this->ResPoeng = htmlspecialchars(strip_tags($this->ResPoeng));
     
        // bind values
        $stmt->bindParam(":ResultatID", $this->ResultatID);
        $stmt->bindParam(":ResOmgRef", $this->ResOmgRef);
        $stmt->bindParam(":ResSpillerRef", $this->ResSpillerRef);
        $stmt->bindParam(":ResPoeng", $this->ResPoeng);
     
        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
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