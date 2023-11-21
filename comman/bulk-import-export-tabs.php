<?php
$pageScriptName = basename($_SERVER['PHP_SELF']);
?>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent5" aria-controls="navbarSupportedContent5" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent5">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'bulk-import-export-product.php') ? 'active' : '' ?>" href="./bulk-import-export-product.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageScriptName == 'bulk-import-export-service.php') ? 'active' : '' ?>" href="./bulk-import-export-service.php">Service</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>