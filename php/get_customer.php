<?php

include("db.php");

$id = $_GET['id'];

$sql = "SELECT * FROM customers WHERE id='$id'";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

echo json_encode($row);

?>