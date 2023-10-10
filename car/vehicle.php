<?php
include 'partials/ccheader.php';
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
?>
<?php
$vID = $_GET['vID'];
$sql = "SELECT*FROM `vehicle` WHERE VehicleID = '$vID'";
$vehicles = mysqli_query($connection, $sql);
while ($vehicle = mysqli_fetch_assoc($vehicles)) : ?>


  <section class="singlepost">
    <div class="container singlepost_container">
      <div class="post_info">
                <article class="post">
                <div class="post_thumbnail">
                <img src="./images/<?= $vehicle['vImage'] ?>">
                </div>
                <div class="post_info">
                <h3 class="post_title">
                <a href="post.php"><?= $vehicle['vBrand'] ?></a>
                </h3>
                <p class="vModel"> <?= $vehicle['vModel'] ?></p>
                <p class="vPLNo"><?= $vehicle['vPLNo'] ?></p>
                <p class="RatePerDay"><?= $vehicle['RatePerDay'] ?></p>
                <p class="Availability"><?= $vehicle['Availability'] ?></p>
                </div>
                </article>     
      </div>
       </div>

       <div class="container customer_container" style="color: var(--color-white);">
       <h2>Reservation Details</h2>
        <form action="vehicle-logic.php" method="GET" enctype="multipart/form-data">
          <input type="text" name="vID" class="vID" value="<?= $vehicle['VehicleID'] ?>" readonly>
          <label for="cResrvationDate">Today's Date</label>
          <input type="date" name="today_date" class="cReservationtDate" placeholder="Today's Date" required>
          <label for="cRentalEndDate">Rental Start Date</label>
          <input type="date" name="start_date" class="cRentalStartDate" placeholder="Rental Start Date" required>
          <label for="cRentalEndDate">Rental End Date</label>
          <input type="date" name="end_date" class="cRentalEndDate" placeholder="Rental End Date" required>
          
          <button type="submit" name="nxt" class="btn">Next</button>
        </form>
      </div>
  </section>
  <?php endwhile ?> 
<?php
include 'partials/footer.php';
?>

