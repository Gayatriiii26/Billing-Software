<?php
include("../php/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Invoice History</title>

<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/dashboard.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <?php include("../sidebar.php"); ?>

    <!-- Main -->
    <main class="main">

    
        <!-- Welcome -->

        <div class="welcome-box">

            <h1>
                <i class="fa-solid fa-clock-rotate-left"></i>
                Invoice History
            </h1>

            <p>View All Saved Invoices.</p>

        </div>

        <!-- Date Time -->

        <div class="info-bar">

            <div>

                <i class="fa-solid fa-calendar-days"></i>

                <b>Date:</b>

                <?php echo date("d M Y"); ?>

            </div>

            <div>

                <i class="fa-solid fa-clock"></i>

                <b>Time:</b>

                <span id="clock"></span>

            </div>

        </div>

        <!-- Table -->

       <div class="table-card">

<table class="customer-table">

<thead>

<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Date</th>
    <th>Vehicle</th>
    <th>Total</th>
    <th>Action</th>
</tr>

</thead>

<tbody>

<?php

$sql = "SELECT invoices.*, customers.customer_name
FROM invoices
JOIN customers
ON invoices.customer_id = customers.id
ORDER BY invoices.id DESC";

$result = $conn->query($sql);

while($row = $result->fetch_assoc())
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['customer_name']; ?></td>

<td><?php echo $row['invoice_date']; ?></td>

<td><?php echo $row['vehicle_no']; ?></td>

<td>₹<?php echo number_format($row['grand_total'],2); ?></td>

<td>

<div class="action-buttons">

<a href="gst_invoice.php?id=<?php echo $row['id']; ?>" target="_blank" class="print-btn">
    🖨 Print
</a>


</div>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

        </div>

    </main>

</div>

<script>

function updateClock(){

let now=new Date();

document.getElementById("clock").innerHTML=
now.toLocaleTimeString();

}

setInterval(updateClock,1000);

updateClock();

</script>
<script src="theme.js"></script>
</body>
</html>