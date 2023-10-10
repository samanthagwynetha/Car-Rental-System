<?php
require_once 'config/database.php';

$id = $_GET['id'];
$sql = "DELETE FROM `customer` WHERE CustomerID = '$id'";
$result = mysqli_query($connection, $sql);

if($result) {
    ?>
    <script type="text/javascript">
        alert("Customer Info Deleted Successfully");
        window.open("http://localhost/car/admin/customer-info.php","_self");
    </script>
    <?php
}else{
    ?>
    <script type="text/javascript">
        alert("Please try again");
    </script>
    <?php
}
?>
