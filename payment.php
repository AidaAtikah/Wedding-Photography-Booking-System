<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obbsuid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['obbsuid'];
        $bid = $_GET['bookingid'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip_code = $_POST['zip_code'];
        $card_number = $_POST['card_number'];
        $exp_month = $_POST['exp_month'];
        $exp_year = $_POST['exp_year'];
        $cvv = $_POST['cvv'];
        $paymentid = mt_rand(100000000, 999999999);

        // Validate Card Number
        if (!validateCardNumber($card_number)) {
            echo '<script>alert("Invalid card number. Card number must be exactly 16 digits")</script>';
            echo "<script>window.location.href ='payment.php'</script>";
            // Stop executing further code
            exit;
        }

        // Validate Expiration Year
        $current_year = date('Y');
        if ($exp_year <= $current_year) {
            echo '<script>alert("Expiration year must be greater than the current year")</script>';
            echo "<script>window.location.href ='payment.php'</script>";
            // Stop executing further code
            exit;
        }

        // Validate Expiration Month
        $current_year = date('Y');
        $current_month = date('m');
        if ($exp_year == $current_year && $exp_month <= $current_month) {
            echo '<script>alert("Expiration month must be greater than the current month")</script>';
            echo "<script>window.location.href ='payment.php'</script>";
            // Stop executing further code
            exit;
        }

        // Validate CVV
        if (strlen($cvv) != 3) {
            echo '<script>alert("CVV must be a 3-digit number")</script>';
            echo "<script>window.location.href ='payment.php'</script>";
            // Stop executing further code
            exit;
        }

        $sql = "INSERT INTO tblpayment(PaymentID,BookingID,UserID,FullName, Email, Address, City, State, ZipCode, CardNumber, ExpMonth, ExpYear, CVV)
                VALUES(:paymentid,:bid,:uid,:full_name, :email, :address, :city, :state, :zip_code, :card_number, :exp_month, :exp_year, :cvv)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':paymentid', $paymentid, PDO::PARAM_STR);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
        $query->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
        $query->bindParam(':card_number', $card_number, PDO::PARAM_INT);
        $query->bindParam(':exp_month', $exp_month, PDO::PARAM_STR);
        $query->bindParam(':exp_year', $exp_year, PDO::PARAM_STR);
        $query->bindParam(':cvv', $cvv, PDO::PARAM_STR);

        if ($query->execute()) {
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId > 0) {
                echo '<script>alert("Payment has been successfully made")</script>';
                echo "<script>window.location.href ='view-status.php'</script>";
            } else {
                echo '<script>alert("Something went wrong. Please try again")</script>';
            }
        } else {
            echo '<script>alert("Error occurred while making payment. Please try again")</script>';
        }
    }
}

// Function to validate card number
function validateCardNumber($card_number) {
    // Remove any non-digit characters
    $card_number = preg_replace('/\D/', '', $card_number);
    return strlen($card_number) == 16; // Return true if the card number is exactly 16 digits
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Swakarya Studio | Payment</title>
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
            <span>Payment</span>
            <p>Welcome to the Payment page. Here, you can securely complete your payment for our exceptional wedding photography services.
            To proceed with your payment, please enter the required payment details, including your card credit details and any necessary billing information. 
            Once your payment is successfully processed, you will receive a booking confirmation email.
            </p>
        </div>
    </section>
    <!-- home section end -->

    <section class="payment" id="payment">
    <h1 class="heading">Payment</h1>
    <div class="container">
        <div class="left">
        <h3>BILLING ADDRESS</h3>
        <form method="POST" action="">
            <!--Display user information from tbluser -->
            <input type="text" name="full_name" placeholder="Enter name" required="true">
            <input type="email" name="email" placeholder="Enter email" required="true">
            <input type="text" name="address" placeholder="Enter address" required="true">
            <input type="text" name="city" placeholder="Enter City" required="true">
            <div id="state">
            <label>State
                <select name="state">
                <option value="">Choose State</option>
                <option value="Perlis">Perlis</option>
                <option value="Kedah">Kedah</option>
                <option value="Puala Pinang">Puala Pinang</option>
                <option value="Perak">Perak</option>
                <option value="W.P Kuala Lumpur">W.P Kuala Lumpur</option>
                <option value="Selangor">Selangor</option>
                <option value="Putrajaya">Putrajaya</option>
                <option value="Negeri Sembilan">Negeri Sembilan</option>
                <option value="Melaka">Melaka</option>
                <option value="Johor">Johor</option>
                <option value="Pahang">Pahang</option>
                <option value="Terengganu">Terengganu</option>
                <option value="Kelantan">Kelantan</option>
                </select>
            </label>
            </div>
            <label>
            Zip code
            <input type="text" name="zip_code" placeholder="Zip code" required="true">
            </label>
        </div>
        <div class="right">
            <h3>PAYMENT</h3>
            <div class="card-details">
            <div class= "card-number">
                <label>
                <img src="images/card1.png" width="100">
                <img src="images/card2.png" width="50">
                </label>
            </div>
            <div class="card-number">
                <label>Credit card number</label>
                <input type="text" name="card_number" placeholder="Enter card number" required="true">
            </div>
            <div class="exp-date">
                <label>Exp month</label>
                <input type="text" name="exp_month" placeholder="Enter Month" required="true">
            </div>
            <div class="exp-date">
                <label>Exp year</label>
                <select name="exp_year">
                    <option value="">Choose Year..</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>
            <div class="cvv">
                <label>CVV</label>
                <input type="text" name="cvv" placeholder="CVV" required="true">
            </div>
            </div>
            <input type="submit" name="submit" value="Submit" class="btn">
            </div>
            </div>
        </form>
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
