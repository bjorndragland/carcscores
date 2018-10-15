<?php
header('Content-Type: text/html; charset=utf-8');
class spiller
{
    // database connection and table name
    private $conn;
    private $table_name = "spiller";
 
    // spiller attributter
    public $SpillerID;
    public $SpillerFornavn;
 
    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

   // les spillere
    function read()
    {
    // select all query
        $query = "SELECT
               SpillerID, SpillerFornavn
            FROM
                spiller
            ORDER BY SpillerFornavn";
    // prepare query statement
        $stmt = $this->conn->prepare($query);
    // execute query
        $stmt->execute();
        return $stmt;
    }

// opprett spiller
    function create()
    {
        // query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                SpillerFornavn=:SpillerFornavn";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->SpillerFornavn = htmlspecialchars(strip_tags($this->SpillerFornavn));
     
        // bind values
        $stmt->bindParam(":SpillerFornavn", $this->SpillerFornavn);
     
        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>