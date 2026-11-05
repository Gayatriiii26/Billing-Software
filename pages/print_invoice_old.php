<?php
include("../php/db.php");

$id = $_GET['id'];

$sql = "SELECT
invoices.*,
customers.customer_name,
customers.address,
customers.phone,
customers.gst_number,
customers.vehicle
FROM invoices
JOIN customers
ON invoices.customer_id = customers.id
WHERE invoices.id = '$id'";

$result = $conn->query($sql);
$invoice = $result->fetch_assoc();

$items = $conn->query("
SELECT
invoice_items.*,
products.product_name
FROM invoice_items
INNER JOIN products
ON invoice_items.product_id = products.id
WHERE invoice_items.invoice_id = '$id'
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Print Invoice</title>

<style>

body{
    background:#eef3ff;
    font-family:Arial,Helvetica,sans-serif;
    padding:40px;
}

.invoice{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:40px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.12);
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:3px solid #21409A;
    padding-bottom:20px;
    margin-bottom:30px;
}

.company h1{
    color:#21409A;
    font-size:38px;
    margin:0;
}

.company p{
    color:#666;
}

.invoice-title{
    text-align:right;
}

.invoice-title h2{
    color:#21409A;
}

.info{
    background:#f7f9ff;
    padding:20px;
    border-left:5px solid #21409A;
    border-radius:10px;
    margin-bottom:25px;
}

.info p{
    margin:10px 0;
    font-size:16px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#21409A;
    color:white;
    padding:14px;
}

table td{
    padding:14px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table tr:nth-child(even){
    background:#f5f8ff;
}

.total{
    width:300px;
    margin-left:auto;
    margin-top:25px;
    background:#21409A;
    color:white;
    padding:20px;
    border-radius:10px;
}

.total h2{
    text-align:right;
    margin:0;
}

.button-box{
    margin-top:30px;
    display:flex;
    justify-content:space-between;
}

.back-btn,
button{

    padding:12px 25px;
    border:none;
    border-radius:8px;
    text-decoration:none;
    font-size:16px;
    cursor:pointer;
    font-weight:bold;
}

.back-btn{
    background:#21409A;
    color:white;
}

button{
    background:#28a745;
    color:white;
}

.back-btn:hover{
    background:#17337b;
}

button:hover{
    background:#1d7d33;
}

@media print{

.button-box{
display:none;
}

body{
background:white;
padding:0;
}

.invoice{
box-shadow:none;
}

}

</style>

</head>

<body>

<div class="invoice">

<div class="header">

<div class="company">

<h1>SHREE TILES</h1>

<p>Billing System</p>

</div>

<div class="invoice-title">

<h2>Invoice</h2>

</div>

</div>

<div class="info">

<p><b>Customer :</b> <?php echo $invoice['customer_name']; ?></p>

<p><b>Date :</b> <?php echo $invoice['invoice_date']; ?></p>

<p><b>Vehicle :</b> <?php echo $invoice['vehicle']; ?></p>

</div>

<table>

<tr>

<th>Product</th>

<th>Quantity</th>

<th>Rate</th>

<th>Amount</th>

</tr>

<?php while($row = $items->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo number_format($row['rate'],2); ?></td>

<td>₹<?php echo number_format($row['amount'],2); ?></td>

</tr>

<?php } ?>

</table>

<div class="total">

<h2>

Grand Total

<br><br>

₹<?php echo number_format($invoice['grand_total'],2); ?>

</h2>

</div>

<div class="button-box">

<a href="../index.php" class="back-btn">

← Dashboard

</a>

<button onclick="window.print()">

🖨 Print Invoice

</button>

</div>

</div>
</body>
</html>