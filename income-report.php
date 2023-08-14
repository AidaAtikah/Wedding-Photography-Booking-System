<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
} else {
?>

<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Swakarya Admin - Income Report</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <h2 class="content-heading">Income Report</h2>
            <div class="row">
                <div class="col-md-12">
                    <!-- Bootstrap Register -->
                    <div class="block block-themed">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">Income Report</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                        data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                        data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <?php
                            $sql = "SELECT SUM(tblbooking.EventPrice) AS total_income, MONTH(PaymentDate) AS month, YEAR(PaymentDate) AS year 
                                    FROM tblpayment join tblbooking on tblpayment.BookingID=tblbooking.BookingID
                                    GROUP BY YEAR(PaymentDate), MONTH(PaymentDate)
                                    ORDER BY YEAR(PaymentDate) DESC, MONTH(PaymentDate) DESC";

                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);

                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                echo '<table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">';
                                echo '<tr><th>Month</th><th>Year</th><th>Total Income</th></tr>';
                                foreach ($results as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['month'] . '</td>';
                                    echo '<td>' . $row['year'] . '</td>';
                                    echo '<td>' . $row['total_income'] . '</td>';
                                    echo '</tr>';
                                    $cnt++;
                                }
                                echo '</table>';
                            } else {
                                echo "<p>No payments found.</p>";
                            }
                            ?>
                        </div>

                        <div class="block-content">
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>

                   <!-- END Page Content -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right mt-2">
                        <a href="download-report.php" class="btn btn-primary" target="_blank">Download Report</a>
                        <button class="btn btn-primary" onclick="window.print()">Print Report</button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Retrieve income data from PHP
                    var incomeData = <?php echo json_encode($results); ?>;

                    // Prepare chart labels and data
                    var labels = incomeData.map(function(item) {
                        return item['month'] + '/' + item['year'];
                    });
                    var data = incomeData.map(function(item) {
                        return item['total_income'];
                    });

                    // Create the line chart
                    var ctx = document.getElementById('incomeChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Income',
                                data: data,
                                fill: false,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        borderDash: [2],
                                        borderDashOffset: [2]
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'RM' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
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
