<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<aside class="sidebar" id="sidebar">

    <div class="logo">
        <img src="/tiles-billing-system/images/logo.png" alt="Shree Tiles">
        <h2>Billing System</h2>
    </div>

    <ul>

        <li>
            <a href="/tiles-billing-system/index.php">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/customers.php">
                <i class="fa-solid fa-users"></i>
                <span>Customers</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/products.php">
                <i class="fa-solid fa-box"></i>
                <span>Products</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/invoice.php">
                <i class="fa-solid fa-file-invoice"></i>
                <span>New Invoice</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/history.php">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Invoice History</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/reports.php">
                <i class="fa-solid fa-chart-column"></i>
                <span>Reports</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/pages/settings.php">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>

        <li>
            <a href="/tiles-billing-system/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

    <a href="/tiles-billing-system/pages/profile.php" class="admin-box">

        <div class="admin-image">
            <i class="fa-solid fa-user"></i>
        </div>

        <div>

            <h4>Welcome</h4>

            <p>

                <?php
                echo isset($_SESSION['admin_username'])
                    ? $_SESSION['admin_username']
                    : 'Admin';
                ?>

            </p>

        </div>

    </a>

</aside>