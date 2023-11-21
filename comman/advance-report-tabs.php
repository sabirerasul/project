<?php
$pageScriptName = basename($_SERVER['PHP_SELF']);
?>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent10" aria-controls="navbarSupportedContent10" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent10">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-nowrap flex-wrap">
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-report.php') ? 'active' : '' ?>" href="./advance-report.php">Reports</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-sale-report.php') ? 'active' : '' ?>" href="./advance-sale-report.php">Sales Report</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-employee-report.php') ? 'active' : '' ?>" href="./advance-employee-report.php">Employee</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-job-card-report.php') ? 'active' : '' ?>" href="./advance-job-card-report.php">Job Card</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-collection-report.php') ? 'active' : '' ?>" href="./advance-collection-report.php">Collection</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-expense-report.php') ? 'active' : '' ?>" href="./advance-expense-report.php" >Expense</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-gst-report.php') ? 'active' : '' ?>" href="./advance-gst-report.php" >GST Report</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-service-sale-report.php') ? 'active' : '' ?>" href="./advance-service-sale-report.php" >Service Sales</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-product-purchase-report.php') ? 'active' : '' ?>" href="./advance-product-purchase-report.php" >Product Purchase</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-product-sale-report.php') ? 'active' : '' ?>" href="./advance-product-sale-report.php" >Product Sales</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-product-usage-report.php') ? 'active' : '' ?>" href="./advance-product-usage-report.php" >Product Usage</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-membership-report.php') ? 'active' : '' ?>" href="./advance-membership-report.php" >Membership</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-upsell-report.php') ? 'active' : '' ?>" href="./advance-upsell-report.php" >Upsell</a>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'advance-wallet-report.php') ? 'active' : '' ?>" href="./advance-wallet-report.php">Wallet Recharge</a>
                </ul>
            </div>
        </div>
    </nav>
</div>