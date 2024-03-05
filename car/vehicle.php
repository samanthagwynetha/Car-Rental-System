<?php
include 'partials/ccheader.php';
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
?>

<?php
$vID = $_GET['vID'];
$sql = "SELECT * FROM `vehicle` WHERE VehicleID = '$vID'";
$vehicles = mysqli_query($connection, $sql);
while ($vehicle = mysqli_fetch_assoc($vehicles)) :
?>
<section class="singlepost">
    <div class="container singlepost_container">
        <div class="post_info">
            <article class="post">
                <div class="post_thumbnail">
                    <img src="./images/<?= $vehicle['vImage'] ?>">
                </div>
                <div class="post_info">
                    <h3 class="post_title">
                        <a href="post.php"><?= $vehicle['vBrand'] ?></a>
                    </h3>
                    <p class="vModel"> <?= $vehicle['vModel'] ?></p>
                    <p class="vPLNo"><?= $vehicle['vPLNo'] ?></p>
                    <p class="RatePerDay"><?= $vehicle['RatePerDay'] ?></p>
                    <p class="Availability"><?= $vehicle['Availability'] ?></p>
                </div>
            </article>
        </div>
    </div>
    <div class="container customer_container" style="color: var(--color-white);">
        <h2>Reservation Details</h2>
        <form action="vehicle.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="vID" class="vID" value="<?= $vehicle['VehicleID'] ?>" readonly>
            <label for="cResrvationDate">Today's Date</label>
            <input type="date" name="today_date" class="cReservationtDate" placeholder="Today's Date" required readonly>
            <script>
                // Get today's date
                var today = new Date().toISOString().split('T')[0];
                // Set the value of the input field to today's date
                document.getElementsByName("today_date")[0].value = today;
            </script>
            <label for="cRentalStartDate">Rental Start Date</label>
            <input type="date" name="start_date" id="start_date" class="cRentalStartDate" placeholder="Rental Start Date" min="<?php echo date('Y-m-d'); ?>" required onchange="updateMinEndDate()">
            <label for="cRentalEndDate">Rental End Date</label>
            <input type="date" name="end_date" id="end_date" class="cRentalEndDate" placeholder="Rental End Date" required>
            <script>
                function updateMinEndDate() {
                    var startDate = document.getElementById("start_date").value;
                    document.getElementById("end_date").min = startDate;
                    // Ensure end date is not before start date
                    if (document.getElementById("end_date").value < startDate) {
                        document.getElementById("end_date").value = startDate;
                    }
                    // Calculate total cost when start date changes
                    calculateTotalCost();
                }

                function calculateTotalCost() {
                    var startDate = new Date(document.getElementById("start_date").value);
                    var endDate = new Date(document.getElementById("end_date").value);
                    var ratePerDay = <?= $vehicle['RatePerDay'] ?>;
                    
                    // Calculate number of days
                    var numberOfDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24) + 1);
                    
                    // If start date and end date are the same, set number of days to 1
                    if (startDate.toDateString() === endDate.toDateString()) {
                        numberOfDays = 1;
                    }
                    
                    // Calculate total cost
                    var totalCost = numberOfDays * ratePerDay;
                    
                    // Update total cost input field
                    document.getElementById("totalCost").value = totalCost;
                }

                // Ensure end date is not before start date when end date is changed directly
                document.getElementById("end_date").addEventListener("change", function() {
                    var startDate = document.getElementById("start_date").value;
                    if (this.value < startDate) {
                        this.value = startDate;
                    }
                    // Calculate total cost when end date changes
                    calculateTotalCost();
                });
            </script>

            <div class="form-group">
                <label for="_driveroption">Driver Option:</label>
                <hr>
                <input type="radio" name="_driveroption" value="Self-Driven" class="form-control" required> (Self-driven)
                <hr>
                <input type="radio" name="_driveroption" value="Driver-Driven" class="form-control" required> (Driver-driven)
            </div>
            <div class="form-group" id="license-photo-field" style="display: none;">
                <label for="cLicensePhoto">License Photo:</label>
                <input type="file" name="cLicensePhoto" accept="image/*" class="form-control">
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Get the radio buttons
                const option1Radio = document.querySelector('input[name="_driveroption"][value="Self-Driven"]');
                const option2Radio = document.querySelector('input[name="_driveroption"][value="Driver-Driven"]');
        
                  // Get the license photo field
                const licensePhotoField = document.getElementById('license-photo-field');
        
                  // Function to show or hide the license photo field
                  function toggleLicensePhotoField() {
                if (option1Radio.checked) {
                    licensePhotoField.style.display = 'block';
                    // Make the license photo field required
                    licensePhotoField.querySelector('input').setAttribute('required', 'required');
                } else if(option2Radio.checked) {
                    licensePhotoField.style.display = 'none';
                    // Remove the required attribute
                    licensePhotoField.querySelector('input').removeAttribute('required');
                }
            }
                  // Initial state
                toggleLicensePhotoField();
        
                  // Add event listeners to the radio buttons to toggle the field
                option1Radio.addEventListener('change', toggleLicensePhotoField);
                option2Radio.addEventListener('change', toggleLicensePhotoField);
                });
              </script>

            <label for="TotalCost">Total Cost</label>
            <input type="text" name="totalCost" id="totalCost" class="TotalCost" value="" readonly>

            <label for="ReservationStatus">Reservation Status</label>
            <input type="text" name="resrvationS"class="ReservationStatus" value="Pending" readonly>
            <button type="submit" name="confirm_btn" class="btn">Confirm</button>
        </form>
    </div>
