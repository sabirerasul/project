<?php
require_once "lib/db.php";
check_auth();
extract($_REQUEST);

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
    $service_provider_id = 0;
}


$mainModel = [];

$serviceAmount = [0];
$totalService = [0];
$productAmount = [0];
$totalProduct = [0];
$packageAmount = [0];
$totalPackage = [0];
$membershipAmount = [0];
$totalMembership = [0];

$serviceProviderModel = fetch_all($db, "SELECT * FROM `service_provider` WHERE `id`='{$service_provider_id}' AND `status`=1");

foreach ($serviceProviderModel as $serviceProviderKey => $serviceProviderVal) {

    $serviceProviderValue = (object) $serviceProviderVal;

    $assignServiceProvider = fetch_all($db, "SELECT billing_id FROM `client_billing_assign_service_provider` WHERE `service_provider_id`='{$serviceProviderValue->id}'");

    $billing_ids = array_column($assignServiceProvider, "billing_id");
    $billing_ids = implode(',', $billing_ids);
    $billing_ids = !empty($billing_ids) ? $billing_ids : 0;

    $sql = "SELECT *,STR_TO_DATE(billing_date, '%d/%m/%Y') as billing_date FROM client_billing WHERE id IN ({$billing_ids})";

    $billingModel = fetch_all($db, $sql);

    if (count($billingModel) > 0) {
        foreach ($billingModel as $billingKey => $billingVal) {
            $modelValue = (object) $billingVal;

            if ($modelValue->billing_date >= $start_date && $modelValue->billing_date <= $end_date) {

                $serviceAmount[] = get_billing_product_amount($db, $modelValue->id, 'service');
                $productAmount[] = get_billing_product_amount($db, $modelValue->id, 'stock');
                $packageAmount[] = get_billing_product_amount($db, $modelValue->id, 'package');
                $membershipAmount[] = get_billing_product_amount($db, $modelValue->id, 'membership');
                $totalService[] = get_total_billing_product($db, $modelValue->id, 'service');
                $totalProduct[] = get_total_billing_product($db, $modelValue->id, 'stock');
                $totalMembership[] = get_total_billing_product($db, $modelValue->id, 'membership');
                $totalPackage[] = get_total_billing_product($db, $modelValue->id, 'package');

                $mainModel[] = $modelValue;
            }
        }
    }
}


$serviceAmount = array_sum($serviceAmount);
$productAmount = array_sum($productAmount);
$packageAmount = array_sum($packageAmount);
$membershipAmount = array_sum($membershipAmount);

$totalService = array_sum($totalService);
$totalProduct = array_sum($totalProduct);
$totalMembership = array_sum($totalMembership);
$totalPackage = array_sum($totalPackage);

$totalCollectedRevenue = ($serviceAmount + $productAmount + $packageAmount + $membershipAmount);

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

$serviceProviderModel1 = fetch_all($db, "SELECT * FROM `service_provider` WHERE status=1");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Advance Job Card Report - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/site.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="./css/datepicker.min.css">



    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
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

                    <div class="row">

                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Job Card Report</h6>
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

                                                <div class="col-md-3">
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
                                                    <div class="d-flex justify-content-between">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <a href="advance-job-card-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-2">
                                    <div class="d-flex justify-content-between">
                                        <h6>Total Revenue Collected : <?= $totalCollectedRevenue ?></h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel1('xlsx')">Export</div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">

                                                <tr>
                                                    <td>1</td>
                                                    <th>Services</td>
                                                    <td><?= $totalService ?></th>
                                                    <td><?= $serviceAmount ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <th>Products</th>
                                                    <td><?= $totalProduct ?></td>
                                                    <td><?= $productAmount ?></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <th>Packages</th>
                                                    <td><?= $totalPackage ?></td>
                                                    <td><?= $packageAmount ?></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <th>Memberships</th>
                                                    <td><?= $totalMembership ?></td>
                                                    <td><?= $membershipAmount ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-2">
                                    <div class="d-flex justify-content-between">
                                        <h6>Service List</h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel2('xlsx')">Export</div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client</th>
                                                    <th>Client Number</th>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php

                                                $mainModel = (array) $mainModel;
                                                if (count($mainModel) > 0) {
                                                    $count = 0;
                                                    $mBillingIds = array_column($mainModel, "id");
                                                    $mBillingIds = implode(',', $mBillingIds);
                                                    $mBillingIds = !empty($mBillingIds) ? $mBillingIds : 0;

                                                    $billingSeviceModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id` IN ({$mBillingIds})");
                                                    foreach ($billingSeviceModel as $billingSeviceKey => $billinbillingSevicegVal) {
                                                        $count++;
                                                        $billingServiceValue = (object) $billinbillingSevicegVal;
                                                        $mBillingModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE `id`='{$billingServiceValue->billing_id}'");
                                                        $clientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$mBillingModel->client_id}'");

                                                        $enquiryForModel = fetch_object($db, "SELECT * FROM {$billingServiceValue->service_type} WHERE id='{$billingServiceValue->service_id}'");

                                                        $arrayField = [
                                                            'service' => 'service_name',
                                                            'membership' => 'membership_name',
                                                            'package' => 'package_name',
                                                            'stock' => 'product_id'
                                                        ];

                                                        $arrayFieldType = [
                                                            'service' => 'Service',
                                                            'membership' => 'Membership',
                                                            'package' => 'Package',
                                                            'stock' => 'Product'
                                                        ];

                                                        $fieldName = $arrayField[$billingServiceValue->service_type];

                                                        $serviceForText = '';
                                                        if ($billingServiceValue->service_type == 'stock') {
                                                            $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
                                                            $serviceForText = $productModel->product;
                                                        } else {
                                                            $serviceForText = $enquiryForModel->$fieldName;
                                                        }

                                                        $actuaPrice = get_actual_product_amount($billingServiceValue);
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $clientModel->client_name ?></td>
                                                            <td><?= $clientModel->contact ?></td>
                                                            <td><?= "(" . $arrayFieldType[$billingServiceValue->service_type] . ") " . $serviceForText ?></td>
                                                            <td><?= $actuaPrice ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


        <!-- Footer -->
        <?php include('./comman/footer.php'); ?>
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
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript" src="./js/toastify-js.js"></script>

    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script type="text/javascript" src="./js/pages/advance-job-card-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>