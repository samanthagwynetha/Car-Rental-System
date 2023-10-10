<?php
session_start();
if(isset($_SESSION['customer_ID'])){
  include 'partials/cheader.php';
} else{
  include 'partials/header.php';
}
?>

<section class="empty_page">
  <h1>Contact Us</h1>
</section>

<?php
include 'partials/footer.php';
?>