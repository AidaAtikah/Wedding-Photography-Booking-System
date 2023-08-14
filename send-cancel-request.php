<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']) == 0) {
    header('location:logout.php');
} else {
    $bookingid = $_GET['bookingid'];
    $query = $dbh->prepare("UPDATE tblbooking SET CancelStatus = 'Pending' WHERE ID = :bookingid");
    $query->bindParam(':bookingid', $bookingid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Booking cancel request sent to the admin. Please wait for approval.');</script>";
    echo "<script>window.location.href='booking-history.php'</script>";
}
?>
