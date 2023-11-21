<?php
$pageName = basename($_SERVER['PHP_SELF']);

$menuAddManageArr = [
    'expense.php' => 'expense.php',
    'service.php' => 'service.php',
    'package.php' => 'package.php',
    'coupon.php' => 'coupon.php',
    'employee-salary.php' => 'employee-salary.php',
    'service-provider.php' => 'service-provider.php',
    'service-reminder.php' => 'service-reminder.php',
    'staff.php' => 'staff.php',
    'membership.php' => 'membership.php',
    'all-branch.php' => 'all-branch.php',
    'transfer-option.php' => 'transfer-option.php',
    'software-setting-super-admin.php' => 'software-setting-super-admin.php',
    'software-setting.php' => 'software-setting.php',
    'self-assessment-data.php' => 'self-assessment-data.php',
    'mark-attendance.php' => 'mark-attendance.php',
    'gst-slab.php' => 'gst-slab.php',
    'sms-panel.php' => 'sms-panel.php',
    'sms-tempate.php' => 'sms-template.php',
    'sms-message.php' => 'sms-message.php',
    'sms-panel-history' => 'sms-panel-history',
    'sms-template.php' => 'sms-template.php',
    'sms-panel-history.php' => 'sms-panel-history.php',
    'bulk-import-export-product.php' => 'bulk-import-export-product.php',
    'bulk-import-export-service.php' => 'bulk-import-export-service.php'
];

$menuReportArr = [
    'daily-report.php' => 'daily-report.php',
    'day-summary-report.php' => 'day-summary-report.php',
    'billing-report.php' => 'billing-report.php',
    'enquiry-report.php' => 'enquiry-report.php',
    'service-provider-report.php' => 'service-provider-report.php',
    'receive-pending-payment-report.php' => 'receive-pending-payment-report.php',
    'received-pending-payment.php' => 'received-pending-payment.php',
    'history-appointment-report.php' => 'history-appointment-report.php',
    'history-billing-report.php' => 'history-billing-report.php',
    'history-wallet-report.php' => 'history-wallet-report.php',
    'history-wallet-view-report.php' => 'history-wallet-view-report.php',
    'balance-report.php' => 'balance-report.php',
    'advance-report.php' => 'advance-report.php',
    'attendance-report.php' => 'attendance-report.php',
    'advance-report.php' => 'advance-report.php',
    'advance-sale-report.php' => 'advance-sale-report.php',
    'advance-employee-report.php' => 'advance-employee-report.php',
    'advance-job-card-report.php' => 'advance-job-card-report.php',
    'advance-collection-report.php' => 'advance-collection-report.php',
    'advance-expense-report.php' => 'advance-expense-report.php',
    'advance-gst-report.php' => 'advance-gst-report.php',
    'advance-service-sale-report.php' => 'advance-service-sale-report.php',
    'advance-product-purchase-report.php' => 'advance-product-purchase-report.php',
    'advance-product-sale-report.php' => 'advance-product-sale-report.php',
    'advance-product-usage-report.php' => 'advance-product-usage-report.php',
    'advance-membership-report.php' => 'advance-membership-report.php',
    'advance-upsell-report.php' => 'advance-upsell-report.php',
    'advance-wallet-report.php' => 'advance-wallet-report.php',
];

$menuAdvanceReportArr = [
    'advance-report.php' => 'advance-report.php',
    'advance-sale-report.php' => 'advance-sale-report.php',
    'advance-employee-report.php' => 'advance-employee-report.php',
    'advance-job-card-report.php' => 'advance-job-card-report.php',
    'advance-collection-report.php' => 'advance-collection-report.php',
    'advance-expense-report.php' => 'advance-expense-report.php',
    'advance-gst-report.php' => 'advance-gst-report.php',
    'advance-service-sale-report.php' => 'advance-service-sale-report.php',
    'advance-product-purchase-report.php' => 'advance-product-purchase-report.php',
    'advance-product-sale-report.php' => 'advance-product-sale-report.php',
    'advance-product-usage-report.php' => 'advance-product-usage-report.php',
    'advance-membership-report.php' => 'advance-membership-report.php',
    'advance-upsell-report.php' => 'advance-upsell-report.php',
    'advance-wallet-report.php' => 'advance-wallet-report.php',
];

