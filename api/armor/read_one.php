<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/armor.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$armor = new Armor($db);
 
// set ID property of record to read
$armor->itemID = isset($_GET['itemID']) ? $_GET['itemID'] : die();
 
// read the details of product to be edited
$armor->readOne();
 
if($armor->gearColor!=null){
    // create array
    $armor_arr = array(
        "itemID" =>  $armor->itemID,
        "gearColor" => $armor->gearColor,
        "gearType" => $armor->gearType,
        "statOne" => $armor->statOne,
        "statTwo" => $armor->statTwo,
        "statThree" => $armor->statThree,
        "statFour" => $armor->statFour
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($armor_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Armor piece does not exist."));
}
?>