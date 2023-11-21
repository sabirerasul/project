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


$serviceProviderModel = fetch_all($db, "SELECT * FROM `service_provider` WHERE `status`=1");

foreach ($serviceProviderModel as $serviceProviderKey => $serviceProviderVal) {
    $serviceProviderValue = (object) $serviceProviderVal;

    $assignServiceProvider = fetch_all($db, "SELECT billing_id FROM `client_billing_assign_service_provider` WHERE `service_provider_id`='{$serviceProviderValue->id}'");

    $billing_ids = array_column($assignServiceProvider, "billing_id");
    $billing_ids = implode(',', $billing_ids);
    $billing_ids = !empty($billing_ids) ? $billing_ids : 0;

    $sql = "SELECT *,STR_TO_DATE(billing_date, '%d/%m/%Y') as billing_date FROM client_billing WHERE id IN ({$billing_ids})";

    $billingModel = fetch_all($db, $sql);

    $serviceProvider = "{$serviceProviderValue->name}<br>({$serviceProviderValue->contact_number})";

    $totalClient = [0];
    $totalService = [0];
    $serviceAmount = [0];
    $serviceCommission = [0];
    $totalProduct = [0];
    $productAmount = [0];
    $productCommission = [0];
    $membershipTotal = [0];
    $membershipAmount = [0];
    $packageTotal = [0];
    $packageAmount = [0];
    $actualAmount = [0];
    $discount = [0];
    $totalAmount = [0];
    $averageBillValue = [0];

    foreach ($billingModel as $billingKey => $billingVal) {
        $modelValue = (object) $billingVal;

        if ($modelValue->billing_date >= $start_date && $modelValue->billing_date <= $end_date) {

            $serviceAmount[] = get_billing_product_amount($db, $modelValue->id, 'service');
            $productAmount[] = get_billing_product_amount($db, $modelValue->id, 'stock');
            $packageAmount[] = get_billing_product_amount($db, $modelValue->id, 'package');
            $membershipAmount[] = get_billing_product_amount($db, $modelValue->id, 'membership');
            $totalClient[] = $modelValue->client_id;
            $totalService[] = get_total_billing_product($db, $modelValue->id, 'service');
            $totalProduct[] = get_total_billing_product($db, $modelValue->id, 'stock');
            $membershipTotal[] = get_total_billing_product($db, $modelValue->id, 'membership');
            $packageTotal[] = get_total_billing_product($db, $modelValue->id, 'package');
            $discount[] = get_billing_discount($db, $modelValue->id);

            $billingProductModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$modelValue->id}'");

            foreach ($billingProductModel as $billingProductKey => $billingProductVal) {
                $billingProductValue = (object) $billingProductVal;
                if ($billingProductValue->service_type == 'service' || $billingProductValue->service_type == 'package') {
                    $serviceCommission[] = get_service_provider_commission($db, $serviceProviderValue->id, $billingProductValue, "service");
                }

                if ($billingProductValue->service_type == 'stock') {
                    $productCommission[] = get_service_provider_commission($db, $serviceProviderValue->id, $billingProductValue, "stock");
                }
            }
        }
    }

    $totalClient = array_unique($totalClient);
    $totalClient = count($totalClient);
    $totalService = array_sum($totalService);
    $serviceAmount = array_sum($serviceAmount);
    $serviceCommission = array_sum($serviceCommission);
    $totalProduct = array_sum($totalProduct);
    $productAmount = array_sum($productAmount);
    $productCommission = array_sum($productCommission);
    $membershipTotal = array_sum($membershipTotal);
    $membershipAmount = array_sum($membershipAmount);
    $packageTotal = array_sum($packageTotal);
    $packageAmount = array_sum($packageAmount);

    $actualAmount[] = $serviceAmount;
    $actualAmount[] = $productAmount;
    $actualAmount[] = $membershipAmount;
    $actualAmount[] = $packageAmount;

    $actualAmount = array_sum($actualAmount);
    $discount = array_sum($discount);
    $totalAmount = $actualAmount - $discount;
    $averageBillValue = $totalAmount / $totalClient;


    $modelArray = [
        'serviceProvider' => $serviceProvider,
        'totalClient' => $totalClient,
        'totalService' => $totalService,
        'serviceAmount' => $serviceAmount,
        'serviceCommission' => $serviceCommission,
        'totalProduct' => $totalProduct,
        'productAmount' => $productAmount,
        'productCommission' => $productCommission,
        'membershipTotal' => $membershipTotal,
        'membershipAmount' => $membershipAmount,
        'packageTotal' => $packageTotal,
        'packageAmount' => $packageAmount,
        'actualAmount' => $actualAmount,
        'discount' => $discount,
        'totalAmount' => $totalAmount,
        'averageBillValue' => $averageBillValue,

    ];

    $mainModel[] = $modelArray;
}


