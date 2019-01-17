<?php
header('Content-Type: text/html; charset=utf-8');

class statistikk
{
    // database connection and table name
    private $conn;
    private $table_name = 'resultat';
 
    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function plassering()
    {
        $query = 'SELECT
               ResOmgRef, ResSpillerRef, ResPoeng
            FROM
                resultat
            ORDER BY ResOmgRef';
 
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // execute query
        $stmt->execute();
        return $stmt;
    }
}
?>