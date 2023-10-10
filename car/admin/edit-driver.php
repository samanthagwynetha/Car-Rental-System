<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}
  if (isset($_GET['id'])) {
    $driverID = $_GET['id'];

    // Now, you have the $driverID, and you can use it to fetch the driver's data from the database.
    // You can perform a database query to retrieve the data and display it on the edit form.
    // For example:
    $query = mysqli_query($connection, "SELECT * FROM driver WHERE DriverID = $driverID");
    $row = mysqli_fetch_assoc($query);

    if (!$row) {
        // Handle the case where the driver with the specified ID does not exist.
    }

    $dfname = $row['dFname'];
    $dlname = $row['dLname'];
    $dphoneNo = $row['dPhoneNo'];
    $demail = $row['dEmail'];
    // You can fetch other data as needed.

} else {
    // Handle the case where the 'id' parameter is not set.
}

// Check if the form has been submitted
if (isset($_POST['update'])) {
    // Get the updated data from the form
    $updatedDfname = $_POST['dfname'];
    $updatedDlname = $_POST['dlname'];
    $updatedDphoneNo = $_POST['dphoneNo'];
    $updatedDemail = $_POST['demail'];

    // Update the data in the database
    $updateQuery = mysqli_query($connection, "UPDATE driver SET dFname = '$updatedDfname', dLname = '$updatedDlname', dPhoneNo = '$updatedDphoneNo', dEmail = '$updatedDemail' WHERE DriverID = $driverID");

    if ($updateQuery) {
        // Update was successful
        echo "<script>alert('Driver information updated successfully.'); window.location.href = 'drivers-info.php';</script>";
    } else {
        // Update failed
        echo "<script>alert('Error updating driver information.'); window.location.href = 'edit-driver.php?id=$driverID';</script>";
    }
}
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Driver</h2>
        <form action="edit-driver.php?id=<?php echo $driverID; ?>" method="POST" enctype="multipart/form-data">
            <label for="dfname">First Name:</label>
            <input type="text" name="dfname" value="<?php echo $dfname; ?>" placeholder="First Name">
            <label for="dlname">Last Name:</label>
            <input type="text" name="dlname" value="<?php echo $dlname; ?>" placeholder="Last Name">
            <label for="dphoneNo">Phone Number:</label>
            <input type="text" name="dphoneNo" value="<?php echo $dphoneNo; ?>" placeholder="Phone Number">
            <label for="demail">Email:</label>
            <input type="email" name="demail" value="<?php echo $demail; ?>" placeholder="Email">
            <button type="submit" name="update" class="btn">Update</button>
            <a href="drivers-info.php" class="btn">Back</a>
        </form>
    </div>
</section>

  
<?php
  include '../partials/footer.php';
  
  ?>