<?php
require 'config/database.php';

if(isset($_GET['VehicleID'])){
  $VehicleID = filter_var($_GET['VehicleID'], FILTER_SANITIZE_NUMBER_INT);

  //fetch post from database in order to delete thumbnail from images folder
  $query = "SELECT * FROM vehicle WHERE VehicleID=$VehicleID";
  $result = mysqli_query($connection, $query);

  //make sure only 1 record/post was fetched
  if(mysqli_num_rows($result)==1) {
    $vehicle = mysqli_fetch_assoc($result);
    $thumbnail_name = $vehicle['vImage'];
    $thumbnail_path = '../images/' .$thumbnail_name;
    
    if($thumbnail_path){
      unlink($thumbnail_path);

      //delete post from db
      $delete_post_query = "DELETE FROM vehicle WHERE VehicleID=$VehicleID LIMIT 1";
      $delete_post_query = mysqli_query($connection, $delete_post_query);

      if(!mysqli_errno($connection)) {
        $_SESSION['delete-post-success'] = "Post deleted successfully";
      }
    }
  }
}

header('location: ' . ROOT_URL . 'admin/');
die();