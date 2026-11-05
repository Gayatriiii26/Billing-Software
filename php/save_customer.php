<?php

include "db.php";

$name = $_POST['customer_name'];
$address = $_POST['address'];
$gst = $_POST['gst_number'];
$phone = $_POST['phone'];
$vehicle = $_POST['vehicle'];

$sql = "INSERT INTO customers
(customer_name,address,gst_number,phone,vehicle)
VALUES
('$name','$address','$gst','$phone','$vehicle')";

if($conn->query($sql))
{
    echo "<script>
alert('Customer Saved Successfully');
window.location='../pages/customers.php';
</script>";
}
else
{
    echo "Error : ".$conn->error;
}

?>