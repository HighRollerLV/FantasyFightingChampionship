<?php
$title = "Rankings";
include "includes/views/components/header.php"; ?>
<body>
<main class="pt-[5rem] pb-[5rem]">
    <div class="mainContainer w-full min-h-screen flex flex-row justify-center items-center">
        <div class="content w-4/5 min-h-screen flex flex-col justify-start items-center">
            <div class="title pt-4 flex flex-row justify-center items-center">
                <h1 class="text-6xl sm:text-8xl text-[#e4c065] font-semibold drop-shadow-lg">Rankings</h1>
            </div>
            <div class="flex flex-row justify-center items-center w-screen sm:w-full pt-24">
                <?php include "controllers/getTopThree.php" ?>
            </div>
            <div class="flex flex-row h-5 bg-zinc-700 rounded-full w-screen md:w-full drop-shadow-2xl"></div>
            <div class="top50 flex flex-col justify-center items-center w-full min-h-screen pt-32">
                <div class="playerList flex flex-col justify-start items-center text-center drop-shadow-2xl w-screen md:w-full lg:w-[87%] h-[87vh]">
                    <h5 class="text-3xl md:text-5xl pt-6 pb-6 font-semibold drop-shadow-lg border-b-8 border-[#e4c065] w-full bg-[#e4c065] text-slate-200">
                        Top 50 Players in Fantasy Fighting Championship
                    </h5>
                    <div class="scrollBar flex flex-col overflow-y-auto w-full gap-2 md:gap-4 pt-4">
                        <?php include "controllers/getRankings.php" ?>
                    </div>
                    <div class="w-full h-96 flex flex-row bg-[#e4c065]">
                    </div>
                </div>
            </div>
            <div class="rankingInfo flex flex-col justify-center items-center w-full md:w-[92%] lg:w-[82%] xl:w-[84%]">
                <div class="informationBar flex flex-col justify-start items-center">
                    <ul class="list-disc text-base md:text-lg font-semibold text-[#e4c065]">
                        <li>
                            The FFC Rankings are a list of the top 50 fighters in the game, ranked by their performance
                            in FFC events.
                        </li>
                        <li>
                            The top three fighters are ranked on the podium, while the remaining fighters are listed in
                            order below the podium.
                        </li>
                        <li>
                            The rankings work on a points system, where players earn points based on their performance
                            in FFC events. Points are awarded for wins and taken away for losses.
                        </li>
                        <li>
                            The more points a player earns, the higher they will be ranked on the FFC Rankings.
                        </li>
                        <li>
                            In order to participate in FFC events and earn points, players must use their in-game
                            currency to place bets on fights.
                        </li>
                        <li>
                            If you're looking to climb the FFC Rankings and become one of the top players in the game,
                            start participating in FFC events, winning fights, and earning points. Good luck!
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "includes/views/components/footer.php" ?>
</body>
