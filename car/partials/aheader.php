<?php
require 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Website</title>

  <!--Style-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!--Icon-->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <!--FONTS-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;800&family=Playfair:wght@300&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body>
  <nav>
    <div class="container nav_container">
      <a href="<?= ROOT_URL ?>" class="nav_logo">Car Rent</a>
      <ul class="nav_items">
        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
        <li class="nav_profile">
          <div class="avatar">
            
          </div>
          <ul>
            <li><a href="<?= ROOT_URL ?>admin/alogout.php">Logout</a></li>
          </li>
        </ul>
        </ul>

      <button id="open_nav-btn"><i class="uil uil-bars"></i></button>
      <button id="close_nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
  </nav>
 <!--===================END OF NAV==============================================-->
