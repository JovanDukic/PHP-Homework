<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

require "../database/databaseManager.php";
require "../entity/Like.php";

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if($_POST['Action'] == 'CREATE') {
    echo Like::createLike($_POST['commentID'], $_POST['userID'], $connection);
} else {
    echo Like::deleteLike($_POST['commentID'], $_POST['userID'], $connection);
}


