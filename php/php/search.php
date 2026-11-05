<?php
include("../db.php");

if(isset($_GET['search'])){

    $search = $conn->real_escape_string($_GET['search']);

    // Search Customers
    $customer = $conn->query("
    SELECT
id,
customer_name AS title,
phone,
gst_number,
CONCAT('pages/customer_details.php?id=',id) AS page,
'Customer' AS type
FROM customers
WHERE customer_name LIKE '%$search%'
    ");

    // Search Products
    $product = $conn->query("
    SELECT product_name AS title,
           'Product' AS type,
           'pages/products.php' AS page
    FROM products
    WHERE product_name LIKE '%$search%'
    ");

    // Search Invoices
    $invoice = $conn->query("
    SELECT CONCAT('Invoice #', id) AS title,
           'Invoice' AS type,
           'pages/history.php' AS page
    FROM invoices
    WHERE id LIKE '%$search%'
    ");

    while($row = $customer->fetch_assoc()){

    echo "
    <a href='{$row['page']}' class='search-item'>

        <b>👤 {$row['title']}</b><br>

        <small>Phone : {$row['phone']}</small><br>

        <small>GST : {$row['gst_number']}</small>

    </a>
    ";
}

    while($row = $product->fetch_assoc()){
        echo "<a href='{$row['page']}' class='search-item'>
                <b>{$row['title']}</b><br>
                <small>{$row['type']}</small>
              </a>";
    }

    while($row = $invoice->fetch_assoc()){
        echo "<a href='{$row['page']}' class='search-item'>
                <b>{$row['title']}</b><br>
                <small>{$row['type']}</small>
              </a>";
    }

}
?>