<?php

//Izvēlas datus no tabulas UFC_Single_Event 8 dienu intervālā
$event = "SELECT * FROM UFC_Single_Event
WHERE eventDate >= CURDATE() AND eventDate <= DATE_ADD(CURDATE(), INTERVAL 8 DAY)
ORDER BY id DESC";
//Priekš pārbaudēm
//$event = "SELECT * FROM UFC_Single_Event
//WHERE eventDate >= DATE_SUB(CURDATE(), INTERVAL 20 DAY) AND eventDate <= CURDATE()
//ORDER BY id DESC";
$stmt = $conn->prepare($event);

// Pārbaude priekš veiksmīgas izpildes
if ($stmt) {
    // Izpilda vaicājumu
    $stmt->execute();

    // Dabū rezultātus no vaicājuma un ieraksta mainīgajā $result
    $result = $stmt->get_result();
    $i = 0;
    $eventPrinted = false;
    $cardNull = null;
    // Kamēr ir rindas, izvada datus uz ekrāna
    while ($rowEv = $result->fetch_assoc()) {

        $figAway = $rowEv["fighter_away_id"];
        $figHome = $rowEv["fighter_home_id"];
        //Izvēlas datus no tabulas Fighter par attiecīgajiem cīkstoņiem (home un away)
        $fighterHome = "SELECT * FROM Fighter WHERE fig_id = $figHome";
        $fighterAway = "SELECT * FROM Fighter WHERE fig_id = $figAway";
        $figHomeSelected = select($fighterHome, $conn);
        $figAwaySelected = select($fighterAway, $conn);
        $figHomeSelected = $figHomeSelected->fetch_assoc();
        $figAwaySelected = $figAwaySelected->fetch_assoc();

        //Veic pielabojumus datiem, lai izvadītu uz ekrāna pareizi formatētus
        $fighterHomeFull = substr(strstr($figHomeSelected["fighter"], ', '), 2) . ' ' . strstr($figHomeSelected["fighter"], ', ', true);
        $fighterHomeRank = str_replace('99', 'NR', ($figHomeSelected["rank"]));
        $fighterHomeRank = ($figHomeSelected["rank"] === '0') ? 'C' : str_replace('99', 'NR', $figHomeSelected["rank"]);

        $fighterAwayFull = substr(strstr($figAwaySelected["fighter"], ', '), 2) . ' ' . strstr($figAwaySelected["fighter"], ', ', true);
        $fighterAwayRank = ($figAwaySelected["rank"] === '0') ? 'C' : str_replace('99', 'NR', $figAwaySelected["rank"]);

        $fightBout = ucfirst(str_replace('lightheavy', 'light heavyweight', str_replace('_', ' ', $rowEv["weightDiv"])));

        $evId = $rowEv["event_id"];
        //Izvēlas datus no tabulas eventInfo par attiecīgajām cīņām
        $eventId = "SELECT * FROM eventInfo WHERE competitionId = $evId";
        $eventSelected = select($eventId, $conn);
        $eventSelected = $eventSelected->fetch_assoc();


        $currentEvent = $eventSelected["event"];
        $cardType = $rowEv["cardType"];

        $bets = "SELECT * FROM UserBets WHERE SingleEventId = " . $rowEv['id'] . " AND userId = $userID";
        $currentBet = select($bets, $conn);
        $currentBet = $currentBet->fetch_assoc();
//        echo "<pre>";
//        print_r($currentBet);

        ?>
        <?php
        //Izvada pasākuma nosaukumu, ja tas nav izvadīts jau iepriekš
        if (!$eventPrinted) { ?>
            <div class="eventName flex flex-col items-center justify-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#e4c065] drop-shadow-xl" style="text-shadow: 0 0 5px #4E4E4E, 1px 0 0 #4E4E4E,
            -1px 0 0 #4E4E4E, 0 1px 0 #4E4E4E, 0 -1px 0 #4E4E4E,
            1px 1px #4E4E4E, -1px -1px 0 #4E4E4E, 1px -1px 0 #4E4E4E,
            -1px 1px 0 #4E4E4E;"
                ><?php echo $currentEvent; ?></h1>
            </div>
            <?php
            $eventPrinted = true;
        }
        ?>
        <?php
        //Izvada kārts nosaukumu, ja tas nav izvadīts jau iepriekš
        if ($cardType != $cardNull) { ?>
            <div class="flex flex-col w-full">
                <div class="cardType flex flex-col min-h-[5vh] w-full text-center justify-center items-center font-semibold bg-[#606060] text-[#e4c065] drop-shadow-xl">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#e4c065] drop-shadow-xl justify-center items-center"
                        style="text-shadow: 0 0 5px #4E4E4E, 1px 0 0 #4E4E4E,
            -1px 0 0 #4E4E4E, 0 1px 0 #4E4E4E, 0 -1px 0 #4E4E4E,
            1px 1px #4E4E4E, -1px -1px 0 #4E4E4E, 1px -1px 0 #4E4E4E,
            -1px 1px 0 #4E4E4E;"><?php echo $cardType; ?></h2>
                </div>
                <div class="flex w-full min-h-[0.5vh] bg-[#e4c065]"></div>
            </div>
            <?php
            $cardNull = $cardType;
        }
        ?>
        <!--            Izvada cīņu informāciju uz ekrāna pareizi formatētu un pielāgotu lietotājam-->
        <div class="main1 flex flex-row min-h-[40vh] sm:min-h-[30vh] justify-center items-center font-semibold w-full bg-[#606060] text-[#e4c065] drop-shadow-xl"
             data-mainEv="<?= $evId ?>" id="mainEv-<?= $rowEv['id'] ?>">
            <div class="Profile hidden flex-col lg:flex">
                <img src="includes/images/boxing.png" class="max-w-[15rem] sticky">
            </div>
            <div class="Data flex flex-col justify-center gap-4">
                <?php
                //Ja cīņa ir čempionāta cīņa, tad izvada uz ekrāna Čempionāts
                if ($rowEv["titleBout"] == "true") {
                    ?><h3 class="text-2xl font-semibold text-[#e4c065]">Championship</h3><?php
                } elseif ($rowEv["titleBout"] == "false") {
                    echo "";
                } ?>
                <div class="flex flex-col sm:flex-row items-center justify-around gap-4 sm:gap-16 flex-wrap">
                    <div class="flex flex-row gap-4 text-lg items-center justify-center">
                        <!--                        Izvada cīkstoni, kā arī viņa rangu-->
                        <p><?php echo $fighterHomeRank ?></p>
                        <h4><?php echo $fighterHomeFull ?></h4>
                        <!--                        Izvada checkbox, kas ļauj lietotājam izvēlēties cīkstoni-->
                        <input id="checkBoxHome-<?= $rowEv['id'] ?>" data-event="<?= $rowEv['id'] ?>" type="checkbox"
                               name="fight-<?= $i ?>"
                               value="<?= $figHomeSelected['id'] ?>"
                               class="h-5 w-5 rounded-sm accent-[#e4c065]">
                    </div>
                    <div class="flex flex-row gap-4 text-lg items-center justify-center">
                        <!--                        Izvada checkbox, kas ļauj lietotājam izvēlēties cīkstoni-->
                        <input id="checkBoxAway-<?= $rowEv['id'] ?>" type="checkbox" name="fight-<?= $i ?>"
                               value="<?= $figAwaySelected['id'] ?>"
                               class="h-5 w-5 rounded-sm accent-[#e4c065]">
                        <!--                        Izvada cīkstoni, kā arī viņa rangu-->
                        <p><?php echo $fighterAwayRank ?></p>
                        <h4><?php echo $fighterAwayFull ?></h4>
                    </div>
                    <script>
                        toggleCheckboxes('checkBoxHome-', 'checkBoxAway-', <?= $rowEv['id']?>);
                    </script>
                </div>
                <div class="flex flex-col justify-center items-center">
                    <!--                    Izvada cīņas svara kategoriju, kā arī koeficientus cīkstoņu -->
                    <h5 class="text-2xl"><?php echo $fightBout ?>
                        Bout</h5>
                    <p class="text-lg">VS</p>
                    <div class="flex flex-row justify-center items-center gap-6 text-lg">
                        <p id="koefHome-<?= $rowEv['id'] ?>"
                           data-koef="<?= $rowEv["koef_home_fighter"]; ?>"><?php echo $rowEv["koef_home_fighter"]; ?></p>
                        <p>ODDS</p>
                        <p id="koefAway-<?= $rowEv['id'] ?>"
                           data-koef="<?= $rowEv["koef_away_fighter"]; ?>"><?php echo $rowEv["koef_away_fighter"]; ?></p>
                    </div>
                </div>
                <!--                Izvada pogas, kas ļauj lietotājam izvēlēties likmes summu-->
                <div class="Buttons flex flex-row gap-4 justify-center items-center flex-wrap">
                    <!--                    Ja likmes poga ir uzspiesta un ir izvēlēts cīkstonis, tad izvada pogu ar aktīvu klasi un vērtību noteikto-->
                    <!--                    Ja likmes poga ir uzspiesta pārējās pogas tiek atslēgtas un tiek pievienota ikona, lai norādītu to-->
                    <!--                    Ja likmes poga nav nospiesta, tad visām pogā tiek piesķirta to sākuma vērtība-->
                    <button value="10"
                            id="bet-<?= $rowEv['id'] ?>-10"
                            type="button"
                            data-amount="10"
                            onclick="activateButton(<?= $rowEv['id'] ?>,10)"
                            class="currency-btn-<?= $rowEv['id'] ?> rounded bg-[#4E4E4E] text-[#e4c065] font-bold w-20 h-[2rem] text-xl
                             hover:bg-[#e4c065] hover:text-[#4E4E4E] transition duration-150 ease-out hover:ease-in
                             hover:transition duration-300 ease-out
                                 <?php if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 10) {
                                echo "active";
                            } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 10) {
                                echo "disabled";
                                echo "uil uil-ban text-red-500";
                            }

                            ?>
                                 "
                    >
                        <?php
                        if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 10) {
                            echo "10";
                        } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 10) {
                            echo "";
                        } else {
                            echo "10";
                        }
                        ?>

                    </button>
                    <button value="20"
                            id="bet-<?= $rowEv['id'] ?>-20"
                            type="button"
                            data-amount="20"
                            onclick="activateButton(<?= $rowEv['id'] ?>,20)"
                            class="currency-btn-<?= $rowEv['id'] ?> rounded bg-[#4E4E4E] text-[#e4c065] font-bold w-20 h-[2rem] text-xl
                            hover:bg-[#e4c065] hover:text-[#4E4E4E] transition duration-150 ease-out hover:ease-in
                            hover:transition duration-300 ease-out
                                <?php if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 20) {
                                echo "active";
                            } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 20) {
                                echo "disabled";
                                echo "uil uil-ban text-red-500";
                            }
                            ?>
                                "
                    >
                        <?php
                        if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 20) {
                            echo "20";
                        } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 20) {
                            echo "";
                        } else {
                            echo "20";
                        }
                        ?>
                    </button>
                    <button value="50"
                            id="bet-<?= $rowEv['id'] ?>-50"
                            type="button"
                            data-amount="50"
                            onclick="activateButton(<?= $rowEv['id'] ?>,50)"
                            class="currency-btn-<?= $rowEv['id'] ?> rounded bg-[#4E4E4E] text-[#e4c065] font-bold w-20 h-[2rem] text-xl
                            hover:bg-[#e4c065] hover:text-[#4E4E4E] transition duration-150 ease-out hover:ease-in hover:transition
                            duration-300 ease-out
                                <?php if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 50) {
                                echo "active";
                            } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 50) {
                                echo "disabled";
                                echo "uil uil-ban text-red-500";
                            }
                            ?>
                                "
                    >
                        <?php
                        if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 50) {
                            echo "50";
                        } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 50) {
                            echo "";
                        } else {
                            echo "50";
                        }
                        ?>
                    </button>
                    <button value="100"
                            id="bet-<?= $rowEv['id'] ?>-100"
                            type="button"
                            data-amount="100"
                            onclick="activateButton(<?= $rowEv['id'] ?>,100)"
                            class="currency-btn-<?= $rowEv['id'] ?> rounded bg-[#4E4E4E] text-[#e4c065] font-bold w-20 h-[2rem] text-xl
                            hover:bg-[#e4c065] hover:text-[#4E4E4E] transition duration-150 ease-out hover:ease-in hover:transition
                            duration-300 ease-out
                                <?php if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 100) {
                                echo "active";
                            } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 100) {
                                echo "disabled";
                                echo "uil uil-ban text-red-500";
                            }
                            ?>
                                "
                    >
                        <?php
                        if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 100) {
                            echo "100";
                        } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 100) {
                            echo "";
                        } else {
                            echo "100";
                        }
                        ?>
                    </button>
                    <button value="200"
                            id="bet-<?= $rowEv['id'] ?>-200"
                            type="button"
                            data-amount="200"
                            onclick="activateButton(<?= $rowEv['id'] ?>,200)"
                            class="currency-btn-<?= $rowEv['id'] ?> rounded bg-[#4E4E4E] text-[#e4c065] font-bold w-20 h-[2rem] text-xl
                            hover:bg-[#e4c065] hover:text-[#4E4E4E] transition duration-150 ease-out hover:ease-in hover:transition
                            duration-300 ease-out
                                <?php if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 200) {
                                echo "active";
                            } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 200) {
                                echo "disabled";
                                echo "uil uil-ban text-red-500";
                            }
                            ?>
                                "
                    >
                        <?php
                        if (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] == 200) {
                            echo "200";
                        } elseif (isset($currentBet['BetAmount']) && $currentBet['BetAmount'] !== 200) {
                            echo "";
                        } else {
                            echo "200";
                        }
                        ?>
                    </button>
                </div>
            </div>
            <div class="Profile hidden flex-col lg:flex">
                <img src="includes/images/boxing.png" class="sticky max-w-[15rem]">
            </div>
        </div>

        <?php
        $i++;
    }
    $stmt->close();
} else {
    //    Ja nav neviena cīkstona, tad izvada kļūdas paziņojumu
    echo "Sorry we ran into an error!";
}
$conn->close();