<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
if(isset($_POST['submit']))
  {
	$uid=$_SESSION['obbsuid'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobno=$_POST['mobno'];
	$rating=$_POST['rating'];
    $feedback=$_POST['feedback'];

    $sql="insert into tblfeedback(UserID,Name,Email,MobileNumber,Rating,Feedback)
	values(:uid,:name,:email,:mobno,:rating,:feedback)";
	$query=$dbh->prepare($sql);
	$query->bindParam(':uid',$uid,PDO::PARAM_STR);
	$query->bindParam(':name',$name,PDO::PARAM_STR);
	$query->bindParam(':email',$email,PDO::PARAM_STR);
	$query->bindParam(':mobno',$mobno,PDO::PARAM_STR);
	$query->bindParam(':rating',$rating,PDO::PARAM_STR);
	$query->bindParam(':feedback',$feedback,PDO::PARAM_STR);

	$query->execute();
	$LastInsertId=$dbh->lastInsertId();
	if ($LastInsertId>0) {
	echo "<script>alert('Your feedback was sent successfully!');</script>";
	echo "<script>window.location.href ='feedback.php'</script>";
	}
  else
    {
       echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | Feedback</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- css -->
<link rel="stylesheet" href="css/contact.css" type="text/css" media="all" />
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
            <span>Feedback</span></br>
            <p>After viewing your gallery and completed every booking process, feel free to give us feedback. 
				The feedback will helps us in improving our services.</p>
			<p>We are grateful to have you as our clients, thank you.</p>
        </div>
        
    </section>
    <!-- home section end -->

    <!-- contact section starts  -->

    <section class="contact" id="contact">

    <h1 class="heading"> Feedback </h1>

    <div class="row">

        <form action="" method="POST" >
		<?php
								$uid=$_SESSION['obbsuid'];
								$sql="SELECT * from  tbluser where ID=:uid";
								$query = $dbh -> prepare($sql);
								$query->bindParam(':uid',$uid,PDO::PARAM_STR);
								$query->execute();
								$results=$query->fetchAll(PDO::FETCH_OBJ);
								$cnt=1;
								if($query->rowCount() > 0)
								{
								foreach($results as $row)
								{               ?>
            <input type="text" name = "name" value="<?php  echo $row->FullName;?>" placeholder="Name" class="box" readonly="true">
            <input type="email" name = "email"  value ="<?php  echo $row->Email;?>" placeholder="Email" class="box" readonly="true">
			<input type="text" name = "mobno" value="<?php  echo $row->MobileNumber;?>" placeholder="Mobile Number" class="box" maxlength="12" pattern="[0-9]+" readonly="true">
            <input type="text" name = "rating" placeholder="Rating 1 to 5" class="box" maxlength="1" pattern="[1-5]">
            <textarea name="feedback" class="box" placeholder="Give Your Feedback Here" id="" cols="30" rows="10"></textarea>
            <?php $cnt=$cnt+1;}} ?>
			<button name ="submit" class="btn">Send</a>
        </form>

    </div>

    </section>

    <!-- contact section ends -->

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