<?php
include '../partials/aheader.php';
session_start();
if (!isset($_SESSION['admin_ID'])) {
    header('location: ' . ROOT_URL . 'signin.php');
}
?>
<?php
if (isset($_POST['submit'])) {
    $reservationID = $_POST['reservationID'];
    $adminID = $_SESSION['admin_ID'];
    $customerID = $_POST['customerID'];
    $driverOption = $_POST['_driveroption'];
    $driverID = $_POST['driverID']; // Add this line to get the updated Driver ID
    $reservationStatus = $_POST['reservationStatus'];
    
    // Check if a new license photo is uploaded
    if ($driverOption === "Self-Driven") {
        $sql = "UPDATE reservation SET AdminID = ?, DriverOption = ?, ReservationStatus = ? WHERE ReservationID = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "issi", $adminID, $driverOption, $reservationStatus, $reservationID);
    } else {
        // Update the reservation data without changing the license photo and with the updated Driver ID
        $sql = "UPDATE reservation SET AdminID = ?, DriverOption = ?, DriverID = ?, ReservationStatus = ? WHERE ReservationID = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "isssi", $adminID, $driverOption, $driverID, $reservationStatus, $reservationID);
    }

    if (mysqli_stmt_execute($stmt)) {
        header('Location: manage-reservation.php');
        exit;
    } else {
        echo "Error updating reservation: " . mysqli_error($connection);
    }
} else {
    // Handle the case where the form was not submitted properly
    echo "Form submission error.";
}
?>
