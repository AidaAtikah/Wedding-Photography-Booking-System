<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('sendemail.php');
include('success.php');

if (strlen($_SESSION['odmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $eid = $_GET['editid'];
        $paymentid = $_GET['paymentid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        $sql = "UPDATE tblpayment SET Status=:status, Remark=:remark WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);

        $query->execute();

        $sql = "SELECT * FROM tblpayment WHERE PaymentID = :paymentid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':paymentid', $paymentid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $email = $results['Email'];
        $bid = $results['BookingID'];

        $sql = "SELECT * FROM tblbooking WHERE BookingID = :bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);

        $bookdate = $results['BookDate'];
        $bookstarttime = $results['BookStartTime'];
        $bookendtime = $results['BookEndTime'];

        $content = successEmail($bid, $bookdate, $bookstarttime, $bookendtime);

        if ($status == "Paid"){

        sendEmail2("$email", 'Your Booking has been confirmed!', 'Swakarya', $content);
        }
        echo '<script>alert("Remark has been updated.")</script>';
        echo "<script>window.location.href ='payment-status.php'</script>";
    }
?>

<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - View Payment</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                <!-- Register Forms -->
                <h2 class="content-heading">View Payment</h2>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Bootstrap Register -->
                        <div class="block block-themed">
                            <div class="block-header bg-gd-emerald">
                                <h3 class="block-title">View Payment</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="content_toggle"></button>
                                </div>
                            </div>
                            <div class="block-content">
                                <?php

                                $eid=$_GET['editid'];

                                $sql = "SELECT * FROM tblpayment where tblpayment.ID=:eid";
                                $query = $dbh->prepare($sql);
                                $query-> bindParam(':eid', $eid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                        ?>
                                        <table border="1"
                                               class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                            <tr>
                                                <th colspan="5"
                                                    style="text-align: center;font-size: 20px;color: blue;">
                                                    Payment ID: <?php echo $row->PaymentID; ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Card Owner Name</th>
                                                <td><?php echo $row->FullName; ?></td>
                                                <th>Card Owner Address</th>
                                                <td><?php echo $row->Address; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Card Number</th>
                                                <td><?php echo $row->CardNumber; ?></td>
                                                <th>Payment Date</th>
                                                <td><?php echo $row->PaymentDate; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Final Status</th>
                                                <td>
                                                    <?php
                                                    $status = $row->Status;
                                                    if ($row->Status == "Paid") {
                                                        echo "Paid";
                                                    }
                                                    if ($row->Status == "Pending") {
                                                        echo "Pending";
                                                    }
                                                    if ($row->Status == "") {
                                                        echo "Not Response Yet";
                                                    }
                                                    ?>
                                                </td>
                                                <th>Admin Remark</th>
                                                <?php if ($row->Status == "") { ?>
                                                    <td><?php echo "Not Updated Yet"; ?></td>
                                                <?php } else { ?>
                                                    <td><?php echo htmlentities($row->Remark); ?></td>
                                                <?php } ?>
                                            </tr>
                                            <?php $cnt = $cnt + 1;
                                    }
                                } ?>
                                        </table>
                                        <?php
                                        if ($status == "" || $status =="Pending") {
                                        ?>
                                            <p align="center" style="padding-top: 20px">
                                                <button class="btn btn-primary waves-effect waves-light w-lg"
                                                        data-toggle="modal" data-target="#myModal">Take Action
                                                </button>
                                            </p>
                                        <?php } ?>
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Take
                                                            Action</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered table-hover data-tables">
                                                            <form method="post" name="submit" action="">
                                                                <tr>
                                                                    <th>Remark :</th>
                                                                    <td>
                                                                        <textarea name="remark" placeholder="Remark"
                                                                                  rows="12" cols="14"
                                                                                  class="form-control wd-450"
                                                                                  required="true"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status :</th>
                                                                    <td>
                                                                        <select name="status"
                                                                                class="form-control wd-450"
                                                                                required="true">
                                                                            <option value="Paid" selected="true">Paid
                                                                            </option>
                                                                            <option value="Pending">Pending</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" name="submit"
                                                                class="btn btn-primary">Update
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Bootstrap Register -->
                                </div>
                            </div>
                            <!-- END Page Content -->
                        </main>
                        <!-- END Main Container -->
                        <?php include_once('includes/footer.php'); ?>
                    </div>
                    <!-- END Page Container -->
                    <!-- Codebase Core JS -->
                    <script src="assets/js/core/jquery.min.js"></script>
                    <script src="assets/js/core/popper.min.js"></script>
                    <script src="assets/js/core/bootstrap.min.js"></script>
                    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
                    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
                    <script src="assets/js/core/jquery.appear.min.js"></script>
                    <script src="assets/js/core/jquery.countTo.min.js"></script>
                    <script src="assets/js/core/js.cookie.min.js"></script>
                    <script src="assets/js/codebase.js"></script>
                </body>
            </html>
            <?php
        }
    ?>
