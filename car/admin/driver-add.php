<?php
require 'config/database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize an array to store validation errors
    $errors = [];

    // Validate and sanitize input data
    $driverId = isset($_POST['_DriverID']) ? trim($_POST['_DriverID']) : '';
    $dfname = isset($_POST['_dFname']) ? trim($_POST['_dFname']) : '';
    $dlname = isset($_POST['_dLname']) ? trim($_POST['_dLname']) : '';
    $dphoneNo = isset($_POST['_dPhoneNo']) ? trim($_POST['_dPhoneNo']) : '';
    $demail = isset($_POST['_dEmail']) ? trim($_POST['_dEmail']) : '';
    $dpassword = isset($_POST['_dPassword']) ? $_POST['_dPassword'] : '';
    $dlicensePhoto = isset($_POST['_dLicensePhoto']) ? trim($_POST['_dLicensePhoto']) : '';

    // Check if a license photo was uploaded
    if (isset($_FILES['dLicensePhoto'])) {
        $dlicensePhoto = $_FILES['dLicensePhoto']['tmp_name'];
        
        // Validate and handle the uploaded file
        if (empty($dlicensePhoto)) {
            $errors[] = 'License photo is required.';
        } else {
            // Read the file data
            $dlicensePhoto_data = file_get_contents($dlicensePhoto);

            // Insert data into the database
            $sql = "INSERT INTO driver (DriverID, dFname, dLname, dPhoneNo, dLicensePhoto, dEmail, dPassword)
                    VALUES ('$driverId', '$dfname', '$dlname', '$dphoneNo', ?, '$demail', '$dPassword')";

            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, 's', $dlicensephoto_data);

            if (mysqli_stmt_execute($stmt)) {
                header('location: ' . ROOT_URL . 'drivers-info.php');
                die("Registered Successfully");
            } else {
                header('location: ' . ROOT_URL . 'drivers-info.php');
                die("Something went wrong");
            }

            
        }
    } else {
        $errors[] = 'License photo is required.';
    }

    // Perform validation on other fields
    // (The code for other fields remains the same as in your previous code)

    // Check if there are any validation errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert_message error'>$error</div>";
        }
    }
} else {
    // If the form wasn't submitted, redirect to the signup page
    header('location: ' . ROOT_URL . 'drivers-info.php');
    die();
}
?>
