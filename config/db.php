<?php
$host = 'localhost';
$user = 'skolnieks';
$pass = 'pQcM10ClEn3lSWy';
$dbName = 'ralfsd';

$conn = new mysqli($host, $user, $pass, $dbName);

if ($conn->connect_error) {
    echo "There was an error connecting to the database!";
}
