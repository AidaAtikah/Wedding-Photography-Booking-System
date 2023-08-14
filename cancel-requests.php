<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - Cancel Requests</title>
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
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
                <h2 class="content-heading">Cancel Requests</h2>
                <!-- Dynamic Table Full Pagination -->
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Cancel Requests</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th>Booking ID</th>
                                    <th class="d-none d-sm-table-cell">Client Name</th>
                                    <th class="d-none d-sm-table-cell">Mobile Number</th>
                                    <th class="d-none d-sm-table-cell">Email</th>
                                    <th class="d-none d-sm-table-cell">Booking Date</th>
                                    <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT tbluser.FullName, tbluser.MobileNumber, tbluser.Email, tblbooking.ID as bid, tblbooking.BookingID, tblbooking.BookingDate, tblbooking.CancelStatus FROM tblbooking JOIN tbluser ON tbluser.ID = tblbooking.UserID WHERE tblbooking.CancelStatus = 'Pending'";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo htmlentities($cnt); ?></td>
                                            <td class="font-w600"><?php echo htmlentities($row->BookingID); ?></td>
                                            <td class="font-w600"><?php echo htmlentities($row->FullName); ?></td>
                                            <td class="font-w600"><?php echo htmlentities($row->MobileNumber); ?></td>
                                            <td class="font-w600"><?php echo htmlentities($row->Email); ?></td>
                                            <td class="font-w600">
                                                <span class="badge badge-primary"><?php echo htmlentities($row->BookingDate); ?></span>
                                            </td>
                                            <?php if ($row->CancelStatus == "") { ?>
                                                <td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
                                            <?php } else { ?>
                                                <td class="font-w600">
                                                    <p align="center" style="padding-top: 20px">
                                                        <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal_<?php echo $row->bid; ?>">Take Action</button>
                                                    </p>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                <?php
                                        $cnt = $cnt + 1;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Dynamic Table Full Pagination -->
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <!-- Modal -->
        <?php foreach ($results as $row) { ?>
            <div class="modal fade" id="myModal_<?php echo $row->bid; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-success btn-lg btn-block" onclick="approveRequest(<?php echo $row->bid; ?>)">Approve</button>
                            <button type="button" class="btn btn-danger btn-lg btn-block" onclick="rejectRequest(<?php echo $row->bid; ?>)">Reject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- End Modal -->

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

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        function approveRequest(bookingID) {
            // Send AJAX request to approve-delete-request.php
            $.ajax({
                url: 'approve-cancel-request.php',
                type: 'POST',
                data: {
                    booking_id: bookingID
                },
                success: function(response) {
                    // Handle the response as needed
                    alert('Request Approved');
                    // Reload the delete-requests.php page
                    window.location.reload();
                }
            });
        }


        function rejectRequest(bookingID) {
            // Send AJAX request to reject-delete-request.php
            $.ajax({
                url: 'reject-cancel-request.php',
                type: 'POST',
                data: {
                    booking_id: bookingID
                },
                success: function(response) {
                    // Handle the response as needed
                    alert('Request Rejected');
                    // Reload the delete-requests.php page
                    window.location.reload();
                }
            });
        }
    </script>
</body>
</html>
<?php }  ?>
