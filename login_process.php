<?php
session_start();

include("php/db.php");

if (!isset($_POST['mobile']) || !isset($_POST['password'])) {
    header("Location: login.php");
    exit();
}

$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM admin WHERE mobile='$mobile' AND password='$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0)
{
    $admin = mysqli_fetch_assoc($result);

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_mobile'] = $admin['mobile'];
    $_SESSION['admin_username'] = $admin['username'];

    header("Location: index.php");
    exit();
}
else
{
    header("Location: login.php?error=1");
    exit();
}
?>