<?php
require 'config/database.php';

if (isset($_POST['submit'])){
  $CategoryID = filter_var($_POST['CategoryID'], FILTER_SANITIZE_NUMBER_INT);
  $VehicleType = filter_var($_POST['VehicleType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $VDescription = filter_var($_POST['VDescription'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  //validate input
  if(!$VehicleType || !$VDescription){
    $_SESSION['edit-category'] = "Invalid form input on edit category";
  } else {
    $query = "UPDATE category SET VehicleType='$VehicleType', VDescription='$VDescription' WHERE CategoryID=$CategoryID LIMIT 1";
    $result = mysqli_query($connection, $query);

    if(mysqli_errno($connection)) {
      $_SESSION['edit-category'] = "Couldn't update category";
    } else {
      $_SESSION['edit-category-success'] = "Category $VehicleType updated successful";
    }
  }
}
header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
?>