</section>
<?php endwhile ?>
<?php
include 'partials/footer.php';
?>

<?php

if (isset($_POST['confirm_btn'])) {

    $cID = $_SESSION['customer_ID'];
    $vID = $_POST['vID'];
    $rD = $_POST['today_date'];
    $sD = $_POST['start_date'];
    $eD = $_POST['end_date'];
    $dO = $_POST['_driveroption'];
    $tC = $_POST['totalCost'];
    $rS = $_POST['resrvationS'];

    // Validate form data
    if (empty($rD) || empty($sD) || empty($eD) || empty($dO) || empty($tC) || empty($rS)) {
        echo '<script>alert("All fields are required");</script>';
        echo '<script>window.location.href="vehicle.php?vID=' . urlencode($vID) . '";</script>';
        exit();
    } else {
        // Check if "Self-Driven" option is selected and validate the license photo
        if ($dO === "Self-Driven") {
            // Check if a file is uploaded
            if (!empty($_FILES['cLicensePhoto']['name'])) {
                // Define allowed file types
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                // Get file extension
                $file_extension = pathinfo($_FILES['cLicensePhoto']['name'], PATHINFO_EXTENSION);
                // Check if the file extension is allowed
                if (in_array(strtolower($file_extension), $allowed_types)) {
                    // Check file size (for example, limit it to 5MB)
                    if ($_FILES['cLicensePhoto']['size'] <= 5 * 1024 * 1024) { // 5MB in bytes
                        // Process the uploaded file
                        $lP = addslashes(file_get_contents($_FILES['cLicensePhoto']['tmp_name']));
                    } else {
                        echo '<script>alert("File size exceeds the limit (5MB). Please upload a smaller file.");</script>';
                        echo '<script>window.location.href="vehicle.php?vID=' . urlencode($vID) . '";</script>';
                        exit(); // Exit the script
                    }
                } else {
                    echo '<script>alert("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");</script>';
                    echo '<script>window.location.href="vehicle.php?vID=' . urlencode($vID) . '";</script>';
                    exit(); // Exit the script
                }
            } else {
                echo '<script>alert("Please upload a license photo.");</script>';
                echo '<script>window.location.href="vehicle.php?vID=' . urlencode($vID) . '";</script>';
                exit(); // Exit the script
            }
        } else {
            // If "Driver-driven," set $lP to NULL
            $lP = NULL;
        }

        // Insert data into the database
        $sql = "INSERT INTO `reservation`(`ReservationID`, `CustomerID`, `VehicleID`, `ReservationDate`, `RentalStartDate`, `RentalEndDate`, `DriverOption`, `LicensePhoto`, `TotalCost`, `ReservationStatus`) VALUES (null,'$cID','$vID','$rD','$sD','$eD','$dO','$lP','$tC','$rS')";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            header('location: ' . ROOT_URL . 'cdashboard.php');
        } else {
            echo '<script>alert("Error occurred while processing your request. Please try again later.");</script>';
            echo '<script>window.location.href="vehicle.php?vID=' . urlencode($vID) . '";</script>';
            exit();
        }
    }
}
?>
