<?php
include("db.php");

// Get form data
$customer_id = (int)$_POST['customer_id'];

// Convert date to MySQL format (YYYY-MM-DD)
$invoice_date = date("Y-m-d", strtotime($_POST['invoice_date']));

$vehicle_no = $_POST['vehicle_no'];

$product_id = (int)$_POST['product_id'];
$quantity = (float)$_POST['quantity'];
$rate = (float)$_POST['rate'];
$amount = (float)$_POST['amount'];

// Calculate tax
$taxable_value = $amount;
$cgst = $amount * 0.09;
$sgst = $amount * 0.09;
$grand_total = $taxable_value + $cgst + $sgst;

// Save invoice
$sql = "INSERT INTO invoices
(customer_id, invoice_date, vehicle_no, taxable_value, cgst, sgst, grand_total)
VALUES
('$customer_id','$invoice_date','$vehicle_no','$taxable_value','$cgst','$sgst','$grand_total')";

if($conn->query($sql))
{
    $invoice_id = $conn->insert_id;

    $sql2 = "INSERT INTO invoice_items
    (invoice_id, product_id, quantity, rate, amount)
    VALUES
    ('$invoice_id','$product_id','$quantity','$rate','$amount')";

    if($conn->query($sql2))
    {
        echo "<script>
        alert('Invoice Saved Successfully');
        window.location='../pages/invoice.php';
        </script>";
    }
    else
    {
        echo $conn->error;
    }

}
else
{
    echo $conn->error;
}
?>