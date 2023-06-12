<?php
$title = "Home";
include "includes/views/components/header.php"; ?>
<body>
<main class="pt-[5rem]">
    <div class="flex justify-center items-center w-full h-screen bg-no-repeat bg-end bg-contain bg-gradient-to-b from-amber-400 via-stone-500 to-neutral-600 xl:bg-[url('includes/images/ufcposter288.png')] items-center sm:bg-cover xl:bg-contain 2xl:bg-contain min-w-[320px] md:bg-center"
         style="background-size: cover;">
        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/rankings.php"
           class="text-slate-100 text-4xl md:text-5xl xl:text-7xl font-bold hover:transition duration-300 ease-out
          hover:scale-110 hover:text-[#e4c065] ml-8"
           style="text-shadow: 0 0 5px black, 1px 0 0 black,
            -1px 0 0 black, 0 1px 0 black, 0 -1px 0 black, 1px 1px black,
             -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black;">
            Check out the rankings!
        </a>
    </div>
    <div class="info flex flex-col justify-center items-center w-full h-[80vh]">
        <a href="http://into.id.lv/ip19/ralfs/galadarbshelp/info.php"><h1
                    class="text-white text-4xl lg:text-6xl text-center hover:text-[#e4c065] hover:transition duration-300 ease-out hover:scale-110">
                What is FFC?</h1></a>
        <p class="indent-8 text-sm sm:text-base md:text-base lg:text-lg xl:text-2xl text-white text-center w-[95%] lg:w-[60%] xl:w-[40%]">
            Welcome to Fantasy Fighting Championship (FFC), the ultimate virtual fighting experience where users can bet
            on real-life fights using virtual currency and compete with other fans to test their prediction skills.
            To get started, simply create an account on the FFC website. Browse upcoming fights and place virtual bets
            on the fighters you believe will win. Successful bets earn virtual winnings, which can be used to place
            bigger bets and improve your ranking on the FFC leaderboards. Good luck!
        </p>
    </div>
</main>
<?php include "includes/views/components/footer.php" ?>
<script src="includes/js/script.js"></script>
</body>