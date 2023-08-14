<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | Gallery</title>
<link rel="stylesheet" href="css/gallery.css" type="text/css" media="all" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</head>
<body>
    <?php include("includes/header.php"); ?>

        <!-- home section start -->
        <section class="home" id="home">

        <div class="content">  
            <h3>Swakarya Studio</h3>
            <span>Gallery</span>
            <p> Congratulations on your wedding day! As a cherished client of Swakarya, we are thrilled to present your personalized digital album, a treasure trove of cherished memories. 
            Relive your wedding day through our personalized digital album. This carefully curated collection captures every precious moment, allowing you to cherish and share the joy for years to come. 
            Enjoy the artistry and immerse yourself in the magic of your love story.</p>
            <a href="booking.php" class="btn">Book now</a>
        </div>

        </section>
        <!-- home section end -->

    <section class="gallery" id="gallery">
        <h1 class="heading">Gallery</h1>

        <div class="row">
            <?php
            $uid = $_SESSION['obbsuid'];

            // Retrieve all albums and their images from the database
            $sql = "SELECT tblgallery.AlbumName, tblgallery.AlbumImage 
                    FROM tblgallery 
                    JOIN tbluser ON tblgallery.UserID = tbluser.ID 
                    WHERE tblgallery.UserID = :uid";

            $query = $dbh->prepare($sql);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query->execute();
            $albums = $query->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php
            $counter = 0; // Counter for tracking the number of images

            foreach ($albums as $album):
                $albumName = $album['AlbumName'];

                if ($counter % 2 == 0) {
                    // Add a new row for every fourth image
            ?>
                </div>
                <div class="row">
            <?php
                }

                $imagePath = 'admin/gallery/' . $album['AlbumName'] . '/' . $album['AlbumImage'];
            ?>
                <div class="column">
                    <img src="<?php echo $imagePath; ?>" alt="Album Image" class="img-thumbnail">
                </div>
            <?php
                $counter++;
            endforeach;
            ?>
        </div>
        </br>
        <?php
        if($counter == 0){
         ?> <h3>No Image Have Been Uploaded. </h3> <?php
        } else{ ?>
            <div style= "text-align:center">
            <a href="feedback.php" class="btn">Leave Your Feedback Here</a> </div>
           <?php }
            ?>
    </section>

    <?php include("includes/footer.php"); ?>

    <script src="js/jarallax.js"></script>
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript">
        $('.jarallax').jarallax({
            speed: 1200,
            imgWidth: 1366,
            imgHeight: 768,
            easingType: 'linear'
        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $().UItoTop({ easingType: 'easeOutQuart' });
        });
    </script>
    <script src="js/modernizr.custom.js"></script>
</body>
</html>
<?php
}
?>
