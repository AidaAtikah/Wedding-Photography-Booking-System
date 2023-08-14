<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('sendemail.php');

if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
} else {
    $vid = $_GET['viewid'];
    $isread = 1;
    $sql = "UPDATE tblcontact SET IsRead = :isread WHERE ID = :vid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
    $query->execute();

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];

        // Send the email with the entered subject and content
        sendEmail2($email, $subject, 'Swakarya', $content);
        echo "<script>alert('Email has been sent successfully');</script>";
    }
?>

<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - View Queries</title>
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        <main id="main-container">
            <div class="content">
                <h2 class="content-heading">View Queries</h2>
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">View Queries</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <?php
                        $sql = "SELECT * FROM tblcontact WHERE ID = :vid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);

                        $name = $result['Name'];
                        $email = $result['Email'];

                        if ($query->rowCount() > 0) {
                        ?>
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <tr align="center">
                                <td colspan="2" style="font-size:20px;color:blue">View Queries</td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td><?php echo $name;?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td><?php echo $email;?></td>
                            </tr>
                            <tr>
                                <th scope="row">Message</th>
                                <td colspan="3"><?php echo $result['Message'];?></td>
                            </tr>
                        </table>         
                    </div>
                </div>

                <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Compose Email</h3>
                </div>
                    <!-- Form to enter email subject and content -->
                    <div class="block-content block-content-full">
                    <form method="post" action="">
                        <div class="form-group">
                        <select type="email" class="form-control" name="email" id="email" required="true">
                        <option value="">Recipient Email:</option>
                          <?php
                              $sql2 = "SELECT * from tblcontact";
                              $query2 = $dbh->prepare($sql2);
                              $query2->execute();
                              $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                              foreach ($result2 as $row) {
                          ?>
                          <option value="<?php echo htmlentities($row->Email); ?>"><?php echo htmlentities($row->Email); ?></option>
                          <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Email Subject:</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Email Content:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Send Email" class="btn btn-primary">
                        </div>
                    </form>
                <?php } ?>
                </div>
              </div>

            </div>
        </main>
        <?php include_once('includes/footer.php');?>
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
    <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/pages/be_tables_datatables.js"></script>
</body>
</html>
<?php
}
?>
