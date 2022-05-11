<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

require "../database/databaseManager.php";
require "../entity/User.php";

session_start();

$user = new User(null, null, null, null, $_POST["username"], $_POST["password"]);

$rs = User::login($user, $connection);

if (!empty($rs) && $rs->num_rows > 0) {
    while ($row = $rs->fetch_array()) {
        echo json_encode(array('status' => 'success', 'userID' => $row['userID'], 'username' => $row['username']));
    }
} else {
    echo json_encode(array('status' => 'failed'));
}