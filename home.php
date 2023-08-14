<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['obbsuid'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Swakarya Studio | Home Page</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include("includes/header.php") ?>

    <!-- home section start -->
    <section class="home" id="home">

        <div class="content">  
            <h3>Swakarya Studio</h3>
            <span>Home</span>
            <p>Capture the moments that last a lifetime. Welcome to our wedding photography booking system, where love and art converge. 
                Simplify your journey from "I do" to beautifully preserved memories.
                Secure your special day with ease and let our passionate photographers immortalize your love story.
                Begin your extraordinary adventure today.</p>
            <a href="services.php" class="btn">Book now</a>
        </div>
        
    </section>
    <!-- home section end -->

    <!-- about section start -->
    <section class="about" id="about">

        <h1 class="heading"> about us  </h1>
    
        <div class="row">
    
            <div class="video-container">
                <video src="images/about-vid.mp4" loop autoplay muted></video>
            </div>
    
            <div class="content">
                <h3>Why you should choose us?</h3>
                <p>Swakarya studio here could offer you with a professional wedding photographer. We enjoy interacting with people and capturing an emotional moment of your special day.</p>
                <p>We believe in prompting rather than posturing in order to capture genuine moments such as the raw, real emotions on showcase at a ceremony.</p>   
                <p>We really enjoy capturing moments of laughing, tears of delight, and genuine love and affection connecting people's eyes.</p>
                <a href="about.php" class="btn" >learn more</a> 
            </div>
    
        </div>
    
    </section>
    <!--about section start-->

    <!-- gallery section starts  -->
    <section class="gallery" id="gallery">

    <h1 class="heading"> gallery </h1>

    <div class="box-container">
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

        $counter = 0; // Counter for tracking the number of images

        foreach ($albums as $album) {
            $albumName = $album['AlbumName'];
            $imagePath = 'admin/gallery/' . $album['AlbumName'] . '/' . $album['AlbumImage'];

            if ($counter < 3) { // Display only three images
                ?>
                <div class="box">
                    <div class="image">
                        <a href="gallery.php">
                            <img src="<?php echo $imagePath; ?>" alt="Album Image" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="content">
                        <!-- Display album name or additional content here -->
                    </div>
                </div>
                <?php
                $counter++;
            } else {
                break; // Break the loop after displaying three images
            }
        }
        ?>
    </div>
    <?php
        if($counter == 0){
                ?> <h3>No Image Have Been Uploaded. </h3> <?php
            }
            ?>
    
    </section>
    <!-- gallery section ends -->



    <!-- services section starts  -->

    <section class="services" id="services">

    <h1 class="heading"> Services </h1>

    <div class="box-container">

    <div class="box">
        <div class="image">
            <a href="services.php">
            <img src="images/pre-wed.JPG" alt=""></a>
            <div class="icons">
                <a href="gallery.php" class="fas fa-images"></a>
                <a href="booking.php" class="cart-btn">Book Now</a>
                <a href="services.php" class="fas fa-share"></a>
            </div>
        </div>
        <div class="content">
            <h3>Pre-Wedding</h3>
        </div>
    </div>

    <div class="box">
        <div class="image">
            <a href="services.php">
            <img src="images/wedding.JPG" alt=""></a>
            <div class="icons">
                <a href="gallery.php" class="fas fa-images"></a>
                <a href="booking.php" class="cart-btn">Book Now</a>
                <a href="services.php" class="fas fa-share"></a>
            </div>
        </div>
        <div class="content">
            <h3>Wedding</h3>
        </div>
    </div>

    <div class="box">
        <div class="image">
            <a href="services.php">
            <img src="images/other.jpg" alt=""></a>
            <div class="icons">
                <a href="gallery.php" class="fas fa-images"></a>
                <a href="booking.php" class="cart-btn">Book Now</a>
                <a href="services.php" class="fas fa-share"></a>
            </div>
        </div>
        <div class="content">
            <h3>Outdoor</h3>
        </div>
    </div>

    </section>

    <!-- services section ends -->

    <!-- contact section starts  -->

    <section class="contact" id="contact">

    <h1 class="heading"> contact us </h1>

    <div class="row">

        <div class="image">
            <img src="images/contact-img.jpg" alt="">
        </div>

        <div class="content">
                <h3>Get In Touch with us </h3>
                <br/><br/>
                <p>Swakarya studio offers the best services for the clients.
                We valued each of our clients who needs helps, thus don't hesistate to ask help from us.We ready to give our best! </p>
                <p>Get the help you need now!</p>
							<?php
								$sql="SELECT * from tblpage where PageType='contactus'";
								$query = $dbh -> prepare($sql);
								$query->execute();
								$results=$query->fetchAll(PDO::FETCH_OBJ);

								$cnt=1;
								if($query->rowCount() > 0)
								{
								foreach($results as $row)
								{               ?>
							<p> <i class="fa fa-phone" aria-hidden="true"></i> <span><?php  echo htmlentities($row->MobileNumber);?></span></p>
							<p> <i class="fa fa-envelope" aria-hidden="true"></i> <span><?php  echo htmlentities($row->Email);?></span></p>
							<p> <i class="fa fa-map-marker" aria-hidden="true"></i> <span><?php  echo htmlentities($row->PageDescription);?>.</span></p>
                            <?php $cnt=$cnt+1;}} ?>
                                </br>
                <a href="contact.php" class="btn" >learn more</a> 
        </div>
    </div>

    </section>

<!-- contact section ends -->

	
<?php include_once('includes/footer.php');?>

</body>	
</html>