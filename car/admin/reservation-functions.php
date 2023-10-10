<?php
include 'config/database.php';

if (isset($_POST['submit'])) {
    try {
        $customerID = $_POST['_customerID'];
        $vehicleID = $_POST['_vehicleID'];
        $adminID = $_POST['_adminID'];
        $driverID = $_POST['_driverID'];
        $resdate = $_POST['_resdate'];
        $startdate = $_POST['_startdate'];
        $enddate = $_POST['_enddate'];
        
        $driveroption = $_POST['_driveroption'];
    
        // Check if it's self-driven
        if ($driveroption === 'option1') {
            $driverID = 1; // Replace with the actual DriverID of the "Self-driven" driver
        } else {
            // Handle the case when a driver is selected for "Driver-driven" reservations
            $driverID = $_POST['_driverID'];
        }
        $totalcost = $_POST['totalcost'];
        $reservationstatus = isset($_POST['_reservationstatus']) ? $_POST['_reservationstatus'] : '';

        if ($_POST['_driveroption'] === 'option2') {
            // Handle the driver's license photo upload
            if ($_FILES['_dLicensePhoto']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['_dLicensePhoto']['tmp_name'];
                $dLicensePhoto = file_get_contents($tmp_name);
                // Save $dLicensePhoto to the database for the selected driver
            } else {
                // Handle the case where there was an error with the file upload
                echo "Error uploading driver's license photo.";
            }
        }
        
        // $adminID = $_SESSION['admin_ID'];

        $imageData = file_get_contents($_FILES['_dLicensePhoto']['tmp_name']);

        insertData($customerID, $vehicleID, $adminID, $driverID, $resdate, $startdate, $enddate, $driveroption, $imageData, $totalcost, $reservationstatus, $connection);
    } catch (Exception $e) {
        echo "<script>alert('Cannot add reservation from records.'); window.location.href = 'add-driver.php';</script>";
    }
}

include '../partials/footer.php';

if (isset($_POST['update'])) {
  $updatedCategoryID = $_POST['id'];
  $updatedVehicleType = $_POST['_vehicleType'];
  $updatedDescription = $_POST['_description'];

  updateCategory($updatedCategoryID, $updatedVehicleType, $updatedDescription, $connection);
}

function updateCategory($updatedCategoryID, $updatedVehicleType, $updatedDescription, $connection) {
  $sql = "UPDATE category SET VehicleType = '$updatedVehicleType', Description = '$updatedDescription' WHERE CategoryID = $updatedCategoryID";
  $query = mysqli_query($connection, $sql);

  if ($query) {
      header("location: manage-categories.php");
      exit;
  } else {
      echo "<script>alert('Error updating category.'); window.location.href = 'manage-categories.php';</script>";
  }
}

function insertData($customerID, $vehicleID, $adminID, $driverID, $resdate, $startdate, $enddate, $driveroption, $imageData, $totalcost, $reservationstatus, $connection) {
    $existingCategorySql = "SELECT ReservationID FROM reservation WHERE CustomerID = '$customerID'";
    $existingCategoryQuery = mysqli_query($connection, $existingCategorySql);

    if (mysqli_num_rows($existingCategoryQuery) > 0) {
        echo "<script>alert('Reservation exists.'); window.location.href = 'add-reservation.php';</script>";
        exit;
    }

    $sql = "INSERT INTO reservation (CustomerID, VehicleID, AdminID, DriverID, ReservationDate, RentalStartDate, RentalEndDate, DriverOption, LicensePhoto, TotalCost, ReservationStatus)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiiisssssds", $customerID, $vehicleID, $adminID, $driverID, $resdate, $startdate, $enddate, $driveroption, $imageData, $totalcost, $reservationstatus);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("location: manage-reservation.php");
            exit;
        } else {
            echo "Error inserting data into the database: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($connection);
    }
}

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $driverID = $_GET['id']; 

    // Perform the deletion
    $deleteQuery = mysqli_query($connection, "DELETE FROM reservation WHERE ReservationID = $reservationID"); // Change to $driverID

    if ($deleteQuery) {
        // Deletion was successful
        header("location: manage-reservation.php");
        exit;
    } else {
        // Deletion failed
        echo "<script>alert('Error deleting driver.'); window.location.href = 'manage-reservation.php';</script>";
    }
} else {
    // 'id' parameter is missing
    echo "Reservation ID is missing.";
}

?>
