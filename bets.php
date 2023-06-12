<?php
$title = "Bets";
include "includes/views/components/header.php";
?>
    <main class="pt-[5rem]">
        <div class="content w-full min-h-screen flex flex-row justify-center items-center pt-32">
            <div class="max-w-[1280px] w-full min-h-[250vh] flex flex-col justify-center items-center gap-2">
                <div class="mainCard flex flex-col min-h-[40vh] min-w-[320px] sm:min-w-[640px] md:min-w-[768px] lg:min-w-[1024px] xl:min-w-[1280px] text-center justify-around gap-6">
                    <div class="fighters flex flex-col justify-center items-center gap-10">
                        <?php include "controllers/ufcSingleEvent.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include "includes/views/components/footer.php" ?>