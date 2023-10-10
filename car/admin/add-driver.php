<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}
?>

<section class="form_section">
  <div class="container form_section-container">
    <h2>Add Driver</h2>
    <form action="driver-functions.php" method="POST" enctype="multipart/form-data">  
            <input type="text" name="_dFname" placeholder="First Name"    class="form-control" required>
            <input type="text" name="_dLname" placeholder="Last Name" class="form-control" required>
            <input type="number" name="_dPhoneNo" placeholder="Phone Number" class="form-control" required>
            <input type="email" name="_dEmail" placeholder="Email" class="form-control" required>
            <input type="password" name="_dPassword" placeholder="Password" class="form-control" required>
            <input type="file" name="_dLicensePhoto" placeholder="License" accept="image/*" class="form-control">
            <button type="submit" name="submit" class="btn">Add Driver</button>
            <a href="drivers-info.php" class="btn sm danger">Back</a>
        </form>
  </div>
</section>

<?php
  include '../partials/footer.php';
?>