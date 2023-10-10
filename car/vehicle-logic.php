<?php
include 'partials/header.php';
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
?>
<?php
$vID = $_GET['vID'];
$sql = "SELECT*FROM `vehicle` WHERE VehicleID = '$vID'";
$vehicles = mysqli_query($connection, $sql);
while ($vehicle = mysqli_fetch_assoc($vehicles)) : 
?>
<?php
if (isset($_GET['nxt'])) {
  $vID = $_GET['vID'];
  $td = $_GET['today_date'];
  $sd = $_GET['start_date'];
  $ed = $_GET['end_date'];
  

  if(empty($td) || empty($sd) || empty($ed)) {
    echo '<script>alert("All fields are required");</script>';
  }else {

  $date1_timestamp = strtotime($sd);
  $date2_timestamp = strtotime($ed);

    if ($date1_timestamp === false || $date2_timestamp === false) {
      echo '<script>alert("Invalid date format");</script>';
      exit;
    }
  $seconds_interval = abs($date2_timestamp - $date1_timestamp);
  $days_interval = floor($seconds_interval / (60 * 60 * 24));

  $rpd= $vehicle['RatePerDay'];

  $totalC = $rpd*$days_interval;
  }
} 
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
        <form action="vehicle-logic.php" method="POST" enctype="multipart/form-data">
          <input type="text" name="vID" class="vID" value="<?= $vehicle['VehicleID'] ?>" readonly>
          <label for="cResrvationDate">Today's Date</label>
          <input type="date" name="today_date" class="cReservationtDate" value="<?php echo isset($td) ? htmlspecialchars($td) : ''; ?>" readonly>
          <label for="cRentalEndDate">Rental Start Date</label>
          <input type="date" name="start_date" class="cRentalStartDate" value="<?php echo isset($sd) ? htmlspecialchars($sd) : ''; ?>" readonly>
          <label for="cRentalEndDate">Rental End Date</label>
          <input type="date" name="end_date" class="cRentalEndDate" value="<?php echo isset($ed) ? htmlspecialchars($ed) : ''; ?>" readonly>
          
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
          <input type="text" name="totalCost" class="TotalCost" value="<?php echo isset($totalC) ? htmlspecialchars($totalC) : ''; ?>" readonly>
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
    } else {
        // Check if the "License Photo" field is required
        if ($dO === "Self-Driven") {
            // Validate and process the uploaded license photo
            if ($_FILES['cLicensePhoto']['error'] === 0) {
                $lP = addslashes(file_get_contents($_FILES['cLicensePhoto']['tmp_name']));
            } else {
                echo '<script>alert("Please upload a valid license photo");</script>';
                // You might want to add additional validation or error handling for the file upload here.
                // This is a basic example.
                exit(); // Exit the script since the file is not valid.
            }
        } else {
            // If "Driver-driven," set $lP to NULL (assuming your database accepts NULL for LicensePhoto)
            $lP = NULL;
        }

        // Insert data into the database
        $sql = "INSERT INTO `reservation`(`ReservationID`, `CustomerID`, `VehicleID`, `ReservationDate`, `RentalStartDate`, `RentalEndDate`, `DriverOption`, `LicensePhoto`, `TotalCost`, `ReservationStatus`) VALUES (null,'$cID','$vID','$rD','$sD','$eD','$dO','$lP','$tC','$rS')";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            header('location: ' . ROOT_URL . 'cdashboard.php');
        } else {
            echo "MySQL Error: " . mysqli_error($connection);
        }
    }
}
?>

