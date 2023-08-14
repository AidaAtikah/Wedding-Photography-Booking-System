<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
if(isset($_POST['signup']))
  {
    $username = $_POST['username'];
	$fname = $_POST['fname'];
    $mobno = $_POST['mobno'];
    $email = $_POST['email'];
	$address = $_POST['address'];
    $password = md5($_POST['password']);
    $ret="select Email from tbluser where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query -> rowCount() == 0)
	{
	$sql="Insert Into tbluser(Username,FullName,MobileNumber,Email,Address,Password)Values(:username,:fname,:mobno,:email,:address,:password)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':username',$username,PDO::PARAM_STR);
	$query->bindParam(':fname',$fname,PDO::PARAM_STR);
	$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
	$query->bindParam(':email',$email,PDO::PARAM_STR);
	$query->bindParam(':address',$address,PDO::PARAM_STR);
	$query->bindParam(':password',$password,PDO::PARAM_STR);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	if($lastInsertId)
	{

	echo "<script>alert('You have register successfully');</script>";
	}
	else
	{

	echo "<script>alert('Something went wrong.Please try again');</script>";
	}
	}
	else
	{

	echo "<script>alert('Email already exist. Please try again');</script>";
	}
	}
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | Register</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--// bootstrap-css -->
<!-- css -->
<link rel="stylesheet" href="css/login.css" type="text/css" media="all" />
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
	<script type="text/javascript">
function checkpass()
{
if(document.signup.password.value!=document.signup.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.signup.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>
<body>
	<div class="container">
			<form method="post" name="signup" class="login-email" onsubmit="return checkpass();">
				<p class="login-text" style="font-size: 3rem; font-weight: 800;">Register</p>
				<div class="input-group">
					<input type="text" name="uname" placeholder="User Name" required="true">
				</div>
				<div class="input-group">
					<input type="text" name="fname" placeholder="Full Name" required="true">
				</div>
				<div class="input-group">
					<input type="email" name="email" placeholder="E-mail" required="true">
				</div>
				<div class="input-group">
					<input type="text" name="mobno" placeholder="Mobile Number" required="true" maxlength="10" pattern="[0-9]+">
				</div>
				<div class="input-group">
					<input type="text" name="address" placeholder="Address" required="true">
				</div>
				<div class="input-group">
					<input type="password"  name="password" placeholder="Password" required="true" id="password1">
				</div>
				<div class="input-group">
					<input type="password"  name="confirmpassword" placeholder="Confirm Password" required="true" id="password2">
				</div>
				<div class="input-group">
					<button name="signup" class="btn">Register</button>
				</div>
				<p class="login-register-text">Already have an account?  <a href="login.php">Login Here.</a></p>
			</form>
	</div>


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