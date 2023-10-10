<?php
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}

include 'partials/cheader.php';

//fetch post
$query = "SELECT*FROM vehicle ORDER BY VehicleID DESC";
$vehicles = mysqli_query($connection, $query);
?>


<section class="home" id="home">
  <div class="home-text">
    <h1>  
      <span>Looking</span> to <span>rent</span> <br>  a <span>car</span></h1>
    <p>PRC, your gateway to hassle-free, convenient, and reliable car rentals. <br> Explore our diverse fleet, find the perfect vehicle for your needs, 
      and <br> book with confidence. Your journey begins here.</p>

      <button class="home-btn" >
        <a class="home-rent" href="signin.php">Discover Now</a>
      </button>
  </div>
  
  <div class="car0-container">
    <img class="car0" src="images/clogo.png">
  </div>
</section>


  <!--===========================ABOUT==================================-->

<section class="home-about" id="home-about">
<div class="about-img">
  <img src="images/about-img.webp" alt="">
</div>

<div class="about-text">
  <h2>PAN-AN - Your Siargao Adventure Partner</h2>
  <p>PAN-AN is your trusted partner for unforgettable adventures on Siargao Island. Founded by the renowned Puno family, known for their successful businesses in Davao City and Siargao, PAN-AN is dedicated to enhancing your Siargao experience. They provide top-notch rental vehicles and exceptional service, reflecting their mission to "carry" you on a journey of discovery around this breathtaking island. PAN-AN prioritizes convenience and comfort by offering a wide range of meticulously maintained rental vehicles, suitable for solo travelers, families, and groups. Their vehicles are designed to handle Siargao's diverse terrains, ensuring ease of navigation while exploring the island's beauty.</p>
  </div>
</section>

  <!--===========================SERVICES==================================-->
  <section class="home-services" id="home-services">
  <p class="top-text">BEST SERVICES</p>
  <h2 class="top-text sersec">Explore Vehicle</h2>

  <div class="container posts_container">
    <?php while ($vehicle = mysqli_fetch_assoc($vehicles)) : ?>
      <article class="post">
        <div class="post_thumbnail"
        style=" border-radius: var(--card-border-radius-5)0;
                background:var(--color-sleepyblue);
                color: white;
                overflow: hidden;
                margin-bottom:1.6rem;
                "
        >
          <img class="thumbnail_img" src="./images/<?= $vehicle['vImage'] ?>" 
            style = " width: 100%;
                    height: 175px;
                    object-fit: contain;" >
        </div>
        <div class="post_info">
        <?php 
        //fetch category from categorues table usin
        $CategoryID = $vehicle['CategoryID'];
        $category_query = "SELECT * FROM category WHERE CategoryID=$CategoryID";
        $category_result = mysqli_query($connection, $category_query);
        $category = mysqli_fetch_assoc($category_result);
        ?>

        <a href="<?= ROOT_URL ?>category-posts.php?CategoryID=<?= $vehicle['CategoryID']?>" class="category_button"><?= $category['VehicleType']?></a>
          
        <?php
          echo '<h3 class="post_title"><a href="post.php">' . 
          $vehicle['vBrand'] . ' <span style="color: red;">' . 
          $vehicle['vModel'] . '</span></a></h3>';
          echo '<p class="RatePerDay">&#8369;' . $vehicle['RatePerDay'] . ' / Day</p>';
        ?>
          <p class="vPLNo"><?= $vehicle['vPLNo'] ?></p>
          <!-- <p class="RatePerDay"><?= $vehicle['RatePerDay'] ?> <span>/ Day</span></p>-->
          <p class="Availability"><?= $vehicle['Availability'] ?></p>
          <a href="vehicle.php?vID=<?php echo urlencode($vehicle['VehicleID']);?>">
          <button id="rent-btn" class="rent-btn">Rent Now</button></a>
        </div>
      </article>
    <?php endwhile ?>
  </div>
</section>

  <!--=======================CONTACT====================-->
  <section class="home-contact" id="home-contact">
    <h2>GET IN TOUCH</h2>

  <div class="contact-info">
    <div class="info-item">
      <img src="" alt="">
      <h2>Location</h2>
      <p>General Luna, Siargao <br> Del Norte, Philippines</p>
    </div>

    <div class="info-item">
      <img src="" alt="">
      <h2>Phone</h2>
      <p>+63 977 272 5054<br>(082) 297-1235</p>
    </div>

    <div class="info-item">
      <img src="" alt="">
      <h2>Email</h2>
      <p>PanAn@gmail.com</p>
    </div>
 </div>
    

  <div class="contact-container">
    <form>
        <input type="text" name="Name" placeholder="Full Name" required>
        <input type="email" name="Email" placeholder="Email" required>
        <textarea name="Message" placeholder="Message" required></textarea>
        <button type="submit" class="btn">Send</button>
    </form>
  </div>
</section>

  <!--=======================CATEGORY BUTTON====================-->

  <section class="category_buttons">
    <div class="container category_buttons-container">
    <?php
    $all_categories_query = "SELECT *FROM category";
    $all_categories = mysqli_query($connection, $all_categories_query); 
    ?>
    <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
      <a href="<?= ROOT_URL ?>category-posts.php?categoryID=<?= $category['CategoryID'] ?>" 
      class="category_button"><?= $category['VehicleType']?></a>
      <?php endwhile ?>
    </div>
  </section>
  

  <!--=======================END OF THE CATEGORY BUTTON====================-->

  
<?php
include 'partials/footer.php';
?>

