<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
  
}
  //fetch categories from database
  $query = "SELECT * FROM category";
  //$categories = mysqli_query($connection, $query);

  $stmt = mysqli_prepare($connection, $query); // use prepared statements 
  mysqli_stmt_execute($stmt);
  $categories = mysqli_stmt_get_result($stmt);

  //get back form data if invalid post
  $vBrand = $_SESSION['add-vehicle-post-data']['vBrand'] ?? null;
  $vModel = $_SESSION['add-vehicle-post-data']['vModel'] ?? null; 

  //delete from data session
  unset($_SESSION['add-vehicle-post-data']);
?>

<body>
<section class="form_section">
  <div class="container form_section-container">
    <h2>Add Vehicle</h2> 
    <?php if (isset($_SESSION['add-vehicle-post'])) : ?>
    <div class="alert_message error">
        <p> 
          <?= $_SESSION['add-vehicle-post'];
          unset($_SESSION['add-vehicle-post']);
          ?>
        </p>
    </div>  
    <?php endif ?>
  <form action="<?= ROOT_URL ?>admin/add-vehicle-logic.php" enctype="multipart/form-data" method="POST">
     
      <select name="CategoryID"> <!-- Update the name to CategoryID -->
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['CategoryID'] ?>"><?= $category['VehicleType'] ?></option>
        <?php endwhile ?>
      </select>

      <input type="text" name="vBrand" value="<?= $vBrand ?>" placeholder="Brand" required>
      <input type="text"  name="vModel" value="<?= $vModel ?>" placeholder="Model" required>
      <input type="text"  name="vPLNo" placeholder="Plate Number" required>
      <input type="text" name="vRatePerDay" placeholder="Rate For Day" required>
      <input type="text" name="Availability" placeholder="Availability" required>
      <div class="form_control">
            <label for="license">Vehicle Image</label>
            <input type="file" name="vImage" id="vImage">
      </div>
      <button type="submit" name="submit" class="btn">Add Vehicle</button>
    </form>
  </div>
</section>

<?php
  include '../partials/footer.php';
?>
