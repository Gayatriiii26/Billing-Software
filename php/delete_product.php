<?php
include("db.php");

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id=$id";

    if($conn->query($sql))
    {
        header("Location: ../pages/products.php");
        exit();
    }
    else
    {
        echo "Delete Failed!";
    }
}
?>