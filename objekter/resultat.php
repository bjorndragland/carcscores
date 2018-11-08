<?php
header('Content-Type: text/html; charset=utf-8');

class resultat
{
    // database connection and table name
    private $conn;
    private $table_name = 'resultat';
 
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
        $query = 'SELECT
               ResultatID, ResOmgRef, ResSpillerRef, ResPoeng
            FROM
                resultat
            ORDER BY ResOmgRef';
 
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
        $query = 'INSERT INTO
                    ' . $this->table_name . '
             SET
             ResultatID=:ResultatID, ResOmgRef=:ResOmgRef,
             ResSpillerRef=:ResSpillerRef, ResPoeng=:ResPoeng';
  
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->ResultatID = htmlspecialchars(strip_tags($this->ResultatID));
        $this->ResOmgRef = htmlspecialchars(strip_tags($this->ResOmgRef));
        $this->ResSpillerRef = htmlspecialchars(strip_tags($this->ResSpillerRef));
        $this->ResPoeng = htmlspecialchars(strip_tags($this->ResPoeng));
     
        // bind values
        $stmt->bindParam(':ResultatID', $this->ResultatID);
        $stmt->bindParam(':ResOmgRef', $this->ResOmgRef);
        $stmt->bindParam(':ResSpillerRef', $this->ResSpillerRef);
        $stmt->bindParam(':ResPoeng', $this->ResPoeng);
     
        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function createmulti($omgdata)
    {
        $querystreng0 = '';
        foreach ($omgdata as $spillerres) {
            $querystreng0 = $querystreng0 . '(NULL,' . $spillerres->SpillerOmgang . ',' . $spillerres->SpillerID . ',' . $spillerres->SpillerResultat . '),';
        }
        $querystreng1 = substr($querystreng0, 0, (strlen($querystreng0) - 1));
        $query4 = 'INSERT INTO resultat (ResultatID, ResOmgRef, ResSpillerRef, ResPoeng) VALUES' . $querystreng1 . '';
        $stmt4 = $this->conn->prepare($query4);
        if ($stmt4->execute()) {
            return true;
        } else {
            return false;
        }
    }



    // hent spillere til resultat-tabell
    function getPlayerHeaders()
    {
        $queryP = 'SELECT spiller.SpillerID, spiller.SpillerFornavn
        FROM kaerkis.spiller
        ORDER BY SpillerID';
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

    // hent resultat-tabell basert på spillere fra getPlayerHeaders
    function getIts($playerArray)
    {
        $delstreng = '';
        foreach ($playerArray as $player) {
           $delstreng = $delstreng . 'SUM( IF(resspillerref = ' . ($player->SpillerID) .
         ', respoeng,0) ) AS ' . ($player->SpillerFornavn) . ', ';
         //   $delstreng = $delstreng . 'SUM( IF(resspillerref = ' . ($player->SpillerID) .
           // ', respoeng,0) ) AS "' . ($player->SpillerID) . '", ';
        };
        $delstreng2 = substr($delstreng, 0, (strlen($delstreng) - 2));
        $query3 = 'SELECT resultat.resomgref, omgang.omgangdato,' . $delstreng2 . ' FROM kaerkis.resultat
        INNER JOIN omgang ON resultat.resomgref = omgang.omgangID
        group by resomgref';
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->execute();
        $num3 = $stmt3->rowCount();


        if ($num3 > 0) {
            $resultat3_arr = array();
            $res_arr = array();
            $resultat3_arr['resultat'] = array();
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                extract($row3);

                $resomgidarray = array(
                    'ResOmgRef' => $row3
                    //$row3
                );

                array_push($resultat3_arr['resultat'], $row3);
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