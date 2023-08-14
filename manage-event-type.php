<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid'] == 0)) {
    header('location:logout.php');
} else {

    // Code for deleting product from cart
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "delete from tbleventtype where ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'manage-event-type.php'</script>";

    }

    // Code for updating package details
    if (isset($_POST['update'])) {
        $service_id = $_POST['service_id'];
        $package_name = $_POST['package_name'];
        $package_event = $_POST['package_event'];
        $package_price = $_POST['package_price'];
        $package_details = $_POST['package_details'];

        $sql = "UPDATE tbleventtype SET EventType=:package_name, EventDes=:package_event, EventPrice=:package_price, EventDetails=:package_details WHERE ID=:service_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':package_name', $package_name, PDO::PARAM_STR);
        $query->bindParam(':package_event', $package_event, PDO::PARAM_STR);
        $query->bindParam(':package_price', $package_price, PDO::PARAM_STR);
        $query->bindParam(':package_details', $package_details, PDO::PARAM_STR);
        $query->bindParam(':service_id', $service_id, PDO::PARAM_STR);
        $query->execute();

        echo "<script>alert('Data updated successfully');</script>";
        echo "<script>window.location.href = 'manage-event-type.php'</script>";
    }
    ?>
    <!doctype html>
    <html lang="en" class="no-focus"><!--<![endif]-->
    <head>
        <title>Swakarya Admin - Manage Packages</title>

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
                <h2 class="content-heading">Manage Packages</h2>


                <!-- Dynamic Table Full Pagination -->
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Manage Packages</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/be_tables_datatables.js -->
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th>Package Name</th>
                                <th>Package Event</th>
                                <th>Package Price</th>
                                <th>Package Details</th>
                                <th class="d-none d-sm-table-cell">Creation Date</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * from tbleventtype";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlentities($cnt); ?></td>
                                        <td class="font-w600"><?php echo htmlentities($row->EventType); ?></td>
                                        <td class="font-w600"><?php echo htmlentities($row->EventDes); ?></td>
                                        <td class="font-w600"><?php echo htmlentities($row->EventPrice); ?></td>
                                        <td class="font-w600"><?php echo htmlentities($row->EventDetails); ?></td>
                                        <td class="d-none d-sm-table-cell">
                                            <span
                                                class="badge badge-primary"><?php echo htmlentities($row->CreationDate); ?></span>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <a href="manage-event-type.php?delid=<?php echo ($row->ID); ?>"
                                               onclick="return confirm('Do you really want to Delete ?');"><i
                                                        class="fa fa-trash fa-delete" aria-hidden="true"></i>
                                            <a href="#editModal<?php echo $row->ID; ?>" data-toggle="modal"><i
                                                        class="fa fa-pencil fa-edit"
                                                        aria-hidden="true"></i></a>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row->ID; ?>" tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="">
                                                        <input type="hidden" name="service_id"
                                                               value="<?php echo $row->ID; ?>">
                                                        <div class="form-group">
                                                            <label>Package Name</label>
                                                            <input type="text" class="form-control"
                                                                   name="package_name"
                                                                   value="<?php echo htmlentities($row->EventType); ?>"
                                                                   required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Package Event</label>
                                                            <input type="text" class="form-control"
                                                                   name="package_event"
                                                                   value="<?php echo htmlentities($row->EventDes); ?>"
                                                                   required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Package Price</label>
                                                            <input type="text" class="form-control"
                                                                   name="package_price"
                                                                   value="<?php echo htmlentities($row->EventPrice); ?>"
                                                                   required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Package Details</label>
                                                            <textarea class="form-control"
                                                                      name="package_details"
                                                                      rows="4"
                                                                      required><?php echo htmlentities($row->EventDetails); ?></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" name="update"
                                                                    class="btn btn-primary">Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $cnt = $cnt + 1;
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Dynamic Table Full Pagination -->

                <!-- END Dynamic Table Simple -->
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

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page JS Code -->
    <script src="assets/js/pages/be_tables_datatables.js"></script>
    </body>
    </html>
<?php } ?>
