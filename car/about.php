<?php
session_start();
if(isset($_SESSION['customer_ID'])){
  include 'partials/cheader.php';
} else{
  include 'partials/header.php';
}
?>

<section class="empty_page">
        <div class="container"
        style="
              display: absolute;
              margin-bottom: 5px;
              margin-top: 5rem;">
            <h1>About Us</h1>
            <p>Welcome to Panan Car Rental System, your trusted partner for hassle-free car rentals. We are dedicated to providing high-quality, reliable, and convenient rental services to meet all your transportation needs.</p>
            <p>Our mission is to make your travel experience as smooth as possible. Whether you're planning a family vacation, a business trip, or just need a temporary vehicle, we've got you covered.</p>
            <p>Why choose Panan Car Rental System?</p>
            <ul>
                <li>Wide Range of Vehicles: From compact cars to spacious SUVs, we offer a diverse fleet of vehicles to suit your preferences.</li>
                <li>Affordable Rates: We provide competitive rental rates and special offers to make your journey budget-friendly.</li>
                <li>Easy Booking: Our online booking system ensures a quick and hassle-free reservation process.</li>
                <li>Customer Satisfaction: Your satisfaction is our top priority. We strive to exceed your expectations with top-notch customer service.</li>
            </ul>
            <p>Experience the convenience of renting a vehicle with Panan Car Rental System. Book your car today and embark on a memorable journey with us.</p>
            
        </div>
</section>

  <?php
include 'partials/footer.php';
?>