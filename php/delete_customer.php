<?php
include("db.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM customers WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: ../pages/customers.php");
        exit();
    } else {
        echo "Error deleting customer.";
    }
}
?>