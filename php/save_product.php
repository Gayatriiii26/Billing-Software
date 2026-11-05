<?php

include "db.php";

$product = $_POST["product_name"];
$hsn = $_POST["hsn_no"];
$rate = $_POST["rate"];

$sql = "INSERT INTO products(product_name, hsn_no, rate)
VALUES('$product','$hsn','$rate')";

if($conn->query($sql))
{
    echo "<script>
    alert('Product Saved Successfully');
    window.location='../pages/products.php';
    </script>";
}
else
{
    echo "Error: ".$conn->error;
}

$conn->close();

?>