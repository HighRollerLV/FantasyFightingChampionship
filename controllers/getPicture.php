<?php

if (isset($_POST['submit'])) {
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $image_type = $_FILES['image']['type'];
    $image_size = $_FILES['image']['size'];

    $allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
    if (!in_array($image_type, $allowed_types)) {
        echo "<p class='alertText'>Incorrect file type, please choose one of these file types GIF, JPEG, PNG, JPG</p>";
        exit();
    }

    $max_size = 1000000;
    if ($image_size > $max_size) {
        echo "<p class='alertText'>File size too large try again.</p>";
        exit();
    }

    $target_dir = "includes/profileImages/";
    $target_file = $target_dir . $image_name;
    move_uploaded_file($image, $target_file);

    $sql = "UPDATE loginhelp SET profilePic='$target_file' WHERE id='$userID'";
    $result = insert($sql, $conn);
    if ($result) {
        echo "<p class='alertText'>Profile picture added successfully please refresh your page to activate it.</p>";
    } else {
        echo "<p class='alertText'>Failed to update profile picture.</p>";
    }
}