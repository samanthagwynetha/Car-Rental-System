<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}

  if(isset($_GET['CategoryID'])){
    $CategoryID = filter_var($_GET['CategoryID'], FILTER_SANITIZE_NUMBER_INT);
    // fetch category from db
    $query = "SELECT * FROM category WHERE CategoryID=$CategoryID";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 1){
      $category = mysqli_fetch_assoc($result);
    }
  } else {
    header('location: ' . ROOT_URL . 'admin/manage-categories');
    die();
  }
?>

<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit Category</h2>
    <form action="<?= ROOT_URL?>admin/edit-category-logic.php" method="POST">
      <input type="hidden" name="CategoryID" value="<?= $category['CategoryID'] ?>">
      <input type="text" name="VehicleType" value="<?= $category['VehicleType'] ?>" placeholder="Type of car">
      <textarea rows="4" name="VDescription" placeholder="Description"><?= $category['VDescription']?> </textarea>
      <button type="submit" name="submit" class="btn">Update</button>
    </form>
  </div>
</section>

<?php
  include '../partials/footer.php';
?>