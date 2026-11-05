<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("php/db.php");

$customers = $conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc()['total'];
$products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$invoices = $conn->query("SELECT COUNT(*) AS total FROM invoices")->fetch_assoc()['total'];
$sales = $conn->query("SELECT SUM(grand_total) AS total FROM invoices")->fetch_assoc()['total'];

if($sales == NULL){
    $sales = 0;
}

$monthlySales = [];

for($i = 1; $i <= 12; $i++){

    $month = str_pad($i,2,"0",STR_PAD_LEFT);

    $result = $conn->query("
        SELECT SUM(grand_total) AS total
        FROM invoices
        WHERE MONTH(invoice_date)='$month'
    ");

    $row = $result->fetch_assoc();

    $monthlySales[] = $row['total'] ? $row['total'] : 0;
}

// Top Selling Products
$topProducts = $conn->query("
SELECT
products.product_name,
SUM(invoice_items.quantity) AS total_qty
FROM invoice_items
INNER JOIN products
ON invoice_items.product_id = products.id
GROUP BY invoice_items.product_id
ORDER BY total_qty DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Shree Tiles Billing System</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/dashboard.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("sidebar.php"); ?>

<main class="main">

<div class="topbar">

<div class="search-box">

<input
type="text"
id="search"
placeholder="Search customers, products, invoices..."
autocomplete="off">

<div id="searchResult"></div>

</div>

<div class="admin">
<i class="fa-solid fa-circle-user"></i>
<span>Welcome Admin</span>
</div>

</div>

<div class="welcome-box">

<h1>👋 Welcome to Shree Tiles Billing System</h1>

<p>Manage Customers, Products, Invoices and Reports Easily.</p>

</div>

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

<section class="cards">

<a href="pages/customers.php" class="card">
<i class="fa-solid fa-users"></i>
<h2>Customers</h2>
<h1><?php echo $customers; ?></h1>
</a>

<a href="pages/products.php" class="card">
<i class="fa-solid fa-box"></i>
<h2>Products</h2>
<h1><?php echo $products; ?></h1>
</a>

<a href="pages/history.php" class="card">
<i class="fa-solid fa-file-invoice"></i>
<h2>Invoices</h2>
<h1><?php echo $invoices; ?></h1>
</a>

<a href="pages/reports.php" class="card">
<i class="fa-solid fa-indian-rupee-sign"></i>
<h2>Total Sales</h2>
<h1>₹<?php echo number_format($sales,2); ?></h1>
</a>

</section>

<h2 class="section-title">Quick Actions</h2>

<div class="quick-actions">

<a href="pages/customers.php" class="action">
<i class="fa-solid fa-user-plus"></i>
<h3>Add Customer</h3>
</a>

<a href="pages/products.php" class="action">
<i class="fa-solid fa-box-open"></i>
<h3>Add Product</h3>
</a>

<a href="pages/invoice.php" class="action">
<i class="fa-solid fa-file-circle-plus"></i>
<h3>Create Invoice</h3>
</a>

<a href="pages/reports.php" class="action">
<i class="fa-solid fa-chart-line"></i>
<h3>View Reports</h3>
</a>

</div>

<h2 class="section-title">Recent Activity</h2>

<div class="recent-box">

<?php

$result = $conn->query("
SELECT
customers.customer_name,
invoices.invoice_date,
invoices.grand_total
FROM invoices
INNER JOIN customers
ON invoices.customer_id = customers.id
ORDER BY invoices.id DESC
LIMIT 5
");

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<div class="activity">

<i class="fa-solid fa-file-invoice"></i>

<div>

<b><?php echo $row['customer_name']; ?></b><br>

Date : <?php echo $row['invoice_date']; ?>

&nbsp;&nbsp;&nbsp;

₹<?php echo number_format($row['grand_total'],2); ?>

</div>

</div>

<?php

}

}else{

?>

<p>No recent invoices found.</p>

<?php

}

?>

</div>

<script>

const monthlySales = <?php echo json_encode($monthlySales); ?>;

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('salesChart');

if(ctx){

new Chart(ctx,{
type:'bar',
data:{
labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
datasets:[{
label:'Monthly Sales (₹)',
data:monthlySales,
borderWidth:1
}]
},
options:{
responsive:true,
scales:{
y:{
beginAtZero:true
}
}
}
});

}

</script>

<script src="script.js"></script>
<script src="pages/theme.js"></script>

</main>

</div>

</body>

</html>