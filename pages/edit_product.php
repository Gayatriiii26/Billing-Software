<?php
include("../php/db.php");

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Product</title>

<link rel="stylesheet" href="../css/customers.css">

</head>

<body>

<div class="form-card">

<h2>Edit Product</h2>

<form action="../php/update_product.php" method="POST">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

<label>Product Name</label>

<input type="text"
name="product_name"
value="<?php echo $row['product_name']; ?>"
required>

<label>HSN Number</label>

<input type="text"
name="hsn_no"
value="<?php echo $row['hsn_no']; ?>"
required>

<label>Rate</label>

<input type="number"
step="0.01"
name="rate"
value="<?php echo $row['rate']; ?>"
required>

<button class="save-btn">
Update Product
</button>

</form>

</div>

</body>
</html>
