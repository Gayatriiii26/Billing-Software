<?php
include("../php/db.php");

if (!isset($_GET['id'])) {
    die("Invoice not found.");
}

$id = (int)$_GET['id'];

$invoice = $conn->query("
SELECT invoices.*, customers.*
FROM invoices
INNER JOIN customers
ON invoices.customer_id = customers.id
WHERE invoices.id=$id
")->fetch_assoc();

$items = $conn->query("
SELECT
invoice_items.*,
products.product_name,
products.hsn_no
FROM invoice_items
INNER JOIN products
ON invoice_items.product_id=products.id
WHERE invoice_items.invoice_id=$id
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<title>Invoice Details</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#eef3ff;
padding:40px;
}

.invoice-box{
max-width:1200px;
margin:auto;
background:#fff;
padding:35px;
border-radius:18px;
box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.header{
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:2px solid #eee;
padding-bottom:20px;
margin-bottom:30px;
}

.logo h1{
color:#21409A;
font-size:34px;
}

.logo p{
color:#666;
}

.invoice-title{
text-align:right;
}

.invoice-title h2{
color:#21409A;
margin-bottom:10px;
}

.info-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:25px;
margin-bottom:30px;
}

.card{
background:#f7f9ff;
padding:25px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.card h3{
color:#21409A;
margin-bottom:18px;
font-size:22px;
}

.card p{
margin:12px 0;
font-size:16px;
}

.product-title{
font-size:28px;
font-weight:bold;
color:#21409A;
margin-bottom:15px;
}

table{
width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:10px;
}

table th{
background:#21409A;
color:white;
padding:15px;
}

table td{
padding:14px;
text-align:center;
border-bottom:1px solid #ddd;
}

table tr:hover{
background:#f5f8ff;
}

.total-box{
width:350px;
margin-left:auto;
margin-top:30px;
background:#21409A;
color:white;
padding:25px;
border-radius:12px;
}

.total-box table{
color:white;
}

.total-box td{
border:none;
padding:10px;
}

.button-box{
display:flex;
justify-content:space-between;
margin-top:35px;
}

.btn-home,
.btn-print{

padding:14px 28px;
border:none;
border-radius:8px;
font-size:16px;
text-decoration:none;
cursor:pointer;
font-weight:bold;
}

.btn-home{
background:#21409A;
color:white;
}

.btn-print{
background:#28a745;
color:white;
}

.btn-home:hover{
background:#17337b;
}

.btn-print:hover{
background:#1d7d33;
}

@media(max-width:900px){

.info-grid{
grid-template-columns:1fr;
}

.button-box{
flex-direction:column;
gap:15px;
}

.total-box{
width:100%;
}

}

@media print{

.button-box{
display:none;
}

body{
background:white;
padding:0;
}

.invoice-box{
box-shadow:none;
}

}

</style>

</head>

<body>

<div class="invoice-box">

<div class="header">

<div class="logo">

<h1>SHREE TILES</h1>

<p>Billing System</p>

</div>

<div class="invoice-title">

<h2>Invoice</h2>

<p><b>Invoice No:</b> <?php echo $invoice['id']; ?></p>

<p><b>Date:</b> <?php echo $invoice['invoice_date']; ?></p>

</div>

</div>

<div class="info-grid">

<div class="card">

<h3><i class="fa-solid fa-user"></i> Customer Details</h3>

<p><b>Name :</b> <?php echo $invoice['customer_name']; ?></p>

<p><b>Address :</b> <?php echo $invoice['address']; ?></p>

<p><b>Phone :</b> <?php echo $invoice['phone']; ?></p>

<p><b>GST :</b> <?php echo $invoice['gst_number']; ?></p>

<p><b>Vehicle :</b> <?php echo $invoice['vehicle']; ?></p>

</div>

<div class="card">

<h3><i class="fa-solid fa-file-invoice"></i> Invoice Summary</h3>

<p><b>Taxable Value :</b> ₹<?php echo number_format($invoice['taxable_value'],2); ?></p>

<p><b>CGST :</b> ₹<?php echo number_format($invoice['cgst'],2); ?></p>

<p><b>SGST :</b> ₹<?php echo number_format($invoice['sgst'],2); ?></p>

<p style="font-size:22px;color:#21409A;">

<b>Grand Total :</b>

₹<?php echo number_format($invoice['grand_total'],2); ?>

</p>

</div>

</div>

<div class="product-title">

<i class="fa-solid fa-box"></i>

Product Details

</div>

<table>

<tr>

<th>#</th>

<th>Product</th>

<th>HSN</th>

<th>Quantity</th>

<th>Rate</th>

<th>Amount</th>

</tr>

<?php

$i=1;

while($row=$items->fetch_assoc()){

?>

<tr>

<td><?php echo $i++; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['hsn_no']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo number_format($row['rate'],2); ?></td>

<td>₹<?php echo number_format($row['amount'],2); ?></td>

</tr>

<?php } ?>

</table>

<div class="total-box">

<table width="100%">

<tr>

<td>Taxable Value</td>

<td align="right">

₹<?php echo number_format($invoice['taxable_value'],2); ?>

</td>

</tr>

<tr>

<td>CGST</td>

<td align="right">

₹<?php echo number_format($invoice['cgst'],2); ?>

</td>

</tr>

<tr>

<td>SGST</td>

<td align="right">

₹<?php echo number_format($invoice['sgst'],2); ?>

</td>

</tr>

<tr style="font-size:22px;font-weight:bold;">

<td>Grand Total</td>

<td align="right">

₹<?php echo number_format($invoice['grand_total'],2); ?>

</td>

</tr>

</table>

</div>

<div class="button-box">

<a href="../index.php" class="btn-home">

← Back to Dashboard

</a>

<button class="btn-print" onclick="window.print()">

🖨 Print Invoice

</button>

</div>

</div>

</body>

</html>