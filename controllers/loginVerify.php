<?php
session_start();
include "../models/dbOperations.php";
include "../config/db.php";
//Pārbauda vai lietotājs ir ievadījis e-pasta adresi un paroli
if (isset($_POST['email2']) && isset($_POST['password2'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email2']);
    $password = mysqli_real_escape_string($conn, $_POST['password2']);
//Iegūst datus no datu bāzes
    $stmt = $conn->prepare("SELECT * FROM loginhelp WHERE email = ?");
    //Novērš SQL injekcijas
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
//Pārbauda vai lietotājs eksistē
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //Pārbauda vai parole un e-pasta adrese sakrīt ar datu bāzes vērtībām
            if ($email == $row['email'] && password_verify($password, $row['password'])) {
                $_SESSION['user'] = $row['id'];
                $_SESSION['logged'] = true;
                $users = "true";
            } else {
                $users = "Password or Email is incorrect, please try again!";
            }
        }
    } else {
        $users = "User does not exist";
    }
    //Pārbauda vai visi lauki ir aizpildīti
} else {
    $users = "Fill in all fields!";
}

if (!empty($users)) {
    echo htmlentities($users, ENT_QUOTES);
}
