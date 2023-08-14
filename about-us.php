<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | About Us </title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- css -->
<link rel="stylesheet" href="css/about.css" type="text/css" media="all" />
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

		<?php
			$sql="SELECT * from tblpage where PageType='aboutus'";
			$query = $dbh -> prepare($sql);
			$query->execute();
			$results=$query->fetchAll(PDO::FETCH_OBJ);

			$cnt=1;
			if($query->rowCount() > 0)
			{
			foreach($results as $row)
			{               ?>
			
			<div class="content">
				<h3>Swakarya Studio</h3>
				<span><?php  echo htmlentities($row->PageTitle);?></span>
				<p><?php  echo htmlentities($row->PageDescription);?></p><?php $cnt=$cnt+1;}} ?>
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
				<p>Swakarya Studio here could offer you with a professional wedding photographer. We enjoy interacting with people and capturing an emotional moment of your special day.</p>
				<p>We believe in prompting rather than posturing in order to capture genuine moments such as the raw, real emotions on showcase at a ceremony.</p>   
				<p>We really enjoy capturing moments of laughing, tears of delight, and genuine love and affection connecting people's eyes.</p>
			</div>

		</div>
		</section>
		<!-- about section end -->

		<!-- story section starts -->
		<section class="story" id="story">
		<h1 class="heading"> Our Story </h1>
			<div class = "container">
				<div class = "sec-left">
					<!-- image here -->
					<div>
						<h3>How we started</h3>
						<p> A boy who interested in photography and videography. At a young age, I realized that photography and videography will be my future.</p>
						<p> In 2020, I started my business by establishing Swakarya production. I started to learn new things and keep improving my skills.</p>
						<p> I love to captures human, natures and most important things the emotions shown on the lens.</p> 
					</div>
				</div>

				<div class = "sec-right">
					<!-- image here -->
					<div>
						<h3>Motivation</h3>
						<p>The motivation is myself. I tend to learn something extensively. Keep dreaming and keep doing untill your dream come true.</p>
						<p>In my entire life, I like to take risks and if i fall once, i get up stronger.</p>
					</div>
				</div>
			</div>

		</section>
		<!-- story section end -->

		<!-- team section starts -->
		<section class = "team" id="team">
		<h1 class="heading"> Our Team </h1>
			<div class = "container">
				<div class = "sec-one-left">
					<!-- image here -->
					<div>
						<h3>Swakarya owner</h3>
						<p>Al-Amin, a man who have  keen interest in photography and videography. Since then, he establish Swakarya production. Without stopping, he build his career in the journey of become a professional photographer and videographer.</p>
					</div>
				</div>

				<div class = "sec-one-right">
					<div class = "work-content">
						<h3>Amazing Team Work with a Professional</h3>
						<p> I fill mind with curiosity, and keep learning new things. Curiosity is the wick in the candle of learning. Other than that, surround yourself with positive thoughts.
						<p>Hopefully SwaKarya will grow bigger and better. 
						<br>- Al-Amin (Owner of Swakarya Production)</p>
						<p>Swakarya have a partner named @hashphoto, both of them are a professional photographer and videographer.</p>
						<a href = "https://www.instagram.com/swakarya_wedding/" class = "center">view portfolio</a>
					</div>
					<div class = "work-imgs">
						<a href="https://www.instagram.com/wn_amn/">
						<div class = "work-img-1">
							<!--image here-->
						</div></a>
						<a href="https://www.instagram.com/hash_photoss/">
						<div class = "work-img-2">
							<!-- image here -->
						</div></a>
					</div>
					<h3>"Explore the world through viewfinder"</h3>
				</div>
			</div>
		</section>
		<!-- team section ends -->

		<section class = "section-two">
            <div class = "container">
                <h2>FOLLOW ON INSTAGRAM</h2>
                <span>@swakarya_wedding</span>
                <div class = "insta-imgs">
                    <div>
						<a href="https://www.instagram.com/p/Crz0vETB6bU/">
							<img src = "images/insta-1.jpg">
							<div class = "icon-overlay flex">
								<i class = "fab fa-instagram"></i>
							</div>
						</a>
                    </div>
                    <div>
						<a href="https://www.instagram.com/p/Ci7IlUXhm_Z/">
							<img src = "images/insta-2.jpg">
							<div class = "icon-overlay flex">
								<i class = "fab fa-instagram"></i>
							</div>
						</a>
                    </div>
                    <div>
						<a href="https://www.instagram.com/p/Cn4fQIsSHcm/">
							<img src = "images/insta-3.jpg">
							<div class = "icon-overlay flex">
								<i class = "fab fa-instagram"></i>
							</div>
						</a>
                    </div>
                    <div>
						<a href="https://www.instagram.com/p/CkQjeLHh47s/">
							<img src = "images/insta-4.jpg">
							<div class = "icon-overlay flex">
								<i class = "fab fa-instagram"></i>
							</div>
						</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of main -->
	
	<!-- //about -->
	<!-- footer -->
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