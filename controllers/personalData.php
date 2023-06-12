<?php
session_start();
include "../models/dbOperations.php";
include "../config/db.php";
include "../controllers/sessions.php";
include "../models/countries.php";

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$location = $_POST['location'];
$age = $_POST['age'];
$userID = userID();

if (empty($firstName) || empty($lastName) || empty($location) || empty($age)) {
    $insertMsg = "All fields must be filled!";
} else if ($age < 18) {
    $insertMsg = "You have to be 18 years old or older!";
} else if (!in_array($location, $countries)) {
    $insertMsg = "Invalid location selected";
} else {
    $stmt = $conn->prepare("UPDATE loginhelp SET firstName=?, lastName=?, location=?, age=? WHERE id=?");
    $stmt->bind_param("ssssi", $firstName, $lastName, $location, $age, $userID);
    if ($stmt->execute()) {
        $insertMsg = "Data has been added successfully!";
    } else {
        $insertMsg = "Data has not been added! Try again!";
    }
}
echo $insertMsg;