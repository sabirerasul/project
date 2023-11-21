<?php
$pageScriptName = basename($_SERVER['PHP_SELF']);
?>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent4" aria-controls="navbarSupportedContent4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent4">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'history-appointment-report.php') ? 'active' : '' ?>" href="./history-appointment-report.php">Appointment</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'history-billing-report.php') ? 'active' : '' ?>" href="./history-billing-report.php">Billing</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'history-wallet-report.php' || $pageScriptName == 'history-wallet-view-report.php') ? 'active' : '' ?>" href="./history-wallet-report.php">Wallet</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>