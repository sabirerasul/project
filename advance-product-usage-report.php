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
}

$mainModel = [];


$dateArray = displayDates($start_date, $end_date, $format = 'd/m/Y');

foreach ($dateArray as $key => $val) {

    $start_date1 = getDateServerFormat($val);
    $end_date1 = getDateServerFormat($val);

    $walletModel = fetch_object($db, "SELECT sum(amount) as amount FROM `client_wallet` WHERE amount_receive_from='Add_wallet' AND `created_at` BETWEEN '{$start_date1} 00:00:00' AND '{$end_date1} 23:59:59'");
    $billingModel = fetch_all($db, "SELECT * FROM client_billing WHERE billing_date='{$val}'");

    $billDate = [0];
    $serviceAmount = [0];
    $productAmount = [0];
    $packageAmount = [0];
    $membershipAmount = [0];
    $walletAmount = !empty($walletModel->amount) ? $walletModel->amount : 0;
    $appointmentAdvance = [0];
    $discount = [0];
    $inclusiveTax = [0];
    $exclusiveTax = [0];
    $totalAmount = [0];

    foreach ($billingModel as $billingKey => $billingVal) {
        $modelValue = (object) $billingVal;
        $serviceAmount[] = get_billing_product_amount($db, $modelValue->id, 'service');
        $productAmount[] = get_billing_product_amount($db, $modelValue->id, 'stock');
        $packageAmount[] = get_billing_product_amount($db, $modelValue->id, 'package');
        $membershipAmount[] = get_billing_product_amount($db, $modelValue->id, 'membership');
        $discount[] = get_billing_discount($db, $modelValue->id);

        $totalAmount[] = $modelValue->total;
        $appointmentAdvance[] = $modelValue->advance_receive;

        $taxValue = get_tax_value($db, $modelValue->tax, $modelValue->sub_total);

        $inclusiveTax[] = $taxValue['inclusive'];
        $exclusiveTax[] = $taxValue['exclusive'];
    }


    $serviceAmount = array_sum($serviceAmount);
    $productAmount = array_sum($productAmount);
    $packageAmount = array_sum($packageAmount);
    $membershipAmount = array_sum($membershipAmount);

    $appointmentAdvance = array_sum($appointmentAdvance);
    $discount = array_sum($discount);
    $inclusiveTax = array_sum($inclusiveTax);
    $exclusiveTax = array_sum($exclusiveTax);
    $totalAmount = array_sum($totalAmount);

    $modelArray = [
        'billDate' => $val,
        'serviceAmount' => $serviceAmount,
        'productAmount' => $productAmount,
        'packageAmount' => $packageAmount,
        'membershipAmount' => $membershipAmount,
        'walletAmount' => $walletAmount,
        'appointmentAdvance' => $appointmentAdvance,
        'discount' => $discount,
        'inclusiveTax' => $inclusiveTax,
        'exclusiveTax' => $exclusiveTax,
        'totalAmount' => $totalAmount,
    ];

    $mainModel[] = $modelArray;
}

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Product Usage Report- <?= SALONNAME ?></title>

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
                                <h6>Product Usage Report</h6>
                                <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                            </div>
                            <hr>

                            <div>
                                <form action="" method="POST" id="filterEnquiry">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Date</label>
                                                <input type="text" class="form-control filterfollowdate" name="filterfollowdate" value="<?= $inputDate ?>" id="filterfollowdate">
                                                <input type="hidden" id="start_date" value="<?= dateMMFormar(formatDate($start_date)) ?>">
                                                <input type="hidden" id="end_date" value="<?= dateMMFormar(formatDate($end_date)) ?>">
                                            </div>
                                        </div>
                                        <?php /*
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Client</label>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Product</label>
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
                                        <div class="col-md-2">
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Used From</label>
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
                                        <?php */ ?>
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                </div>
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <a href="advance-product-usage-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Bill Date</th>
                                            <th>Invoice Number</th>
                                            <th>Client Name</th>
                                            <th>Service Name</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Stock ID</th>
                                            <th>Service Provider</th>
                                            <th>Used From</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;

                                        $sserviceAmount = [0];
                                        $sproductAmount = [0];
                                        $spackageAmount = [0];
                                        $smembershipAmount = [0];
                                        $swalletAmount = [0];
                                        $sappointmentAdvance = [0];
                                        $sdiscount = [0];
                                        $sinclusiveTax = [0];
                                        $sexclusiveTax = [0];
                                        $stotalAmount = [0];

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);
                                            $sserviceAmount[] = $serviceAmount;
                                            $sproductAmount[] = $productAmount;
                                            $spackageAmount[] = $packageAmount;
                                            $smembershipAmount[] = $membershipAmount;
                                            $swalletAmount[] = $walletAmount;
                                            $sappointmentAdvance[] = $appointmentAdvance;
                                            $sdiscount[] = $discount;
                                            $sinclusiveTax[] = $inclusiveTax;
                                            $sexclusiveTax[] = $exclusiveTax;
                                            $stotalAmount[] = $totalAmount;
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $billDate ?></td>
                                                <td><?= $serviceAmount ?></td>
                                                <td><?= $productAmount ?></td>
                                                <td><?= $packageAmount ?></td>
                                                <td><?= $membershipAmount ?></td>
                                                <td><?= $walletAmount ?></td>
                                                <td><?= $appointmentAdvance ?></td>
                                                <td>
                                                    <p><b>Inclusive : </b><?= $inclusiveTax ?></p>
                                                    <p><b>Exclusive : </b><?= $exclusiveTax ?></p>
                                                </td>
                                                <td><?= $discount ?></td>
                                                <td><?= $totalAmount ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php

                                        $tserviceAmount = array_sum($sserviceAmount);
                                        $tproductAmount = array_sum($sproductAmount);
                                        $tpackageAmount = array_sum($spackageAmount);
                                        $tmembershipAmount = array_sum($smembershipAmount);
                                        $twalletAmount = array_sum($swalletAmount);
                                        $tappointmentAdvance = array_sum($sappointmentAdvance);
                                        $tdiscount = array_sum($sdiscount);
                                        $tinclusiveTax = array_sum($sinclusiveTax);
                                        $texclusiveTax = array_sum($sexclusiveTax);
                                        $ttotalAmount = array_sum($stotalAmount);

                                        ?>
                                        <tr>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th><?= $tserviceAmount ?></th>
                                            <th><?= $tproductAmount ?></th>
                                            <th><?= $tpackageAmount ?></th>
                                            <th><?= $tmembershipAmount ?></th>
                                            <th><?= $twalletAmount ?></th>
                                            <th><?= $tappointmentAdvance ?></th>
                                            <th>
                                                <p><b>Inclusive : </b><?= $tinclusiveTax ?></p>
                                                <p><b>Exclusive : </b><?= $texclusiveTax ?></p>
                                            </th>
                                            <th><?= $tdiscount ?></th>
                                            <th><?= $ttotalAmount ?></th>
                                        </tr>
                                    </tfoot>
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
    <script type="text/javascript" src="./js/pages/advance-product-usage-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>