<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | Services</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- css -->
<link rel="stylesheet" href="css/service.css" type="text/css" media="all" />
<!--// css -->
<!-- font -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!-- //font -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script> 
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<![endif]-->
</head>
<body>

	<?php include("includes/header.php") ?>

	<!-- home section start -->
	<section class="home" id="home">

	<div class="content">  
		<h3>Swakarya Studio</h3>
		<span>Services</span>
		<p> Swakarya Studio is dedicated to providing a comprehensive range of professional wedding services. 
			Our offerings include engagement ceremonies, solemnization ceremonies, reception ceremonies, and outdoor wedding experiences. 
			With our expertise and attention to detail, we are committed to assisting you in selecting the perfect package tailored to your unique preferences and desires. 
			Explore our carefully crafted options on this page, and let us guide you towards an unforgettable wedding experience.</p>
		<a href="#services" class="btn">Learn More</a>
	</div>

	</section>
	<!-- home section end -->
	
	<section class = "services" id="services">
        <h1 class="heading"> Services </h1>
            <div class = "container">
                <div class = "box">
                    <div class = "services-wrapper">
                        <tr><!-- single services post -->
                        <td>
                        <?php
                        $Image = 5;
                        $sql="SELECT * from tblservice";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        $i= 1;

                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)

                        {               ?>
                        <div class = "services">
                            <?php if ($i <= $Image) {
                            $imagePath = "images/s" . $i . ".jpg";
                            echo '<img src="' . $imagePath . '" alt="Image ' . $i . '">';
                            }
                            ?>
                            <img src = ""></a>
                            <div class = "services-content">
                                <span class = "badge">Photography</span>
                                <h3 class = "services-title">
                                <?php  echo htmlentities($row->ServiceName);?>
                                </h3>
                                <p class = "services-text">
                                <?php  echo htmlentities($row->SerDes);?>
                                </p>
                                <?php if($_SESSION['obbsuid']==""){?>
									<td><a href="login.php" class="btn btn-default">Book Services</a></td>
									<?php } else {?>
									<td><a href="book-services.php?bookid=<?php echo $row->ID;?>" class="btn btn-default">Book Services</a></td><?php }?>
                            </div>
                        </div>
                        <!-- end of single post -->
                        </tr><?php 
                        $cnt; 
                        $i=$i+1; 
                        }} ?>
                    </div>
                </div>
            </div>
    </section>

    <?php include_once('includes/footer.php');?>

	<!-- jarallax -->
	<script src="js/jarallax.js"></script>
	<script src="js/SmoothScroll.min.js"></script>
	<script type="text/javascript">
		/* init Jarallax */
		$('.jarallax').jarallax({
			speed: 0.5,
			imgWidth: 1366,
			imgHeight: 768
		})
	</script>
	<!-- //jarallax -->
	<script src="js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
<script src="js/modernizr.custom.js"></script>

</body>	
</html>