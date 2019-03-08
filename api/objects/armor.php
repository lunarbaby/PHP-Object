<?php
class Armor{
 
    // database connection and table name
    private $conn;
    private $table_name = "loot";
 
    // object properties
    public $itemID;
    public $gearColor;
    public $gearType;
    public $statOne;
    public $statTwo;
    public $statThree;
    public $statFour;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 
    // select all query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " a
            ORDER BY
                a.itemID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                gearColor=:gearColor, gearType=:gearType, statOne=:statOne, statTwo=:statTwo, statThree=:statThree, statFour=:statFour";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->gearColor=htmlspecialchars(strip_tags($this->gearColor));
    $this->gearType=htmlspecialchars(strip_tags($this->gearType));
    $this->statOne=htmlspecialchars(strip_tags($this->statOne));
    $this->statTwo=htmlspecialchars(strip_tags($this->statTwo));
    $this->statThree=htmlspecialchars(strip_tags($this->statThree));
    $this->statFour=htmlspecialchars(strip_tags($this->statFour));
 
    // bind values
    $stmt->bindParam(":gearColor", $this->gearColor);
    $stmt->bindParam(":gearType", $this->gearType);
    $stmt->bindParam(":statOne", $this->statOne);
    $stmt->bindParam(":statTwo", $this->statTwo);
    $stmt->bindParam(":statThree", $this->statThree);
    $stmt->bindParam(":statFour", $this->statFour);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " a
            WHERE
                a.itemID = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->itemID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->gearColor = $row['gearColor'];
    $this->gearType = $row['gearType'];
    $this->statOne = $row['statOne'];
    $this->statTwo = $row['statTwo'];
    $this->statThree = $row['statThree'];
    $this->statFour = $row['statFour'];
}
// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                gearColor = :gearColor,
                gearType = :gearType,
                statOne = :statOne,
                statTwo = :statTwo,
                statThree = :statThree,
                statFour = :statFour
            WHERE
                itemID = :itemID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->gearColor=htmlspecialchars(strip_tags($this->gearColor));
    $this->gearType=htmlspecialchars(strip_tags($this->gearType));
    $this->statOne=htmlspecialchars(strip_tags($this->statOne));
    $this->statTwo=htmlspecialchars(strip_tags($this->statTwo));
    $this->statThree=htmlspecialchars(strip_tags($this->statThree));
    $this->statFour=htmlspecialchars(strip_tags($this->statFour));
 
    // bind new values
    $stmt->bindParam(':gearColor', $this->gearColor);
    $stmt->bindParam(':gearType', $this->gearType);
    $stmt->bindParam(':statOne', $this->statOne);
    $stmt->bindParam(':statTwo', $this->statTwo);
    $stmt->bindParam(':statThree', $this->statThree);
    $stmt->bindParam(':statFour', $this->statFour);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->itemID=htmlspecialchars(strip_tags($this->itemID));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->itemID);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}