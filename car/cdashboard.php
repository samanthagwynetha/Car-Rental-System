<?php
session_start();
if(!isset($_SESSION['customer_ID'])){
  header("Location: signin.php");
}
include 'partials/ccheader.php';
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
            <main>
                <h2>Your Reservation</h2>
                <div class="text-end mb-3">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>R#</th>
                            <th>V#</th>
                            <th>Reservation Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Driver Option</th>
                            <th>License Photo/Valid ID</th>
                            <th>Total Cost</th>
                            <th>Reservation Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cID=$_SESSION['customer_ID'];
                        $query = mysqli_query($connection, "SELECT * FROM reservation WHERE CustomerID='$cID'");

                        while ($row = mysqli_fetch_assoc($query)) {
                            $reservationID = $row['ReservationID'];
                            $vehicleID = $row['VehicleID'];
                            $resdate = $row['ReservationDate'];
                            $startdate = $row['RentalStartDate'];
                            $enddate = $row['RentalEndDate'];
                            $driveroption = $row['DriverOption'];
                            $licensephoto = $row['LicensePhoto'];
                            $totalcost = $row['TotalCost'];
                            $reservationstatus = $row['ReservationStatus'];
                            ?>

                        <tr style="color: var(--color-white);">
                            <td><?php echo $reservationID; ?></td>
                            <td><?php echo $vehicleID; ?></td>
                            <td><?php echo $resdate; ?></td>
                            <td><?php echo $startdate; ?></td>
                            <td><?php echo $enddate; ?></td>
                            <td><?php echo $driveroption; ?></td>
                            <td>
                            <?php
                                if (!empty($licensephoto)) {
                                    $base64Image = base64_encode($licensephoto);
                                    echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="License Photo" style="width: 1in; height: 1in;">';
                                } else {
                                    echo 'No Photo Available';
                                }
                                ?>
                            </td>
                            <td><?php echo $totalcost; ?></td>
                            <td><?php echo $reservationstatus; ?></td>
                            <?php
                                if ($reservationstatus == "Pending") {
                                        echo '<td><a href="cancle-reservation.php?id=' . $reservationID . '" class="btn sm danger">Cancel</a></td>';
                                    } else {
                                        // If reservation status is not "Pending," do not display the "Cancel" button.
                                        echo '<td></td>';
                                    }
                            ?>
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

</html>

<?php
include 'partials/footer.php';
?>