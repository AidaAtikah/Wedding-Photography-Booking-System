<?php
session_start();
include('includes/dbconnection.php');

// Check if the user is logged in
if (empty($_SESSION['odmsaid'])) {
    header('Location: logout.php');
}

// Handle the form submission
if (isset($_POST['submit'])) {
    $albumName = $_POST['album_name'];
    $uid=$_POST['user_email'];
    
    // Replace spaces with underscores in the album name
    $albumName = str_replace(' ', '_', $albumName);
    
    // Create a directory for the album
    $albumDirectory = 'gallery/' . $albumName;
    
    // Check if the album directory already exists
    if (!is_dir($albumDirectory)) {
        mkdir($albumDirectory, 0777, true); // Set the third parameter to true for recursive directory creation
    }
    
    // Upload each image file
    $uploadedImages = $_FILES['album_images'];
    $imageFiles = array(); // To store the filenames for database insertion
    
    foreach ($uploadedImages['tmp_name'] as $key => $tmpName) {
        $imageFile = $uploadedImages['name'][$key];
        $targetPath = $albumDirectory . '/' . $imageFile;
        
        // Move uploaded image to the album directory
        move_uploaded_file($tmpName, $targetPath);
        
        $imageFiles[] = $imageFile; // Store the filename for database insertion
    }
    
    // Insert album details into the database
    $sql = "INSERT INTO tblgallery (UserID,AlbumName,AlbumImage) VALUES (:uid,:albumName, :albumImage)";
    $query = $dbh->prepare($sql);
    
    foreach ($imageFiles as $imageFile) {
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':albumName', $albumName, PDO::PARAM_STR);
        $query->bindParam(':albumImage', $imageFile, PDO::PARAM_STR);
        $query->execute();
    }
    
    if ($query->rowCount() > 0) {
        // Insertion successful
        echo '<script>alert("Album has been successfully added.")</script>';
        echo "<script>window.location.href ='add-album.php'</script>";
    } else {
        // Insertion failed
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - Add Album</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php');?>

        <!-- Header -->
        <?php include_once('includes/header.php');?>

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                <!-- Add Album Form -->
<h2 class="content-heading">Add Album</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-gd-emerald">
                <h3 class="block-title">Add Album</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-12" for="user-email">User Email:</label>
                        <div class="col-12">
                            <select class="form-control" name="user_email" required>
                                <option value="">Select User Email:</option>
                                <?php
                                $query = $dbh->prepare("SELECT * FROM tbluser");
                                $query->execute();
                                $users = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($users as $user) {
                                    echo '<option value="' . $user['ID'] . '">' . $user['Email'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="album-name">Album Name:</label>
                        <div class="col-12">
                            <input type="text" class="form-control" name="album_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="album-images">Images:</label>
                        <div class="col-12">
                            <input type="file" class="form-control" name="album_images[]" id="album_images" multiple accept="image/*" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-alt-success" name="submit">
                                <i class="fa fa-plus mr-5"></i> Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <?php include_once('includes/footer.php');?>
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

