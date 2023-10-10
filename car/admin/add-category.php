<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}
  //get back from data if invalid
  $tor = $_SESSION['add-category-data']['VehicleType']?? null;
  $description = $_SESSION['add-category-data']['VDescription'] ?? null;
  unset($_SESSION['add-category-data']);
?>

<section class="form_section">
  <div class="container form_section-container">
    <h2>Add Category</h2>
   <?php if(isset($_SESSION['add-category'])) : ?>
    <div class="alert_message error">
        <p>
          <?= $_SESSION['add-category'];
          unset($_SESSION['add-category'])?>
        </p>
      </div>
    <?php endif?>
  <form action="<?= ROOT_URL?>admin/add-category-logic.php" method="POST">
    <input type="text" value="<?= $tor?>" name="tor" placeholder="Type of car">
    <textarea rows="4" value="<?= $description?>" name="description" placeholder="Description"></textarea>   
    <button type="submit" name="submit" class="btn">Add Category</button>
  </form>
</div>
</section>

<?php
  include '../partials/footer.php';
  ?>