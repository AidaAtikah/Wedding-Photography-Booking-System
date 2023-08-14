<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $bid = $_GET['bookid'];
        $uid = $_SESSION['obbsuid'];
        $bride_name = $_POST['bride_name'];
        $bookdate = $_POST['bookdate'];

        // Check if the selected booking date is occupied
        $currentDate = date("Y-m-d"); // Get the current date
        $sql3 = "SELECT DISTINCT BookDate FROM tblbooking WHERE BookingDate >= '$currentDate'";
        $query3 = $dbh->prepare($sql3);
        $query3->execute();
        $result3 = $query3->fetchAll(PDO::FETCH_COLUMN);
        $occupiedDates = $result3;

        if (in_array($bookdate, $occupiedDates)) {
            echo '<script>alert("Booking date is occupied. Please choose a different date.")</script>';
        } else {
            $bookstarttime = date('H:i', strtotime($_POST['bookstarttime']));
            $bookendtime = date('H:i', strtotime($_POST['bookendtime']));
            $eventtype = $_POST['eventtype'];
            $eventprice = $_POST['eventprice'];
            $eventaddon = $_POST['eventaddon'];
            $location = $_POST['location'];
            $nop = $_POST['nop'];
            $message = $_POST['message'];
            $bookingid = mt_rand(100000000, 999999999);
            $sql = "INSERT INTO tblbooking(BookingID,ServiceID,UserID,BrideName,BookDate,BookStartTime,BookEndTime,EventType,EventPrice,EventAddOn,Location,NumberofPhoto,Message)
                VALUES(:bookingid,:bid,:uid,:bride_name,:bookdate,:bookstarttime,:bookendtime,:eventtype,:eventprice,:eventaddon,:location,:nop,:message)";

            $query = $dbh->prepare($sql);
            $query->bindParam(':bookingid', $bookingid, PDO::PARAM_STR);
            $query->bindParam(':bid', $bid, PDO::PARAM_STR);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query->bindParam(':bride_name', $bride_name, PDO::PARAM_STR);
            $query->bindParam(':bookdate', $bookdate, PDO::PARAM_STR);
            $query->bindParam(':bookstarttime', $bookstarttime, PDO::PARAM_STR);
            $query->bindParam(':bookendtime', $bookendtime, PDO::PARAM_STR);
            $query->bindParam(':location', $location, PDO::PARAM_STR);
            $query->bindParam(':eventtype', $eventtype, PDO::PARAM_STR);
            $query->bindParam(':eventprice', $eventprice, PDO::PARAM_STR);
            $query->bindParam(':eventaddon', $eventaddon, PDO::PARAM_STR);
            $query->bindParam(':nop', $nop, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);

            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId > 0) {
                echo '<script>alert("Your Booking Request Has Been Sent. 
                Please Check Your Booking History To Proceed with Deposit Payment.")</script>';
                echo "<script>window.location.href ='booking-history.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Swakarya Studio| Book Services</title>

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

<script>
    window.onload = function() {
        var currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + 3); // Add 3 days to the current date
        var minDate = currentDate.toISOString().split("T")[0];
        document.getElementById("bookdate").setAttribute("min", minDate);
    };
</script>

