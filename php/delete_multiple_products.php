<?php

include("db.php");

if(isset($_POST['selected_ids'])){

    $ids = array_map('intval', $_POST['selected_ids']);

    if(count($ids) > 0){

        $idList = implode(",", $ids);

        mysqli_query($conn, "DELETE FROM products WHERE id IN ($idList)");

    }

}

header("Location: ../pages/products.php");
exit();

?>