<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {


    $eid=$_GET['editid'];
    $bookingid=$_GET['bookingid'];
    $status=$_POST['status'];
    $remark=$_POST['remark'];
  

    $sql= "update tblbooking set Status=:status,Remark=:remark where ID=:eid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':status',$status,PDO::PARAM_STR);
    $query->bindParam(':remark',$remark,PDO::PARAM_STR);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);

    $query->execute();

    echo '<script>alert("Remark has been updated")</script>';
    echo "<script>window.location.href ='all-booking.php'</script>";
}

?>
<!doctype html>
 <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
 <title>Swakarya Admin - View Booking</title>
<link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">

</head>
    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
     

             <?php include_once('includes/sidebar.php');?>

          <?php include_once('includes/header.php');?>

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content">
                
                    <!-- Register Forms -->
                    <h2 class="content-heading">View Booking</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Bootstrap Register -->
                            <div class="block block-themed">
                                <div class="block-header bg-gd-emerald">
                                    <h3 class="block-title">View Booking</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                   
                                    <?php
                  $eid=$_GET['editid'];

          $sql="SELECT tbluser.FullName,tbluser.MobileNumber,tbluser.Email,tbluser.Address,
          tblbooking.BookingID,tblbooking.BookingDate,tblbooking.BookDate,tblbooking.BookStartTime,tblbooking.BookEndTime,
          tblbooking.EventType,tblbooking.Location,tblbooking.NumberofPhoto,tblbooking.Message, 
          tblbooking.Remark,tblbooking.Status,tblbooking.UpdationDate,
          tblservice.ServiceName,tblservice.SerDes
          from tblbooking join tblservice on tblbooking.ServiceID=tblservice.ID join tbluser on tbluser.ID=tblbooking.UserID  where tblbooking.ID=:eid";
          $query = $dbh -> prepare($sql);
          $query-> bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);

          $cnt=1;
          if($query->rowCount() > 0)
          {
          foreach($results as $row)
          {               ?>
<table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
			
			<tr>
                <th colspan="5" style="text-align: center;font-size: 20px;color: blue;">Booking Number: <?php  echo $row->BookingID;?>
                </th>
            </tr>

		  <tr>
            <th>Client Name</th>
              <td><?php  echo $row->FullName;?></td>
			<th>Client Future Partner Name</th>
              <td><?php  echo $row->FullName;?></td>
            
          </tr>
  
          <tr> 
            <th>Mobile Number</th>
              <td><?php  echo $row->MobileNumber;?></td>
			<th>Email</th>
              <td><?php  echo $row->Email;?></td>
            
          </tr>

          <tr> 
			<th>Address</th>
              <td><?php  echo $row->Address;?></td>
            <th>Book Date</th>
              <td><?php  echo $row->BookDate;?></td>
            
          </tr>

		  <tr>
			<th>Book Start Time</th>
              <td><?php  echo $row->BookStartTime;?></td>	
			<th>Book End Time</th>
              <td><?php  echo $row->BookEndTime;?></td>		
		 </tr>

          <tr> 
            <th>Event Type</th>
              <td><?php  echo $row->EventType;?></td>
            <th>Event Price</th>
              <td><?php  echo $row->EventPrice;?></td>
          </tr>

          <tr> 
		  	<th>Event Add On</th>
              <td><?php  echo  $row->EventAddOn; ?></td>
		  	<th>Location</th>
              <td><?php  echo $row->Location;?></td>
          </tr>

          <tr>  
            <th>Service Name</th>
              <td><?php  echo $row->ServiceName;?></td>
            <th>Service Description</th>
              <td><?php  echo $row->SerDes;?></td>
          </tr>

		  <tr>
             <th>Number of Photographer</th>
              <td><?php  echo $row->NumberofPhoto;?></td>
		  	<th>Message</th>
              <td>
			  <?php  
				if ($row->Message == null || $row->Message == "") {
					echo "No message has been inputted.";
				} else {
					echo $row->Message;
				}
			  ?>
			  </td>
				
		 </tr> 

			<tr>
				<th>Apply Date</th>
              <td><?php  echo $row->BookingDate;?></td>

			  <?php
				// ...
				if ($row->Status == "Approved") {
				// Check the payment status for the current booking
				$paymentStatus = "Pending"; // Set the default payment status to "Pending"
				
				// Query the tblpayment table to get the payment status
				$paymentQuery = $dbh->prepare("SELECT Status FROM tblpayment WHERE BookingID = :bookingID");
				$paymentQuery->bindParam(':bookingID', $row->BookingID, PDO::PARAM_STR);
				$paymentQuery->execute();
				$paymentResult = $paymentQuery->fetch(PDO::FETCH_OBJ);
				
				if ($paymentQuery->rowCount() > 0) {
					$paymentStatus = $paymentResult->Status;
				}
				
				if ($paymentStatus == "Paid") {
					// Display the "Paid" status
					echo '<th>Payment</th>';
					echo '<td>Paid</td>';
				} else {
					// Display the "Make Payment" button
					echo '<th>Payment</th>';
					echo '<td><a href="payment.php?bookingid='.$row->BookingID.'" class="btn">Make Payment</a></td>';
				}
				} else {
				
				// Display a message regarding the payment status
				echo '<th>Payment</th>';
				echo '<td>The payment can be made after the booking is approved</td>';
				}
				?>

		</tr>
  	
	<tr>
     <th>Booking Final Status</th>
    <td> <?php  $status=$row->Status;
    
		if($row->Status=="Approved")
		{
		echo "Approved";
		}

		if($row->Status=="Cancelled")
		{
		echo "Cancelled";
		}


		if($row->Status=="")
		{
		echo "Not Response Yet";
		}


     ;?></td>
     <th >Admin Remark</th>
    <?php if($row->Status==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>
  </tr>
  
 
<?php $cnt=$cnt+1;}} ?>

</table> 
<?php 

if ($status==""){
?> 
<p align="center"  style="padding-top: 20px">                            
 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button></p>  

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">

                                <form method="post" name="submit">

                                
                               
     <tr>
    <th>Remark :</th>
    <td>
    <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
  </tr> 
   
 
  <tr>
    <th>Status :</th>
    <td>

   <select name="status" class="form-control wd-450" required="true" >
     <option value="Approved" selected="true">Approved</option>
     <option value="Cancelled">Cancelled</option>
   </select></td>
  </tr>
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" name="submit" class="btn btn-primary">Update</button>
  
  </form>



                                </div>
                            </div>
                            <!-- END Bootstrap Register -->
                        </div>
                        
                       </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

          <?php include_once('includes/footer.php');?>
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->
        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.appear.min.js"></script>
        <script src="assets/js/core/jquery.countTo.min.js"></script>
        <script src="assets/js/core/js.cookie.min.js"></script>
        <script src="assets/js/codebase.js"></script>
    </body>
</html>
<?php }  ?>