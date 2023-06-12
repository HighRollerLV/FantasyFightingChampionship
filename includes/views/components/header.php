<?php
// Uzsāk sesiju
session_start();
// Iekļauj nepieciešamos failus
include "./config/db.php";
include "controllers/sessions.php";
include "./models/dbOperations.php";
$userID = userID();
logOut();
// Iegūst lietotāja valūtas summu
$coin = currency($conn);
?>
<!--Tīmekļa vietnes galvene un galva -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    Izsauc katras vietnes nosaukumu-->
    <title><?php echo $title; ?></title>
    <!--    Iekļauj CSS failu-->
    <link rel="stylesheet" href="includes/css/style.css">
    <!--    Iekļauj tailwindCSS failu-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--    Iekļauj failus, kas atbild par ikonām-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <!--    Pievieno saīsnes ikonu-->
    <link rel="icon" type="image/png" href="includes/images/ffcNoBG.png"/>
    <!--    Iekļauj JS failu-->
    <script src="includes/js/checkbox.js"></script>
</head>
<body class="bg-[#4E4E4E]">
<header class="fixed bg-[#4e4e4e] w-full h-20 z-10 drop-shadow-xl">
    <div class="min-w-full max-h-20 flex align-center  items-center flex-wrap lg:justify-center">
        <!--        Navigācijas joslas logotips-->
        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/index.php"><img src="includes/images/FFCblack.png"
                                                                            class="rounded-lg cursor-pointer h-12 sm:h-16 md:h-20"></a>
        <!--        Navigācijas joslas hipersaites-->
        <div class="headerImage min-w-[25%] flex flex-row justify-start items-center h-20">
            <!--            Izsauc javascript funkciju, kas atbild par navigācijas joslas izvēlnes parādīšanu uz mazākiem ekrāniem-->
            <button onclick="hamburger(); event.stopPropagation();" data-collapse-toggle="mobile-menu-2" type="button"
                    class="visible lg:invisible inline-flex items-center p-2 ml-1 text-sm text-white rounded-lg hover:bg-[#e4c065] focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                          clip-rule="evenodd"></path>
                </svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>
            <!--            Navigācijas joslas hipersaites-->
            <div class="hidden absolute top-[7vh] left-0 lg:top-[3vh] lg:left-[32vh] lg:justify-between lg:items-center min-w-[100%] lg:flex lg:w-auto lg:order-1"
                 id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 ">
                    <li>
                        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/index.php"
                           class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-[#e4c065]
                           lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 lg:hover:text-[#e4c065] bg-[#4E4E4E]
                           lg:hover:bg-transparent lg:hover:underline-none lg:hover:underline lg:hover:underline-offset-8 hover:transition duratio
                           n-300 ease-out hover:scale-110"
                           aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/rankings.php"
                           class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-[#e4c065]
                           lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 lg:hover:text-[#e4c065] bg-[#4E4E4E]
                           lg:hover:bg-transparent lg:hover:underline-none lg:hover:underline lg:hover:underline-offset-8 hover:transition duratio
                           n-300 ease-out hover:scale-110">Ranks</a>
                    </li>
                    <li>
                        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/bets.php" class="block py-2 pr-4 pl-3 text-white
                           border-b border-gray-100 hover:bg-[#e4c065] bg-[#4E4E4E]
                           lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 lg:hover:text-[#e4c065]
                           lg:hover:bg-transparent lg:hover:underline-none lg:hover:underline lg:hover:underline-offset-8
                           hover:transition duration-300 ease-out hover:scale-110">Bets</a>
                    </li>
                    <li>
                        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/info.php"
                           class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-[#e4c065] lg:hover:bg-transparent
                           lg:border-0 lg:hover:text-primary-700 lg:p-0 lg:hover:text-[#e4c065] bg-[#4E4E4E]
                           lg:hover:bg-transparent lg:hover:underline-none lg:hover:underline lg:hover:underline-offset-8
                           hover:transition duration-300 ease-out hover:scale-110">Info</a>
                    </li>
                    <li>
                        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/results.php"
                           class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-[#e4c065] lg:hover:bg-transparent
                           lg:border-0 lg:hover:text-primary-700 lg:p-0 lg:hover:text-[#e4c065] bg-[#4E4E4E]
                           lg:hover:bg-transparent lg:hover:underline-none lg:hover:underline lg:hover:underline-offset-8
                           hover:transition duration-300 ease-out hover:scale-110">Results</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="headerProfile min-w-[50%] md:min-w-[60%] flex flex-row justify-end items-center h-22 gap-8 font-medium pr-3.5">
            <div class="flex">
                <!--                Lietotāja virtuālā nauda-->
                <p id="currency" class="text-white font-semibold" data-currency="<?= $coin ?>">
                    <?= $coin ?>
                </p>
            </div>
            <div class="hidden flex md:flex">
                <!--                Lietotāja vārds-->
                <?php
                nickName($conn);
                ?>
            </div>
            <!--            Profila ikona-->
            <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/profile.php"><i
                        class="uil uil-user-circle text-4xl font-extralight text-white hover:text-[#e4c065] hover:transition  "></i></a>
            </svg>
            <form method="POST">
                <!--                Atslēgšanās poga-->
                <button name="logOut"
                        class="justify-items-center text-white underline-none hover:text-[#e4c065] hover:underline hover:underline-offset-8 hover:transition duration-300 ease-out hover:scale-110">
                    EXIT
                </button>
            </form>
        </div>
    </div>
</header>
