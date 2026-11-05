<?php
session_start();

include("db.php");

// Get form data
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
$username = mysqli_real_escape_string($conn, $_POST['username']);

// Update only Mobile & Username
$sql = "UPDATE admin SET
mobile='$mobile',
username='$username'
WHERE id=1";

if($conn->query($sql))
{
    // Update session values
    $_SESSION['admin'] = $mobile;
    $_SESSION['admin_mobile'] = $mobile;
    $_SESSION['admin_username'] = $username;

    header("Location: ../pages/profile.php?success=1");
}
else
{
    header("Location: ../pages/profile.php?error=1");
}

exit();
?>