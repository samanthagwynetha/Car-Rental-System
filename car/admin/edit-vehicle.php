<?php
include '../partials/aheader.php';
session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}

// Include your database connection code here if not already included
// ...

// Fetch categories from the database
$category_query = "SELECT * FROM category";
$categories = mysqli_query($connection, $category_query);

// Fetch vehicle data based on the VehicleID from the URL
if (isset($_GET['VehicleID'])) {
    $VehicleID = filter_var($_GET['VehicleID'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM vehicle WHERE VehicleID=$VehicleID";
    $result = mysqli_query($connection, $query);
    $vehicle = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}
?>

<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit Vehicle</h2>
    <form method="POST" action="<?= ROOT_URL ?>admin/edit-vehicle-logic.php" enctype="multipart/form-data">
      <input type="hidden" name="VehicleID" value="<?= $vehicle['VehicleID'] ?>">
      <input type="hidden" name="previous_thumbnail_name" value="<?= $vehicle['vImage'] ?>">
      <select name="CategoryID">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['CategoryID'] ?>"<?= ($category['CategoryID'] == $vehicle['CategoryID']) ? ' selected' : '' ?>>
            <?= $category['VehicleType'] ?>
          </option>
        <?php endwhile ?>
      </select>
      <input type="text" name="vBrand" value="<?= $vehicle['vBrand'] ?>" placeholder="Brand">
      <input type="text" name="vModel" value="<?= $vehicle['vModel'] ?>" placeholder="Model">
      <input type="text" name="vPLNo" value="<?= $vehicle['vPLNo'] ?>" placeholder="Plate Number">
      <input type="text" name="RatePerDay" value="<?= $vehicle['RatePerDay'] ?>" placeholder="Rate Per Day">
      <input type="text" name="Availability" value="<?= $vehicle['Availability'] ?>" placeholder="Availability">
      <!--<select name="Availability">
        <option value="1"<?= ($vehicle['Availability'] == '1') ? ' selected' : '' ?>>Available</option>
        <option value="0"<?= ($vehicle['Availability'] == '0') ? ' selected' : '' ?>>Not Available</option>
      </select>
  -->
        <div class="form_control">
        <label for="vImage">Vehicle Image</label>
        <input type="file" name="vImage" id="vImage">
      </div>
      <button type="submit" name="submit" class="btn">Update Vehicle</button>
    </form>
  </div>
</section>

<?php
include '../partials/footer.php';
?>
