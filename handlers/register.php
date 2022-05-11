<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

require "../database/databaseManager.php";
require "../entity/User.php";

$user = new User(null, $_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["username"], $_POST["password"]);

if (User::checkUsername($user->username, $connection)) {
    echo "exists";
    exit();
}

$res = User::register($user, $connection);

if ($res) {
    $rs = User::getGeneratedKey($connection);

    if (!empty($rs) && $rs->num_rows > 0) {
        while ($row = $rs->fetch_array()) {
            echo json_encode(array('status' => 'success', 'ID' => $row['ID']));
        }
    } else {
        echo json_encode(array('status' => 'failed', 'ID' => $row['ID']));
    }
} else {
    echo json_encode(array('status' => 'failed', 'ID' => $row['ID']));
}

