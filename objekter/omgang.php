<?php
header('Content-Type: text/html; charset=utf-8');

class omgang
{
    // database connection and table name
    private $conn;
    private $table_name = "omgang";
 
    // spiller attributter
    public $OmgangID;
    public $OmgangOpprettet;

   // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


// les spillomganger
    function read()
    {
    // select all query
        $query = "SELECT
            OmgangID, OmgangOpprettet
        FROM
            omgang
        ORDER BY OmgangID";
        
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // execute query
        $stmt->execute();
        return $stmt;
    }

// opprett spillomgang
    function create()
    {
        // query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                OmgangID=:OmgangID";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->OmgangID = htmlspecialchars(strip_tags($this->OmgangID));
     
        // bind values
        $stmt->bindParam(":OmgangID", $this->OmgangID);
     
        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

// oppdater spillomgang
    function update()
    {

    }

// slett spillomgang
    function delete()
    {

    }

}

?>