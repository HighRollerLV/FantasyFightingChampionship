<?php
$userID = $_SESSION['user'];

$stmt = $conn->prepare("SELECT * FROM UserBets WHERE UserId = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '
    <h1 class="text-2xl font-bold">You currently have no active bets</h1>
    ';
} else {
    $hasResultsThisWeek = false;

    while ($row = $result->fetch_assoc()) {
        $fighterId = $row['FighterId'];
        $betAmount = $row['BetAmount'];
        $koef = $row['Koef'];
        $mainEv = $row['eventId'];
        $fighterNameStmt = $conn->prepare("SELECT fighter, fig_id FROM Fighter WHERE id = ?");
        $fighterNameStmt->bind_param("i", $fighterId);
        $fighterNameStmt->execute();
        $fighterNameResult = $fighterNameStmt->get_result();
        $fighterNameResult = $fighterNameResult->fetch_assoc();
        $fighterName = $fighterNameResult['fighter'];
        $figId = $fighterNameResult['fig_id'];
        $fighterNameStmt->close();

        $result2 = $conn->prepare("SELECT * FROM ufcResults WHERE eventId = ? AND singleEventId = ? AND `date` >= CURDATE() - INTERVAL 6 DAY AND `date` <= CURDATE()");
        $result2->bind_param("ii", $mainEv, $row['SingleEventId']);
        $result2->execute();
        $result2 = $result2->get_result();

        if ($result2->num_rows > 0) {
            $hasResultsThisWeek = true;
            $row2 = $result2->fetch_assoc();
            $fightWinner = $row2['fightWinner'];
            $calculate = intval($koef * $betAmount / 20);

            if ($row['paid'] == 0) {
                $updateStmt = $conn->prepare("UPDATE loginhelp SET currency = currency + ? WHERE id = ?");
                $updateStmt->bind_param("ii", $calculate, $userID);
                $updateResult = $updateStmt->execute();
                $updateStmt->close();

                if ($updateResult) {
                    $updatePaidStmt = $conn->prepare("UPDATE UserBets SET paid = 1 WHERE UserId = ?");
                    $updatePaidStmt->bind_param("i", $userID);
                    $updatePaidStmt->execute();
                    $updatePaidStmt->close();
                }
            }

            $outcome = ($fightWinner == $figId) ? 'Won' : 'Lost';
            $amountReceived = abs($calculate);
            $fightRounds = $row2['fightRounds'];
            $finalRound = $row2['finalRound'];
            $finalMinute = $row2['finalMinute'];
            $method = ucwords(str_replace('_', ' ', $row2['method']));

            echo '
                <div class="flex flex-col bg-[#606060] drop-shadow-xl rounded-lg shadow-md p-4 mb-4 text-[#e4c065] w-72 h-80">
                    <p class="text-xl font-bold mb-2">Fighter: ' . $fighterName . '</p>
                    <p class="text-lg">Bet Amount: $' . $betAmount . '</p>
                    <p class="text-lg">Outcome: ' . $outcome . '</p>
                    <p class="text-lg">Amount Received: $' . $amountReceived . '</p>
                    <p class="text-lg">Fight Rounds: ' . $fightRounds . '</p>
                    <p class="text-lg">Final Round: ' . $finalRound . '</p>
                    <p class="text-lg">Final Minute: ' . $finalMinute . '</p>
                    <p class="text-lg">Method: ' . $method . '</p>
                </div>
                ';
        }

        $result2->free_result();
    }

    if (!$hasResultsThisWeek) {
        echo '
        <h1 class="text-2xl font-bold">No bets have been made this week</h1>
        ';
    }
}

$result->free_result();
$stmt->close();
$conn->close();