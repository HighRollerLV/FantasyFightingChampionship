<?php
// šeit ir funkcijas, kas tiek izmantotas visās lapās, kurās ir nepieciešama sesija
// šī funkcija pārbauda vai sesija ir sākusies, ja nav, tad tiek pāradresēts uz reģistrācijas vietni
function userID()
{
    // Pārbauda vai sesija ir sākusies
    if (isset($_SESSION['logged'])) {
        $userID = $_SESSION['user'];
        return $_SESSION['user'];
        // Ja nav, tad tiek pāradresēts uz reģistrācijas vietni
    } else {
        header("Location:./register.php");
    }
}
// Ja ir nospiesta hipersaite "Iziet", tad tiek izsaukta šī funkcija, kas iznīcina sesiju un pāradresē uz reģistrācijas vietni
function logOut()
{
    // Pārbauda vai ir nospiesta hipersaite "EXIT", ja ir tad iznīcina sesiju un pāradresē uz reģistrācijas vietni
    if (isset($_POST['logOut'])) {
        session_destroy();
        header("Location:./register.php");
    }
}
// Šī funkcija paņem lietotāja vārdu no datubāzes, kur pēc tam tas tiek apstrādāts ar unikālu CSS stilu
function nickName($conn)
{
    // Pārbauda vai sesija ir sākusies
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT nickname FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Izvada lietotājvārdu uz navigācija joslas
            while ($row = $result->fetch_assoc()) {
                echo "<h3 class='nickname'>" . htmlspecialchars($row['nickname']) . "</h3>";
            }
        }
        $stmt->close();
    }
}
// Šī funkcija paņem lietotāja virtuālo naudu no datubāzes
function currency($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT currency FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['currency'];
        }
    }
}
// Šī funkcija paņem lietotājvārdu no datubāzes
function nickNameProfile($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT nickname FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['nickname'];
            }
        }
        $stmt->close();
    }
}
// Šī funkcija paņem lietotāja e-pasta adresi
function email($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $sql = "SELECT email FROM loginhelp WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo $row['email'];
            }
        }
    }
}
// Šī funkcija paņem lietotāja profila bildi
function profilePic($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $sql = "SELECT * FROM loginhelp WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo $row['profilePic'];
            }
        }
    }
}
// Šī funkcija paņem lietotāja vārdu
function firstName($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT firstName FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['firstName'];
        }
        $stmt->close();
    }
}
// Šī funkcija paņem lietotāja uzvārdu
function lastName($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $sql = "SELECT lastName FROM loginhelp WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo $row['lastName'];
            }
        }
    }
}
// Šī funkcija paņem lietotāja dzīvesvietu
function location($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT * FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo $row['location'];
            }
        }
    }
}
// Šī funkcija paņem lietotāja vecumu
function age($conn)
{
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT * FROM loginhelp WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo $row['age'];
            }
        }
    }
}
// Šī funkcija pārbauda vai lietotājs ir pieslēdzies un ja ir tad tiek pāradresēts uz index.php vietni
function loggedIn()
{
    // Pārbauda vai sesija ir sākusies, ja ir tad tiek pāradresēts uz index.php vietni
    if (isset($_SESSION['logged'])) {
        header("Location:./index.php");
    }
}

?>

