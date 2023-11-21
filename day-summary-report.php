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

    // LIKE '%{$filterenquiry_for}%' AND `enquiry_table_type` LIKE '%{$filterenquiry_table_type}%' AND `enquiry_type` LIKE '%{$filterenquiry_type}%' AND `source_of_enquiry` LIKE '%{$filtersource_of_enquiry}%' AND `leaduser` LIKE '%{$filterleaduser}%'";
} else {

    $todayDate = todayDate();
    $start_date = getDateServerFormat($todayDate);
    $end_date = getDateServerFormat($todayDate);
}

$walletModel = fetch_object($db, "SELECT sum(amount) as amount FROM `client_wallet` WHERE amount_receive_from='Add_wallet' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$pendingPaymentModel = fetch_object($db, "SELECT sum(paid) as paid FROM `pending_payment_history` WHERE bill_type='pending payment' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$commissionModel = fetch_object($db, "SELECT sum(commission) as commission FROM `service_provider_commission_history` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$expenseModel = fetch_object($db, "SELECT sum(amount_paid) as amount_paid FROM `expense` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");

$sql = "SELECT * FROM client_billing WHERE {$cond}";
$model = fetch_all($db, $sql);

$totalInvoiceAmount = [0];
$pendingPaymentClient = [0];
$totalCollection = 0;
$productSale = [0];
$serviceSale = [0];
$packageSale = [0];
$membershipSale = [0];
$pendingPaymentReceived = !empty($pendingPaymentModel->paid) ? $pendingPaymentModel->paid : 0;
$appointmentAdvance = [0];
$walletRecharge = !empty($walletModel->amount) ? $walletModel->amount : 0;
$cash = [0];
$onlinePayment = [0];
$creditDebitCard = [0];
$cheque = [0];
$wallet = [0];
$paytm = [0];
$gPay = [0];
$phonePe = [0];
$rewardPoint = [0];
$totalDiscountGiven = [0];
$inclusiveTax = [0];
$exclusiveTax = [0];
$discount = [0];
$totalCommisionsPayable = !empty($commissionModel->commission) ? $commissionModel->commission : 0;
$todayClient = 0;
$todayNewClients = num_rows($db, "SELECT id FROM `client` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
$expensesToday = !empty($expenseModel->amount_paid) ? $expenseModel->amount_paid : 0;

$count = 0;
foreach ($model as $key => $val) {

    $modelValue = (object) $val;

    if (!empty($start_date) && !empty($end_date)) {

        $dbDate = getDateServerFormat($modelValue->billing_date);

        if ($start_date > $dbDate || $end_date < $dbDate) {
            continue;
        }
    }

    $count++;
    $serviceSale[] = get_billing_product_amount($db, $modelValue->id, 'service');
    $productSale[] = get_billing_product_amount($db, $modelValue->id, 'stock');
    $packageSale[] = get_billing_product_amount($db, $modelValue->id, 'package');
    $membershipSale[] = get_billing_product_amount($db, $modelValue->id, 'membership');
    $discount[] = get_billing_discount($db, $modelValue->id);

    $totalInvoiceAmount[] = $modelValue->total;
    $pendingPaymentClient[] = $modelValue->pending_amount;
    $appointmentAdvance[] = $modelValue->advance_receive;



    $cash[] = getTotalPaymentMode($db, $modelValue->id, 1);
    $creditDebitCard[] = getTotalPaymentMode($db, $modelValue->id, 3);
    $cheque[] = getTotalPaymentMode($db, $modelValue->id, 4);
    $onlinePayment[] = getTotalPaymentMode($db, $modelValue->id, 5);
    $paytm[] = getTotalPaymentMode($db, $modelValue->id, 6);
    $wallet[] = getTotalPaymentMode($db, $modelValue->id, 7);
    $rewardPoint[] = getTotalPaymentMode($db, $modelValue->id, 9);
    $phonePe[] = getTotalPaymentMode($db, $modelValue->id, 10);
    $gPay[] = getTotalPaymentMode($db, $modelValue->id, 11);

    $taxValue = get_tax_value($db, $modelValue->tax, $modelValue->sub_total);

    $inclusiveTax[] = $taxValue['inclusive'];
    $exclusiveTax[] = $taxValue['exclusive'];
}

$serviceSale = array_sum($serviceSale);
$productSale = array_sum($productSale);
$packageSale = array_sum($packageSale);
$membershipSale = array_sum($membershipSale);
$totalInvoiceAmount = array_sum($totalInvoiceAmount);
$pendingPaymentClient = array_sum($pendingPaymentClient);
$totalCollection = (($totalInvoiceAmount - $pendingPaymentClient) + $walletRecharge);
$appointmentAdvance = array_sum($appointmentAdvance);

$inclusiveTax = array_sum($inclusiveTax);
$exclusiveTax = array_sum($exclusiveTax);

$cash = array_sum($cash);
$onlinePayment = array_sum($onlinePayment);
$creditDebitCard = array_sum($creditDebitCard);
$cheque = array_sum($cheque);
$wallet = array_sum($wallet);
$paytm = array_sum($paytm);
$gPay = array_sum($gPay);
$phonePe = array_sum($phonePe);
$rewardPoint = array_sum($rewardPoint);
$totalDiscountGiven = array_sum($discount);


$todayClient = $count;


//$packageAmount = array_sum($packageAmount);
//$membershipAmount = array_sum($membershipAmount);


$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date)." - ".formatDate($end_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Day Summary Report- <?= SALONNAME ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="./css/site.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link rel="stylesheet" href="./css/pages/enquiry.css">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                            <div class="d-flex justify-content-between mb-2">
                                <h6>Day Summary Report</h6>
                                <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                            </div>
                            <hr>

                            <div>
                                <form action="" method="POST" id="filterEnquiry">
                                    <div class="row">
                                        <div class="col-md-4">
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
                                                    <a href="day-summary-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Sale Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <tr>
                                            <td><strong>Total Invoice Amount</strong></td>
                                            <td><?= $totalInvoiceAmount ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pending Payable By Clients</strong></td>
                                            <td><?= $pendingPaymentClient ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Collection</strong></td>
                                            <td><?= $totalCollection ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Service Sales</strong></td>
                                            <td><?= $serviceSale ?></td>
                                        </tr>

                                        <tr>
                                            <td><strong>Product Sales</strong></td>
                                            <td><?= $productSale ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong>Package Sales</strong></td>
                                            <td><?= $packageSale ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Membership Sales</strong></td>
                                            <td><?= $membershipSale ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pending Payment Received</strong></td>
                                            <td><?= $pendingPaymentReceived ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Appointment Advance</strong></td>
                                            <td><?= $appointmentAdvance ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wallet Recharged</strong></td>
                                            <td><?= $walletRecharge ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Cash</strong></td>
                                            <td><?= $cash ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Online Payment Mode</strong></td>
                                            <td><?= $onlinePayment ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Credit/Debit Card</strong></td>
                                            <td><?= $creditDebitCard ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Cheque</strong></td>
                                            <td><?= $cheque ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Wallet</strong></td>
                                            <td><?= $wallet ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Paytm</strong></td>
                                            <td><?= $paytm ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Gpay</strong></td>
                                            <td><?= $gPay ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By PhonePe</strong></td>
                                            <td><?= $phonePe ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid By Reward Points</strong></td>
                                            <td><?= $rewardPoint ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Discount Given</strong></td>
                                            <td><?= $totalDiscountGiven ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total TAX</strong></td>
                                            <td>
                                                <p><strong>Inclusive tax : </strong><?= $inclusiveTax ?></p>
                                                <p><strong>Exclusive tax : </strong><?= $exclusiveTax ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Commisions Payable</strong></td>
                                            <td><?= $totalCommisionsPayable ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Clients Visit</strong></td>
                                            <td><?= $todayClient ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>New Clients</strong></td>
                                            <td><?= $todayNewClients ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Expenses</strong></td>
                                            <td><?= $expensesToday ?></td>
                                        </tr>
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
    <script type="text/javascript" src="./js/pages/day-summary-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>