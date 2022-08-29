<?php
/**
 * Handles requests to database
 */

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE"); //Enables specific types of requests to be carried out
header("Access-Control-Allow-Origin: *"); //Enables api to handle cross origin requests
header("Access-Control-Allow-Headers: *"); //Enables api to respond to preflight requests

include "DbManager.php";

$dbManager = new DbManager(); 

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case "POST":
        $dbManager->addProduct();
        break;
    case "GET":
        $dbManager->getProducts();
        break;
    case "DELETE":
        $dbManager->deleteProduct();
        break;
}