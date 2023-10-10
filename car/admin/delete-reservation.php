<?php
include 'config/database.php';

if (isset($_GET['id'])) {
    $reservationID = $_GET['id'];

    $deleteQuery = mysqli_query($connection, "DELETE FROM reservation WHERE ReservationID = $reservationID");

    if ($deleteQuery) {
        header("location: manage-reservation.php");
        exit;
    } else {
        echo "<script>alert('Error deleting reservation.'); window.location.href = 'reservation-info.php';</script>";
    }
} else {
    echo "Reservation ID is missing.";
}
?>
