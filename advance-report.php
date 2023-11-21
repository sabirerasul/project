<?php
require('./lib/db.php');
check_auth();
extract($_REQUEST);

$todayDate = date("Y-m-d");
$start_date = $todayDate;
$end_date = $todayDate;

$start_year_date = date("Y", strtotime($todayDate));
$end_year_date = date("Y", strtotime($todayDate));

$startDate = $start_date;

$start_month_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($todayDate)) . ", first day of this month"));
$end_month_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($todayDate)) . ", last day of this month"));

$start_year_date = date("Y-m-d", strtotime('first day of January ' . date('Y')));
$end_year_date = date("Y-m-d", strtotime('last day of December ' . date('Y')));

$sql = "SELECT * FROM client_billing";
$model = fetch_all($db, $sql);

$dcash = [0];
$donlinePayment = [0];
$dcreditDebitCard = [0];
$dcheque = [0];
$dwallet = [0];
$dpaytm = [0];
$dgPay = [0];
$dphonePe = [0];
$drewardPoint = [0];

$mcash = [0];
$monlinePayment = [0];
$mcreditDebitCard = [0];
$mcheque = [0];
$mwallet = [0];
$mpaytm = [0];
$mgPay = [0];
$mphonePe = [0];
$mrewardPoint = [0];

$ycash = [0];
$yonlinePayment = [0];
$ycreditDebitCard = [0];
$ycheque = [0];
$ywallet = [0];
$ypaytm = [0];
$ygPay = [0];
$yphonePe = [0];
$yrewardPoint = [0];


