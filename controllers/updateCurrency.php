<?php
include "../config/db.php";
include "../models/dbOperations.php";
// Coin ir tā vērtība pogas, kuru lietotājs nospiežot, tiek ievadīta datubāzē pie BetsAmount
if (isset($_POST['coin'])) {
    session_start();
    $userID = $_SESSION['user'];
    $currency = $_POST['coin'];
    $eventID = $_POST['event'];
    $fighterID = $_POST['fighter'];
    $koef = $_POST['koef'];
    $mainEv = $_POST['mainEv'];

    // Dabū lietotāja kopējo valūtas summu
    $sqlGetCurrency = "SELECT currency FROM loginhelp WHERE id = ?";
    // Aizsargā pret SQL injekcijām
    $stmtGetCurrency = $conn->prepare($sqlGetCurrency);
    $stmtGetCurrency->bind_param("i", $userID);
    $stmtGetCurrency->execute();
    $resultGetCurrency = $stmtGetCurrency->get_result();
    $rowGetCurrency = $resultGetCurrency->fetch_assoc();
    $userTotalCurrency = $rowGetCurrency['currency'];
    // Ievieto lietotāja likmi un likmes datus datubāzē
    $sqlIns = "INSERT INTO UserBets (SingleEventId, eventId, FighterId, Koef, UserId, BetAmount) VALUES (?, ?, ?, ?, ?, ?)";
    // Aizsargā pret SQL injekcijām
    $stmt = $conn->prepare($sqlIns);
    $stmt->bind_param("iiidii", $eventID, $mainEv, $fighterID, $koef, $userID, $currency);
    $stmt->execute();
    // Atjaunina lietotāja valūtas summu atņemot no tās likmes vērtību
    $sql = "UPDATE loginhelp SET currency = currency - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $currency, $userID);
    $stmt->execute();
    $updateCurrency = $stmt->affected_rows;
    echo json_encode($updateCurrency);
}