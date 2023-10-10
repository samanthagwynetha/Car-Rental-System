<?php
  include '../partials/aheader.php';
  session_start();
if(!isset($_SESSION['admin_ID'])){
  header('location: '. ROOT_URL .'admin/login.php');
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
       <h2>Customer Information</h2>
       <table>
          <thead>
            <tr>
              <th>C#</th>   
              <th>FName</th>
              <th>LName</th>
              <th>DOB</th>
              <th>Contact</th>
              <th>Email</th>
              <th>Delete</th>
            </tr>
            <?php
            $sql = "SELECT `CustomerID`, `cFname`, `cLname`, `cDOB`, `cPhoneNo`, `cEmail` FROM `customer`";
            $data = mysqli_query($connection, $sql);
            $result = mysqli_num_rows($data);

            if ($result) {
              while($row = mysqli_fetch_array($data)){
                ?>
                <tr>
                  <td><?php echo $row['CustomerID'];?></td>
                  <td><?php echo $row['cFname'];?></td>
                  <td><?php echo $row['cLname'];?></td>
                  <td><?php echo $row['cDOB'];?></td>
                  <td><?php echo $row['cPhoneNo'];?></td>
                  <td><?php echo $row['cEmail'];?></td>
                  <td><a href="delete-customer.php?id=<?php echo urlencode($row['CustomerID']); ?>" class="btn sm danger">Delete</a></td>              
                </tr>
                <?php
              }
            }else {

            }
     ?>
          </thead>
       </table>
    </main>
  </div>
</section>

<?php
  include '../partials/footer.php';
  ?>

