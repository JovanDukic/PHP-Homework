<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

require "../database/databaseManager.php";
require "../entity/Post.php";

echo json_encode(Post::loadSpecificFeed($_POST['userID'], $_POST['username'], $connection));