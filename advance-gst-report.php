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
    $tax_type = '';
}

$mainModel = [];

if (!empty($tax_type)) {

    $taxModelKey = fetch_all($db, "SELECT id FROM gst_slab WHERE tax_type='{$tax_type}'");
    $taxModelKeyIdsArr = array_column($taxModelKey, "id");
    $taxModelKeyIds = implode(',', $taxModelKeyIdsArr);
    $taxModelKeyIds = !empty($taxModelKeyIds) ? $taxModelKeyIds : 0;
}

$cond = ($tax_type != '') ? "tax IN ({$taxModelKeyIds})" : "`tax` != '0' AND `tax` != ''";

$billingModel = fetch_all($db, "SELECT * FROM `client_billing` WHERE {$cond}");

foreach ($billingModel as $billingKey => $billingVal) {

    $modelValue = (object) $billingVal;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($modelValue->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $clientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$modelValue->client_id}'");

    $subTotal = $modelValue->sub_total;


    if ($modelValue->discount_type == 'percentage') {
        $discount = get_price_from_discount($modelValue->discount, $modelValue->sub_total);
    } else {
        $discount = ($modelValue->sub_total - $modelValue->discount);
    }

    $netTotal = ($subTotal - $discount);

    $taxModel = fetch_object($db, "SELECT * FROM gst_slab WHERE id='{$modelValue->tax}'");

    $taxType = $taxModel->tax_type;

    $taxValue = get_tax_value($db, $modelValue->tax, $netTotal);

    $totalTax = ($tax_type == 'inclusive') ? $taxValue['inclusive'] : $taxValue['exclusive'];
    
    $halfTax = ($totalTax != 0) ? $totalTax / 2 : 0;


    $total = ($taxType == 'Exclusive') ? ($netTotal + $totalTax) : $netTotal;

    $cGST = $halfTax;
    $sGST = $halfTax;


    $modelArray = [
        'billDate' => $modelValue->billing_date,
        'invoiceNumber' => $modelValue->invoice_number,
        'clientName' => $clientModel->client_name,
        'clientNumber' => $clientModel->contact,
        'subTotal' => $subTotal,
        'discount' => $discount,
        'netTotal' => $netTotal,
        'taxType' => $taxType,
        'cGST' => $cGST,
        'sGST' => $sGST,
        'total' => $total,
    ];

    $mainModel[] = $modelArray;
}

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance GST Report- <?= SALONNAME ?></title>

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
                                <h6>GST Report</h6>
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tax_type" class="tax_type_label required">Tax Type</label>
                                                <select name="tax_type" id="tax_type" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($taxTypeArr as $taxTypeKey => $taxTypeVal) {
                                                    ?>
                                                        <option value="<?= $taxTypeVal ?>" <?= ($taxTypeKey == $tax_type) ? 'selected' : '' ?>><?= ucfirst($taxTypeVal) ?></option>
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
                                                    <a href="advance-gst-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Client Number</th>
                                            <th>Sub Total</th>
                                            <th>Discount</th>
                                            <th>Net Total</th>
                                            <th>Tax Type</th>
                                            <th>CGST</th>
                                            <th>SGST</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;

                                        $ssubTotal[] = 0;
                                        $sdiscount[] = 0;
                                        $snetTotal[] = 0;

                                        $scGST[] = 0;
                                        $ssGST[] = 0;
                                        $stotal[] = 0;

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);

                                            $ssubTotal[] = $subTotal;
                                            $sdiscount[] = $discount;
                                            $snetTotal[] = $netTotal;

                                            $scGST[] = $cGST;
                                            $ssGST[] = $sGST;
                                            $stotal[] = $total;
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $billDate ?></td>
                                                <td><?= $invoiceNumber ?></td>
                                                <td><?= $clientName ?></td>
                                                <td><?= $clientNumber ?></td>
                                                <td><?= $subTotal ?></td>
                                                <td><?= $discount ?></td>
                                                <td><?= $netTotal ?></td>
                                                <td><?= $taxType ?></td>
                                                <td><?= $cGST ?></td>
                                                <td><?= $sGST ?></td>
                                                <td><?= $total ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php

                                        $tsubTotal = array_sum($ssubTotal);
                                        $tdiscount = array_sum($sdiscount);
                                        $tnetTotal = array_sum($snetTotal);
                                        $tcGST = array_sum($scGST);
                                        $tsGST = array_sum($ssGST);
                                        $ttotal = array_sum($stotal);

                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>

                                            <th><?= $tsubTotal ?></th>
                                            <th><?= $tdiscount ?></th>
                                            <th><?= $tnetTotal ?></th>
                                            <th></th>
                                            <th><?= $tcGST ?></th>
                                            <th><?= $tsGST ?></th>
                                            <th><?= $ttotal ?></th>
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
    <script type="text/javascript" src="./js/pages/advance-gst-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>