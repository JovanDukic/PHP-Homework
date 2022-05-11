<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

require "../database/databaseManager.php";
require "../entity/User.php";

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

echo User::updateUser($_POST['userID'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['username'], $_POST['password'], $connection);