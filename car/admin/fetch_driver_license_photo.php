<?php
include 'config/database.php';

// Get the driver ID from the AJAX request
if (isset($_GET['driverID'])) {
    $driverID = $_GET['driverID'];

    // Fetch the driver's license photo from the database
    $sql = "SELECT dLicensePhoto FROM driver WHERE DriverID = $driverID";
    $query = mysqli_query($connection, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $dLicensePhoto = $row['dLicensePhoto'];

        // Output the driver's license photo as a binary stream
        header('Content-Type: image/png'); // Change this based on the actual image type
        echo $dLicensePhoto;
    }
} else {
    // Handle the case where driverID is not provided in the request
    echo "Driver ID not provided in the request.";
}


