<?php
include("db.php");

$id = $_POST['id'];
$name = $_POST['customer_name'];
$address = $_POST['address'];
$gst = $_POST['gst_number'];
$phone = $_POST['phone'];
$vehicle = $_POST['vehicle'];

$sql = "UPDATE customers
SET
customer_name='$name',
address='$address',
gst_number='$gst',
phone='$phone',
vehicle='$vehicle'
WHERE id=$id";

if($conn->query($sql))
{
    header("Location: ../pages/customers.php");
}
else
{
    echo "Update Failed";
}
?>