<?php
include '../partials/aheader.php';
session_start();
if(!isset($_SESSION['admin_ID'])){
    header('location: '. ROOT_URL .'signin.php');
  }
$connection = mysqli_connect("localhost", "root", "", "carrental");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>RESERVATIONS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
    <script defer
        src="https://use.fontawesome.com/releases/v6.1.1/js/all.js"
        integrity="sha384-xBXmu0dk1bEoiwd71wOonQLyH+VpgR1XcDH3rtxrLww5ajNTuMvBdL5SOiFZnNdp"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
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
                <h2>Manage Reservation</h2>
                <div class="text-end mb-3">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>R#</th>
                            <th>C#</th>
                            <th>V#</th>
                            <th>A#</th>
                            <th>D#</th>
                            <th>Reservation Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Driver Option</th>
                            <th>License Photo</th>
                            <th>Total Cost</th>
                            <th>Reservation Status</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($connection, "SELECT *, FORMAT(TotalCost, 2) AS FormattedTotalCost FROM reservation");

                        while ($row = mysqli_fetch_assoc($query)) {
                            $reservationID = $row['ReservationID'];
                            $customerID = $row['CustomerID'];
                            $vehicleID = $row['VehicleID'];
                            $adminID = $row['AdminID'];
                            $driverID = $row['DriverID'];
                            $resdate = $row['ReservationDate'];
                            $startdate = $row['RentalStartDate'];
                            $enddate = $row['RentalEndDate'];
                            $driveroption = $row['DriverOption'];
                            $licensephoto = $row['LicensePhoto'];
                            $totalcost = $row['TotalCost'];
                            $reservationstatus = $row['ReservationStatus'];
                            ?>

                        <tr>
                            <td><?php echo $reservationID; ?></td>
                            <td><?php echo $customerID; ?></td>
                            <td><?php echo $vehicleID; ?></td>
                            <td><?php echo $adminID; ?></td>
                            <td><?php echo $driverID; ?></td>
                            <td><?php echo $resdate; ?></td>
                            <td><?php echo $startdate; ?></td>
                            <td><?php echo $enddate; ?></td>
                            <td><?php echo $driveroption; ?></td>
                            
                            <td>
                                <div id="license-photo-<?php echo $reservationID; ?>">
                                    <?php
                                    if (!empty($licensephoto)) {
                                        $base64Image = base64_encode($licensephoto);
                                        echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="License Photo" style="width: 1in; height: 1in;">';
                                    } else {
                                        echo 'No Photo Available';
                                    }
                                    ?>
                                </div>
                            </td>
                          
                            <td><?php echo $row['FormattedTotalCost']; ?></td>



                            <td><?php echo $reservationstatus; ?></td>
                            <td>
                            <a href="edit-reservation.php?id=<?php echo $reservationID; ?>"class="btn sm">Edit</a>
                            <button class="btn sm danger" onclick="confirmDelete(<?php echo $reservationID; ?>)">Delete</button>
                            </td>
                          
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>
</body>

<script>
function confirmDelete(reservationID) {
    // Show a confirmation dialog
    Swal.fire({
        title: 'Delete Reservation',
        text: 'Are you sure you want to delete this reservation?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms the deletion, redirect to the delete operation
            window.location.href = 'delete-reservation.php?id=' + reservationID;
        }
    });
}
</script>

</html>

<?php
include '../partials/footer.php';
?>
