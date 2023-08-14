<?php
include('includes/dbconnection.php');

// Fetch income data from the database
$sql = "SELECT SUM(tblbooking.EventPrice) AS total_income, MONTH(PaymentDate) AS month, YEAR(PaymentDate) AS year 
        FROM tblpayment join tblbooking on tblpayment.BookingID=tblbooking.BookingID
        GROUP BY YEAR(PaymentDate), MONTH(PaymentDate)
        ORDER BY YEAR(PaymentDate) DESC, MONTH(PaymentDate) DESC";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Generate CSV file content
$csvData = "Month,Year,Total Income\n";
foreach ($results as $row) {
    $csvData .= $row['month'] . ',' . $row['year'] . ',' . $row['total_income'] . "\n";
}

// Set appropriate headers for download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="income_report.csv"');

// Output the CSV file content
echo $csvData;
exit;
?>
