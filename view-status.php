<!DOCTYPE html>
<html lang="en">
<head>
    <title>Swakarya Studio | Payment</title>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- css -->
    <link rel="stylesheet" href="css/status.css" type="text/css" media="all" />
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
</head>
<body>
 
<?php include("includes/header.php") ?>

    <!-- status section start --> 
    <section class="status" id="status">

        <h1 class="heading">Booking Status</h1>

        <div class = "container">
                <div class = "sec-left">
                    <!-- image here -->
                    <div>
                        <p> Please be patient while our admin working on the payment status.</p>
                        <p> We will send you an email confirmation for the booking.</p>
                        <p> After getting the email, please contact our photographer before your big day!</p>
                        <p> Please check your email and if you have any inquiries, you can contact us on the contact page</p>
                        <p> or WhatsApp is on this number, <a href="https://wa.link/ygu5we">+6014-2112723</a></p>
                        <p> Thank you, have a nice day. </p>
                    </div>
                </div>
        </div>


    </section>
    <!-- status section end -->

</body>
</html>

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