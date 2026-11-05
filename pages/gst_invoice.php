<?php
include("../php/db.php");

if(!isset($_GET['id'])){
    die("Invoice not found");
}

$id = (int)$_GET['id'];

$invoice = $conn->query("
SELECT
    invoices.*,
    invoices.id AS invoice_id,
    customers.*
FROM invoices
INNER JOIN customers
ON invoices.customer_id = customers.id
WHERE invoices.id = $id
")->fetch_assoc();

$items = $conn->query("
SELECT invoice_items.*,products.product_name,products.hsn_no
FROM invoice_items
INNER JOIN products
ON invoice_items.product_id=products.id
WHERE invoice_items.invoice_id=$id
");

function numberToWords($number)
{
    $no = floor($number);
    $point = round(($number - $no) * 100);

    $words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three',
        4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen',
        15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty',
        30 => 'Thirty', 40 => 'Forty',
        50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty',
        90 => 'Ninety'
    );

    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

    $str = array();

    while ($no > 0) {

        if (count($str) == 1)
            $divider = 10;
        else
            $divider = 100;

        $numberPart = $no % $divider;
        $no = floor($no / $divider);

        if ($numberPart) {

            if ($numberPart < 21)
                $text = $words[$numberPart];
            else
                $text = $words[floor($numberPart / 10) * 10] . " " . $words[$numberPart % 10];

            if (count($str) == 0)
                $str[] = $text;
            else
                $str[] = $text . " " . $digits[count($str)];
        }
    }

    $rupees = implode(' ', array_reverse($str));

    $paise = "";

    if ($point > 0) {

        if ($point < 21)
            $paise = $words[$point];
        else
            $paise = $words[floor($point / 10) * 10] . " " . $words[$point % 10];

        $paise .= " Paise";
    }

    return trim($rupees) . " Rupees" .
        ($paise ? " and " . $paise : "") .
        " Only";
}

?>
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>GST Invoice</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{
background:#eee;
padding:20px;
}

.invoice{
width:820px;
margin:auto;
background:#fff;
border:1px solid #000;
}
table{
width:100%;
border-collapse:collapse;
}

td,th{
border:1px solid #000;
padding:4px;
vertical-align:middle;
font-size:13px;
}

.company{
text-align:center;
}

.company h1{
font-size:44px;
letter-spacing:2px;
}

.company p{
font-size:12px;
line-height:1.2;
margin-top:4px;
}

.company h2{
font-size:18px;
font-weight:bold;
margin-top:5px;
}

.right{
width:260px;
text-align:right;
font-size:18px;
font-weight:bold;
}

.tax{
    width:220px;
    height:140px;
    background:#fff;
    color:#000;
    font-size:20px;
    font-weight:bold;
    text-align:center;
    vertical-align:middle;
    padding:0;
}

@page{
    size: A4;
    margin:8mm;
}

@media print{

button{
display:none;
}

}

body{
background:white;
padding:0;
}

.invoice{
width:190mm;
margin:0 auto;
border:none;
}

button{
display:none;
}

.invoice{
border:none;
}

body{
margin:0;
padding:0;


}

</style>

</head>

<body>

<?php if(!isset($pdfMode)){ ?>

<div style="
width:820px;
margin:15px auto;
display:flex;
justify-content:space-between;
align-items:center;
">

<a href="history.php"
style="
background:#2563eb;
color:#fff;
padding:10px 22px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
">
← Back
</a>

<a href="#"
onclick="window.print();return false;"
style="
background:#16a34a;
color:#fff;
padding:10px 22px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
">
🖨 Print Invoice
</a>
</div>

<?php } ?>

<div class="invoice">

<table>

<tr>

<td class="tax">
    <div style="
        height:170px;
        display:flex;
        justify-content:center;
        align-items:center;
    ">
        TAX - INVOICE
    </div>
</td>

<td class="company" colspan="2">

<img src="../images/ST_Logo.png" width="110" alt="Company Logo">

<p>
Gat No.115/A, Momin Mal,
At & Post - Vathar Tarf Vadgaon,
<br>
Near Shri Vasant Indian Oil Petrol Pump,
Tal-Hatkanangale,

Dist-Kolhapur - 416112
</p>

<h2>GST No. 27DJQPG1790H1ZU</h2>

</td>

<td
style="
width:215px;
padding:0;
text-align:center;
vertical-align:middle;
"
>

<div
style="
height:110px;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
gap:12px;
font-size:17px;
font-weight:bold;
">

<div>
Subject to Kolhapur
<br>
Jurisdiction
</div>

<div>
Mob. 9637924687
</div>

</div>

</td>

</tr>

</table>

<table style="margin-top:-1px;font-size:17px;">

<tr>

<td style="width:70%;padding:15px;">

<b>Name :</b>
&nbsp;
<?php echo $invoice['customer_name']; ?>

</td>

<td style="width:30%;padding:15px;">

<b>Invoice No :</b>
&nbsp;
<?php echo $invoice['invoice_id']; ?>

</td>

</tr>

<tr>

<td style="padding:12px;">

<b>Address :</b>
&nbsp;
<?php echo $invoice['address']; ?>

</td>

<td style="padding:12px;">

<b>Invoice Date :</b>
&nbsp;
<?php echo date("d-m-Y",strtotime($invoice['invoice_date'])); ?>

</td>

</tr>

<tr>

<td style="padding:12px;">

<table style="width:100%;border:none;border-collapse:collapse;">

<tr>

<td style="border:none;width:60%;padding:0;">

<b>GSTIN :</b>
&nbsp;
<?php echo $invoice['gst_number']; ?>

</td>

<td style="border:none;width:40%;text-align:right;padding:0;">

<b>State Code :</b>
27

</td>

</tr>

</table>

</td>

<td style="padding:12px;">

<b>Vehicle No :</b>
&nbsp;
<?php echo $invoice['vehicle_no']; ?>

</td>

</tr>

</table>

<table style="width:100%; border-collapse:collapse;">

<tr style="background:#f2f2f2;font-weight:bold;text-align:center;">

<th style="width:8%;">Sr.</th>

<th style="width:42%;">PRODUCT NAME</th>

<th style="width:10%;">HSN NO</th>

<th style="width:10%;">Qty./BOX</th>

<th style="width:10%;">RATE</th>

<th style="width:20%;">TOTAL AMOUNT</th>

</tr>

<?php
$sr = 1;
$rowCount = 0;

while($row = mysqli_fetch_assoc($items))
{
$rowCount++;
?>

<tr>

<td style="width:8%; text-align:center; vertical-align:top;">
    <?php echo $sr++; ?>
</td>

<td style="
width:42%;
text-align:left;
padding:8px;
vertical-align:top;
white-space:normal;
word-break:break-word;
line-height:1.5;
">
    <?php echo htmlspecialchars($row['product_name']); ?>
</td>
<td style="width:10%; text-align:center; vertical-align:top;">
    <?php echo $row['hsn_no']; ?>
</td>

<td style="width:10%; text-align:center; vertical-align:top;">
    <?php echo $row['quantity']; ?>
</td>

<td style="width:10%; text-align:right; padding-right:8px; vertical-align:top;">
    <?php echo number_format($row['rate'],2); ?>
</td>

<td style="width:20%; text-align:right; padding-right:8px; vertical-align:top;">
    <?php echo number_format($row['amount'],2); ?>
</td>

</tr>
<?php } ?>



<?php

?>

</table>


<table style="width:100%;border-collapse:collapse;margin-top:-1px;table-layout:fixed;">

<tr>

<!-- LEFT + RIGHT -->
<td style="
width:70%;
padding:0;
vertical-align:top;
border:none;
">
<table style="
width:100%;
border-collapse:collapse;
border-right:none;
">

<tr style="height:55px;">
<td style="width:170px;font-weight:bold;padding:10px;">
Amount in Words
</td>

<td style="padding:10px;font-weight:bold;">
: <?php echo numberToWords($invoice['grand_total']); ?>
</td>
</tr>

<tr style="height:55px;">
<td colspan="2" style="font-size:22px;font-weight:bold;text-align:center;">
BANK DETAILS
</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;"><b>Bank</b></td>
<td style="padding:10px;"> Bank Of Maharashtra, Ghunki</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;"><b>A/C No.</b></td>
<td style="padding:10px;"> 60558909321</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;"><b>IFSC</b></td>
<td style="padding:10px;"> MAHB0000295</td>
</tr>

<tr style="height:80px;">
<td colspan="2" style="vertical-align:bottom;padding:12px;font-weight:bold;">
Receiver Signature
</td>
</tr>

</table>

</td>

<td style="
width:30%;
padding:0;
vertical-align:top;
border:none;
">

<table style="
width:100%;
border-collapse:collapse;
border:none;
">

<tr style="height:55px;">
<td style="padding:10px;font-weight:bold;">
Taxable Value
</td>
<td style="padding:10px;text-align:right;font-weight:bold;">
<?php echo number_format($invoice['taxable_value'],2); ?>
</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;">Add : @CGST %</td>
<td style="padding:10px;text-align:right;">
<?php echo number_format($invoice['cgst'],2); ?>
</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;">Add : @SGST %</td>
<td style="padding:10px;text-align:right;">
<?php echo number_format($invoice['sgst'],2); ?>
</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;">Add : @IGST %</td>
<td style="padding:10px;text-align:right;">0.00</td>
</tr>

<tr style="height:55px;">
<td style="padding:10px;font-weight:bold;font-size:18px;">
Grand Total
</td>

<td style="padding:10px;text-align:right;font-weight:bold;font-size:18px;">
<?php echo number_format($invoice['grand_total'],2); ?>
</td>
</tr>

<tr style="height:80px;">
<td colspan="2" style="text-align:center;vertical-align:bottom;">
<div style="margin-bottom:20px;font-weight:bold;">
For SHREE TILES
</div>
<b>Proprietor</b>
</td>
</tr>

</table>

</td>

</tr>

</table>

<div style="text-align:center; margin:20px 0;">
    <button
        type="button"
        onclick="window.print()"
        style="
            background:#16a34a;
            color:#fff;
            padding:12px 28px;
            border:none;
            border-radius:6px;
            font-size:16px;
            cursor:pointer;
            position:relative;
            z-index:9999;
        ">
        🖨 Print Invoice
    </button>
</div>



</body>
</html>