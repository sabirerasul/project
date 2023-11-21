<?php
require('./lib/db.php');
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
    $client_id = 0;
    $stock_id = 0;
}

$mainModel = [];

$cond = query_maker(['client_id' => $client_id]);

$billingModel = fetch_all($db, "SELECT * FROM `client_billing` WHERE {$cond} ORDER BY id ASC");

foreach ($billingModel as $billingKey => $billingVal) {

    $billingValue = (object) $billingVal;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($billingValue->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $cond2 = ($stock_id != 0) ? "AND `service_id`='{$stock_id}'" : '';
    $billingProductModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billingValue->id}' AND `service_type`='stock' {$cond2}");
    $billingClientModel = fetch_object($db, "SELECT * FROM `client` WHERE `id`='{$billingValue->client_id}'");
    $taxValue = get_tax_value($db, $billingValue->tax, $billingValue->sub_total);

    $inclusiveTax = $taxValue['inclusive'];
    $exclusiveTax = $taxValue['exclusive'];
    $paymentMode = '';
    $discount = get_billing_discount($db, $billingValue->id);

    $billingPaymentModel = fetch_all($db, "SELECT * FROM `client_billing_payment` WHERE `billing_id`='{$billingValue->id}'");
    foreach ($billingPaymentModel as $billingPaymentKey => $billingPaymentVal) {
        $paymentMode .= "<br>" . $appointmentPaymentModeArr[$billingPaymentVal['method']];
    }

    if (count($billingProductModel) > 0) {
        $productArray = [];
        foreach ($billingProductModel as $billingProductKey => $billingProductVal) {
            $billingProductValue = (object) $billingProductVal;

            $stockModel = fetch_object($db, "SELECT * FROM {$billingProductValue->service_type} WHERE id='{$billingProductValue->service_id}'");

            $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$stockModel->product_id}'");

            $billingServiceProvider = fetch_object($db, "SELECT * FROM `client_billing_assign_service_provider` WHERE `billing_id`='{$billingProductValue->billing_id}' AND `billing_service_id`='{$billingProductValue->id}'");


            $billingAssignServiceProviderId = !empty($billingServiceProvider) ? $billingServiceProvider->service_provider_id : 0;
            $bServiceProvider = fetch_object($db, "SELECT * FROM `service_provider` WHERE `id`='{$billingAssignServiceProviderId}'");

            $serviceProviderTitle = !empty($bServiceProvider) ? "{$bServiceProvider->name}<br>({$bServiceProvider->contact_number})" : '';

            $productArray[] = [
                'productName' => $productModel->product,
                'unit' => $stockModel->unit,
                'price' => $billingProductValue->price,
                'quantity' => $billingProductValue->quantity,
                'amount' => ($billingProductValue->price * $billingProductValue->quantity),
                'soldBy' => $serviceProviderTitle,
            ];
        }

        $modelArray = [
            'billDate' => $billingValue->billing_date,
            'invoiceNumber' => $billingValue->invoice_number,
            'clientName' => $billingClientModel->client_name,
            'clientNumber' => $billingClientModel->contact,
            'productArray' => $productArray,
            'discount' => $discount,
            'subTotal' => $billingValue->sub_total,
            'inclusiveTax' => $inclusiveTax,
            'exclusiveTax' => $exclusiveTax,
            'grandTotal' => $billingValue->total,
            'paymentMethod' => $paymentMode,
        ];

        $mainModel[] = $modelArray;
    }
}

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

