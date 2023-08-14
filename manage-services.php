<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
} else {

    // Code for deleting product from cart
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblservice WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'manage-services.php'</script>";
    }

    // Code for updating form
    if (isset($_POST['update'])) {
        $serviceId = $_POST['service_id'];
        $serviceName = $_POST['service_name'];
        $serviceDescription = $_POST['service_description'];

        $sql = "UPDATE tblservice SET ServiceName=:serviceName, SerDes=:serviceDescription WHERE ID=:serviceId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':serviceName', $serviceName, PDO::PARAM_STR);
        $query->bindParam(':serviceDescription', $serviceDescription, PDO::PARAM_STR);
        $query->bindParam(':serviceId', $serviceId, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data updated successfully');</script>";
        echo "<script>window.location.href = 'manage-services.php'</script>";
    }
?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - Manage Services</title>

    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
</head>
<body>
<div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>
    <main id="main-container">
        <div class="content">
            <h2 class="content-heading">Manage Services</h2>
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Manage Services</h3>
                </div>
                <div class="block-content block-content-full">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th>Service Name</th>
                            <th class="d-none d-sm-table-cell">Service Description</th>
                            <th class="d-none d-sm-table-cell">Creation Date</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tblservice";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlentities($cnt); ?></td>
                                    <td class="font-w600"><?php echo htmlentities($row->ServiceName); ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo htmlentities($row->SerDes); ?></td>
                                    <td class="d-none d-sm-table-cell">
                                        <span class="badge badge-primary"><?php echo htmlentities($row->CreationDate); ?></span>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <a href="manage-services.php?delid=<?php echo ($row->ID); ?>"
                                           onclick="return confirm('Do you really want to Delete ?');">
                                            <i class="fa fa-trash fa-delete" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#updateModal<?php echo ($row->ID); ?>">
                                            <i class="fa fa-pencil fa-edit" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Update Service Modal -->
                                <div class="modal fade" id="updateModal<?php echo ($row->ID); ?>" tabindex="-1" role="dialog"
                                     aria-labelledby="updateModalLabel<?php echo ($row->ID); ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel<?php echo ($row->ID); ?>">Update Service</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="service_id" value="<?php echo ($row->ID); ?>">
                                                    <div class="form-group">
                                                        <label for="service_name">Service Name</label>
                                                        <input type="text" class="form-control" name="service_name" id="service_name"
                                                               value="<?php echo ($row->ServiceName); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="service_description">Service Description</label>
                                                        <textarea class="form-control" name="service_description" id="service_description" rows="3"><?php echo ($row->SerDes); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php $cnt = $cnt + 1;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once('includes/footer.php'); ?>
</div>

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
