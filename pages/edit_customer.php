<?php
include("../php/db.php");

$id = $_GET['id'];

$sql = "SELECT * FROM customers WHERE id=$id";

$result = $conn->query($sql);

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Customer</title>

<link rel="stylesheet" href="../css/customers.css">

</head>

<body>

<div class="card">

<h2>Edit Customer</h2>

<form action="../php/update_customer.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<label>Customer Name</label>

<input type="text" name="customer_name"
value="<?php echo $row['customer_name']; ?>">

<label>Address</label>

<textarea name="address"><?php echo $row['address']; ?></textarea>

<label>GST Number</label>

<input type="text"
name="gst_number"
value="<?php echo $row['gst_number']; ?>">

<label>Phone Number</label>

<input type="text"
name="phone"
value="<?php echo $row['phone']; ?>">

<label>Vehicle Number</label>

<input type="text"
name="vehicle"
value="<?php echo $row['vehicle']; ?>">

<button type="submit">Update Customer</button>

</form>

</div>

</body>

</html>