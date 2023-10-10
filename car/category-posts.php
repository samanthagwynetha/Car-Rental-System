<?php
include 'partials/header.php';

//fetch posts if id is set
if (isset($_GET['CategoryID'])) {
    $Category_ID = filter_var($_GET['CategoryID'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM vehicle WHERE CategoryID = $Category_ID";
    $vehicles = mysqli_query($connection, $query);

} else {
    header('location: ' . ROOT_URL . 'home.php');
    die();
}
?>

<header class="category_title">
<h2>
  <?php 
        //fetch category from categorues table usin
        $CategoryID = $Category_ID;
        $category_query = "SELECT * FROM category WHERE CategoryID=$Category_ID";
        $category_result = mysqli_query($connection, $category_query);
        $category = mysqli_fetch_assoc($category_result); 
        echo $category['VehicleType'];   
    ?>
  </h2>
  <span>
    <p>
    <?php 
       echo $category['VDescription'];   
    ?>
    </p>
  </span>
</header>
  <!--===========================SERVICES==================================-->
  <section class="posts">
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
          echo '<h3 class="post_title"><a href="post.php">' . 
          $vehicle['vBrand'] . ' <span style="color: red;">' . 
          $vehicle['vModel'] . '</span></a></h3>';
          echo '<p class="RatePerDay">&#8369;' . $vehicle['RatePerDay'] . ' / Day</p>';
        ?>
<!--     <h3 class="post_title">
            <a href="post.php"><?= $vehicle['vBrand'] ?></a>
          </h3>
          <p class="vModel"> <?= $vehicle['vModel'] ?></p>-->
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

  <!--=======================END OF THE SERVICES====================-->
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

<?php
include 'partials/footer.php';
?>

