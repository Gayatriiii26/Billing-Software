<?php
session_start();

// Destroy any previous session
session_unset();
session_destroy();

// Start a fresh session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    position:relative;
}

/* Background */

body::before{
    content:"";
    position:fixed;
    inset:0;

    background:
    linear-gradient(rgba(0,0,0,.45),rgba(0,0,0,.45)),
    url("images/login-bg.png");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    filter:blur(4px);
    transform:scale(1.08);

    z-index:-2;
}

body::after{
    content:"";
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.15);
    z-index:-1;
}

/* Login Card */

.login-box{

    width:430px;

    background:rgba(20,20,20,.42);

    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.25);

    border-radius:25px;

    padding:40px;

    box-shadow:
    0 20px 60px rgba(0,0,0,.45);

    animation:popup .7s ease;

    transition:.35s;
}

.login-box:hover{

    transform:translateY(-6px);

    box-shadow:
    0 30px 70px rgba(0,0,0,.55);

}

/* Animation */

@keyframes popup{

from{

opacity:0;
transform:translateY(40px) scale(.94);

}

to{

opacity:1;
transform:translateY(0) scale(1);

}

}

/* Logo */

.logo{

text-align:center;
margin-bottom:25px;

}

.logo img{

width:120px;
margin-bottom:10px;

}

.logo h1{

color:#fff;
font-size:38px;
letter-spacing:1px;

}

.logo p{

color:#ddd;
font-size:15px;

}

/* Fields */

.field{

margin-top:20px;

}

.field label{

display:block;
margin-bottom:8px;
font-weight:600;
color:#fff;

}

/* Input Wrapper */

.input-box{

position:relative;

}

.input-box i{

position:absolute;

right:18px;

top:50%;

transform:translateY(-50%);

color:#ddd;

font-size:17px;

cursor:pointer;

transition:.3s;

}

.input-box i:hover{

color:#fff;

}

/* Inputs */

input{

width:100%;

padding:15px 48px 15px 18px;

border-radius:12px;

border:1px solid rgba(255,255,255,.25);

background:rgba(255,255,255,.15);

color:#fff;

font-size:15px;

outline:none;

transition:.35s;

}

input::placeholder{

color:#ddd;

}

input:focus{

border-color:#3b82f6;

background:rgba(255,255,255,.22);

box-shadow:0 0 18px rgba(59,130,246,.35);

}

.password-box{
    position:relative;
}

.password-box input{
    padding-right:50px;
}

.password-box i{
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    color:#fff;
    cursor:pointer;
    font-size:18px;
    transition:.3s;
}

.password-box i:hover{
    color:#60a5fa;
}
input::-ms-reveal,
input::-ms-clear{
    display:none;
}

input[type="password"]::-webkit-credentials-auto-fill-button{
    visibility:hidden;
    display:none !important;
}

/* Button */

button{

width:100%;

margin-top:28px;

padding:15px;

border:none;

border-radius:14px;

background:linear-gradient(135deg,#2563eb,#4f46e5);

color:white;

font-size:17px;

font-weight:600;

cursor:pointer;

transition:.35s;

}

button:hover{

transform:translateY(-3px);

box-shadow:0 15px 30px rgba(37,99,235,.45);

}

button:active{

transform:scale(.98);

}

/* Error */

.error{

margin-top:15px;

background:#ff4d4d;

color:#fff;

padding:12px;

border-radius:10px;

text-align:center;

font-weight:600;

}

/* Responsive */

@media(max-width:500px){

.login-box{

width:92%;
padding:28px;

}

.logo img{

width:90px;

}

.logo h1{

font-size:30px;

}

}
</style>

</head>

<body>

<div class="login-box">

<div class="logo">

<img src="images/logo.png" class="logo-img">

<h1>SHREE TILES</h1>

<p>Billing Management System</p>

</div>

<form action="login_process.php" method="POST">
<div class="field">
    <label>Mobile Number</label>

    <div class="input-box">
        <input type="text" name="mobile" placeholder="Enter Mobile Number">
        <i class="fa-solid fa-phone"></i>
    </div>
</div>

<div class="field">
    <label>Password</label>

    <div class="password-box">
    <input
        type="password"
        name="password"
        id="password"
        placeholder="Enter Password"
        autocomplete="new-password"
        required>

    <i class="fa-solid fa-eye" id="togglePassword" onclick="togglePassword()"></i>
</div>
</div>

<button type="submit">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

<?php

if(isset($_GET['error']))
{
echo "<div class='error'>Invalid Mobile Number or Password</div>";
}

?>

</form>

</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("togglePassword");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
</body>
</html>