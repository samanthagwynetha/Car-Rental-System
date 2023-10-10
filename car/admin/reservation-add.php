<?php
require 'config/database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize an array to store validation errors
    $errors = [];

    // Validate and sanitize input data
    $reservationID = isset($_POST['_reservationID']) ? trim($_POST['_reservationID']) : '';
    $customerID = isset($_POST['_customerID']) ? trim($_POST['_customerID']) : '';
    $adminID = isset($_POST['_adminID']) ? trim($_POST['_adminID']) : '';
    $driverID = isset($_POST['_driverID']) ? trim($_POST['_driverID']) : '';
    $resdate = isset($_POST['_resdate']) ? trim($_POST['_resdate']) : '';
    $startdate = isset($_POST['_startdate ']) ? $_POST['_startdate '] : '';
    $enddate = isset($_POST['_enddate']) ? $_POST['_enddate'] : '';
    $driveroption = isset($_POST['_driveroption']) ? $_POST['_driveroption'] : '';
    $totalcost = isset($_POST['_totalcost']) ? $_POST['_totalcost'] : '';
    // ... (previous code)

$reservationstatus = isset($_POST['_reservationstatus']) ? $_POST['_reservationstatus'] : '';
$licensephoto = isset($_POST['_dLicensePhoto']) ? trim($_POST['_dLicensePhoto']) : '';

// Check if a license photo was uploaded
if (isset($_FILES['dLicensePhoto'])) {
    $licensephoto = $_FILES['dLicensePhoto']['tmp_name'];

    // Validate and handle the uploaded file
    if (empty($licensephoto)) {
        $errors[] = 'License photo is required.';
    } else {
        // Read the file data
        $dlicensephoto_data = file_get_contents($licensephoto);

        // Insert data into the database
        $sql = "INSERT INTO driver (DriverID, dFname, dLname, dPhoneNo, dLicensePhoto, dEmail, dPassword)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'issssss', $driverId, $dfname, $dlname, $dphoneNo, $dlicensephoto_data, $demail, $dPassword);

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

// ... (continue with other field validations and error handling)

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
    header('location: ' . ROOT_URL . 'reservations-info.php');
    die();
}
?>
