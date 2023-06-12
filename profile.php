<?php
$title = "Profile";
include "includes/views/components/header.php";
include "controllers/getPicture.php";
include "models/countries.php";
$sql = "SELECT * FROM loginhelp WHERE id = '$userID'";
$results = select($sql, $conn);
$row = $results->fetch_array(MYSQLI_ASSOC);
?>
<body>
<main class="pt-[5rem] z-1">
    <div class="boxHolder flex-wrap flex justify-center items-center w-[100%] min-h-[91vh]">
        <div class="middleBox flex bg-white w-[100%] md:w-[65%] min-h-[91.8vh] drop-shadow-xl flex-row">
            <div class="leftBar flex flex-col w-[30%] md:w-[20%] min-h-[91.8vh] border-r-2 border-[#F9FAFA] bg-[#959595]">
                <div class="w-[100%] h-[10vh] flex flex-col justify-center">
                    <h1 class="bg-[#959595] border-b-2 border-[#F9FAFA] text-[#F9FAFA] h-[6vh] text-2xl md:text-4xl font-bold pb-4 text-center">
                        Menu</h1>
                </div>
                <div class="w-[100%] h-[80vh] flex flex-col justify-center items-center">
                    <div id="accountContent" class="w-[100%]">
                        <button onclick="tabs(0)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            Account
                        </button>
                    </div>
                    <div id="addImage" class="w-[100%]">
                        <button onclick="tabs(1)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            Add Image
                        </button>
                    </div>
                    <div id="profileContent" class="w-[100%]">
                        <button onclick="tabs(2)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            Profile
                        </button>
                    </div>
                    <div id="changePass" class="w-[100%]">
                        <button onclick="tabs(3)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            Password
                        </button>
                    </div>
                    <div id="changeEmail" class="w-[100%]">
                        <button onclick="tabs(4)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            E-mail
                        </button>
                    </div>
                    <div id="deleteContent" class="w-[100%]">
                        <button onclick="tabs(5)"
                                class="tabBtn bg-[#959595] hover:bg-[#e4c065] hover:border-y-2 hover:border-[#F9FAFA] text-[#F9FAFA] w-[100%] h-[10vh] text-lg md:text-xl font-bold">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
            <div class="rightBar flex w-[70%] md:w-[80%] min-h-[91.8vh] flex-col justify-center items-center bg-[#959595]">
                <form id="accForm">
                    <div id="accountItems"
                         class="accountItems flex flex-col gap-6 tabShow w-[100%] min-h-[91.8vh] justify-center lg:items-center">
                        <div class="topTitle flex flex-col justify-center items-center">
                            <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Account Settings</h1>
                        </div>
                        <div class="items flex flex-col gap-4 min-[1420px]:flex-row lg:gap-12">
                            <div class="rightItemsAcc flex flex-col gap-4">
                                <div class="nameInput">
                                    <p class="text-lg text-[#F9FAFA]">First Name</p>
                                    <input value="<?php echo $row["firstName"] ? ($row["firstName"]) : ""; ?>"
                                           name="firstName" type="text" placeholder="Enter your name"
                                           class="btn rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5">
                                </div>
                                <div class="lastnameInput">
                                    <p class="text-lg text-[#F9FAFA]">Last name</p>
                                    <input value="<?php echo $row["lastName"] ? ($row["lastName"]) : ""; ?>"
                                           name="lastName" type="text" placeholder="Enter your last name"
                                           class="btn rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5">
                                </div>
                            </div>
                            <div class="leftItemsAcc flex flex-col gap-4">
                                <div class="locationInput">
                                    <p class="text-lg text-[#F9FAFA]">Location</p>
                                    <select name="location"
                                            class="btn rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5">
                                        <option value="">Select your location</option>
                                        <?php
                                        foreach ($countries as $country) {
                                            $selected = $row["location"] === $country ? "selected" : "";
                                            echo "<option value='$country' $selected>$country</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="ageInput">
                                    <p class="text-lg text-[#F9FAFA]">Age</p>
                                    <input value="<?php echo $row["age"] ? ($row["age"]) : ""; ?>" name="age"
                                           type="number" placeholder="Age"
                                           class="btn rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                           min="18" max="100">
                                </div>
                            </div>
                        </div>
                        <div class="bottomButtonAcc min-w-[100%] flex flex-col gap-8">
                            <button onclick="getValue('personalData.php', event, 'accForm', 1)"
                                    class="rounded-md text-lg bg-[#959595] hover:bg-[#e4c065] border-2 border-[#F9FAFA] text-[#F9FAFA] w-[12vh] h-[4rem] font-bold">
                                Done
                            </button>
                            <div class="h-10 w-56">
                                <p id="msg1" class="text-lg text-[#F9FAFA]"></p>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="accImage" method='POST' enctype='multipart/form-data'>
                    <div id="accountImage"
                         class="accountImage flex flex-col gap-6 tabShow w-[100%] min-h-[91.8vh] justify-center lg:items-center">
                        <div class="topTitle flex flex-col justify-center items-center">
                            <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Add Account Image</h1>
                        </div>
                        <div class="items flex flex-col gap-4 lg:flex-row lg:gap-12">
                            <input type="file" id="image" name="image" class="relative m-0 block w-full min-w-0 flex-auto rounded border-2 border-solid
                            border-[#F9FAFA] bg-clip-padding py-[0.32rem] px-3 text-base font-normal
                            text-[#F9FAFA] transition duration-300 ease-in-out file:-mx-3
                            file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0
                            file:border-solid file:border-inherit file:bg-[#959595] file:px-3
                            file:py-[0.32rem] file:text-[#F9FAFA] file:transition file:duration-150
                            file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px]
                            hover:file:bg-[#e4c065] focus:border-primary focus:text-[#F9FAFA] focus:shadow-[0_0_0_1px]
                            focus:shadow-primary focus:outline-none">
                        </div>
                        <div class="bottomButtonAcc min-w-[100%] flex flex-col gap-8">
                            <button type="submit"
                                    name="submit"
                                    class="rounded-md text-lg bg-[#959595] hover:bg-[#e4c065] border-2 border-[#F9FAFA] text-[#F9FAFA] w-[12vh] h-[4rem] font-bold">
                                Add
                            </button>
                            <p id="msg2" class="text-lg text-[#F9FAFA]"></p>
                        </div>
                    </div>
                </form>
                <div id="profileItems" style="display:none"
                     class="profileItems flex flex-col justify-center items-center gap-6 tabShow min-h-[91.8vh] w-[100%]">
                    <div class="topTitle flex flex-col justify-center items-center">
                        <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Profile Settings</h1>
                    </div>
                    <div class="items flex flex-col gap-12 ml-2 xl:m-0 justify-center items-center">
                        <div class="profilePicture flex flex-col justify-center items-center">
                            <img src="<?php +profilePic($conn); ?>"
                                 class="w-40 h-40 rounded-full border-8 drop-shadow-2xl" alt="userImage">
                        </div>
                        <div class="flex flex-col lg:flex-row gap-8 md:gap-16 lg:gap-12 xl:gap-32">
                            <div class="leftItemsAcc flex flex-col gap-4 md:gap-6">
                                <div class="emailOutput">
                                    <p class="text-lg md:text-xl text-white">Your e-mail: <?php email($conn); ?></p>
                                </div>
                                <div class="nameOutput">
                                    <p class="text-lg md:text-xl text-white">Your first
                                        name: <?php firstName($conn); ?></p>
                                </div>
                                <div class="locationOutput">
                                    <p class="text-lg md:text-xl text-white">Your
                                        location: <?php location($conn); ?></p>
                                </div>
                            </div>
                            <div class="rightItemsAcc flex flex-col gap-4 md:gap-6">
                                <div class="nickNameOutput">
                                    <p class="text-lg md:text-xl text-white">Your
                                        nickname: <?php nickNameProfile($conn); ?></p>
                                </div>
                                <div class="lastnameOutput">
                                    <p class="text-lg md:text-xl text-white">Your last
                                        name: <?php lastName($conn); ?></p>
                                </div>
                                <div class="ageOutput">
                                    <p class="text-lg md:text-xl text-white">Your age: <?php age($conn); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="changePass" style="display:none"
                     class="changePass flex flex-col gap-6 tabShow min-h-[91.8vh] justify-center items-center w-[100%]">
                    <div class="topTitle flex flex-col justify-center items-center gap-6">
                        <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Change password</h1>
                    </div>
                    <div class="flex flex-col justify-center items-center gap-10">
                        <form id="accPassword">
                            <div class="flex flex-col gap-4">
                                <p class="text-lg text-[#F9FAFA] text-left">Update password</p>
                                <input name="oldPassword" type="password"
                                       class="rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                       placeholder="Old password">
                                <input name="newPassword" type="password"
                                       class="rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                       placeholder="New password">
                                <input name="checkPassword" type="password"
                                       class="rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                       placeholder="Repeat new password">
                                <div class="bottomButtonAcc flex flex-col gap-8">
                                    <button onclick="getValue('updatePass.php', event, 'accPassword', 3)"
                                            class="rounded-md text-lg bg-[#959595] hover:bg-[#e4c065] border-2 border-[#F9FAFA] text-[#F9FAFA] w-[12vh] h-[4rem] font-bold">
                                        Update
                                    </button>
                                    <div class="h-10 w-56">
                                        <p id="msg3" class="text-lg text-[#F9FAFA]"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="changeEmail" style="display:none"
                     class="changeEmail flex flex-col gap-6 tabShow min-h-[91.8vh] justify-center items-center w-[100%]">
                    <div class="topTitle flex flex-col justify-center items-center gap-6">
                        <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Change e-mail</h1>
                    </div>
                    <div class="flex flex-col lg:flex-row justify-center items-center gap-10">
                        <form id="accEmail">
                            <div class="flex flex-col gap-4">
                                <p class="text-lg text-[#F9FAFA] text-left">Update e-mail</p>
                                <input name="oldEmail" type="email"
                                       class="rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                       placeholder="Old email">
                                <input name="newEmail" type="email"
                                       class="rounded-full w-52 md:w-80 h-[2.5rem] outline-none p-2.5"
                                       placeholder="New email">
                                <div class="bottomButtonAcc min-w-[100%] flex flex-col gap-8">
                                    <button onclick="getValue('updateData.php', event, 'accEmail', 4)"
                                            class="rounded-md text-lg bg-[#959595] hover:bg-[#e4c065] border-2 border-[#F9FAFA] text-[#F9FAFA] w-[12vh] h-[4rem] font-bold">
                                        Update
                                    </button>
                                    <div class="h-10 w-56">
                                        <p id="msg4" class="text-lg text-[#F9FAFA]"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--                Dzēst lietotāja no datu bāzes-->
                <div id="deleteItems" style="display:none"
                     class="deleteItems flex flex-col tabShow min-h-[91.8vh] justify-center items-center gap-6 w-[100%]">
                    <div class="topTitle flex flex-col justify-center items-center">
                        <h1 class="text-2xl min-[425px]:text-3xl font-bold text-[#F9FAFA]">Delete Account</h1>
                    </div>
                    <!--                    Attēlo lietotāja lietotājvārdu un pārvaicā vai tiešām vēlas dzēst savu kontu-->
                    <div class="deleteAccount flex flex-col gap-2 justify-center items-center xl:px-52 lg:px-32 md:px-16">
                        <p class="text-lg text-[#F9FAFA] text-center">Do you really want to delete your
                            account <?php nickNameProfile($conn); ?> ?</p>
                    </div>
                    <!--                    Dzēst kontu poga-->
                    <div class="buttonDelete flex flex-col gap-2 justify-center items-center">
                        <button onclick="deleteUser(<?php echo $userID; ?>)" name="delete" id="deleteUser"
                                class="rounded-md text-lg bg-[#959595] hover:bg-[#e4c065] border-2 border-[#F9FAFA] text-[#F9FAFA] w-[16vh] h-[4rem] font-bold">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "includes/views/components/footer.php" ?>
<script src="includes/js/script.js"></script>
<script>
    const tabBtn = document.querySelectorAll(".tabBtn");
    const tab = document.querySelectorAll(".tabShow");

    function tabs(panelIndex) {
        tab.forEach(element => {
            element.style.display = "none";

        });
        tab[panelIndex].style.display = "flex";
    }
</script>
</body>