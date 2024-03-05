<?php
require 'config/database.php';
session_start();

if(isset($_POST['submit'])){
    //get form data
    $tor = filter_var($_POST['tor'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate form data
    if(empty($tor)){
        $_SESSION['add-category'] = "Enter a Type of car";
    } elseif(empty($description)){
        $_SESSION['add-category'] = "Enter description";
    }

    //redirect back to add category page with form data if there was invalid input
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        exit();
    } else {
        //insert category into database
          
        /* $query = "INSERT INTO category (VehicleType, VDescription) VALUES ('$tor', '$description')";
        $result = mysqli_query($connection,$query);
        */
        
        $query = "INSERT INTO category (VehicleType, VDescription) VALUES (?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ss", $tor, $description);
        mysqli_stmt_execute($stmt);

        if(mysqli_errno($connection)){
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            exit();
        } else {
            $_SESSION['add-category-success'] = "$tor added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            exit();
        }
    }
} else {
    // Redirect back to add category page if form was not submitted
    header('location: ' . ROOT_URL . 'admin/add-category.php');
    exit();
}

