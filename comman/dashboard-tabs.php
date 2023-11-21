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
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'index-sale.php') ? 'active' : '' ?>" href="./index-sale.php">Sale</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'index-appointment.php') ? 'active' : '' ?>" href="./index-appointment.php">Appointment</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'index-enquiry.php') ? 'active' : '' ?>" href="./index-enquiry.php">Enquiry</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'index-visit.php') ? 'active' : '' ?>" href="./index-visit.php">Visit</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>