<?php

$host = "localhost";
$port = 3306;
$database = "iteh_projekat";
$username = "root";
$password = "root";

$connection = new mysqli($host, $username, $password, $database, $port);

$connection->autocommit(true);

if ($connection->connect_errno) {
    exit("Failed to connect to DB!");
}
