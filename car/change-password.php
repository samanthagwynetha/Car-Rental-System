<?php
include 'partials/ccheader.php';
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Website</title>

  <!--Style-->
  <link rel="stylesheet" href="css/style.css">
    <!--Icon-->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <!--FONTS-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;800&family=Playfair:wght@300&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body>
  <section class="form_section">
    <div class="container form_section-container">
      <h2>Change Password</h2>
    <form action="change-password.php" method="POST" enctype="multipart/form-data">
        <label for="currentP">Current Password</label>
        <input type="password" name="currentP" id="currentP" placeholder="Current Password" required>
        <label for="newP">New Password</label>
        <div class="password-container">
          <input type="password" name="newP" id="newP" placeholder="New Password" required>
          <button type="button" class="toggle-password" onclick="togglePassword('newP')">Show</button>
        </div>
        <label for="newP2">Confirm New Password</label>
        <div class="password-container">
          <input type="password" name="newP2" id="newP2" placeholder="Confirm New Password" required>
          <button type="button" class="toggle-password" onclick="togglePassword('newP2')">Show</button>
        </div>   
        <script>
          // Function to toggle password visibility
          function togglePassword(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var fieldType = passwordField.getAttribute('type');

            if (fieldType === 'password') {
              passwordField.setAttribute('type', 'text');
              event.target.textContent = 'Hide';
            } else {
              passwordField.setAttribute('type', 'password');
              event.target.textContent = 'Show';
            }
          }

          // Client-side validation for password length and match
          document.getElementById("passwordForm").addEventListener("submit", function(event) {
            var newPassword = document.getElementById("newP").value;
            var confirmPassword = document.getElementById("newP2").value;
            var passwordMatchError = document.getElementById("passwordMatchError");

            if (newPassword.length < 8) {
              alert("New Password must be at least 8 characters long.");
              event.preventDefault(); // Prevent form submission
            } else if (newPassword !== confirmPassword) {
              passwordMatchError.style.display = "block";
              event.preventDefault(); // Prevent form submission
            }
          });

          // Check password match on keyup
          document.getElementById("newP2").addEventListener("keyup", function() {
            var newPassword = document.getElementById("newP").value;
            var confirmPassword = this.value;
            var passwordMatchError = document.getElementById("passwordMatchError");

            if (newPassword === confirmPassword) {
              passwordMatchError.style.display = "none";
            } else {
              passwordMatchError.style.display = "block";
            }
          });
        </script>
        <button type="submit" name="update-btn" class="btn">Update</button>
    </form>
  </section>
</body>
</html>

<?php
    if(isset($_POST['update-btn'])){
    $cID= $_SESSION['customer_ID'];
    //input validation
    $currentP=trim($_POST['currentP']);
    $newP=trim($_POST['newP']);
    $newP2=trim($_POST['newP2']);

    $sql="SELECT*FROM customer WHERE CustomerID='$cID'";
    $result = mysqli_query($connection, $sql);
    $customer = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($customer) {
        if($currentP==$customer['cPassword']){
          if ($newP !== $newP2) {
            echo '<script>alert("New Password and Confirm New Password does not match");</script>';          
          }else{
            $sql="UPDATE `customer` SET `cPassword`='$newP' WHERE CustomerID='$cID'";
            if(mysqli_query($connection, $sql)){
              echo '<script>alert("Password Successfully Changed");</script>';
              header('location: '. ROOT_URL .'index.php');
              die();
            }else{
              echo '<script>alert("Something went wrong");</script>';
              header('location: '. ROOT_URL .'change-password.php');
              die();
            }
          }
        }else{
          echo '<script>alert("Incorrect current password. Please try again.");</script>';
        }
    }
    }

?>
