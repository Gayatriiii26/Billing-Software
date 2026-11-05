<?php

include("../php/db.php");

if(isset($_POST['save'])){

    $company_name = $_POST['company_name'];
    $owner_name = $_POST['owner_name'];
    $gst_number = $_POST['gst_number'];
    $phone_number = $_POST['phone_number'];
    $company_address = $_POST['company_address'];

    $igst = $_POST['gst'];
    $cgst = $_POST['cgst'];
    $sgst = $_POST['sgst'];
    $currency = $_POST['currency'];

    $sql = "INSERT INTO settings
    (company_name, owner_name, gst_number, phone_number, company_address,
    igst_percent, cgst_percent, sgst_percent, currency)
    VALUES
    ('$company_name','$owner_name','$gst_number','$phone_number',
    '$company_address','$igst','$cgst','$sgst','$currency')";

    if(mysqli_query($conn,$sql)){
        echo "<script>
        alert('Settings Saved Successfully!');
        window.location='settings.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Settings</title>

<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/settings.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("../sidebar.php"); ?>

<main class="main">

<!-- Heading -->

<div class="welcome-box">

<h1>
<i class="fa-solid fa-gear"></i>
Settings
</h1>

<p>Manage Billing System Configuration</p>

</div>

<!-- Date -->

<div class="info-bar">

<div>
<i class="fa-solid fa-calendar-days"></i>
<b>Date :</b>
<?php echo date("d M Y"); ?>
</div>

<div>
<i class="fa-solid fa-clock"></i>
<b>Time :</b>
<span id="clock"></span>
</div>

</div>

<!-- Company Information -->
 <form method="POST">

<div class="form-box">

<h2>Company Information</h2>

<div class="row">

<div class="field">

<label>Company Name</label>

<input type="text" name="company_name" placeholder="Enter Company Name">

</div>

<div class="field">

<label>Owner Name</label>

<input type="text" name="owner_name" placeholder="Enter Owner Name">

</div>

</div>

<div class="row">

<div class="field">

<label>GST Number</label>

<input type="text" name="gst_number" placeholder="Enter GST Number">

</div>

<div class="field">

<label>Phone Number</label>

<input type="text" name="phone_number" placeholder="Enter Phone Number">

</div>

</div>

<div class="row">

<div class="field full-width">

<label>Company Address</label>

<textarea name="company_address" placeholder="Enter Company Address"></textarea>

</div>

</div>

</div>

<!-- Invoice Settings -->

<div class="form-box">

<h2>Invoice Settings</h2>

<div class="row">

<div class="field">

<label>IGST (%)</label>

<input type="number" name="gst" placeholder="18">

</div>

<div class="field">

<label>CGST (%)</label>

<input type="number" name="cgst" placeholder="9">

</div>

<div class="field">

<label>SGST (%)</label>

<input type="number" name="sgst" placeholder="9">

</div>

<div class="field">

<label>Currency</label>
<input type="text" name="currency" placeholder="₹ INR">

</div>

</div>

</div>

<div style="text-align:right;margin-top:30px;">

<button
type="submit"
name="save"
class="save-btn">

<i class="fa-solid fa-floppy-disk"></i>

Save Settings

</button>

</div>

</form>

</main>

</div>

<script>

function updateClock(){

document.getElementById("clock").innerHTML =
new Date().toLocaleTimeString();

}

setInterval(updateClock,1000);

updateClock();


</script>

</body>
</html>