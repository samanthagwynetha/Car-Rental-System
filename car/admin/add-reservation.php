<?php
  include '../partials/aheader.php';
  session_start();
  if(!isset($_SESSION['admin_ID'])){
    header('location: '. ROOT_URL .'signin.php');
  }
?>


<section class="form_section">
  <div class="container form_section-container">
    <h2>Add Reservations</h2>
    <form action="add-reservation.php" method="POST" enctype="multipart/form-data">
  
           <label for="CustomerID">Customer ID:</label>
            <select class="choices form-select" name="_customerID" class="form-control" required>
                <option value="">Choose..</option>
                <?php
                $sql = "SELECT * FROM customer";
                $query = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($query)) {
                  $CustomerID = $row['CustomerID'];
                  $cFname = $row['cFname'];
                  $cLname = $row['cLname'];
                  ?>
                   <option value="<?php echo $CustomerID; ?>">
                    <?php echo $CustomerID . " - " . $cFname . " " . $cLname;?>
                  </option>
                <?php } ?>
              </select>
          
            <label for="VehicleID">Vehicle ID:</label>
            <select class="choices form-select" name="_vehicleID" class="form-control" required>
                <option value="">Choose..</option>
                <?php
                $sql = "SELECT * FROM vehicle";
                $query = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($query)) {
                  $VehicleID = $row['VehicleID'];
                  $vBrand = $row['vBrand'];
                  $vModel = $row['vModel'];
                  ?>
                   <option value="<?php echo $VehicleID; ?>">
                    <?php echo $VehicleID . " - " . $vBrand . " " . $vModel;?>
                  </option>
                <?php } ?>
              </select>
            <label for="AdminID">Admin ID:</label>
            <input name="_adminID" class="form-control" value="<?php echo $_SESSION['admin_ID']?>" readonly>
            <label for="ReservationDate">Reservation Date:</label>
            <input type="date" name="_resdate" class="form-control" required>
         
            <label for="RentalStartDate">Start Date:</label>
            <input type="date" name="_startdate" class="form-control" required>
         
            <label for="RentalEndDate">End Date:</label>
            <input type="date" name="_enddate" class="form-control" required>
         
            <div class="form-group" 
            style="color: var(--color-white);">
              <label for="_driveroption">Driver Option:</label>
              <br><input type="radio" name="_driveroption" value="Self-Driven" class="form-control" required> (Self-driven)
              <br><input type="radio" name="_driveroption" value="Driver-Driven" class="form-control" required> (Driver-driven)
          </div>
          
          <div class="form-group"  id="license-photo-field" style="display: none;">
              <label for="cLicensePhoto">License Photo:</label>
                <input type="file" name="cLicensePhoto" accept="image/*" class="form-control">
          </div>
          <div class="form-group" id="driverIDField" style="display: none;">
                  <label for="DriverID">Driver ID:</label>
                  <select class="choices form-select" name="_driverID" class="form-control">
                      <option value="">Choose..</option>
                      <?php
                      // Fetch the list of drivers from the database
                      $sql = "SELECT * FROM driver";
                      $query = mysqli_query($connection, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                          $DriverID = $row['DriverID'];
                          $dFname = $row['dFname'];
                          $dLname = $row['dLname'];
                          ?>
                          <option value="<?php echo $DriverID; ?>">
                              <?php echo $DriverID . " - " . $dFname . " " . $dLname; ?>
                          </option>
                      <?php } ?>
                  </select>
          </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the radio buttons
    const option1Radio = document.querySelector('input[name="_driveroption"][value="Self-Driven"]');
    const option2Radio = document.querySelector('input[name="_driveroption"][value="Driver-Driven"]');

    const licensePhotoField = document.getElementById('license-photo-field');
    const driverOption2Fields = document.getElementById('driverIDField');
    
    // Function to show or hide the driver ID field group
    function toggleDriverIDField() {
        if (option1Radio.checked) {
            licensePhotoField.style.display = 'block';
              // Make the license photo field required
            licensePhotoField.querySelector('input').setAttribute('required', 'required');
            driverOption2Fields.style.display = 'none';
              // Remove the required attribute
            driverOption2Fields.querySelector('input').removeAttribute('required');
        } else if(option2Radio.checked) {
            licensePhotoField.style.display = 'none';
              // Remove the required attribute
            licensePhotoField.querySelector('input').removeAttribute('required');
            driverOption2Fields.style.display = 'block';
             // Make the driverID field required
             driverOption2Fields.querySelector('input').setAttribute('required', 'required');
        }
    }
    toggleDriverIDField();
    option1Radio.addEventListener('change', toggleDriverIDField);
    option2Radio.addEventListener('change', toggleDriverIDField);
});
</script>

          <div class="form-group" id="totalCostField" style="display: none;">
              <label for="TotalCost">Total Cost:</label>
              <input type="text" id="totalCost" name="totalcost" class="TotalCost" readonly>
          </div>
          <div class="form-group" style="color: var(--color-white);">
              <label for="ReservationStatus">Reservation Status:</label>
              <br><input type="radio" name="_reservationstatus" value="Pending" class="form-control" required> (Pending)
              <br><input type="radio" name="_reservationstatus" value="Confirmed" class="form-control" required> (Confirmed)
          </div>
          <button type="submit" name="submit" class="btn">Add Reservation</button>
          <a href="manage-reservation.php" class="btn">Back</a>
      </form>
  </div>
