<?php
session_start();
include "../models/dbOperations.php";
include "../config/db.php";
include "../controllers/sessions.php";

$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$checkPassword = $_POST['checkPassword'];
$userID = userID();
$insertMsg = "";

$sql = "SELECT password FROM loginhelp WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$currentPassword = $row['password'];

if (empty($newPassword) || empty($checkPassword)) {
    $insertMsg = "Please enter your new password.";

} elseif ($newPassword !== $checkPassword) {
    $insertMsg = "Passwords do not match. Please try again.";
} elseif (strlen($newPassword) < 8 || !preg_match("#[0-9]+#", $newPassword) || !preg_match("#[A-Z]+#", $newPassword) || !preg_match("#[a-z]+#", $newPassword)) {
    $insertMsg = "Password must contain at least 8 characters, including at least one number and one capital letter!";
} elseif (password_verify($oldPassword, $currentPassword) === false) {
    $insertMsg = "Your current password is incorrect. Please try again.";

} elseif (password_verify($newPassword, $currentPassword)) {
    $insertMsg = "Your new password is the same as your old password. Please choose a different password.";
}


if (empty($insertMsg)) {
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE loginhelp SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $newPasswordHash, $userID);
    mysqli_stmt_execute($stmt);

    $insertMsg = "Your password has been updated successfully.";
}


echo $insertMsg;