$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Employee Report- <?= SALONNAME ?></title>

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
                                <h6>Employee Report</h6>
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
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                </div>
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <a href="advance-employee-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Service Provider</th>
                                            <th>Total Clients</th>
                                            <th>Total Service</th>
                                            <th>Service Amount</th>
                                            <th>Service Commission</th>
                                            <th>Total Products</th>
                                            <th>Product Amount</th>
                                            <th>Product Commission</th>
                                            <th>Total Membership</th>
                                            <th>Membership Amount</th>
                                            <th>Total Package</th>
                                            <th>Package Amount</th>
                                            <th>Actual Amount</th>
                                            <th>Discount</th>
                                            <th>Total Amount</th>
                                            <th>Average Bill Value (ABV)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;
                                        $stotalClient = [0];
                                        $stotalService = [0];
                                        $sserviceAmount = [0];
                                        $sserviceCommission = [0];
                                        $stotalProduct = [0];
                                        $sproductAmount = [0];
                                        $sproductCommission = [0];
                                        $smembershipTotal = [0];
                                        $smembershipAmount = [0];
                                        $spackageTotal = [0];
                                        $spackageAmount = [0];
                                        $sactualAmount = [0];
                                        $sdiscount = [0];
                                        $stotalAmount = [0];
                                        $saverageBillValue = [0];

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);

                                            $stotalClient[] = $totalClient;
                                            $stotalService[] = $totalService;
                                            $sserviceAmount[] = $serviceAmount;
                                            $sserviceCommission[] = $serviceCommission;
                                            $stotalProduct[] = $totalProduct;
                                            $sproductAmount[] = $productAmount;
                                            $sproductCommission[] = $productCommission;
                                            $smembershipTotal[] = $membershipTotal;
                                            $smembershipAmount[] = $membershipAmount;
                                            $spackageTotal[] = $packageTotal;
                                            $spackageAmount[] = $packageAmount;
                                            $sactualAmount[] = $actualAmount;
                                            $sdiscount[] = $discount;
                                            $stotalAmount[] = $totalAmount;
                                            $saverageBillValue[] = $averageBillValue;

                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $serviceProvider ?></td>
                                                <td><?= $totalClient ?></td>
                                                <td><?= $totalService ?></td>
                                                <td><?= $serviceAmount ?></td>
                                                <td><?= $serviceCommission ?></td>
                                                <td><?= $totalProduct ?></td>
                                                <td><?= $productAmount ?></td>
                                                <td><?= $productCommission ?></td>
                                                <td><?= $membershipTotal ?></td>
                                                <td><?= $membershipAmount ?></td>
                                                <td><?= $packageTotal ?></td>
                                                <td><?= $packageAmount ?></td>
                                                <td><?= $actualAmount ?></td>
                                                <td><?= $discount ?></td>
                                                <td><?= $totalAmount ?></td>
                                                <td><?= $averageBillValue ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        $ttotalClient = array_sum($stotalClient);
                                        $ttotalService = array_sum($stotalService);
                                        $tserviceAmount = array_sum($sserviceAmount);
                                        $tserviceCommission = array_sum($sserviceCommission);
                                        $ttotalProduct = array_sum($stotalProduct);
                                        $tproductAmount = array_sum($sproductAmount);
                                        $tproductCommission = array_sum($sproductCommission);
                                        $tmembershipTotal = array_sum($smembershipTotal);
                                        $tmembershipAmount = array_sum($smembershipAmount);
                                        $tpackageTotal = array_sum($spackageTotal);
                                        $tpackageAmount = array_sum($spackageAmount);
                                        $tactualAmount = array_sum($sactualAmount);
                                        $tdiscount = array_sum($sdiscount);
                                        $ttotalAmount = array_sum($stotalAmount);
                                        $taverageBillValue = array_sum($saverageBillValue);

                                        ?>
                                        <tr>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th><?= $ttotalClient ?></th>
                                            <th><?= $ttotalService ?></th>
                                            <th><?= $tserviceAmount ?></th>
                                            <th><?= $tserviceCommission ?></th>
                                            <th><?= $ttotalProduct ?></th>
                                            <th><?= $tproductAmount ?></th>
                                            <th><?= $tproductCommission ?></th>
                                            <th><?= $tmembershipTotal ?></th>
                                            <th><?= $tmembershipAmount ?></th>
                                            <th><?= $tpackageTotal ?></th>
                                            <th><?= $tpackageAmount ?></th>
                                            <th><?= $tactualAmount ?></th>
                                            <th><?= $tdiscount ?></th>
                                            <th><?= $ttotalAmount ?></th>
                                            <th><?= $taverageBillValue ?></th>
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
    <script type="text/javascript" src="./js/pages/advance-employee-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>