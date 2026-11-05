<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Invoice</title>

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/invoice.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Flatpickr -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <?php include("../sidebar.php"); ?>

    <!-- Main -->
    <main class="main">

        <!-- Heading -->

        <div class="welcome-box">

            <h1>
                <i class="fa-solid fa-file-invoice"></i>
                New Invoice
            </h1>

            <p>Create Customer Bill Easily.</p>

        </div>

        <!-- Date Time -->

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

        <!-- Invoice Card -->

        <div class="invoice-card">

            <form action="../php/save_invoice.php" method="POST">

                <!-- ================= CUSTOMER ================= -->

                <h2 class="section-title">

                    <i class="fa-solid fa-user"></i>

                    Customer Details

                </h2>

                <div class="row">

                    <div class="field">

                        <label>Customer Name</label>

                        <select name="customer_id"
                            id="customer"
                            required>

                            <option value="">
                                Select Customer
                            </option>

                            <?php

                            include("../php/db.php");

                            $customers =
                                $conn->query("SELECT * FROM customers");

                            while($row=$customers->fetch_assoc())
                            {

                                echo "

                                <option value='".$row['id']."'>
                                    ".$row['customer_name']."
                                </option>

                                ";

                            }

                            ?>

                        </select>

                    </div>

                    <div class="field">

                        <label>

                            Invoice Date

                        </label>

                        <div class="date-wrapper">

                            <input
                                type="text"
                                id="invoice_date"
                                name="invoice_date"
                                placeholder="Select Invoice Date"
                                required>

                            <i class="fa-solid fa-calendar-days calendar-icon"></i>

                        </div>

                    </div>

                    <div class="field">

                        <label>

                            Vehicle Number

                        </label>

                        <input
                            type="text"
                            id="vehicle"
                            name="vehicle_no">

                    </div>

                </div>

                <hr>

                <!-- ================= PRODUCT ================= -->

                <h2 class="section-title">

                    <i class="fa-solid fa-box"></i>

                    Product Details

                </h2>

                <div class="product-card">

                    <div class="row">

                        <div class="field">

                            <label>

                                Product

                            </label>

                            <select
                                name="product_id"
                                id="product">

                                <option value="">
                                    Select Product
                                </option>

                                <?php

                                $products =
                                $conn->query("SELECT * FROM products");

                                while($p=$products->fetch_assoc())
                                {

                                    echo "

                                    <option

                                    value='".$p['id']."'

                                    data-rate='".$p['rate']."'

                                    >

                                    ".$p['product_name']."

                                    </option>

                                    ";

                                }

                                ?>

                            </select>

                        </div>

                        <div class="field">

                            <label>

                                Quantity

                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity">

                        </div>

                        <div class="field">

                            <label>

                                Rate

                            </label>

                            <input
                                type="number"
                                id="rate"
                                name="rate">

                        </div>

                        <div class="field">

                            <label>

                                Total Amount

                            </label>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                readonly>

                        </div>

                    </div>

                </div>

                <!-- ================= SUMMARY ================= -->

                <h2 class="section-title">

                    <i class="fa-solid fa-receipt"></i>

                    Invoice Summary

                </h2>

                <div class="summary-box">

                    <div>

                        <label>

                            Taxable Value

                        </label>

                        <input
                            type="text"
                            id="taxable"
                            placeholder="18% GST"
                            readonly>

                    </div>

                    <div>

                        <label>

                            CGST

                        </label>

                        <input
                            type="text"
                            id="cgst"
                            placeholder="9%"
                            readonly>

                    </div>

                    <div>

                        <label>

                            SGST

                        </label>

                        <input
                            type="text"
                            id="sgst"
                            placeholder="9%"
                            readonly>

                    </div>

                    <div>

                        <label>

                            Grand Total

                        </label>

                        <input
                            type="text"
                            id="grand_total"
                            readonly>

                    </div>

                </div>

                <!-- Save Button -->

                <div class="save-row">

                    <button
                        type="submit"
                        class="save-btn">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Save Invoice

                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

// Beautiful Calendar

document.addEventListener("DOMContentLoaded", function () {

   flatpickr("#invoice_date", {
    dateFormat: "Y-m-d",
    defaultDate: "today",
    disableMobile: true,
    allowInput: false,
    clickOpens: true
});

});


// =======================
// Amount Calculation
// =======================

const qty=document.getElementById("quantity");
const rate=document.getElementById("rate");
const amount=document.getElementById("amount");

const taxable=document.getElementById("taxable");
const cgst=document.getElementById("cgst");
const sgst=document.getElementById("sgst");
const grand=document.getElementById("grand_total");

function calculateTotal(){

    let q=parseFloat(qty.value)||0;
    let r=parseFloat(rate.value)||0;

    let total=q*r;

    let cgstValue=total*0.09;
    let sgstValue=total*0.09;

    let grandTotal=total+cgstValue+sgstValue;

    amount.value=total.toFixed(2);

    taxable.value="₹ "+total.toFixed(2);

    cgst.value="₹ "+cgstValue.toFixed(2);

    sgst.value="₹ "+sgstValue.toFixed(2);

    grand.value="₹ "+grandTotal.toFixed(2);

}

qty.addEventListener("input",calculateTotal);

rate.addEventListener("input",calculateTotal);


// =======================
// Product Rate Auto Fill
// =======================

const product=document.getElementById("product");

product.addEventListener("change",function(){

    let selected=this.options[this.selectedIndex];

    rate.value=selected.dataset.rate||"";

    calculateTotal();

});


// =======================
// Auto Vehicle Number
// =======================

const customer=document.getElementById("customer");

const vehicle=document.getElementById("vehicle");

customer.addEventListener("change",function(){

    if(this.value==""){

        vehicle.value="";

        return;

    }

    fetch("../php/get_customer.php?id="+this.value)

    .then(response=>response.json())

    .then(data=>{

        vehicle.value=data.vehicle;

    })

    .catch(error=>{

        console.log(error);

    });

});


// =======================
// Live Clock
// =======================

function updateClock(){

    let now=new Date();

    document.getElementById("clock").innerHTML=

    now.toLocaleTimeString("en-IN",{

        hour:"2-digit",

        minute:"2-digit",

        second:"2-digit"

    });

}

setInterval(updateClock,1000);

updateClock();

</script>

<script src="theme.js"></script>

</body>
</html>