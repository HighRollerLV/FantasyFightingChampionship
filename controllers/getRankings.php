<?php
// Paņem visus lietotājus no datubāzes un sakārto tos pēc valūtas daudzuma un izvada tikai 50 lietotājus
$getRankings = "SELECT * FROM loginhelp ORDER BY currency DESC LIMIT 50";
// Novērš SQL injekcijas
$stmt = $conn->prepare($getRankings);
// Pārbauda vai nav kļūdas
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$result = $stmt->get_result();

$rank = 1;
// Izvada visus lietotājus no datubāzes
while ($row = $result->fetch_assoc()) {
    //Sanitize the output for values before outputting to html. Prevents XSS attacks
    // Dezinficē izvadi pirms izvadīšanas uz html. Pasargā no XSS uzbrukumiem
    $currency = htmlspecialchars($row['currency'], ENT_QUOTES);
    $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES);
    // Izvada tikai lietotājus, kuri ir augstāk par 3. vietu
    if ($rank > 3) {
        ?>
        <div class="flex flex-row gap-6 w-full border-y-4 md:border-8 border-[#e4c065] bg-slate-200 justify-center items-center text-center drop-shadow-lg">
            <div class="rankTitle w-1/4 h-10 flex text-center items-center justify-center">
                <p class='text-base sm:text-lg font-bold'>Rank</p>
            </div>
            <div class="rank w-1/4 h-10 flex text-center items-center justify-center">
                <!--                Izvada lietotāja rangu-->
                <p class='text-base sm:text-lg font-bold'><?php echo $rank; ?></p>
            </div>
            <div class="nick w-1/4 h-10 flex text-center items-center justify-center">
                <!--                 Izvada lietotāja vārdu-->
                <p class='text-base sm:text-lg font-bold'><?php echo $nickname; ?></p>
            </div>
            <div class="currency w-1/4 h-10 flex text-center items-center justify-center">
                <!--                Izvada lietotāja valūtu-->
                <p class='text-base sm:text-lg font-bold'><?php echo $currency; ?></p>
            </div>
        </div>

        <?php
    }
    $rank++;
}
$stmt->close();
$conn->close();




