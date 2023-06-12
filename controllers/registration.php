<?php
include "../models/dbOperations.php";
include "../config/db.php";
// Dezinficē ievadītos datus no lietotāja puses un saglabā mainīgajos
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$nickname = filter_var($_POST['nickname'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$repeatpassword = filter_var($_POST['repeatpassword'], FILTER_SANITIZE_STRING);

// Pārbauda vai visi lauki ir aizpildīti
if (empty($email) || empty($nickname) || empty($password) || empty($repeatpassword)) {
    echo "All fields are required! Please try again!";
} // Pārbauda vai paroles atkārtojums sakrīt
elseif ($password !== $repeatpassword) {
    echo "Passwords do not match! Please try again!";
} // Pārbauda vai e-pasts ir derīgs
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address!";
} // Pārbauda vai parole ir droša
elseif (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password)) {
    echo "Password must contain at least 8 characters, including at least one number and one capital letter!";
} else {
    // Aizsargā pret SQL injekcijām
    $stmt = $conn->prepare("SELECT nickname FROM loginhelp WHERE nickname = ? OR email = ?");
    $stmt->bind_param("ss", $nickname, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    // Pārbauda vai lietotājs jau eksistē
    if (!empty($row)) {
        echo "User already exists!";
    } else {
        // Ja lietotājs neeksistē, saglabā datus datubāzē
        // Šifrē paroli
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO loginhelp (email, nickname, `password`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $nickname, $hashed_password);
        // Pārbauda vai izpildījās un izvada atbilstošu paziņojumu
        if ($stmt->execute()) {
            echo "The data has been added successfully!";
        } else {
            echo "Error! Failed to add data!";
        }
    }
}
