<?php
$pageScriptName = basename($_SERVER['PHP_SELF']);
?>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-package-expiry.php') ? 'active' : '' ?>" href="./notification-package-expiry.php">Package Notification</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-stock-expiry.php') ? 'active' : '' ?>" href="./notification-stock-expiry.php">Stock Notification</a></li>

                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-birthday-anniversary.php') ? 'active' : '' ?>" href="./notification-birthday-anniversary.php">Birthday & Anniversary</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-enquiry-followup.php') ? 'active' : '' ?>" href="./notification-enquiry-followup.php">Enquiry followup</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-pending-payment.php') ? 'active' : '' ?>" href="./notification-pending-payment.php">Pending Payment</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-product-low-stock.php') ? 'active' : '' ?>" href="./notification-product-low-stock.php">Product Low Stock</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-irregular-client.php') ? 'active' : '' ?>" href="./notification-irregular-client.php">Irregular Client</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'notification-client-followup.php') ? 'active' : '' ?>" href="./notification-client-followup.php">Client Followup</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>