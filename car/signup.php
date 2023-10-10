<?php
session_start();
if(isset($_SESSION['customer_ID'])){
  header("Location: index.php");
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
    <h2>Sign Up</h2>
     <!--<div class="alert_message error">
    <p>Error Message</p>
  </div>-->
    

  <form class="signup" action="signup.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="fname" placeholder="First Name">
    <input type="text" name="lname" placeholder="Last Name">
    <label for="DOB" style="color: var(--color-white);">Birth Date</label>
    <input type="date" name="birthdate" id="DOB">
    <input type="tel" name="contactNo" placeholder="Contact Number">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Create Password">
    <input type="password" name="cpassword" placeholder="Confirm Password">

    <button type="submit" name="sign-up-btn" class="btn">Sign Up</button>
    <small>Already have an account? <a href="signin.php">Sign In</a></small>
  </form>
</div>
</section>

</body>
</html>

<?php
require_once 'config/database.php';

//signup data
if (isset($_POST['sign-up-btn'])){
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $birthdate = $_POST['birthdate'];
  $contactNo = $_POST['contactNo'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  //validate input values
  $errors = array();

if (empty($fname) || empty($lname) || empty($birthdate) || empty($contactNo) || empty($email) || empty($password) || empty($cpassword)) {
    array_push($errors, "All fields are required");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Email not valid");
}

if (strlen($password) < 8) {
    array_push($errors, "Password must be at least 8 characters long");
}

if ($password !== $cpassword) {
    array_push($errors, "Password does not match");
}

// Email already exists
$sql = "SELECT * FROM customer WHERE cEmail = '$email'";
$result = mysqli_query($connection, $sql);
$rowCount = mysqli_num_rows($result);

if ($rowCount > 0) {
    array_push($errors, "Email already exists!");
}

// Display errors
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo '<script>alert("' . $error . '");</script>';
    }
    }else{
      $sql = "CALL getCustomerInfo('$fname','$lname','$birthdate','$contactNo','$email','$password')";
      if(mysqli_query($connection, $sql)){
        header('location: '. ROOT_URL .'signin.php');
        die("Registered Successfully");
      }else{
        header('location: '. ROOT_URL .'signup.php');
        die("something went wrong");
      }
    }
}else{
}
?>