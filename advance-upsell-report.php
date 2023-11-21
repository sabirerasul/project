<?php
require('./lib/db.php');
check_auth();
extract($_REQUEST);

$cond = 1;

if ($_REQUEST) {

    if (!empty($filterfollowdate)) {
        $dateArr = explode(' - ', $filterfollowdate);
        $start_date = getDateServerFormat(dateMMFormar($dateArr[0]));
        $end_date = getDateServerFormat(dateMMFormar($dateArr[1]));
    } else {
        $todayDate = todayDate();
        $start_date = getDateServerFormat($todayDate);
        $end_date = getDateServerFormat($todayDate);
    }
} else {

    $todayDate = todayDate();
    $start_date = getDateServerFormat($todayDate);
    $end_date = getDateServerFormat($todayDate);
    $client_id = 0;
    $service_provider_id = 0;
}

$mainModel = [];

$cond = query_maker(['client_id' => $client_id, 'id' => 96]);
$cond = ($cond != 1) ? "AND {$cond}" : '';
$billingModel = fetch_all($db, "SELECT * FROM `client_billing` WHERE appointment_id!='0' {$cond}");

foreach ($billingModel as $billingKey => $billingVal) {

    $billingValue = (object) $billingVal;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($billingValue->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $billClient = fetch_object($db, "SELECT * FROM client WHERE id='{$billingValue->client_id}'");

    $billingService = fetch_all($db, "SELECT service_id FROM `client_billing_product` WHERE `billing_id`='{$billingValue->id}' AND `service_type`='service'");
    $appointmentService = fetch_all($db, "SELECT service_id FROM `appointment_service` WHERE `appointment_id`='{$billingValue->appointment_id}'");

    $billing_service_ids = array_column($billingService, "service_id");

    $appointment_service_ids = array_column($appointmentService, "service_id");

    $addKey = array_diff($billing_service_ids, $appointment_service_ids);

    $addKey = implode(',', $addKey);
    $addKey = !empty($addKey) ? $addKey : 0;

    $serviceModel = fetch_all($db, "SELECT * FROM `service` WHERE `id` IN ({$addKey})");

    foreach ($serviceModel as $serviceKey => $serviceVal) {
        $serviceValue = (object) $serviceVal;
        $sbillingService = fetch_object($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billingValue->id}' AND `service_id`='{$serviceValue->id}' AND `service_type`='service'");

        $sbillingServiceProviderId = fetch_object($db, "SELECT `service_provider_id` FROM `client_billing_assign_service_provider` WHERE `billing_id`='{$billingValue->id}' AND `billing_service_id`='{$sbillingService->id}'");

        $billingAssignServiceProviderId = !empty($sbillingServiceProviderId) ? $sbillingServiceProviderId->service_provider_id : 0;

        $sbillingServiceProvider = fetch_object($db, "SELECT * FROM `service_provider` WHERE id='{$billingAssignServiceProviderId}'");

        $serviceName = "(Service) {$serviceValue->service_name}";
        $serviceProvider = !empty($sbillingServiceProvider) ? $sbillingServiceProvider->name : '';
        $amount = get_actual_product_amount($sbillingService);

        $modelArray = [
            'date' => $billingValue->billing_date,
            'invoiceNumber' => $billingValue->invoice_number,
            'clientName' => $billClient->client_name,
            'contactNumber' => $billClient->contact,
            'serviceName' => $serviceName,
            'serviceProvider' => $serviceProvider,
            'amount' => $amount,
        ];
        $mainModel[] = $modelArray;
    }
}

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

$serviceProviderModel1 = fetch_all($db, "SELECT * FROM `service_provider` WHERE status=1");
$clientModel = fetch_all($db, "SELECT * FROM `client`");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Upsell Report- <?= SALONNAME ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/site.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">


    <style>
        .enq-for-wrapper {
            display: none;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('./comman/nav.php') ?>
                <!-- End of Topbar -->

                <?php include('./comman/advance-report-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                            <div class="d-flex justify-content-between mb-2">
                                <h6>Upsell Report</h6>
                                <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                            </div>
                            <hr>

                            <div>
                                <form action="" method="POST" id="filterEnquiry">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Date</label>
                                                <input type="text" class="form-control filterfollowdate" name="filterfollowdate" value="<?= $inputDate ?>" id="filterfollowdate">
                                                <input type="hidden" id="start_date" value="<?= dateMMFormar(formatDate($start_date)) ?>">
                                                <input type="hidden" id="end_date" value="<?= dateMMFormar(formatDate($end_date)) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-none">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Service Provider</label>
                                                <select name="service_provider_id" id="service_provider_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($serviceProviderModel1 as $serviceProviderKey1 => $serviceProviderVal1) {
                                                        $serviceProviderValue1 = (object) $serviceProviderVal1; ?>
                                                        <option value="<?= $serviceProviderValue1->id ?>" <?= ($serviceProviderValue1->id == $service_provider_id) ? 'selected' : '' ?>><?= $serviceProviderValue1->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="client_id" class="client_id_label required">Client</label>
                                                <select name="client_id" id="client_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($clientModel as $clientKey => $clientVal) {
                                                        $clientValue = (object) $clientVal; ?>
                                                        <option value="<?= $clientValue->id ?>" <?= ($clientValue->id == $client_id) ? 'selected' : '' ?>><?= $clientValue->client_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                </div>
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <a href="advance-upsell-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body shadow rounded p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Invoice Number</th>
                                            <th>Client Name</th>
                                            <th>Contact Number</th>
                                            <th>Service Name</th>
                                            <th>Service Provider</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php

                                        $count = 0;

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $date ?></td>
                                                <td><?= $invoiceNumber ?></td>
                                                <td><?= $clientName ?></td>
                                                <td><?= $contactNumber ?></td>
                                                <td><?= $serviceName ?></td>
                                                <td><?= $serviceProvider ?></td>
                                                <td><?= $amount ?></td>
                                                <td><a class="btn btn-primary" target="_BLANK" href="invoice.php?inv=<?= $invoiceNumber ?>">View</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('./comman/footer.php') ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js">
    </script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- JavaScript Bundle with Popper -->

    <!-- Page level plugins -->

    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="./js/toastify-js.js"></script>

    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script type="text/javascript" src="./js/pages/advance-upsell-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>