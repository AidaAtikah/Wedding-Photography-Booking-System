<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {


$etype=$_POST['eventtype'];
$eDes=$_POST['eventdes'];
$eDetails=$_POST['eventdetails'];
$eAddOn=$_POST['eventaddon'];
$ePrice=$_POST['eventprice'];


$sql="insert into tbleventtype(EventType,EventDes,EventDetails,EventAddOn,EventPrice) 
values (:etype,:eDes,:eDetails,:eAddOn,:ePrice)";
$query=$dbh->prepare($sql);
$query->bindParam(':etype',$etype,PDO::PARAM_STR);
$query->bindParam(':eDes',$eDes,PDO::PARAM_STR);
$query->bindParam(':eDetails',$eDetails,PDO::PARAM_STR);
$query->bindParam(':eAddOn',$eAddOn,PDO::PARAM_STR);
$query->bindParam(':ePrice',$ePrice,PDO::PARAM_STR);


 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Packages has been added.")</script>';
    echo "<script>window.location.href ='add-event-type.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}

?>
<!doctype html>
 <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
 <title>Swakarya Admin - Add Packages</title>
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
                    <h2 class="content-heading">Add Packages</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Bootstrap Register -->
                            <div class="block block-themed">
                                <div class="block-header bg-gd-emerald">
                                    <h3 class="block-title">Add Packages</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                   
                                    <form method="post">
                                        
                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">Packages:</label>
                                            <div class="col-12">
                                                 <input type="text" class="form-control" name="eventtype" value="" required='true'>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">Packages Event:</label>
                                            <div class="col-12">
                                                 <textarea type="text" class="form-control" name="eventdes" value="" required='true'></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">Packages Details:</label>
                                            <div class="col-12">
                                                 <textarea type="text" class="form-control" name="eventdetails" value="" required='true'></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">Packages Add On:</label>
                                            <div class="col-12">
                                                 <textarea type="text" class="form-control" name="eventaddon" value="" required='true'></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">Packages Price:</label>
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="eventprice" value="" required='true'>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-alt-success" name="submit">
                                                    <i class="fa fa-plus mr-5"></i> Add
                                                </button>
                                            </div>
                                        </div>
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