$menuProductsArr = [
    'stock-current.php' => 'stock-current.php',
    'stock-expire.php' => 'stock-expire.php',
    'stock-transfer.php' => 'stock-transfer.php',
    'product.php' => 'product.php',
    'product-stock-add.php' => 'product-stock-add.php',
    'product-vendor.php' => 'product-vendor.php',
    'product-use-in-salon.php' => 'product-use-in-salon.php',
    'product-vendor-profile.php' => 'product-vendor-profile.php'
];

$menuNotificationArr = [
    'notification-stock-expiry.php' => 'notification-stock-expiry.php',
    'notification-package-expiry.php' => 'notification-package-expiry.php',
    'notification-birthday-anniversary.php' => 'notification-birthday-anniversary.php',
    'notification-enquiry-followup.php' => 'notification-enquiry-followup.php',
    'notification-pending-payment.php' => 'notification-pending-payment.php',
    'notification-product-low-stock.php' => 'notification-product-low-stock.php',
    'notification-irregular-client.php' => 'notification-irregular-client.php',
    'notification-client-followup.php' => 'notification-client-followup.php',
];

$menuBillingArr = [
    'billing-bill.php' => 'billing-bill.php',
    'billing-wallet.php' => 'billing-wallet.php',
];

$menuClientArr = [
    'client.php' => 'client.php',
    'client-profile.php' => 'client-profile.php',
    'client-appointment.php' => 'client-appointment.php',
    'client-billing.php' => 'client-billing.php',
    'client-reward.php' => 'client-reward.php',
    'client-payment.php' => 'client-payment.php',
    'client-package.php' => 'client-package.php',
    'client-membership.php' => 'client-membership.php',
    'client-wallet.php' => 'client-wallet.php',
    'client-feedback.php' => 'client-feedback.php',
    'client-followup.php' => 'client-followup.php',
];

$menuFeedbackArr = [
    'feedback.php' => 'feedback.php',
    'feedback-add.php' => 'feedback-add.php',
    'feedback-already.php' => 'feedback-already.php',
    'feedback-success.php' => 'feedback-success.php',
];

?>

