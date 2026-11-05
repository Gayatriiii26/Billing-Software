<?php
include("../php/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Customers</title>

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

.customer-checkbox,
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
<i class="fa-solid fa-users"></i>
Customers
</h1>

<p>Manage Customers Easily.</p>

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

<div class="customer-wrapper">

<div class="customer-form-box">

<h2>Add Customer</h2>

<form action="../php/save_customer.php" method="POST">

<label>Customer Name</label>
<input type="text" name="customer_name" placeholder="Enter customer name" required>

<label>Address</label>
<textarea name="address" rows="4" placeholder="Enter address"></textarea>

<label>GST Number</label>
<input type="text" name="gst_number" placeholder="Enter GST number">

<label>Phone Number</label>
<input type="text" name="phone" placeholder="Enter phone number">

<label>Vehicle Number</label>
<input type="text" name="vehicle" placeholder="Enter vehicle number">

<button type="submit">
<i class="fa fa-save"></i>
Save Customer
</button>

</form>

</div>

<div class="customer-table-box">

<div class="table-header">

<h2>Customer List</h2>

<input
type="text"
id="search"
placeholder="Search customer...">

</div>

<form action="../php/delete_multiple_customers.php" method="POST">

<button
type="submit"
class="delete-selected-btn"
onclick="return confirm('Delete selected customers?')">

<i class="fa fa-trash"></i>

Delete Selected

</button>

<table id="customerTable">

<thead>

<tr>

<th>
<input type="checkbox" id="selectAll">
</th>

<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>GST</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$sql="SELECT * FROM customers ORDER BY id DESC";

$result=$conn->query($sql);

while($row=$result->fetch_assoc())
{

?>

<tr>

<td>

<input
type="checkbox"
class="customer-checkbox"
name="selected_ids[]"
value="<?php echo $row['id']; ?>">

</td>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['customer_name']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['gst_number']; ?></td>

<td>

<a href="edit_customer.php?id=<?php echo $row['id']; ?>" class="edit-btn">
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

document.getElementById("search").addEventListener("keyup",function(){

let value=this.value.toLowerCase();

let rows=document.querySelectorAll("#customerTable tbody tr");

rows.forEach(function(row){

row.style.display=row.innerText.toLowerCase().includes(value)?"":"none";

});

});

</script>

<script>

const selectAll=document.getElementById("selectAll");

const checkboxes=document.querySelectorAll(".customer-checkbox");

selectAll.addEventListener("change",function(){

checkboxes.forEach(function(box){

box.checked=selectAll.checked;

});

});

</script>

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