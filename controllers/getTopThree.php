<?php
// Paņemam 3 lietotājus ar vislielāko valūtas daudzumu
$getTopThree = "SELECT * FROM loginhelp ORDER BY currency DESC LIMIT ?";
// Novērš SQL injekcijas
$stmt = $conn->prepare($getTopThree);
$stmt->bind_param("i", $limit);
$limit = 3;
$stmt->execute();
$resultSet = $stmt->get_result();
// Pārveidojam rezultātu masīvā
$topThree = $resultSet->fetch_all(MYSQLI_ASSOC);
$first_place = null;
$second_place = null;
$third_place = null;
// Par katru lietotāju izveidojam masīvu ar viņa lietotāja vārdu, valūtu un profila bildi
foreach ($resultSet as $row) {
    $currency = $row['currency'];
    $nickname = $row['nickname'];
    $picture = $row['profilePic'];
    if (!$first_place) {
        // Pārbaudam vai lietotājs ir pirmajā vietā, ja nav tad pārbaudam vai ir otrajā vietā, ja nav tad pārbaudam vai ir trešajā vietā
        $first_place = [
            'nickname' => $nickname,
            'currency' => $currency,
            'profilePic' => $picture,
        ];
    } elseif (!$second_place) {
        $second_place = [
            'nickname' => $nickname,
            'currency' => $currency,
            'profilePic' => $picture,
        ];
    } elseif (!$third_place) {
        $third_place = [
            'nickname' => $nickname,
            'currency' => $currency,
            'profilePic' => $picture,
        ];
    } else {
        // Ja lietotājs nav nevienā no vietām tad iziet no cikla
        break;
    }
}
?>
    <div class="upperRanking flex flex-col justify-center items-center w-1/3 md:w-1/4 lg:w-1/5 pt-24 text-slate-200"
         style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;">
        <div class="secondPlace flex flex-col flex-wrap justify-start items-center w-full min-h-[28rem] bg-gradient-to-br from-gray-200 via-gray-300 to-gray-400 rounded-tl-lg drop-shadow-lg">
<!--            Izvada otrās vietas lietotāja vārdu, valūtu un profila bildi-->
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold pt-9">Second</h3>
            <div class="flex flex-col items-center justify-center min-h-[28rem] gap-4">
                <div class="pb-10">
                    <img src="<?php echo $second_place['profilePic'] ?>"
                         class="w-20 h-20 sm:w-28 sm:h-28 lg:w-36 lg:h-36 rounded border-8 drop-shadow-2xl border-gray-300"
                         alt="secondPlaceImage">
                </div>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $second_place['nickname'] ?></p>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $second_place['currency'] ?></p>
            </div>
        </div>
    </div>
    <div class="middleRanking flex flex-col justify-center items-center w-1/3 md:w-1/4 xl:w-1/5" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;">
        <div class="champion flex flex-col flex-wrap justify-start items-center w-full min-h-[34rem] bg-gradient-to-r from-yellow-300 to-yellow-500 rounded-t-lg drop-shadow-lg">
<!--            Izvada pirmās vietas lietotāja vārdu, valūtu un profila bildi-->
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold pt-4 text-slate-200">Champion</h2>
            <span class="text-xl sm:text-2xl lg:text-3xl pt-4 text-[#e4c065]"><i
                        class="uil uil-trophy font-bold"></i></span>
            <div class="flex flex-col items-center justify-center min-h-[32rem] gap-4">
                <div class="pb-16">
                    <img src="<?php echo $first_place['profilePic'] ?>"
                         class="w-20 h-20 sm:w-28 sm:h-28 lg:w-36 lg:h-36 rounded border-8 drop-shadow-2xl border-yellow-400"
                         alt="championImage">
                </div>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $first_place['nickname'] ?></p>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $first_place['currency'] ?></p>
            </div>
        </div>
    </div>
    <div class="lowerRanking flex-col justify-center items-center w-1/3 md:w-1/4 lg:w-1/5 pt-40 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;">
        <div class="thirdPlace flex flex-col flex-wrap justify-start items-center w-full min-h-[24rem] bg-gradient-to-r from-amber-500 to-yellow-700 rounded-tr-lg drop-shadow-lg">
<!--            Izvada trešās vietas lietotāja vārdu, valūtu un profila bildi-->
            <h4 class="text-xl sm:text-2xl lg:text-3xl font-bold pt-9">Third</h4>
            <div class="flex flex-col items-center justify-center min-h-[24rem] gap-4">
                <div class="pb-10">
                    <img src="<?php echo $third_place['profilePic'] ?>"
                         class="w-20 h-20 sm:w-28 sm:h-28 lg:w-36 lg:h-36 rounded border-8 drop-shadow-2xl border-yellow-600"
                         alt="thirdPlaceImage">
                </div>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $third_place['nickname'] ?></p>
                <p class="text-lg sm:text-xl lg:text-2xl font-semibold pt-0 text-slate-200" style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;"><?php echo $third_place['currency'] ?></p>
            </div>
        </div>
    </div>
<?php

