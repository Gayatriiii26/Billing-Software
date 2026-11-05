<?php
include("db.php");

$id = $_POST['id'];
$product_name = $_POST['product_name'];
$hsn_no = $_POST['hsn_no'];
$rate = $_POST['rate'];

$sql = "UPDATE products
SET
product_name='$product_name',
hsn_no='$hsn_no',
rate='$rate'
WHERE id=$id";

if($conn->query($sql))
{
    header("Location: ../pages/products.php");
    exit();
}
else
{
    echo "Update Failed!";
}
?>