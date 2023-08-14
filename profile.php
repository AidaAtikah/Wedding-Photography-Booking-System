<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
    $uid=$_SESSION['obbsuid'];
	$uname=$_SESSION['username'];
    $AName=$_POST['fname'];
    $mobno=$_POST['mobno']; 
	$address=$_POST['address'];
 
  	 $sql="update tbluser set Username=:uname,FullName=:name,MobileNumber=:mobno,Address=:address where ID=:uid";
     $query = $dbh->prepare($sql);
	 $query->bindParam(':uname',$uname,PDO::PARAM_STR);
     $query->bindParam(':name',$AName,PDO::PARAM_STR);
     $query->bindParam(':mobno',$mobno,PDO::PARAM_STR);
	 $query->bindParam(':address',$address,PDO::PARAM_STR);
     $query->bindParam(':uid',$uid,PDO::PARAM_STR);
	 $query->execute();

        echo '<script>alert("Profile has been updated")</script>';
		echo "<script>window.location.href ='profile.php'</script>";
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | User Profile</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- css -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
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

	<!-- home section start -->
	<section class="home" id="home">

	<div class="content">  
		<h3>Swakarya Studio</h3>
		<span>User Profile</span>
		<p> Welcome to your User Profile page. Here, you have the ability to conveniently update and modify your personal information. We understand that details may change over time, and we want to ensure that your profile reflects the most accurate and up-to-date information.</p>
		<a href="services.php" class="btn">Book now</a>
	</div>

	</section>
	<!-- home section end -->

	<!-- profile section start -->
    <section class="profile" id="profile">

    <h1 class="heading"> Profile </h1>

    <div class="row">

        <form method="post">
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
			<input type="text" value="<?php  echo $row->Username;?>" name="uname" placeholder="Username" required="true" class="box">
			<input type="text" value="<?php  echo $row->FullName;?>" name="fname" placeholder="Full Name" required="true" class="box">
			<input type="text" value="<?php  echo $row->MobileNumber;?>" name="mobno" placeholder="Mobile Number"  class="box" required="true" maxlength="12" pattern="[0-9]+" >
            <input type="text" value="<?php  echo $row->Address;?>" name="address" placeholder="Address"  class="box" required="true">
			<input type="email" value="<?php  echo $row->Email;?>" name="email" placeholder="Email"  class="box"  required="true" readonly title="Email can't be edit">
			<input type="text" value="<?php  echo $row->RegDate;?>" class="box" placeholder="Registration Date" name="password" readonly="true">
			<?php $cnt=$cnt+1;}} ?>
            <button class="btn" name="submit">Update</button>
        </form>

    </div>

    </section>
    <!-- profile section end -->
	
	

		
		</div>
	</div>
	<!-- //contact -->
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
</html><?php }  ?>