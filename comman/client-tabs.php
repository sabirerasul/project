<?php
$pageScriptName = basename($_SERVER['PHP_SELF']);
$clientId = $_REQUEST['id'];
?>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-profile.php') ? 'active' : '' ?>" href="./client-profile.php?id=<?= $clientId ?>">Profile</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-appointment.php') ? 'active' : '' ?>" href="./client-appointment.php?id=<?= $clientId ?>">Appointment</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-billing.php') ? 'active' : '' ?>" href="./client-billing.php?id=<?= $clientId ?>">Billing</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-reward.php') ? 'active' : '' ?>" href="./client-reward.php?id=<?= $clientId ?>">Reward Point</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-payment.php') ? 'active' : '' ?>" href="./client-payment.php?id=<?= $clientId ?>">Payment</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-package.php') ? 'active' : '' ?>" href="./client-package.php?id=<?= $clientId ?>">Package</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-membership.php') ? 'active' : '' ?>" href="./client-membership.php?id=<?= $clientId ?>">Membership</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-wallet.php') ? 'active' : '' ?>" href="./client-wallet.php?id=<?= $clientId ?>">Wallet</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-feedback.php') ? 'active' : '' ?>" href="./client-feedback.php?id=<?= $clientId ?>">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'client-followup.php') ? 'active' : '' ?>" href="./client-followup.php?id=<?= $clientId ?>">Followup</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>