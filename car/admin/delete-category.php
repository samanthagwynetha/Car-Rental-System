<?php
require  'config/database.php';

if(isset($_GET['CategoryID'])) {
  $CategoryID = filter_var($_GET['CategoryID'], FILTER_SANITIZE_NUMBER_INT);

  //FOR LATER
  //update category_id of posts that belong to this category to id of uncategorieds hdaihoadissoai
  
  //DELETE CATEGORY
  $query = "DELETE FROM category WHERE CategoryID=$CategoryID LIMIT 1";
  $result = mysqli_query($connection, $query);
  $_SESSION['delete-category-success'] = "Category deleted successfully";
}
header('location: ' . ROOT_URL . 'admin/manage-categories.php');
?>