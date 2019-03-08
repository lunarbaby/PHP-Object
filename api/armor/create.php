<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/armor.php';
 
$database = new Database();
$db = $database->getConnection();
 
$armor = new Armor($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->gearColor) &&
    !empty($data->gearType) &&
    !empty($data->statOne) &&
    !empty($data->statTwo) &&
    !empty($data->statThree) &&
    !empty($data->statFour)
){
 
    // set product property values
    $armor->gearColor = $data->gearColor;
    $armor->gearType = $data->gearType;
    $armor->statOne = $data->statOne;
    $armor->statTwo = $data->statTwo;
    $armor->statThree = $data->statThree;
    $armor->statFour = $data->statFour;
 
    // create the product
    if($armor->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Armor piece was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create armor piece."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create armor piece. Data is incomplete."));
}
?>