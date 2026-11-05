<?php

include("db.php");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM customers WHERE id='$id'");

$row = $result->fetch_assoc();

echo json_encode($row);

?>