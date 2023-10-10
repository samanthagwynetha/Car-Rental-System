<?php
include 'partials/header.php';

session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
?>
<?php
if (isset($_POST['confirm_btn'])){
  $cID = $_SESSION['customer_ID'];
  $vID = $_POST['vID'];
  $aID = "null";
  $dID = "null";
  $rD = $_POST['today_date'];
  $sD = $_POST['start_date'];
  $eD = $_POST['end_date'];
  $dO = $_POST['dOp'];
  $lP = $_FILES['cLicenseID'];
  $tC = $_POST['totalCost'];
  $rS = $_POST['resrvationS'];

  // Validate form data
  if(empty($rD) || empty($sD) || empty($eD) || empty($dO) || empty($lP) || empty($tC) || empty($rS)) {
    echo '<script>alert("All fields are required");</script>';
  }else {
    $time = time();
    $vImage_name = $time . $lP['name'];
    $vImage_tmp_name = $lP['tmp_name'];
    $vImage_destination_path = '../images/' . $vImage_name;

    // Make sure file is an image
    $allowed_extensions = ['png', 'jpg', 'jpeg'];
    $extension = strtolower(pathinfo($vImage_name, PATHINFO_EXTENSION)); // Get the file extension

    if (in_array($extension, $allowed_extensions)) {
        // Make sure image is not too big (less than 2MB)
        if ($lP['size'] < 2000000) {
            move_uploaded_file($vImage_tmp_name, $vImage_destination_path);
            $sql="INSERT INTO `reservation`(`ReservationID`, `CustomerID`, `VehicleID`, `ReservationDate`, `RentalStartDate`, `RentalEndDate`, `DriverOption`, `LicensePhoto`, `TotalCost`, `ReservationStatus`) VALUES (null,'$cID','$vID','$rD','$sD','$eD','$dO','$lP','$tC','$rS')";
            $result=mysqli_query($connection, $sql);

            if($result) {
              header('location: '. ROOT_URL .'cdashboard.php');
            }
        } else {
          echo '<script>alert("File size is too big. Should be less than 2MB.");</script>';
          echo '<script>alert("File should be in PNG, JPG, or JPEG format");</script>';
        }
    }
  }
}
?>
