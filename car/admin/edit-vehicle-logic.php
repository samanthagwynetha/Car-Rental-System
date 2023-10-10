<?php
require 'config/database.php';

// Check if the form is submitted
if(isset($_POST['submit'])){
    $VehicleID = filter_var($_POST['VehicleID'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $CategoryID = filter_var($_POST['CategoryID'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vBrand = filter_var($_POST['vBrand'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vModel = filter_var($_POST['vModel'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vPLNo = filter_var($_POST['vPLNo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $RatePerDay = filter_var($_POST['RatePerDay'], FILTER_SANITIZE_SPECIAL_CHARS);
    $Availability = filter_var($_POST['Availability'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $thumbnail = $_FILES['vImage'];

    // Check and validate input values
    if (!$CategoryID || !$vBrand || !$vModel || !$vPLNo || !$RatePerDay || !$Availability) {
        $_SESSION['edit-vehicle'] = "Couldn't Update";
    } else {
        // Delete existing thumbnail if available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // Work on the new thumbnail
            // Rename the image
            $time = time(); // Make each image name unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // Make sure the file is an image
            $allowed_extensions = ['png', 'jpg', 'jpeg'];
            $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION)); // Get the file extension

            if (in_array($extension, $allowed_extensions)) {
                // Make sure the thumbnail is not too large (less than 2MB)
                if ($thumbnail['size'] < 2000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-vehicle-post'] = "File size is too big. Should be less than 2MB.";
                }
            } else {
                $_SESSION['edit-vehicle-post'] = "File should be in PNG, JPG, or JPEG format";
            }
        }
    }

    if ($_SESSION['edit-vehicle-post']) {
        // Redirect to the edit page if the form was invalid
        header('location: ' . ROOT_URL . 'admin/edit-vehicle.php?VehicleID=' . $VehicleID);
        die();
    } else {
        // Set the thumbnail or keep the existing one
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE vehicle SET vImage='$thumbnail_to_insert', CategoryID='$CategoryID', vBrand='$vBrand', vModel='$vModel', vPLNo='$vPLNo', RatePerDay='$RatePerDay', Availability='$Availability' WHERE VehicleID=$VehicleID LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)) {
            $_SESSION['edit-vehicle-post-success'] = "Post updated successfully";
        }

        // Redirect to the edit page or another appropriate location
        header('location: ' . ROOT_URL . 'admin/edit-vehicle.php?VehicleID=' . $VehicleID);
        die();
    }
}

// If the form was not submitted, you can display the edit form here
?>
