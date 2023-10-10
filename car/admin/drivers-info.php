<?php
  include '../partials/aheader.php';

  session_start();
  if(!isset($_SESSION['admin_ID'])){
    header('location: '. ROOT_URL .'signin.php');
  }
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
          <a href="add-reservation.php"><i class="uil uil-user-plus"></i>
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
       <h2>Drivers Info</h2>
       

       <table>
          <thead>
            <tr>
              <th>#ID</th>
              <th>FName</th>
              <th>LName</th>
              <th>Contact</th>
              <th>License</th>
              <th>Email</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $query = mysqli_query($connection, "SELECT * FROM driver");

          while ($row = mysqli_fetch_assoc($query)) {
            $driverID = $row['DriverID'];
            $dfname= $row['dFname'];
            $dlname = $row['dLname'];
            $dphoneNo = $row['dPhoneNo'];
            $dlicensePhoto = $row['dLicensePhoto'];
            $demail = $row['dEmail'];
            
            ?>
            <tr>
              <td><?php echo $driverID; ?></td>
              <td><?php echo $dfname; ?></td>
              <td><?php echo $dlname; ?></td>
              <td><?php echo $dphoneNo; ?></td>
              
              

              <td>
                <?php
                if (!empty($dlicensePhoto)) {
                  $base64Image = base64_encode($dlicensePhoto);
                  echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="License Photo" style="width: 1in; height: 1in;">';                } else {
                  echo 'No Photo Available';
                }
                ?>
              </td>

              <td><?php echo $demail; ?></td>
              <td>
                <a href="edit-driver.php?id=<?php echo $driverID; ?>" class="btn sm">Edit</a>
                <a href="driver-functions.php?id=<?php echo $driverID; ?>" class="btn sm danger">Delete</a>
              </td>
            </tr>
            <?php
          } // End of while loop
          ?>
          </tbody>
       </table>
    </main>
  </div>
</section>


<?php
  include '../partials/footer.php';
  ?>