<?php
require 'config/database.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_POST['submit'])) {
    $CategoryID = filter_var($_POST['CategoryID'], FILTER_SANITIZE_NUMBER_INT);
  // Corrected 'CategoryID' to 'category' for the select input name
    $vBrand = filter_var($_POST['vBrand'], FILTER_SANITIZE_SPECIAL_CHARS);
    $vModel = filter_var($_POST['vModel'], FILTER_SANITIZE_SPECIAL_CHARS);
    $vPLNo = filter_var($_POST['vPLNo'], FILTER_SANITIZE_SPECIAL_CHARS);
    $RatePerDay = filter_var($_POST['vRatePerDay'], FILTER_SANITIZE_NUMBER_INT);
    $Availability = filter_var($_POST['Availability'], FILTER_SANITIZE_SPECIAL_CHARS);
    $vImage = $_FILES['vImage'];

    // Validate form data
    if (!$CategoryID) {
        $_SESSION['add-vehicle-post'] = "Select car category";
    } elseif (!$vBrand) {
        $_SESSION['add-vehicle-post'] = "Enter the Brand";
    } elseif (!$vModel) {
        $_SESSION['add-vehicle-post'] = "Enter the Model";
    } elseif (!$vPLNo) {
        $_SESSION['add-vehicle-post'] = "Enter the Plate Number";
    } elseif (!$RatePerDay) {
        $_SESSION['add-vehicle-post'] = "Enter the Rate Per Day";
    } elseif (!$Availability) {
        $_SESSION['add-vehicle-post'] = "Is it available?";
    } elseif (!$vImage['name']) {
        $_SESSION['add-vehicle-post'] = "Choose post thumbnail";
    } else {
        $time = time();
        $vImage_name = $time . $vImage['name'];
        $vImage_tmp_name = $vImage['tmp_name'];
        $vImage_destination_path = '../images/' . $vImage_name;

        // Make sure file is an image
        $allowed_extensions = ['png', 'jpg', 'jpeg'];
        $extension = strtolower(pathinfo($vImage_name, PATHINFO_EXTENSION)); // Get the file extension

        if (in_array($extension, $allowed_extensions)) {
            // Make sure image is not too big (less than 2MB)
            if ($vImage['size'] < 2000000) {
                move_uploaded_file($vImage_tmp_name, $vImage_destination_path);
            } else {
                $_SESSION['add-vehicle-post'] = "File size is too big. Should be less than 2MB.";
            }
        } else {
            $_SESSION['add-vehicle-post'] = "File should be in PNG, JPG, or JPEG format";
        }
    }

    if (isset($_SESSION['add-vehicle-post'])) {
        $_SESSION['add-vehicle-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-vehicle-post.php');
        die();
    }

    // Insert vehicle post into the database
   /*  $query = "INSERT INTO `vehicle` (`vImage`, `CategoryID`, `vBrand`, `vModel`, `vPLNo`, `RatePerDay`, `Availability`) VALUES ('$vImage_name', $CategoryID, '$vBrand', '$vModel', '$vPLNo', $RatePerDay, '$Availability')";
    $result = mysqli_query($connection, $query);

    if (!mysqli_errno($connection)) {
        $_SESSION['add-vehicle-post-success'] = "New post added successfully";
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } */
    $query = "INSERT INTO `vehicle` (`vImage`, `CategoryID`, `vBrand`, `vModel`, `vPLNo`, `RatePerDay`, `Availability`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sissdis", $vImage_name, $CategoryID, $vBrand, $vModel, $vPLNo, $RatePerDay, $Availability);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['add-vehicle-post-success'] = "New post added successfully";
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        $_SESSION['add-vehicle-post'] = "Error occurred while adding the post.";
    }
}

header('location: ' . ROOT_URL . 'admin/add-vehicle-post.php');
die();
?>