</section>
  
<?php
if (isset($_POST['submit'])) {
    $cID = $_POST['_customerID'];
    $vID = $_POST['_vehicleID'];
    $aID = $_POST['_adminID'];
    $rD = $_POST['_resdate'];
    $sD = $_POST['_startdate'];
    $eD = $_POST['_enddate'];
    $dO = $_POST['_driveroption'];
    //getLicensePhoto
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
    //getTotal Cost 
        $sql = "SELECT*FROM `vehicle` WHERE VehicleID = '$vID'";
        $vehicles = mysqli_query($connection, $sql);
        $vehicle = mysqli_fetch_array($vehicles, MYSQLI_ASSOC);

        $date1_timestamp = strtotime($sD);
        $date2_timestamp = strtotime($eD);

          if ($date1_timestamp === false || $date2_timestamp === false) {
            echo '<script>alert("Invalid date format");</script>';
            exit;
          }
        $seconds_interval = abs($date2_timestamp - $date1_timestamp);
        $days_interval = floor($seconds_interval / (60 * 60 * 24));

        $rpd= $vehicle['RatePerDay'];

        $totalC = $rpd*$days_interval;
    $tC = $totalC;
    $rS = $_POST['_reservationstatus'];

    // Validate form data
    if (empty($rD) || empty($sD) || empty($eD) || empty($dO)) {
        echo '<script>alert("All fields are required");</script>';
    } else {
      if ($dO === "Driver-Driven") {
        $dID = $_POST['_driverID'];
        $sql = "INSERT INTO `reservation`(`ReservationID`, `CustomerID`, `VehicleID`, `AdminID`, `DriverID`, `ReservationDate`, `RentalStartDate`, `RentalEndDate`, `DriverOption`, `LicensePhoto`, `TotalCost`, `ReservationStatus`) VALUES (null,'$cID','$vID','$aID','$dID','$rD','$sD','$eD','$dO','$lP','$tC','$rS')";
        $result = mysqli_query($connection, $sql);

      } else {
        $sql = "INSERT INTO `reservation`(`ReservationID`, `CustomerID`, `VehicleID`, `AdminID`, `ReservationDate`, `RentalStartDate`, `RentalEndDate`, `DriverOption`, `LicensePhoto`, `TotalCost`, `ReservationStatus`) VALUES (null,'$cID','$vID','$aID','$rD','$sD','$eD','$dO','$lP','$tC','$rS')";
        $result = mysqli_query($connection, $sql);
       
      }
    //   if ($result) {
    //     header('Location: manage-reservation.php');
    //     exit(); 
    // } else {
    //     echo '<script>alert("Error adding reservation");</script>';
    // }
    }
}
?>



