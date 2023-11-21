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
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'sms-panel.php') ? 'active' : '' ?>" href="./sms-panel.php">SMS Panel</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'sms-panel-history.php') ? 'active' : '' ?>" href="./sms-panel-history.php">SMS Panel History</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'sms-message.php') ? 'active' : '' ?>" href="./sms-message.php">Message</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'sms-template.php') ? 'active' : '' ?>" href="./sms-template.php">Template</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>