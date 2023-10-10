<?php
include '../partials/aheader.php';
session_start();
if (!isset($_SESSION['admin_ID'])) {
    header('location: ' . ROOT_URL . 'signin.php');
}

if (isset($_GET['id'])) {
    $reservationID = $_GET['id'];

    $query = mysqli_query($connection, "SELECT * FROM reservation WHERE ReservationID = $reservationID");

    if ($query) {
        $row = mysqli_fetch_assoc($query);
        if (!$row) {
            echo "Reservation not found.";
            exit;
        }
    } else {
        echo "Error fetching reservation data.";
        exit;
    }
} else {
    echo "Reservation ID is missing.";
}
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Reservation</h2>
        <form action="update-reservation.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="reservationID" value="<?php echo $row['ReservationID']; ?>">
            <div class="form-group">
                <label for="customerID">Customer ID:</label>
                <input type="number" name="customerID" class="form-control"
                       value="<?php echo $row['CustomerID']; ?>" required readonly>
            </div>

            <div class="form-group">
                <label for="reservationStatus">Reservation Status:</label>
                <select name="reservationStatus" class="form-control">
                    <option value="Pending"
                        <?php if ($row['ReservationStatus'] === 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Confirmed"
                        <?php if ($row['ReservationStatus'] === 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                </select>
            </div>

            <div class="form-group" style="display: none;">
                <label for="_driveroption">Driver Option:</label>
                <br>
                <input type="radio" name="_driveroption" value="Self-Driven" class="form-control" required
                    <?php if ($row['DriverOption'] === 'Self-Driven') echo 'checked'; ?>> (Self-driven)
                <br>
                <input type="radio" name="_driveroption" value="Driver-Driven" class="form-control" required 
                    <?php if ($row['DriverOption'] === 'Driver-Driven') echo 'checked'; ?>> (Driver-driven)
            </div>

            <!-- Add the Driver ID field, but initially hide it -->
            <div class="form-group" id="driverIDField" <?php if ($row['DriverOption'] !== 'Driver-Driven') echo 'style="display: none;"'; ?>>
                <label for="driverID">Driver ID:</label>
                <select name="driverID" class="form-control">
                    <option value="">Choose..</option>
                    <?php
                    $sql = "SELECT * FROM driver";
                    $query = mysqli_query($connection, $sql);

                    while ($driverRow = mysqli_fetch_assoc($query)) {
                        $DriverID = $driverRow['DriverID'];
                        $dFname = $driverRow['dFname'];
                        $dLname = $driverRow['dLname'];
                        ?>
                        <option value="<?php echo $DriverID; ?>"
                            <?php if ($DriverID == $row['DriverID']) echo 'selected'; ?>>
                            <?php echo $DriverID . " - " . $dFname . " " . $dLname; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn">Update Reservation</button>
            <a href="manage-reservation.php" class="btn">Back</a>
        </form>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the radio buttons
        const option1Radio = document.querySelector('input[name="_driveroption"][value="Self-Driven"]');
        const option2Radio = document.querySelector('input[name="_driveroption"][value="Driver-Driven"]');

        const driverIDField = document.getElementById('driverIDField');

        // Function to show or hide the Driver ID field
        function toggleDriverIDField() {
            if (option2Radio.checked) {
                driverIDField.style.display = 'block';
            } else if (option1Radio.checked){
                driverIDField.style.display = 'none';
            }
        }

        toggleDriverIDField();
    });
</script>

<?php
include '../partials/footer.php';
?>
