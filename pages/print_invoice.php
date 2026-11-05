<?php
include("../php/db.php");

if (!isset($_GET['id'])) {
    die("Invoice not found");
}

$id = (int)$_GET['id'];

/* Invoice + Customer Details */
$invoice = $conn->query("
SELECT invoices.*, customers.*
FROM invoices
INNER JOIN customers
ON invoices.customer_id = customers.id
WHERE invoices.id = $id
")->fetch_assoc();

/* Invoice Items */
$items = $conn->query("
SELECT
invoice_items.*,
products.product_name,
products.hsn_no
FROM invoice_items
INNER JOIN products
ON invoice_items.product_id = products.id
WHERE invoice_items.invoice_id = $id
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Print Invoice</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{
background:#edf2ff;
padding:40px;
}

.invoice-container{
max-width:1200px;
margin:auto;
background:#fff;
padding:40px;
border-radius:18px;
box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.top-header{
display:flex;
justify-content:space-between;
align-items:center;
padding-bottom:25px;
border-bottom:3px solid #21409A;
margin-bottom:30px;
}

.top-header h1{
color:#21409A;
font-size:42px;
font-weight:bold;
}

.top-header p{
margin-top:8px;
color:#666;
}

.top-header h2{
color:#21409A;
font-size:34px;
}

.details-row{
display:grid;
grid-template-columns:1fr 1fr;
gap:25px;
margin-bottom:35px;
}

.card{
background:#f8faff;
border-left:6px solid #21409A;
padding:25px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.card h3{
color:#21409A;
margin-bottom:18px;
font-size:24px;
}

.card p{
margin:12px 0;
font-size:16px;
}

.heading{
margin:25px 0;
color:#21409A;
font-size:30px;
}

table{
width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:10px;
margin-bottom:35px;
}

table thead{
background:#21409A;
color:white;
}

table th{
padding:16px;
font-size:16px;
}

table td{
padding:15px;
text-align:center;
border-bottom:1px solid #ddd;
}

table tbody tr:hover{
background:#f4f7ff;
}

.buttons{
display:flex;
justify-content:space-between;
margin-top:30px;
}

.buttons a,
.buttons button{

padding:14px 28px;
border:none;
border-radius:8px;
font-size:16px;
font-weight:bold;
cursor:pointer;
text-decoration:none;
transition:.3s;
}

.buttons a{
background:#21409A;
color:white;
}

.buttons button{
background:#28a745;
color:white;
}

.buttons a:hover{
background:#18327c;
}

.buttons button:hover{
background:#1d7b33;
}

@media(max-width:900px){

.details-row{
grid-template-columns:1fr;
}

.buttons{
flex-direction:column;
gap:15px;
}
.grand-total{

width:350px;
margin-left:auto;
background:#21409A;
color:white;
padding:25px;
border-radius:12px;
text-align:right;
box-shadow:0 6px 15px rgba(0,0,0,.15);
margin-top:20px;

}

.grand-total h2{

font-size:28px;
line-height:1.6;

}

}

@media print{

body{
background:white;
padding:0;
}

.invoice-container{
box-shadow:none;
border:none;
}

.buttons{
display:none;
}

}
</style>

</head>

<body>

<div class="top-actions">

<a href="history.php" class="back-btn">

<i class="fa-solid fa-arrow-left"></i>

Back to Invoice History

</a>

</div>

<div class="invoice-container">

<div class="top-header">

<div>

<h1>SHREE TILES</h1>

<p>Tiles Billing System</p>

</div>

<div>

<h2>Invoice</h2>

<p>#<?php echo $invoice['id']; ?></p>

</div>

</div>


<div class="details-row">

<div class="card">

<h3>

<i class="fa-solid fa-user"></i>

Customer Details

</h3>

<p><b>Name :</b> <?php echo $invoice['customer_name']; ?></p>

<p><b>Address :</b> <?php echo $invoice['address']; ?></p>

<p><b>Phone :</b> <?php echo $invoice['phone']; ?></p>

<p><b>GST :</b> <?php echo $invoice['gst_number']; ?></p>

<p><b>Vehicle :</b> <?php echo $invoice['vehicle']; ?></p>

</div>


<div class="card">

<h3>

<i class="fa-solid fa-file-invoice"></i>

Invoice Summary

</h3>

<p><b>Date :</b> <?php echo $invoice['invoice_date']; ?></p>

<p><b>Taxable :</b>
₹<?php echo number_format($invoice['taxable_value'],2); ?>
</p>

<p><b>CGST :</b>
₹<?php echo number_format($invoice['cgst'],2); ?>
</p>

<p><b>SGST :</b>
₹<?php echo number_format($invoice['sgst'],2); ?>
</p>

<p style="font-size:22px;color:#21409A;">

<b>Total :</b>

₹<?php echo number_format($invoice['grand_total'],2); ?>

</p>

</div>

</div>

<h2 class="heading">

<i class="fa-solid fa-box"></i>

Products

</h2>

<table>

<thead>

<tr>

<th>#</th>

<th>Product</th>

<th>HSN</th>

<th>Qty</th>

<th>Rate</th>

<th>Amount</th>

</tr>

</thead>

<tbody>
<?php

$i = 1;

if($items->num_rows > 0){

while($row = $items->fetch_assoc()){

?>

<tr>

<td><?php echo $i++; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['hsn_no']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo number_format($row['rate'],2); ?></td>

<td>₹<?php echo number_format($row['amount'],2); ?></td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" style="padding:25px;color:red;">

No products found for this invoice.

</td>

</tr>

<?php

}

?>

</tbody>

</table>
<div class="grand-total">

<h2>

Grand Total

<br><br>

₹<?php echo number_format($invoice['grand_total'],2); ?>

</h2>

</div>

<div class="buttons">

<a href="../index.php">

← Dashboard

</a>

<button onclick="window.print()">

🖨 Print Invoice

</button>

</div>

</div>

</body>

</html>