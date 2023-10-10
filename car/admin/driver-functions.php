<?php
include 'config/database.php';

if (isset($_POST['submit'])) {
    try {
        $fname = $_POST['_dFname'];
        $lname = $_POST['_dLname'];
        $ContactNo = $_POST['_dPhoneNo'];
        $Email = $_POST['_dEmail'];
        $Password = $_POST['_dPassword'];
        
        // Get the content of the uploaded file
        $imageData = file_get_contents($_FILES['_dLicensePhoto']['tmp_name']);

        insertData($fname, $lname, $ContactNo, $Email, $Password, $imageData, $connection);
    } catch (Exception $e) {
        echo "<script>alert('Cannot add driver from records.'); window.location.href = 'add-driver.php';</script>";
    }
}

include '../partials/footer.php';

// Check if the form has been submitted
if (isset($_POST['update'])) {
  // Get the updated data from the form
  $updatedCategoryID = $_POST['id'];
  $updatedVehicleType = $_POST['_vehicleType'];
  $updatedDescription = $_POST['_description'];

  // Call the updateCategory function with the updated data
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

function insertData($fname, $lname, $ContactNo, $Email, $Password, $imageData, $connection) {
    $existingCategorySql = "SELECT DriverID FROM driver WHERE dFname = '$fname'";
    $existingCategoryQuery = mysqli_query($connection, $existingCategorySql);

    if (mysqli_num_rows($existingCategoryQuery) > 0) {
        // Category already exists
        echo "<script>alert('Driver already exists.'); window.location.href = 'add-driver.php';</script>";
        exit;
    }

    // Insert the image data into the database
$sql = "INSERT INTO driver(dFname, dLname, dPhoneNo, dEmail, dPassword, dLicensePhoto) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssbs", $fname, $lname, $ContactNo, $Email, $Password, $imageData);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        header("location: drivers-info.php");
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
    $driverID = $_GET['id']; // Change to lowercase 'd' in $driverID

    // Perform the deletion
    $deleteQuery = mysqli_query($connection, "DELETE FROM driver WHERE DriverID = $driverID"); // Change to $driverID

    if ($deleteQuery) {
        // Deletion was successful
        header("location: drivers-info.php");
        exit;
    } else {
        // Deletion failed
        echo "<script>alert('Error deleting driver.'); window.location.href = 'drivers-info.php';</script>";
    }
} else {
    // 'id' parameter is missing
    echo "Driver ID is missing.";
}

?>
