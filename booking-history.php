<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']==0)) {
  header('location:logout.php');
  } else{
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio | Booking History </title>

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
				<span>Booking History</span>
				<p>Welcome to your booking history page. Here, you can conveniently view and manage all your booking details with Swakarya Studio. It serves as a centralized hub for accessing information related to your bookings, including package details, dates, and any additional services you have selected.</p>
			</div>
			
		</section>
		<!-- home section end -->

	<!-- about -->
	<section class="booking" id="booking">

		<h1 class="heading">Booking History</h1>

		<div class="row">
					<table class="content">
						<?php
							$uid=$_SESSION['obbsuid'];
							$sql = "SELECT tbluser.FullName, tbluser.MobileNumber, tbluser.Email, tblbooking.BookingID, tblbooking.BookingDate, tblbooking.Status, tblbooking.ID, tblbooking.CancelStatus
							FROM tblbooking
							JOIN tbluser ON tbluser.ID = tblbooking.UserID
							WHERE tblbooking.UserID = '$uid'";

							$query = $dbh -> prepare($sql);
							$query->execute();
							$results=$query->fetchAll(PDO::FETCH_OBJ);

							$cnt=1;
							if($query->rowCount() > 0)
							{
								foreach($results as $row)
							{               ?>
							<tr>
								<th></br> </th>
							</tr>
                            <tr>
                                <th> Booking ID </th>
								<td class="font-w600"><?php  echo htmlentities($row->BookingID);?></td>       
							</tr>

							<tr>
								<th>Client Name</th>
								<td class="font-w600"><?php  echo htmlentities($row->FullName);?></td>
							</tr>

							<tr>
								<th >Mobile Number</th>
								<td class="font-w600"><?php  echo htmlentities($row->MobileNumber);?></td>
                            </tr>
									
							<tr>
								<th>Email</th>
								<td class="font-w600"><?php  echo htmlentities($row->Email);?></td>
							</tr>

							<tr>
								<th>Apply Date</th>
								<td class="font-w600">
                                    <span class="badge badge-primary"><?php  echo htmlentities($row->BookingDate);?></span>
                                </td>
                            </tr>

							<tr>
								<th>Status</th>
								<?php if($row->Status==""){ ?>
										<td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
										<?php } else { ?>
											<td class="d-none d-sm-table-cell">
											<span class="badge badge-primary"><?php  echo htmlentities($row->Status);?></span>
											</td>
										<?php } ?> 
							</tr>

							<tr>
								<th style="width: 15%;" style="text-transform: initial;">Cancel Status</th>
								<td class="d-none d-sm-table-cell" >
									<?php if($row->CancelStatus == "Pending") { ?>
										<span class="badge badge-warning">Pending. Waiting for the admin approval.</span>
									<?php } else if($row->CancelStatus == "Approved") { ?>
										<span class="badge badge-warning">Approved. The refund will took 7 to 14 days of working. Please be patient while we working on it.</span>
									<?php } else if($row->CancelStatus == "Rejected") { ?>
										<span class="badge badge-warning">Rejected. Sorry, you are not applicable for refund.</span>
									<?php } else { ?>
										<a href="send-cancel-request.php?bookingid=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('Do you really want to Delete ?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
									<?php } ?>
									</td>
							</tr>
							
							<tr>
								<th style="width: 15%;">Action</th>
								<td class="d-none d-sm-table-cell"><a href="view-booking-detail.php?editid=<?php echo htmlentities ($row->ID);?>&&bookingid=<?php echo htmlentities ($row->BookingID);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
							</tr>
							<tr>
								<th></br> </th>
							</tr>
									<?php $cnt=$cnt+1;}} ?> 
                        </table>
		</div>
	</section>
	<!-- //about-top -->
	
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
</html><?php }  ?>