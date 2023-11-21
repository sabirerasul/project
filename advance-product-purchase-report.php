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

    $vendor_id = 0;
}

$mainModel = [];

$cond = query_maker(['vendor_id' => $vendor_id]);
$stockModel = fetch_all($db, "SELECT * FROM `stock_purchase` WHERE {$cond}");

foreach ($stockModel as $stockKey => $stockVal) {
    $stockValue = (object) $stockVal;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($stockValue->purchase_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $vendorName = fetch_object($db, "SELECT * FROM `vendor` WHERE id='{$stockValue->vendor_id}'")->vendor_name;

    $productPurchase = fetch_all($db, "SELECT * FROM `stock_purchase_product` WHERE `stock_purchase_id`='{$stockValue->id}'");
    foreach ($productPurchase as $productPurchaseKey => $productPurchaseVal) {
        $productPurchaseValue = (object) $productPurchaseVal;

        $productName = fetch_object($db, "SELECT * FROM product WHERE id='{$productPurchaseValue->product_id}'")->product;


        $productArray[] = [
            'productName' => $productName,
            'unit' => $productPurchaseValue->unit,
            'price' => $productPurchaseValue->purchase_price,
            'quantity' => $productPurchaseValue->quantity,
            'amount' => $productPurchaseValue->total_price,
        ];
    }


    $mPrice = 0;
    if ($stockValue->discount_type == 'percentage') {
        $dis = (int) $stockValue->discount;
        $mPrice = get_price_from_discount($dis, $stockValue->total_charge);
    } else {
        $mPrice = ($stockValue->discount - $stockValue->total_charge);
    }

    $discount = $mPrice;

    $taxValue = get_tax_value($db, $stockValue->tax, $stockValue->sub_total);
    $inclusiveTax = $taxValue['inclusive'];
    $exclusiveTax = $taxValue['exclusive'];

    $modelArray = [
        'purchaseDate' => $stockValue->purchase_date,
        'invoiceNumber' => $stockValue->invoice_number,
        'vendorName' => $vendorName,
        'productArray' => $productArray,
        'discount' => $discount,
        'inclusiveTax' => $inclusiveTax,
        'exclusiveTax' => $exclusiveTax,
        'netAmount' => $stockValue->sub_total,
        'shippingCharge' => $stockValue->shipping_charge,
        'totalPrice' => $stockValue->total_charge,
        'paid' => $stockValue->amount_paid,
        'pendingDue' => $stockValue->pending_due,
        'paymentMethod' => $paymentModeArr[$stockValue->payment_mode],
    ];


    $mainModel[] = $modelArray;
}

$vendorModel1 = fetch_all($db, "SELECT * FROM `vendor`");

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Product Purchase Report- <?= SALONNAME ?></title>

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
                                <h6>Product Purchase Report</h6>
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
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Vendor</label>
                                                <select name="vendor_id" id="vendor_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($vendorModel1 as $vendorKey1 => $vendorVal1) {
                                                        $vendorValue1 = (object) $vendorVal1; ?>
                                                        <option value="<?= $vendorValue1->id ?>" <?= ($vendorValue1->id == $vendor_id) ? 'selected' : '' ?>><?= $vendorValue1->vendor_name ?></option>
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
                                                    <a href="advance-product-purchase-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Purchase Date</th>
                                            <th>Invoice</th>
                                            <th>Vendor Name</th>
                                            <th>Product Name</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Tax</th>
                                            <th>Net Amount</th>
                                            <th>Shipping Charges</th>
                                            <th>Total Price</th>
                                            <th>Paid</th>
                                            <th>Pending Due</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);
                                            $productCount = count($productArray);
                                            if ($productCount > 0) {
                                                foreach ($productArray as $productArrayKey => $productArrayVal) {
                                                    extract($productArrayVal);

                                                    if ($productArrayKey == 0) {

                                        ?>
                                                        <tr>

                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $count ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $purchaseDate ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $invoiceNumber ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $vendorName ?></td>
                                                            <td><?= $productName ?></td>
                                                            <td><?= $unit ?></td>
                                                            <td><?= $price ?></td>
                                                            <td><?= $quantity ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $amount ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $discount ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>">
                                                                <p><b>Inclusive : </b><?= $inclusiveTax ?></p>
                                                                <p><b>Exclusive : </b><?= $exclusiveTax ?></p>
                                                            </td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $netAmount ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $shippingCharge ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $totalPrice ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $paid ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $pendingDue ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $paymentMethod ?></td>
                                                        </tr>
                                                    <?php
                                                    } else { ?>
                                                        <tr>
                                                            <td><?= $productName ?></td>
                                                            <td><?= $unit ?></td>
                                                            <td><?= $price ?></td>
                                                            <td><?= $quantity ?></td>
                                                        </tr>
                                        <?php
                                                    }
                                                }
                                            }
                                        } ?>
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
    <script type="text/javascript" src="./js/pages/advance-product-purchase-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>