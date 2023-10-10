<?php
require 'config/database.php';
session_start();
session_destroy();
header('location: '. ROOT_URL .'home.php');
?>