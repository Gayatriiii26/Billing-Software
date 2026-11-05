<?php
session_start();

include("db.php");

$current = mysqli_real_escape_string($conn, $_POST['current_password']);
$new = mysqli_real_escape_string($conn, $_POST['new_password']);
$confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

// Get current password
$result = $conn->query("SELECT password FROM admin WHERE id=1");
$row = $result->fetch_assoc();

// Check current password
if($current != $row['password'])
{
    header("Location: ../pages/profile.php?msg=wrong");
    exit();
}

// Check new and confirm password
if($new != $confirm)
{
    header("Location: ../pages/profile.php?msg=notmatch");
    exit();
}

// Update password
$sql = "UPDATE admin SET password='$new' WHERE id=1";

if($conn->query($sql))
{
    header("Location: ../pages/profile.php?msg=success");
}
else
{
    header("Location: ../pages/profile.php?msg=error");
}

exit();
?>