$count = 0;
foreach ($model as $key => $val) {
    $modelValue1 = (object) $val;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($modelValue1->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $dcash[] = getTotalPaymentMode($db, $modelValue1->id, 1);
    $dcreditDebitCard[] = getTotalPaymentMode($db, $modelValue1->id, 3);
    $dcheque[] = getTotalPaymentMode($db, $modelValue1->id, 4);
    $donlinePayment[] = getTotalPaymentMode($db, $modelValue1->id, 5);
    $dpaytm[] = getTotalPaymentMode($db, $modelValue1->id, 6);
    $dwallet[] = getTotalPaymentMode($db, $modelValue1->id, 7);
    $drewardPoint[] = getTotalPaymentMode($db, $modelValue1->id, 9);
    $dphonePe[] = getTotalPaymentMode($db, $modelValue1->id, 10);
    $dgPay[] = getTotalPaymentMode($db, $modelValue1->id, 11);
}

$tSubTotal = [0];
$tTax = [0];
$tNetDiscount = [0];
$tGrandTotal = [0];

foreach ($model as $key => $val) {
    $modelValue2 = (object) $val;

    if (!empty($start_month_date) && !empty($end_month_date)) {

        $dbDate = getDateServerFormat($modelValue2->billing_date);

        if ($start_month_date > $dbDate || $end_month_date < $dbDate) {
            continue;
        }
    }

    $mcash[] = getTotalPaymentMode($db, $modelValue2->id, 1);
    $mcreditDebitCard[] = getTotalPaymentMode($db, $modelValue2->id, 3);
    $mcheque[] = getTotalPaymentMode($db, $modelValue2->id, 4);
    $monlinePayment[] = getTotalPaymentMode($db, $modelValue2->id, 5);
    $mpaytm[] = getTotalPaymentMode($db, $modelValue2->id, 6);
    $mwallet[] = getTotalPaymentMode($db, $modelValue2->id, 7);
    $mrewardPoint[] = getTotalPaymentMode($db, $modelValue2->id, 9);
    $mphonePe[] = getTotalPaymentMode($db, $modelValue2->id, 10);
    $mgPay[] = getTotalPaymentMode($db, $modelValue2->id, 11);

    $taxValue = get_tax_value($db, $modelValue2->tax, $modelValue2->sub_total);

    $inclusiveTax = $taxValue['inclusive'];
    $exclusiveTax = $taxValue['exclusive'];

    $tSubTotal[] = $modelValue2->sub_total;
    $tTax[] = ($inclusiveTax + $exclusiveTax);
    $tNetDiscount[] = get_billing_discount($db, $modelValue2->id);
    $tGrandTotal[] = $modelValue2->total;
}

foreach ($model as $key => $val) {
    $modelValue3 = (object) $val;

    if (!empty($start_year_date) && !empty($end_year_date)) {

        $dbDate = getDateServerFormat($modelValue3->billing_date);

        if ($start_year_date > $dbDate || $end_year_date < $dbDate) {
            continue;
        }
    }

    $ycash[] = getTotalPaymentMode($db, $modelValue3->id, 1);
    $ycreditDebitCard[] = getTotalPaymentMode($db, $modelValue3->id, 3);
    $ycheque[] = getTotalPaymentMode($db, $modelValue3->id, 4);
    $yonlinePayment[] = getTotalPaymentMode($db, $modelValue3->id, 5);
    $ypaytm[] = getTotalPaymentMode($db, $modelValue3->id, 6);
    $ywallet[] = getTotalPaymentMode($db, $modelValue3->id, 7);
    $yrewardPoint[] = getTotalPaymentMode($db, $modelValue3->id, 9);
    $yphonePe[] = getTotalPaymentMode($db, $modelValue3->id, 10);
    $ygPay[] = getTotalPaymentMode($db, $modelValue3->id, 11);
}

$dcash = array_sum($dcash);
$donlinePayment = array_sum($donlinePayment);
$dcreditDebitCard = array_sum($dcreditDebitCard);
$dcheque = array_sum($dcheque);
$dwallet = array_sum($dwallet);
$dpaytm = array_sum($dpaytm);
$dgPay = array_sum($dgPay);
$dphonePe = array_sum($dphonePe);
$drewardPoint = array_sum($drewardPoint);
$dTotal = ($dcash + $donlinePayment + $dcreditDebitCard + $dcheque + $dwallet + $dpaytm + $dgPay + $dphonePe + $drewardPoint);

$mcash = array_sum($mcash);
$monlinePayment = array_sum($monlinePayment);
$mcreditDebitCard = array_sum($mcreditDebitCard);
$mcheque = array_sum($mcheque);
$mwallet = array_sum($mwallet);
$mpaytm = array_sum($mpaytm);
$mgPay = array_sum($mgPay);
$mphonePe = array_sum($mphonePe);
$mrewardPoint = array_sum($mrewardPoint);
$mTotal = ($mcash + $monlinePayment + $mcreditDebitCard + $mcheque + $mwallet + $mpaytm + $mgPay + $mphonePe + $mrewardPoint);

$ycash = array_sum($ycash);
$yonlinePayment = array_sum($yonlinePayment);
$ycreditDebitCard = array_sum($ycreditDebitCard);
$ycheque = array_sum($ycheque);
$ywallet = array_sum($ywallet);
$ypaytm = array_sum($ypaytm);
$ygPay = array_sum($ygPay);
$yphonePe = array_sum($yphonePe);
$yrewardPoint = array_sum($yrewardPoint);
$yTotal = ($ycash + $yonlinePayment + $ycreditDebitCard + $ycheque + $ywallet + $ypaytm + $ygPay + $yphonePe + $yrewardPoint);

$newCustomer = num_rows($db, "SELECT * FROM `client` WHERE `created_at` BETWEEN '{$start_month_date}' AND '{$end_month_date}'");

$repeatCustomer = 0;

$monthlyBillingModel = fetch_all($db, "SELECT * FROM `client_billing` WHERE `created_at` BETWEEN '{$start_month_date}' AND '{$end_month_date}'");

$rCid = [];
foreach ($monthlyBillingModel as $monthlyBillingKey => $monthlyBillingVal) {
    $rCid[] = $monthlyBillingVal['client_id'];
}


$count_occurrences = array();

foreach ($rCid as $k => &$v) {
    $count_occurrences[$v] = array(
        'key' => $k,
        'count' => (isset($count_occurrences[$v]['count']) ? ($count_occurrences[$v]['count'] + 1) : 1)
    );
}
unset($v);

foreach ($count_occurrences as &$v) {
    if ($v['count'] === 1) {
        unset($rCid[$v['key']]);
    }
}
unset($v);

$repeatCustomer = count($rCid);





$tSubTotal = array_sum($tSubTotal);
$tTax = array_sum($tTax);
$tNetDiscount = array_sum($tNetDiscount);
$tGrandTotal = array_sum($tGrandTotal);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Sales Report - <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/advance-report.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .enq-for-wrapper {
            display: none;
        }
    </style>
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

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h6>Sales Report</h6>
                            </div>
                        </div>
                        <div class="card-body shadow rounded p-2">

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                    <div class="card sales-card">
                                        <div class="card-header" style="background:#f8f4f4 !important;padding: 10px;">
                                            <center><strong>Daily Sales</strong></center>
                                        </div>
                                        <div class="card-body" style="background:#fff !important;">
                                            <table class="table tbl responsive">
                                                <tbody>
                                                    <tr id="tr">
                                                        <td class="text-left">Cash </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dcash ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Credit/Debit card </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dcreditDebitCard ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Cheque </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dcheque ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Online payment </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $donlinePayment ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Paytm </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dpaytm ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">E-wallet </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dwallet ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Reward points </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $drewardPoint ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">PhonePe </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dphonePe ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Gpay </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $dgPay ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Total</strong></td>
                                                        <td class="text-right">
                                                            <strong><span style="font-size:15px;margin-right:0px;">₹</span> <?= $dTotal ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                    <div class="card sales-card">
                                        <div class="card-header" style="background:#f8f4f4 !important;padding: 10px;">
                                            <center><strong>Monthly Sales</strong></center>
                                        </div>
                                        <div class="card-body" style="background:#fff !important;">
                                            <table class="table tbl responsive">
                                                <tbody>
                                                    <tr id="tr">
                                                        <td class="text-left">Cash </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mcash ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Credit/Debit card </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mcreditDebitCard ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Cheque </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mcheque ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Online payment </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $monlinePayment ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Paytm </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mpaytm ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">E-wallet </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mwallet ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Reward points </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mrewardPoint ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">PhonePe </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mphonePe ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Gpay </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $mgPay ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Total</strong></td>
                                                        <td class="text-right">
                                                            <strong><span style="font-size:15px;margin-right:0px;">₹</span> <?= $mTotal ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                    <div class="card sales-card">
                                        <div class="card-header" style="background:#f8f4f4 !important;padding: 10px;">
                                            <center><strong>Yearly Sales</strong></center>
                                        </div>
                                        <div class="card-body" style="background:#fff !important;">
                                            <table class="table tbl responsive">
                                                <tbody>
                                                    <tr id="tr">
                                                        <td class="text-left">Cash </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ycash ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Credit/Debit card </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ycreditDebitCard ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Cheque </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ycheque ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Online payment </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $yonlinePayment ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Paytm </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ypaytm ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">E-wallet </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ywallet ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Reward points </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $yrewardPoint ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">PhonePe </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $yphonePe ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="tr">
                                                        <td class="text-left">Gpay </td>
                                                        <td class="text-right">
                                                            <span style="font-size:13px;margin-right:0px;">₹</span>
                                                            <?= $ygPay ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Total</strong></td>
                                                        <td class="text-right">
                                                            <strong><span style="font-size:15px;margin-right:0px;">₹</span> <?= $yTotal ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-8 mt-4">
                                    <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div> -->
                                    <canvas id="chartContainer"></canvas>
                                </div>

                                <div class="col-lg-4 mt-4">
                                    <div class="card sales-card">
                                        <div class="card-header" style="background:#f8f4f4 !important;padding:10px;">
                                            <center><strong>Customers</strong></center>
                                        </div>
                                        <div class="card-body" style="background:#fff !important;">
                                            <br><br>
                                            <div align="center"><button class="button btn btn-success" onclick="window.open('client.php', '_blank')">Total Customers : <?= get_existing_client($db) ?></button></div>
                                            <br><br>
                                            <div align="center"><button class="button btn btn-success">New Customers : <?= $newCustomer ?></button></div>
                                            <br><br>
                                            <div align="center"><button class="button btn btn-success">Repeated Customers : <?= $repeatCustomer ?></button></div>
                                            <br><br>
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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script type="text/javascript" src="./js/pages/advance-report.js"></script>

        <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

        <script>
            window.onload = function() {
                const ctx = document.getElementById('chartContainer');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Sub Total', 'Tax', 'Net Discount', 'Grand Total'],
                        datasets: [{
                            label: 'Sub Total',
                            data: <?= "[{$tSubTotal}, {$tTax}, {$tNetDiscount}, {$tGrandTotal}]"; ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            };
        </script>
<?php include('./comman/loading.php'); ?>
</body>

</html>