$stockModel = fetch_all($db, "SELECT * FROM `stock`");
$clientModel = fetch_all($db, "SELECT * FROM `client`");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Product Sale Report- <?= SALONNAME ?></title>

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
                                <h6>Product Sale Report</h6>
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
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Product</label>
                                                <select name="stock_id" id="stock_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($stockModel as $stockKey => $stockVal) {
                                                        $stockValue = (object) $stockVal;
                                                        $productModel = fetch_object($db, "SELECT * FROM `product` WHERE id='{$stockValue->product_id}'");
                                                        $availableStock = availableStock($db, $stockValue->id)
                                                    ?>
                                                        <option value="<?= $stockValue->id ?>" <?= ($stockValue->id == $stock_id) ? 'selected' : '' ?>><?= "{$productModel->product} ({$availableStock} {$productModel->unit})" ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Client</label>
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
                                                    <a href="advance-product-sale-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Product Name</th>
                                            <th>Unit</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Sold By</th>
                                            <th>Discount</th>
                                            <th>Subtotal</th>
                                            <th>Tax</th>
                                            <th>Grand Total</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;

                                        $sprice = [0];
                                        $squantity = [0];
                                        $samount = [0];
                                        $sdiscount = [0];
                                        $ssubTotal = [0];
                                        $sinclusiveTax = [0];
                                        $sexclusiveTax = [0];
                                        $sgrandTotal = [0];

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);
                                            $productCount = count($productArray);



                                            if ($productCount > 0) {;
                                                $sdiscount[] = $discount;
                                                $ssubTotal[] = $subTotal;
                                                $sinclusiveTax[] = $inclusiveTax;
                                                $sexclusiveTax[] = $exclusiveTax;
                                                $sgrandTotal[] = $grandTotal;

                                                foreach ($productArray as $productArrayKey => $productArrayVal) {
                                                    extract($productArrayVal);

                                                    if ($productArrayKey == 0) {

                                                        $sprice[] = $price;
                                                        $squantity[] = $quantity;
                                                        $samount[] = $amount

                                        ?>
                                                        <tr>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $count ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $billDate ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $invoiceNumber ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $clientName ?></td>
                                                            <td><?= $productName ?></td>
                                                            <td><?= $unit ?></td>
                                                            <td><?= $price ?></td>
                                                            <td><?= $quantity ?></td>
                                                            <td><?= $amount ?></td>
                                                            <td><?= $soldBy ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $discount ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $subTotal ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>">
                                                                <p><b>Inclusive : </b><?= $inclusiveTax ?></p>
                                                                <p><b>Exclusive : </b><?= $exclusiveTax ?></p>
                                                            </td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $grandTotal ?></td>
                                                            <td style="vertical-align:middle;" rowspan="<?= $productCount ?>"><?= $paymentMethod ?></td>
                                                        </tr>
                                                    <?php
                                                    } else { ?>
                                                        <tr>
                                                            <td><?= $productName ?></td>
                                                            <td><?= $unit ?></td>
                                                            <td><?= $price ?></td>
                                                            <td><?= $quantity ?></td>
                                                            <td><?= $amount ?></td>
                                                            <td><?= $soldBy ?></td>
                                                        </tr>
                                        <?php
                                                    }
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php

                                        $tprice = array_sum($sprice);
                                        $tquantity = array_sum($squantity);
                                        $tamount = array_sum($samount);
                                        $tdiscount = array_sum($sdiscount);
                                        $tsubTotal = array_sum($ssubTotal);
                                        $tinclusiveTax = array_sum($sinclusiveTax);
                                        $texclusiveTax = array_sum($sexclusiveTax);
                                        $tgrandTotal = array_sum($sgrandTotal);

                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th></th>
                                            <th><?= $tprice ?></th>
                                            <th><?= $tquantity ?></th>
                                            <th><?= $tamount ?></th>
                                            <th></th>
                                            <th><?= $tdiscount ?></th>
                                            <th><?= $tsubTotal ?></th>
                                            <th>
                                                <p><b>Inclusive : </b><?= $tinclusiveTax ?></p>
                                                <p><b>Exclusive : </b><?= $texclusiveTax ?></p>
                                            </th>
                                            <th><?= $tgrandTotal ?></th>
                                            <th></th>
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
    <script type="text/javascript" src="./js/pages/advance-product-sale-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>