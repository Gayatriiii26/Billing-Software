<?php
include("../php/db.php");

// Total Customers
$cust = $conn->query("SELECT COUNT(*) AS total FROM customers");
$totalCustomers = $cust->fetch_assoc()['total'];

// Total Products
$prod = $conn->query("SELECT COUNT(*) AS total FROM products");
$totalProducts = $prod->fetch_assoc()['total'];

// Total Invoices
$inv = $conn->query("SELECT COUNT(*) AS total FROM invoices");
$totalInvoices = $inv->fetch_assoc()['total'];

// Total Sales
$sales = $conn->query("SELECT SUM(grand_total) AS total FROM invoices");
$totalSales = $sales->fetch_assoc()['total'];

if(!$totalSales){
    $totalSales = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reports</title>

<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/reports.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("../sidebar.php"); ?>

<main class="main">

<!-- Welcome -->

<div class="welcome-box">

<h1>
<i class="fa-solid fa-chart-column"></i>
Reports
</h1>

<p>View Business Reports & Sales Summary.</p>

</div>

<!-- Date -->

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

<!-- Cards -->

<section class="cards">

<div class="card">
<i class="fa-solid fa-users"></i>
<h2>Total Customers</h2>
<h1><?php echo $totalCustomers; ?></h1>
</div>

<div class="card">
<i class="fa-solid fa-box"></i>
<h2>Total Products</h2>
<h1><?php echo $totalProducts; ?></h1>
</div>

<div class="card">
<i class="fa-solid fa-file-invoice"></i>
<h2>Total Invoices</h2>
<h1><?php echo $totalInvoices; ?></h1>
</div>

<div class="card">
<i class="fa-solid fa-indian-rupee-sign"></i>
<h2>Total Sales</h2>
<h1>₹<?php echo number_format($totalSales,2); ?></h1>
</div>

</section>

<!-- Invoice Table -->
<div class="form-box">

<div class="table-header">

<div>

<h2>Invoice Report</h2>

<p class="table-subtitle">
All generated customer invoices.
</p>

</div>

<div class="search-box">
    <i class="fa-solid fa-magnifying-glass"></i>

    <input
        type="text"
        id="searchInvoice"
        placeholder="Search by ID, Customer, Vehicle...">
</div>

</div>

<table id="invoiceTable">

<thead>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Date</th>
<th>Vehicle</th>
<th>Total</th>
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

<td class="customer-name">
    <?php echo $row['customer_name']; ?>
</td>

<td><?php echo $row['invoice_date']; ?></td>

<td><?php echo $row['vehicle_no']; ?></td>

<td class="amount">
    ₹<?php echo number_format($row['grand_total'],2); ?>
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>


</main>

</div>

<script>

function updateClock(){

let now=new Date();

document.getElementById("clock").innerHTML=now.toLocaleTimeString();

}

setInterval(updateClock,1000);

updateClock();

const searchInput = document.getElementById("searchInvoice");

searchInput.addEventListener("input", function(){

    const value = this.value.toLowerCase();

    const rows = document.querySelectorAll("#invoiceTable tbody tr");

    rows.forEach(row=>{

        const customerCell = row.cells[1];

        const original = customerCell.textContent;

        if(value==""){

            customerCell.innerHTML = original;
            row.style.display="";

            return;
        }

        if(original.toLowerCase().includes(value)){

            row.style.display="";

            customerCell.innerHTML =
            original.replace(
                new RegExp(value,"gi"),
                match=>`<mark>${match}</mark>`
            );

        }
        else{

            customerCell.innerHTML = original;
            row.style.display="none";

        }

    });

});
</script>

<script src="../theme.js"></script>

</body>
</html>