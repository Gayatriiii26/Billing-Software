<?php

include("db.php");

if(isset($_POST['selected_ids'])){

$ids = array_map('intval', $_POST['selected_ids']);

$idList = implode(",", $ids);

$sql = "DELETE FROM customers WHERE id IN ($idList)";

mysqli_query($conn,$sql);

}

header("Location: ../pages/customers.php");

exit();

?>