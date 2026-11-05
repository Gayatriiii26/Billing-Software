<?php
include("../php/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Products</title>

<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/customers.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

.delete-selected-btn{
    background:#dc3545;
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    margin-bottom:15px;
}

.delete-selected-btn:hover{
    background:#bb2d3b;
}

.product-checkbox,
#selectAll{
    width:18px;
    height:18px;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

<?php include("../sidebar.php"); ?>

<main class="main">

<div class="welcome-box">

<h1>
<i class="fa fa-box"></i>
Products
</h1>

<p>Manage all products from here.</p>

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

<div class="customer-layout">

<!-- LEFT -->

<div class="form-box">

<h2>
<i class="fa fa-plus-circle"></i>
Add Product
</h2>

<form action="../php/save_product.php" method="POST">

<div class="field">
<label>Product Name</label>
<input type="text" name="product_name" placeholder="Enter Product Name" required>
</div>

<div class="field" style="margin-top:18px;">
<label>HSN Number</label>
<input type="text" name="hsn_no" placeholder="Enter HSN Number" required>
</div>

<div class="field" style="margin-top:18px;">
<label>Rate Per Box</label>
<input type="number" step="0.01" name="rate" placeholder="Enter Rate" required>
</div>

<button type="submit" class="save-btn" style="margin-top:25px;width:100%;">
<i class="fa fa-save"></i>
Save Product
</button>

</form>

</div>

<!-- RIGHT -->

<div class="form-box">

<div class="table-header">

<h2>
<i class="fa fa-box"></i>
Product List
</h2>

<input
type="text"
id="tableSearch"
placeholder="🔍 Search Product...">

</div>

<form action="../php/delete_multiple_products.php" method="POST">

<button
type="submit"
class="delete-selected-btn"
onclick="return confirm('Delete selected products?')">

<i class="fa fa-trash"></i>

Delete Selected

</button>

<table class="customer-table" id="customerTable">

<thead>

<tr>

<th>
<input type="checkbox" id="selectAll">
</th>

<th>ID</th>
<th>Product Name</th>
<th>HSN No.</th>
<th>Rate</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$sql="SELECT * FROM products ORDER BY id DESC";

$result=$conn->query($sql);

while($row=$result->fetch_assoc())
{

?>

<tr>

<td>

<input
type="checkbox"
class="product-checkbox"
name="selected_ids[]"
value="<?php echo $row['id']; ?>">

</td>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['hsn_no']; ?></td>

<td>₹<?php echo $row['rate']; ?></td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>" class="edit-btn">
<i class="fa fa-edit"></i>
Edit
</a>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</form>

</div>

</div>

</main>

</div>

<script>

document.getElementById("tableSearch").addEventListener("keyup",function(){

let value=this.value.toLowerCase();

document.querySelectorAll("#customerTable tbody tr").forEach(function(row){

row.style.display=row.innerText.toLowerCase().includes(value) ? "" : "none";

});

});

const selectAll=document.getElementById("selectAll");

const checkboxes=document.querySelectorAll(".product-checkbox");

selectAll.addEventListener("change",function(){

checkboxes.forEach(function(box){

box.checked=selectAll.checked;

});

});

function updateClock(){

const now=new Date();

document.getElementById("clock").innerHTML=now.toLocaleTimeString();

}

updateClock();

setInterval(updateClock,1000);

</script>

<script src="theme.js"></script>

</body>
</html>