<!-- Topbar -->
<?= is_demo_version(); ?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow first-navbar">

    <div class="logo d-flex gap-2 align-items-center">
        <a href="./" class="text-decoration-none font-weight-bold pl-3 text-dark">
            <img src="<?= BRANDLOGO ?>" alt="logo" style="width:100px">
        </a>
        <h2 class="d-inline-block text-dark mb-0">(<?= SALONNAME ?>)</h2>
    </div>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto first-navbar-last-ul">

        <?php if (USERROLE == 'superadmin') { ?>
            <li class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <form method="post" action="./inc/branch/set-branch.php" id="branch_form">

                        <div style="width:350px;" class="first-navbar-last-div">
                            <div class="form-group d-flex justify-content-center align-items-center gap-2 m-0">
                                <label for="branch_select" class="branch_label m-0"> Change Branch : </label>
                                <select class="form-select branch_select m-0 first-navbar-select" name="branch_select" id="branch_select" onchange="$('#branch_form').submit();" style="max-width: 200px;">
                                    <?php
                                    $allBranchArr = all_branch($db);
                                    foreach ($allBranchArr as $allBranchKey => $allBranchValue) {
                                    ?>
                                        <option value="<?= $allBranchValue['id'] ?>" <?= (BRANCHID == $allBranchValue['id']) ? 'selected' : '' ?>><?= $allBranchValue['branch_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

        <?php } ?>
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle <?= ($pageName == 'notification-birthday-anniversary.php') ? 'active' : '' ?>" href="./notification-birthday-anniversary.php" role="button">
                <i class="fas fa-bell fa-fw"></i>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= USER_NAME ?>(<?= BRANCHNAME ?>)</span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in user-profile-info-wrapper">
                <a class="dropdown-item" href="./profile.php">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="./change-password.php">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>

</nav>

<div class="w-100 my-2 px-2">
    <nav class="navbar navbar-expand-lg navbar-dark secondary-menu shadow rounded p-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="./"><i class="fas fa-home"></i> Dashboard</a>

            <!-- Topbar Search -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 350px;max-width:100%;">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small search_header_Client" placeholder="Client Name / Number" aria-label="Search" aria-describedby="basic-addon2">
                </div>
            </form>

            <ul class="navbar-nav me-auto mb-lg-0">
                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">

                    <a class="navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#searchDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-search fa-fw"></i>
                    </a>

                    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#searchDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-search fa-fw"></i>
                    </button> -->
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown" id="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            </div>
                        </form>
                    </div>
                </li>
            </ul>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>




            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageName == 'enquiry.php') ? 'active' : '' ?>" href="./enquiry.php">Enquiry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageName == 'appointment.php') ? 'active' : '' ?>" href="./appointment.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (array_key_exists($pageName, $menuBillingArr)) ? 'active' : '' ?>" href="./billing-bill.php">Billing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (array_key_exists($pageName, $menuClientArr)) ? 'active' : '' ?>" href="./client.php">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (array_key_exists($pageName, $menuFeedbackArr)) ? 'active' : '' ?>" href="./feedback.php">Feedbacks</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= (array_key_exists($pageName, $menuProductsArr)) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?= ($pageName == 'stock-current.php' || $pageName == 'stock-expire.php') ? 'active' : '' ?>" href="./stock-current.php">All Stock</a></li>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'product.php') ? 'active' : '' ?>" href="./product.php">Product List</a></li> <?php } ?>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'stock-transfer.php') ? 'active' : '' ?>" href="./stock-transfer.php">Stock Transfer</a></li> <?php } ?>
                            <li><a class="dropdown-item <?= ($pageName == 'product-stock-add.php') ? 'active' : '' ?>" href="./product-stock-add.php">Add Stock</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'product-vendor.php') ? 'active' : '' ?>" href="./product-vendor.php">Product Vendor</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'product-use-in-salon.php') ? 'active' : '' ?>" href="./product-use-in-salon.php">Use Product In Salon</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= (array_key_exists($pageName, $menuReportArr)) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Reports
                        </a>
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item <?= ($pageName == 'daily-report.php') ? 'active' : '' ?>" href="daily-report.php">Daily Reports</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'day-summary-report.php') ? 'active' : '' ?>" href="day-summary-report.php">Day Summary</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'billing-report.php') ? 'active' : '' ?>" href="billing-report.php">Billing Reports</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'enquiry-report.php') ? 'active' : '' ?>" href="enquiry-report.php">Enquiry Reports</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'service-provider-report.php') ? 'active' : '' ?>" href="service-provider-report.php">Service Provider Reports</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'receive-pending-payment-report.php') ? 'active' : '' ?>" href="receive-pending-payment-report.php">Received Pending Payments</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'history-appointment-report.php' || $pageName == 'history-billing-report.php' || $pageName == 'history-wallet-report.php' || $pageName == 'history-wallet-view-report.php') ? 'active' : '' ?>" href="history-appointment-report.php">History</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'balance-report.php') ? 'active' : '' ?>" href="balance-report.php">Balance Reports</a></li>
                            <li><a class="dropdown-item <?= (array_key_exists($pageName, $menuAdvanceReportArr)) ? 'active' : '' ?>" href="advance-report.php">Advance Reports</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'attendance-report.php') ? 'active' : '' ?>" href="attendance-report.php">Attendance Report</a></li>
                            <!--<?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'sms-history.php') ? 'active' : '' ?>" href="sms-history.php">SMS History</a></li><?php } ?>-->
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= (array_key_exists($pageName, $menuNotificationArr)) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Notification
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?= ($pageName == 'notification-package-expiry.php') ? 'active' : '' ?>" href="./notification-package-expiry.php">Packages Notification</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-stock-expiry.php') ? 'active' : '' ?>" href="./notification-stock-expiry.php">Stock Notification</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-birthday-anniversary.php') ? 'active' : '' ?>" href="./notification-birthday-anniversary.php">Birthday Anniversary</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-enquiry-followup.php') ? 'active' : '' ?>" href="./notification-enquiry-followup.php">Enquiry Followup</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-pending-payment.php') ? 'active' : '' ?>" href="./notification-pending-payment.php">Pending Payment</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-product-low-stock.php') ? 'active' : '' ?>" href="./notification-product-low-stock.php">Product Low Stock</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-irregular-client.php') ? 'active' : '' ?>" href="./notification-irregular-client.php">Irregular Client</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'notification-client-followup.php') ? 'active' : '' ?>" href="./notification-client-followup.php">Client Followup</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown mr-4">
                        <a class="nav-link dropdown-toggle <?= (array_key_exists($pageName, $menuAddManageArr)) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Add &amp; Manage
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?= ($pageName == 'expense.php') ? 'active' : '' ?>" href="./expense.php">Expenses</a></li>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'service.php') ? 'active' : '' ?>" href="./service.php">Services</a></li><?php } ?>
                            <li><a class="dropdown-item <?= ($pageName == 'package.php') ? 'active' : '' ?>" href="./package.php">Packages</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'coupon.php') ? 'active' : '' ?>" href="./coupon.php">Coupons</a></li>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'employee-salary.php') ? 'active' : '' ?>" href="./employee-salary.php">Employee Salary</a></li> <?php } ?>
                            <li><a class="dropdown-item <?= ($pageName == 'service-provider.php') ? 'active' : '' ?>" href="./service-provider.php">Service Providers</a></li>
                            <!-- <li><a class="dropdown-item <?= ($pageName == 'service-reminder.php') ? 'active' : '' ?>" href="./service-reminder.php">Automatic Service Reminder</a></li> -->
                            <li><a class="dropdown-item <?= ($pageName == 'staff.php') ? 'active' : '' ?>" href="./staff.php">Staff</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'membership.php') ? 'active' : '' ?>" href="./membership.php">Membership</a></li>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'all-branch.php') ? 'active' : '' ?>" href="./all-branch.php">All Branches</a></li><?php } ?>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'transfer-option.php') ? 'active' : '' ?>" href="./transfer-option.php">Transfer Service Provider</a></li><?php } ?>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'software-setting-super-admin.php') ? 'active' : '' ?>" href="./software-setting-super-admin.php">Software Setting</a></li><?php } ?>
                            <?php if (USERROLE == 'superadmin') { ?><li><a class="dropdown-item <?= ($pageName == 'software-setting.php') ? 'active' : '' ?>" href="./software-setting.php">Branch Setting</a></li><?php } ?>
                            <?php if (USERROLE == 'admin') { ?><li><a class="dropdown-item <?= ($pageName == 'software-setting.php') ? 'active' : '' ?>" href="./software-setting.php">Branch Setting</a></li><?php } ?>
                            <li><a class="dropdown-item <?= ($pageName == 'self-assessment-data.php') ? 'active' : '' ?>" href="./self-assessment-data.php">Self Assessment Data</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'mark-attendance.php') ? 'active' : '' ?>" href="./mark-attendance.php">Mark Attendance</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'gst-slab.php') ? 'active' : '' ?>" href="./gst-slab.php">GST Slab</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'sms-panel.php' || $pageName == 'sms-panel-history.php' || $pageName == 'sms-message.php' || $pageName == 'sms-template.php') ? 'active' : '' ?>" href="./sms-panel.php">SMS Panel</a></li>
                            <li><a class="dropdown-item <?= ($pageName == 'bulk-import-export-service.php' || $pageName == 'bulk-import-export-product.php') ? 'active' : '' ?>" href="./bulk-import-export-product.php">Bulk Import/Export</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<style>
    #searchDropdown {
        position: fixed;
        width: 100%;
        top: 140px;
        border-color: #102e23;
    }

    #searchDropdown input {
        border: 1px solid #102e23 !important;
    }

    @media screen and (max-width:768px) {
        .first-navbar {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: auto !important;
        }

        .first-navbar-last-ul {
            margin-left: unset !important;
        }

        .first-navbar-select {
            width: 100px;
        }

        .first-navbar-last-div {
            width: 300px !important;
        }
    }
</style>