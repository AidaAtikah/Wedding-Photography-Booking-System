<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['booking_id'])) {
        $bookingID = $_POST['booking_id'];

        // Update the CancelStatus to 'Approved'
        $sql = "UPDATE tblbooking SET CancelStatus = 'Rejected' WHERE ID = :booking_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':booking_id', $bookingID, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId > 0) {
            echo 'Request Rejected';
        } else {
            echo 'Something Went Wrong. Please try again';
        }
    }
}
?>
