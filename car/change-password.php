<?php
include 'partials/cheader.php';
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
            <input type="password" name="currentP" placeholder="Current Password">
        <label for="currentP">New Password</label>
            <input type="password" name="newP" placeholder="New Password">
        <label for="currentP">Confirm New Password</label>
            <input type="password" name="newP2" placeholder="Confirm New Password">      
        <button type="submit" name="update-btn" class="btn">Update</button>
    </form>
  </section>
</body>
</html>

<?php
    if(isset($_POST['update-btn'])){
    $cID= $_SESSION['customer_ID'];
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
          echo '<script>alert("Password does not match");</script>';
        }
    }
    }

?>