<?php
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
    public $resomgref;
    public $allPlayers;
    public $resultatP_arr;

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
        // query
        $query = "INSERT INTO
                    " . $this->table_name . "
             SET
             ResultatID=:ResultatID, ResOmgRef=:ResOmgRef,
             ResSpillerRef=:ResSpillerRef, ResPoeng=:ResPoeng";
  
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

    // hent spillere til resultat-tabell
    function getPlayerHeaders()
    {
        $queryP = "SELECT spiller.SpillerID, spiller.SpillerFornavn
        FROM kaerkis.spiller
        ORDER BY SpillerID";
        $stmtP = $this->conn->prepare($queryP);
        $stmtP->execute();
        $numP = $stmtP->rowCount();
        if ($numP > 0) {

            $resultatP_arr = array();
            while ($rowP = $stmtP->fetch(PDO::FETCH_OBJ)) {
                array_push($resultatP_arr, $rowP);
            }
            return $resultatP_arr;
        } else {
            return false;
        }
    }

    // hent resultat-tabell basert på spillere
    function getIts($playerArray)
    {
        $delstreng = "";
        foreach ($playerArray as $value) {
            $delstreng = $delstreng . "SUM( IF(resspillerref = " . ($value->SpillerID) . ", respoeng,0) ) AS " . ($value->SpillerFornavn) . ", ";
        };
        $delstrenglen = strlen($delstreng);
        $delstreng2 = substr($delstreng, 0, ($delstrenglen - 2));
        $query3 = "SELECT resultat.resomgref, omgang.omgangdato," . $delstreng2 . " FROM kaerkis.resultat
        INNER JOIN omgang ON resultat.resomgref = omgang.omgangID
        group by resomgref";
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->execute();
        $num3 = $stmt3->rowCount();
        if ($num3 > 0) {
            $resultat3_arr = array();
            $resultat3_arr["resultat"] = array();
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                extract($row3);
                array_push($resultat3_arr["resultat"], $row3);
            }
            return $resultat3_arr;
        } else {
            return false;
        }
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