</head>
<body>

	<?php include("includes/header.php") ?>

	<!-- home section start -->
	<section class="home" id="home">

		<div class="content">  
			<h3>Swakarya Studio</h3>
			<span>Booking</span>
			<p> We are thrilled that you have chosen Swakarya Studio to be a part of your special day. 
                To secure our exceptional wedding services, simply fill out the booking form below with your desired package and preferred date. 
                Our dedicated team will promptly review your request and get in touch to confirm the availability and discuss further details. 
                Rest assured that your wedding booking is in capable hands, and we are committed to providing you with an unforgettable experience. 
                We look forward to working with you and turning your wedding dreams into reality. </p>
		</div>
		
	</section>
	<!-- home section end -->

    <!-- packages section starts  -->

    <section class="wedding" id="wedding">

    <h1 class="heading">Packages</h1>

    <div class="row">
        <?php
            $Image = 6;
            $sql="SELECT * from tbleventtype";
            $query = $dbh -> prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);

            $cnt=1;
            $i= 1;

            if($query->rowCount() > 0)
            {
            foreach($results as $row)
            
            {               ?>
        <div class="picture-container">
            <?php if ($i <= $Image) {
                $imagePath = "images/wed" . $i . ".jpg";
                echo '<img src="' . $imagePath . '" alt="Image ' . $i . '">';
                    }
            ?>
                <div class="content">
                    <h3><?php  echo htmlentities($row->EventType);?></h3>
                    <p><?php  echo htmlentities($row->EventDes);?></p>
                    <p><?php echo $eventDetails = nl2br(htmlentities($row->EventDetails))?>
                    <p> 
                    <div class="price">
                        <h4>RM <?php  echo htmlentities($row->EventPrice);?></h4>
                    </div>
                </div> 
        </div>
        <?php $cnt; $i=$i+1; }} ?>

    </section>

    <!-- terms section start --> 
    <section class="term" id="term">

        <h1 class="heading"> term & Conditions</h1>

        <div class="row">

            <div class="content">
                <p>1. A deposit of RM100 is required for every booking.
                    <br>2. Regrettably, refunds cannot be provided for cancellations made within 2-3 days before the booking date. Refunds, if applicable, will be processed within 7 working days.
                    <br>3. Please allow a dedicated timeframe of 1-2 months for our team to meticulously edit and perfect your photographs. We appreciate your patience and understanding as we work diligently to deliver the final, polished product that will exceed your expectations.
                    <br>4. The timeline for photobook production is depends on the album provider.
                    <br>5. Time coverage is limited as per the selected time slots.
                    <br>6. To extend the time coverage, a fee of RM100 per hour applies.
                    <br><br>Thank you for your understanding and cooperation. If you have any further questions or need clarification, please don't hesitate to reach out. We value your trust and are dedicated to providing you with a seamless and exceptional wedding photography experience.
                </p>
                <p><input type="checkbox" id="agreeCheckbox">I agree to the terms and conditions</p><br><br>
                <button onclick="toggleBooking()" class="btn" >Continue</button>
            </div>

        </div>

    </section>
    <!-- terms section end -->

	<!-- booking section start -->
    <section class="booking" id="booking" style="display: none;">

    <h1 class="heading"> My Booking </h1>

    <div class="row">

        <form action="" method="POST" >
            <input type="text" name = "bride_name" value="" placeholder="Name of your prospective partner" class="box" required ="true">
            <input type="date" name = "bookdate" id ="bookdate"value = "" placeholder="Book Date" class="box" required ="true">
            
            <select name="bookstarttime" class="box" required="true">
                <option value="">Select Start Time</option>
                <option value="09:00 AM">09:00 AM</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="01:00 PM">01:00 PM</option>
                <!-- Add more time slots as needed -->
            </select>

            <select name="bookendtime" class="box" required="true">
                <option value="">Select End Time</option>
                <option value="4:00 PM">04:00 PM</option>
                <option value="5:00 PM">05:00 PM</option>
                <option value="6:00 PM">06:00 PM</option>
                <option value="7:00 PM">07:00 PM</option>
                <option value="8:00 PM">08:00 PM</option>
                <!-- Add more time slots as needed -->
            </select>

            <select type="text" class="box" name="eventtype" id="eventtype" required="true">
            <?php
                $sql2 = "SELECT * from tblbooking";
                $query2 = $dbh->prepare($sql2);
                $query2->execute();
                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                foreach ($result2 as $row) {
            ?>
            <option value="">Select Event Type</option>
            <option value="<?php echo htmlentities($row->EventType); ?>"><?php echo htmlentities($row->EventType); ?></option>
            <?php } ?>
            </select>
            <input type="text" placeholder="Event Price" name="eventprice" id="eventprice" class="box" readonly>  
            
            <select name="eventaddon" class="box" required="true">
                <option value="">Choose Event Add On</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <input type="text" name = "location" value = "" placeholder="Location" class="box" required ="true">
            
            <select name="nop" class="box" required="true">
                <option value="">Choose Number of Photographer</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>

			<textarea type="number" name = "message" value = "" placeholder="Message (if any)" class="box" ></textarea>
            <button name = "submit" class="btn">Book</a>
            
        </form>

        <script>
            // JavaScript code for date validation
            var bookdateInput = document.getElementById("bookdate");
            bookdateInput.addEventListener("change", function() {
                var selectedDate = new Date(this.value);
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (selectedDate < currentDate) {
                    alert("Booking date should be a future date.");
                    this.value = ""; // Clear the selected date
                }
            });
        </script>

        <script>
                // Get references to the event type dropdown and event price input
                var eventTypeDropdown = document.getElementById("eventtype");
                var eventPriceInput = document.getElementById("eventprice");
                
                // Define the event type data
                var eventTypeData = [
                { name: 'Engagement Packages A', price: '899' },
                { name: 'Engagement Packages B', price: '599' },
                { name: 'Wedding Packages A', price: '1199' },
                { name: 'Wedding Packages B', price: '899' },
                { name: 'Wedding Packages C', price: '899' },
                { name: 'Wedding Packages D', price: '599' }
                ];
                
                // Function to generate the event type options
                function generateEventTypeOptions() {
                var options = "";
                eventTypeData.forEach(function(eventType) {
                    options += "<option value='" + eventType.name + "'>" + eventType.name + "</option>";
                });
                eventTypeDropdown.innerHTML = options;
                }
                
                // Function to update the event price based on the selected event type
                function updateEventPrice() {
                var selectedEventType = eventTypeDropdown.value;
                var selectedEventTypeData = eventTypeData.find(function(eventType) {
                    return eventType.name === selectedEventType;
                });
                if (selectedEventTypeData) {
                    eventPriceInput.value = selectedEventTypeData.price;
                } else {
                    eventPriceInput.value = "";
                }
                }
                
                // Attach the event listener to the event type dropdown
                eventTypeDropdown.addEventListener("change", updateEventPrice);
                
                // Generate the event type options
                generateEventTypeOptions();
                
                // Trigger the initial update of the event price
                updateEventPrice();
        </script>

        <script>
            function toggleBooking() {
                var agreeCheckbox = document.getElementById("agreeCheckbox");
                var booking = document.getElementById("booking");

                if (agreeCheckbox.checked) {
                    booking.style.display = "block";
                } else {
                    booking.style.display = "none";
                }
            }
        </script>

    </div>

    </section>
    <!-- booking section end -->

	

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