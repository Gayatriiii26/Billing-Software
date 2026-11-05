<?php
include("../php/db.php");

$result = $conn->query("SELECT * FROM admin LIMIT 1");
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/profile.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("../sidebar.php"); ?>

<main class="main">

<div class="welcome-box">
<h1>
<i class="fa-solid fa-user"></i>
My Profile
</h1>
<p>Manage Login Details</p>
</div>


<?php

if(isset($_GET['success']))
{
echo "<div class='success-msg'>Profile Updated Successfully.</div>";
}

if(isset($_GET['msg']))
{
    if($_GET['msg']=="success")
    {
        echo "<div class='success-msg'>Password Updated Successfully.</div>";
    }

    if($_GET['msg']=="wrong")
    {
        echo "<div class='error-msg'>Current Password is Wrong.</div>";
    }

    if($_GET['msg']=="notmatch")
    {
        echo "<div class='error-msg'>New Password & Confirm Password do not match.</div>";
    }
}



?>


<div class="profile-top">

<div class="profile-avatar">
<i class="fa-solid fa-user"></i>
</div>

<div class="profile-info">
<h2>Administrator Profile</h2>
<p>Manage your login details and account security.</p>
</div>

</div>



<div class="profile-grid">

<!-- LEFT CARD -->

<div class="profile-box">

<h3>
<i class="fa-solid fa-user-gear"></i>
Profile Details
</h3>

<form action="../php/update_profile.php" method="POST">

<div class="input-group">
<label>Mobile Number</label>

<input
type="text"
name="mobile"
value="<?php echo $admin['mobile']; ?>"
required>

</div>


<div class="input-group">

<label>Username</label>

<input
type="text"
name="username"
value="<?php echo $admin['username']; ?>"
required>

</div>

<div class="input-group">

<label>Password</label>

<div class="password-box">

<div class="password-box">

<input
type="password"
id="profilePassword"
name="password"
placeholder="Enter Password"
required>

<i class="fa-solid fa-eye"
onclick="togglePassword('profilePassword',this)"></i>

</div>

<i class="fa-solid fa-eye"
onclick="togglePassword('profile_password',this)"></i>

</div>

</div>

<button class="save-btn">

<i class="fa-solid fa-floppy-disk"></i>

Save Changes

</button>

</form>

</div>



<!-- RIGHT CARD -->

<div class="profile-box">

<h3>

<i class="fa-solid fa-lock"></i>

Change Password

</h3>

<form action="../php/change_password.php" method="POST">

<div class="input-group">

<label>Current Password</label>

<div class="password-box">

<input
type="password"
id="currentPassword"
name="current_password"
required>

<i class="fa-solid fa-eye"
onclick="togglePassword('currentPassword',this)"></i>

</div>

</div>


<div class="input-group">

<label>New Password</label>

<div class="password-box">

<input
type="password"
id="newPassword"
name="new_password"
required>

<i class="fa-solid fa-eye"
onclick="togglePassword('newPassword',this)"></i>

</div>

</div>


<div class="input-group">

<label>Confirm Password</label>

<div class="password-box">

<input
type="password"
id="confirmPassword"
name="confirm_password"
required>

<i class="fa-solid fa-eye"
onclick="togglePassword('confirmPassword',this)"></i>

</div>

</div>

<button class="save-btn">

<i class="fa-solid fa-key"></i>

Update Password

</button>

</form>

</div>


</div>

</main>

</div>

<script>

function togglePassword(id,icon){

let input=document.getElementById(id);

if(input.type==="password"){

input.type="text";

icon.classList.remove("fa-eye");
icon.classList.add("fa-eye-slash");

}
else{

input.type="password";

icon.classList.remove("fa-eye-slash");
icon.classList.add("fa-eye");

}

}

</script>

</body>
</html>