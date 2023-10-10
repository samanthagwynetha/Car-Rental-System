<?php
include '../partials/aheader.php';
session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
}

// Include your database connection code here if not already included
// ...

// Fetch vehicle data from the database
$vehicle_query = "SELECT v.*, c.VehicleType
                  FROM vehicle v
                  LEFT JOIN category c ON v.CategoryID = c.CategoryID";
$vehicles = mysqli_query($connection, $vehicle_query);
?>

<section class="dashboard">
  <div class="container dashboard_container">
    <button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right-b"></i></button>
    <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left-b"></i></button>
    <aside>
      <ul>
         <li>
          <a href="add-vehicle-post.php"><i class="uil uil-list-ul"></i>
            <h5>Add Vehicle</h5>
          </a>
        </li>
        <li>
          <a href="manage-vehicle-post.php"><i class="uil uil-pen"></i>
            <h5>Manage Vehicle</h5>
          </a>
        </li>
        <li>
          <a href="add-category.php"><i class="uil uil-list-ul"></i>
            <h5>Add Category</h5>
          </a>
        </li>
        <li>
          <a href="manage-categories.php"><i class="uil uil-edit"></i>
            <h5>Manage Category</h5>
          </a>
        </li>
        <li>
          <a href="add-driver.php"><i class="uil uil-user-plus"></i>
            <h5>Add Driver</h5>
          </a>
        </li>
        <li>
          <a href="drivers-info.php"><i class="uil uil-user-plus"></i>
            <h5>Driver Info</h5>
          </a>
        </li>
        <li>
          <a href="customer-info.php"><i class="uil uil-user-plus"></i>
            <h5>Customer Info</h5>
          </a>
        </li>
        <li>
          <a href="add-resevation.php"><i class="uil uil-user-plus"></i>
            <h5>Add Reservation</h5>
          </a>
        </li>
        <li>
          <a href="manage-reservation.php"><i class="uil uil-user-plus"></i>
            <h5>Manage Reservation</h5>
          </a>
        </li>
      </ul>
    </aside>
    <main>
       <h2>Manage Vehicle</h2>
       <table>
          <thead>
            <tr>
              <th>Brand</th>
              <th>Model</th>
              <th>Plate No.</th>
              <th>RPD</th>
              <th>Category</th>
              <th>Status</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($vehicle = mysqli_fetch_assoc($vehicles)) : ?>
            <tr>
              <td><?= $vehicle['vBrand'] ?></td>
              <td><?= $vehicle['vModel'] ?></td>
              <td><?= $vehicle['vPLNo'] ?></td>
              <td><?= $vehicle['RatePerDay'] ?></td>
              <td><?= $vehicle['VehicleType'] ?></td>
              <td><?= $vehicle['Availability'] ?></td>
              <!--<td>
                <select name="status_<?= $vehicle['VehicleID'] ?>">
                  <option value="available" <?= ($vehicle['Availability'] == '1') ? 'selected' : '' ?>>Available</option>
                  <option value="unavailable" <?= ($vehicle['Availability'] == '0') ? 'selected' : '' ?>>Unavailable</option>
                </select>
              </td>-->
              
              <td><a href="edit-vehicle.php?VehicleID=<?= $vehicle['VehicleID'] ?>" class="btn sm">Edit</a></td>
              <td><a href="delete-vehicle.php?VehicleID=<?= $vehicle['VehicleID'] ?>" class="btn sm danger">Delete</a></td>
            </tr>
            <?php endwhile ?>
          </tbody>
       </table>
    </main>
  </div>
</section>

<?php
  include '../partials/footer.php';
?>
