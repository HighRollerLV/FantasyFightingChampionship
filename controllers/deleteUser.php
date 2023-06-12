<?php
session_start();
include "../models/dbOperations.php";
include "../config/db.php";
include "../controllers/sessions.php";
$userID = $_SESSION['user'];
// Dzēš lietotāju no datubāzes
$stmt = $conn->prepare("DELETE FROM loginhelp WHERE id=?");
// Aizsargā pret SQL injekcijām
$stmt->bind_param("i", $userID);
// Pārbauda vai izpildījās
if ($stmt->execute()) {
    // Ja funkcija izpildas, tad lietotājam pārtrauc sesiju un iznīcina to.
    unset($_SESSION['user']);
    unset($_SESSION['logged']);
    session_destroy();
    $insertDel = 0;
} else {
    // Ja neizpildījās izvada kļūdu
    $insertDel = "Error! Please try again!";
}
echo $insertDel;