<?php
include("../php/db.php");

if(!isset($_GET['id'])){
    die("Customer ID not found.");
}

$id = (int)$_GET['id'];

$result = $conn->query("
SELECT *
FROM customers
WHERE id = $id
");

if($result->num_rows == 0){
    die("Customer not found.");
}

$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Customer Details</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    margin:0;
    padding:40px;
    font-family:Arial,Helvetica,sans-serif;
    background:#eef3ff;
}

.card{
    max-width:850px;
    margin:auto;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.12);
}

.header{
    background:linear-gradient(135deg,#21409A,#3d6df2);
    color:#fff;
    text-align:center;
    padding:35px;
}

.header h1{
    margin:0;
    font-size:36px;
}

.profile{
    padding:40px;
    text-align:center;
}

.avatar{
    width:110px;
    height:110px;
    background:#21409A;
    color:#fff;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:auto;
    font-size:45px;
    box-shadow:0 10px 25px rgba(33,64,154,.3);
}

.profile h2{
    margin-top:18px;
    color:#21409A;
    font-size:32px;
}

.info{
    margin-top:35px;
}

.item{
    display:flex;
    align-items:center;
    gap:20px;
    text-align:left;
    padding:18px 20px;
    margin-bottom:18px;
    border-radius:12px;
    background:#f7f9ff;
    transition:.3s;
}

.item:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(0,0,0,.08);
}

.item i{
    width:55px;
    height:55px;
    border-radius:50%;
    background:#21409A;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:22px;
}

.item h4{
    margin:0;
    color:#21409A;
}

.item p{
    margin:4px 0 0;
    color:#555;
    font-size:17px;
}

.buttons{
    margin-top:35px;
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

.buttons a{
    text-decoration:none;
    padding:14px 28px;
    border-radius:10px;
    color:#fff;
    font-weight:bold;
    transition:.3s;
}

.edit{
    background:#28a745;
}

.home{
    background:#21409A;
}

.buttons a:hover{
    transform:translateY(-3px);
    opacity:.9;
}

</style>

</head>

<body>

<div class="card">

<div class="header">
    <h1><i class="fa-solid fa-user"></i> Customer Details</h1>
</div>

<h1>👤 Customer Details</h1>

<div class="profile">

<div class="avatar">
<i class="fa-solid fa-user"></i>
</div>

<h2><?php echo $customer['customer_name']; ?></h2>

<div class="info">

<div class="item">
<i class="fa-solid fa-phone"></i>
<div>
<h4>Phone Number</h4>
<p><?php echo $customer['phone']; ?></p>
</div>
</div>

<div class="item">
<i class="fa-solid fa-location-dot"></i>
<div>
<h4>Address</h4>
<p><?php echo $customer['address']; ?></p>
</div>
</div>

<div class="item">
<i class="fa-solid fa-car"></i>
<div>
<h4>Vehicle Number</h4>
<p><?php echo $customer['vehicle']; ?></p>
</div>
</div>

<div class="item">
<i class="fa-solid fa-file-invoice"></i>
<div>
<h4>GST Number</h4>
<p><?php echo $customer['gst_number']; ?></p>
</div>
</div>

</div>

<div class="buttons">

<a href="edit_customer.php?id=<?php echo $customer['id']; ?>" class="edit">
✏ Edit Customer
</a>

<a href="../index.php" class="home">
🏠 Dashboard
</a>

</div>

</div>

</body>
</html>