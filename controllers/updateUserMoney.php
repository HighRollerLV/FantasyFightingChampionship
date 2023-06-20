<?php
// Iekļauj datubāzi
include "../config/db.php";
// Uzsāk sesiju
session_start();
// Ja no javascript ir padota vērtība getResult tad izpilda kodu
if (isset($_POST['getResult'])) {
    $userID = $_SESSION['user'];
    // Paņem no datubāzes visu, kas ir vienāds ar lietotāja ID
    $stmt = $conn->prepare("SELECT * FROM UserBets WHERE UserId = ?");
    // Aizsargā pret SQL injekcijām
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    // Nosacījums pārbauda, vai vaicājumā atgriezto rindu skaits ir lielāks par nulli.
    if ($result->num_rows > 0) {
        $hasResultsThisWeek = false;
        // Iegūst no datubāzes ierakstus vienu pa vienam
        while ($row = $result->fetch_assoc()) {
            $fighterId = $row['FighterId'];
            $betAmount = $row['BetAmount'];
            $koef = $row['Koef'];
            $mainEv = $row['eventId'];
            // Paņem no datubāzes visu, kas ir vienāds ar id
            $fighterNameStmt = $conn->prepare("SELECT * FROM Fighter WHERE id = ?");
            // Aizsargā pret SQL injekcijām
            $fighterNameStmt->bind_param("i", $fighterId);
            $fighterNameStmt->execute();
            $fighterNameResult = $fighterNameStmt->get_result();
            $fighterNameResult = $fighterNameResult->fetch_assoc();
            $fighterName = $fighterNameResult['fighter'];
            $figId = $fighterNameResult['fig_id'];
            $fighterNameStmt->close();
            // Ievāc visus datus no ufcResults tabulas, kur eventId, singleEventId un date tiek iegūtu 6 dienu intervālā
            $result2 = $conn->prepare("SELECT * FROM ufcResults WHERE eventId = ? AND singleEventId = ? AND `date` >= CURDATE() - INTERVAL 6 DAY AND `date` <= CURDATE()");
            // Aizsargā pret SQL injekcijām
            $result2->bind_param("ii", $mainEv, $row['SingleEventId']);
            $result2->execute();
            $result2 = $result2->get_result();
            // Nosacījums pārbauda, vai vaicājumā atgriezto rindu skaits ir lielāks par nulli.
            if ($result2->num_rows > 0) {
                $hasResultsThisWeek = true;
                $row2 = $result2->fetch_assoc();
                $fightWinner = $row2['fightWinner'];
                // Aprēķina likmes izmaksu. Koeficients reizināts ar likmes daudzumu un dalīts ar 20
                $calculate = intval($koef * $betAmount / 20);
                // Ja rinda paid = 0, tad izpilda kodu
                if ($row['paid'] == 0 && $fightWinner == $figId) {
                    // Atjaunina lietotāja tobrīdējo naudas daudzumu ar aprēķināto likmes izmaksu
                    $updateStmt = $conn->prepare("UPDATE loginhelp SET currency = currency + ? WHERE id = ?");
                    $updateStmt->bind_param("ii", $calculate, $userID);
                    $updateResult = $updateStmt->execute();
                    // Ja mainīgais $updateResult ir izsaukts, tad izpilda kodu
                    if ($updateResult) {
                        // Atjaunina paid = 1, lai vairs nevarētu izmaksāt likmi
                        $updatePaidStmt = $conn->prepare("UPDATE UserBets SET paid = 1 WHERE UserId = ?");
                        $updatePaidStmt->bind_param("i", $userID);
                        // Novērš sql injekcijas
                        $updatePaidStmt->execute();
                        //Iegūst lietotāja id no tabulas loginhelp
                        $playerPaidStmt = $conn->prepare("SELECT * FROM loginhelp WHERE id = ?");
                        $playerPaidStmt->bind_param("i", $userID);
                        // Novērš sql injekcijas
                        $playerPaidStmt->execute();
                        $playerPaidStmt = $playerPaidStmt->get_result();
                        $playerPaidStmt = $playerPaidStmt->fetch_assoc();
                        //Izsauc lietotāja naudas daudzumu
                        echo $playerPaidStmt['currency'];

                    }

                }
            }
            $result2->close();
        }
    }
    $result->free_result();
    $stmt->close();
    $conn->close();
}
