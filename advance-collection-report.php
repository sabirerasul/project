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

    // LIKE '%{$filterenquiry_for}%' AND `enquiry_table_type` LIKE '%{$filterenquiry_table_type}%' AND `enquiry_type` LIKE '%{$filterenquiry_type}%' AND `source_of_enquiry` LIKE '%{$filtersource_of_enquiry}%' AND `leaduser` LIKE '%{$filterleaduser}%'";
} else {

    $todayDate = todayDate();
    $start_date = getDateServerFormat($todayDate);
    $end_date = getDateServerFormat($todayDate);
}

$mainModel = [];


$sql = "SELECT * FROM client_billing";
$model = fetch_all($db, $sql);


$pendingPaymentModel = fetch_object($db, "SELECT sum(paid) as paid FROM `pending_payment_history` WHERE bill_type='pending payment' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$walletModel = fetch_object($db, "SELECT sum(amount) as amount FROM `client_wallet` WHERE amount_receive_from='Add_wallet' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$type = '';
$invoice_number = '';
$client_name = '';
$client_number = '';

$billDate = [0];
$serviceAmount = [0];
$productAmount = [0];
$packageAmount = [0];
$membershipAmount = [0];
$walletAmount = !empty($walletModel->amount) ? $walletModel->amount : 0;
$pendingAmountReceived = !empty($pendingPaymentModel->paid) ? $pendingPaymentModel->paid : 0;
$appointmentAdvance = [0];
$pendingPayment = [0];
$totalInvoiceAmount = [0];
$discount = [0];
$netSale = [0];
$inclusiveTax = [0];
$exclusiveTax = [0];
$grandSale = [0];
$totalCollection = [0];
$cash = [0];
$creditDebitCard = [0];
$cheque = [0];
$onlinePayment = [0];
$paytm = [0];
$wallet = [0];
$rewardPoint = [0];
$phonePe = [0];
$gPay = [0];
$pendingPaymentClient = [0];
$billing_date = '';

foreach ($model as $key => $val) {
    $modelValue = (object) $val;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($modelValue->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $clientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$modelValue->client_id}'");

    $type = "Invoice";
    $invoice_number = $modelValue->invoice_number;
    $client_name = $clientModel->client_name;
    $client_number = $clientModel->contact;


    $serviceAmount = get_billing_product_amount($db, $modelValue->id, 'service');
    $productAmount = get_billing_product_amount($db, $modelValue->id, 'stock');
    $packageAmount = get_billing_product_amount($db, $modelValue->id, 'package');
    $membershipAmount = get_billing_product_amount($db, $modelValue->id, 'membership');
    $discount = get_billing_discount($db, $modelValue->id);

    $totalInvoiceAmount = $modelValue->total;
    $pendingPayment = $modelValue->pending_amount;
    $appointmentAdvance = $modelValue->advance_receive;

    $cash = getTotalPaymentMode($db, $modelValue->id, 1);
    $creditDebitCard = getTotalPaymentMode($db, $modelValue->id, 3);
    $cheque = getTotalPaymentMode($db, $modelValue->id, 4);
    $onlinePayment = getTotalPaymentMode($db, $modelValue->id, 5);
    $paytm = getTotalPaymentMode($db, $modelValue->id, 6);
    $wallet = getTotalPaymentMode($db, $modelValue->id, 7);
    $rewardPoint = getTotalPaymentMode($db, $modelValue->id, 9);
    $phonePe = getTotalPaymentMode($db, $modelValue->id, 10);
    $gPay = getTotalPaymentMode($db, $modelValue->id, 11);

    $taxValue = get_tax_value($db, $modelValue->tax, $modelValue->sub_total);

    $netSale = $modelValue->sub_total;
    $grandSale = $modelValue->total;

    $inclusiveTax = $taxValue['inclusive'];
    $exclusiveTax = $taxValue['exclusive'];

    $totalCollection = (($totalInvoiceAmount - $pendingPayment) + $walletAmount);

    $modelArray = [
        'type' => $type,
        'invoice_number' => $invoice_number,
        'client_name' => $client_name,
        'client_number' => $client_number,
        'billDate' => $modelValue->billing_date,
        'serviceAmount' => $serviceAmount,
        'productAmount' => $productAmount,
        'packageAmount' => $packageAmount,
        'membershipAmount' => $membershipAmount,
        'walletAmount' => $walletAmount,
        'pendingAmountReceived' => $pendingAmountReceived,
        'appointmentAdvance' => $appointmentAdvance,
        'pendingPayment' => $pendingPayment,
        'totalInvoiceAmount' => $totalInvoiceAmount,
        'discount' => $discount,
        'netSale' => $netSale,
        'inclusiveTax' => $inclusiveTax,
        'exclusiveTax' => $exclusiveTax,
        'grandSale' => $grandSale,
        'totalCollection' => $totalCollection,
        'cash' => $cash,
        'creditDebitCard' => $creditDebitCard,
        'cheque' => $cheque,
        'onlinePayment' => $onlinePayment,
        'paytm' => $paytm,
        'wallet' => $wallet,
        'rewardPoint' => $rewardPoint,
        'phonepe' => $phonePe,
        'gpay' => $gPay
    ];
    $mainModel[] = $modelArray;
}






$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Collection Report- <?= SALONNAME ?></title>

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
                                <h6>Collection Report</h6>
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
                                                    <a href="advance-collection-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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

                                            <th>Type</th>
                                            <th>Invoice Number</th>
                                            <th>Client Name</th>
                                            <th>Client Number</th>
                                            <th>Service Amount</th>
                                            <th>Product Amount</th>
                                            <th>Package Amount</th>
                                            <th>Membership Amount</th>
                                            <th>Wallet Amount</th>
                                            <th>Pending Amount Received</th>
                                            <th>Appointment Advance</th>
                                            <th>Pending Payment</th>
                                            <th>Discount</th>
                                            <th>Tax</th>
                                            <th>Net Sale</th>
                                            <th>Grand Sale</th>
                                            <th>Total Collection</th>
                                            <th>Cash</th>
                                            <th>Credit/Debit Card</th>
                                            <th>Cheque</th>
                                            <th>Online Payment</th>
                                            <th>Paytm</th>
                                            <th>Wallet</th>
                                            <th>Reward Point</th>
                                            <th>Phonepe</th>
                                            <th>Gpay</th>
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
                                        $spendingAmountReceived = [0];
                                        $sappointmentAdvance = [0];
                                        $spendingPayment = [0];
                                        $stotalInvoiceAmount = [0];
                                        $sdiscount = [0];
                                        $snetSale = [0];
                                        $sinclusiveTax = [0];
                                        $sexclusiveTax = [0];
                                        $sgrandSale = [0];
                                        $stotalCollection = [0];
                                        $scash = [0];
                                        $screditDebitCard = [0];
                                        $scheque = [0];
                                        $sonlinePayment = [0];
                                        $spaytm = [0];
                                        $swallet = [0];
                                        $srewardPoint = [0];
                                        $sphonePe = [0];
                                        $sgPay = [0];

                                        foreach ($mainModel as $mainKey => $mainValue) {
                                            $count++;
                                            extract($mainValue);


                                            $sserviceAmount[] = $serviceAmount;
                                            $sproductAmount[] = $productAmount;
                                            $spackageAmount[] = $packageAmount;
                                            $smembershipAmount[] = $membershipAmount;
                                            $swalletAmount[] = $walletAmount;
                                            $spendingAmountReceived[] = $pendingAmountReceived;
                                            $sappointmentAdvance[] = $appointmentAdvance;
                                            $spendingPayment[] = $pendingPayment;
                                            $stotalInvoiceAmount[] = $totalInvoiceAmount;
                                            $sdiscount[] = $discount;
                                            $snetSale[] = $netSale;
                                            $sinclusiveTax[] = $inclusiveTax;
                                            $sexclusiveTax[] = $exclusiveTax;
                                            $sgrandSale[] = $grandSale;
                                            $stotalCollection[] = $totalCollection;
                                            $scash[] = $cash;
                                            $screditDebitCard[] = $creditDebitCard;
                                            $scheque[] = $cheque;
                                            $sonlinePayment[] = $onlinePayment;
                                            $spaytm[] = $paytm;
                                            $swallet[] = $wallet;
                                            $srewardPoint[] = $rewardPoint;
                                            $sphonePe[] = $phonePe;
                                            $sgPay[] = $gPay;

                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $billDate ?></td>
                                                <td><?= $type ?></td>
                                                <td><?= $invoice_number ?></td>
                                                <td><?= $client_name ?></td>
                                                <td><?= $client_number ?></td>
                                                <td><?= $serviceAmount ?></td>
                                                <td><?= $productAmount ?></td>
                                                <td><?= $packageAmount ?></td>
                                                <td><?= $membershipAmount ?></td>
                                                <td><?= $walletAmount ?></td>
                                                <td><?= $pendingAmountReceived ?></td>
                                                <td><?= $appointmentAdvance ?></td>
                                                <td><?= $pendingPayment ?></td>

                                                <td><?= $discount ?></td>
                                                <td>
                                                    <p><b>Inclusive : </b><?= $inclusiveTax ?></p>
                                                    <p><b>Exclusive : </b><?= $exclusiveTax ?></p>
                                                </td>


                                                <td><?= $netSale ?></td>
                                                <td><?= $grandSale ?></td>
                                                <td><?= $totalCollection ?></td>
                                                <td><?= $cash ?></td>
                                                <td><?= $creditDebitCard ?></td>
                                                <td><?= $cheque ?></td>
                                                <td><?= $onlinePayment ?></td>
                                                <td><?= $paytm ?></td>
                                                <td><?= $wallet ?></td>
                                                <td><?= $rewardPoint ?></td>
                                                <td><?= $phonePe ?></td>
                                                <td><?= $gPay ?></td>
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
                                        $tpendingAmountReceived = array_sum($spendingAmountReceived);
                                        $tappointmentAdvance = array_sum($sappointmentAdvance);
                                        $tpendingPayment = array_sum($spendingPayment);
                                        $ttotalInvoiceAmount = array_sum($stotalInvoiceAmount);
                                        $tdiscount = array_sum($sdiscount);
                                        $tnetSale = array_sum($snetSale);
                                        $tinclusiveTax = array_sum($sinclusiveTax);
                                        $texclusiveTax = array_sum($sexclusiveTax);
                                        $tgrandSale = array_sum($sgrandSale);
                                        $ttotalCollection = array_sum($stotalCollection);
                                        $tcash = array_sum($scash);
                                        $tcreditDebitCard = array_sum($screditDebitCard);
                                        $tcheque = array_sum($scheque);
                                        $tonlinePayment = array_sum($sonlinePayment);
                                        $tpaytm = array_sum($spaytm);
                                        $twallet = array_sum($swallet);
                                        $trewardPoint = array_sum($srewardPoint);
                                        $tphonePe = array_sum($sphonePe);
                                        $tgPay = array_sum($sgPay);

                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th><?= $tserviceAmount ?></th>
                                            <th><?= $tproductAmount ?></th>
                                            <th><?= $tpackageAmount ?></th>
                                            <th><?= $tmembershipAmount ?></th>
                                            <th><?= $twalletAmount ?></th>
                                            <th><?= $tpendingAmountReceived ?></th>
                                            <th><?= $tappointmentAdvance ?></th>
                                            <th><?= $tpendingPayment ?></th>
                                            <th><?= $tdiscount ?></th>
                                            <th>
                                                <p><b>Inclusive : </b><?= $tinclusiveTax ?></p>
                                                <p><b>Exclusive : </b><?= $texclusiveTax ?></p>
                                            </th>
                                            <th><?= $tnetSale ?></th>
                                            <th><?= $tgrandSale ?></th>
                                            <th><?= $ttotalCollection ?></th>
                                            <th><?= $tcash ?></th>
                                            <th><?= $tcreditDebitCard ?></th>
                                            <th><?= $tcheque ?></th>
                                            <th><?= $tonlinePayment ?></th>
                                            <th><?= $tpaytm ?></th>
                                            <th><?= $twallet ?></th>
                                            <th><?= $trewardPoint ?></th>
                                            <th><?= $tphonePe ?></th>
                                            <th><?= $tgPay ?></th>
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
    <script type="text/javascript" src="./js/pages/advance-collection-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>