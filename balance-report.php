<?php
require_once "lib/db.php";
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
    $service_provider_id = 0;
    $service_type = 0;
    $service_id = 0;
    $payment_method = 1;
}



$array1 = [
    'date' => '',
    'branch' => '',
    'invoice_number' => '',
    'client_name' => '',
    'contact' => '',
    'advance_received' => '',
    'pending_payment' => '',
    'amount_received' => '',
    'type' => '',
];

$amountReceivedArray = [
    'advance_received' => [0],
    'amount_received' => [0],
];

$array2 = [
    'date' => '',
    'category' => '',
    'amount_paid' => '',
    'paid_by' => '',
];


$amountReceivedModel = [];
$expenseBlankModel = [];
$expensePaid = [0];


$dateArray = displayDates($start_date, $end_date, $format = 'd/m/Y');

foreach ($dateArray as $key => $val) {

    $appointmentModel = fetch_all($db, "SELECT * FROM appointment WHERE appointment_date='{$val}'");

    $expenseModel = fetch_all($db, "SELECT * FROM expense WHERE date='{$val}'");

    if (count($appointmentModel) > 0) {
        foreach ($appointmentModel as $appointmentKey => $appointmentVal) {
            $appointmentValue = (object) $appointmentVal;
            $appBranchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$appointmentValue->branch_id}'");
            $appClientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$appointmentValue->client_id}'");
            $appAmountReceived = $appointmentValue->total - $appointmentValue->pending_due;

            $array1 = [
                'date' => $appointmentValue->appointment_date,
                'branch' => $appBranchModel->branch_name,
                'invoice_number' => '',
                'client_name' => $appClientModel->client_name,
                'contact' => $appClientModel->contact,
                'advance_received' => 0,
                'pending_payment' => $appointmentValue->pending_due,
                'amount_received' => $appAmountReceived,
                'type' => 'Appointment',
            ];

            $amountReceivedModel[] = $array1;

            $billingModel  = fetch_object($db, "SELECT * FROM client_billing WHERE appointment_id='{$appointmentValue->id}'");
            if (!empty($billingModel)) {
                $billBranchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
                $billClientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$billingModel->client_id}'");

                $billAmountReceived = $billingModel->total - ($billingModel->advance_receive + $billingModel->pending_amount);
                $array1 = [
                    'date' => $billingModel->billing_date,
                    'branch' => $billBranchModel->branch_name,
                    'invoice_number' => $billingModel->invoice_number,
                    'client_name' => $billClientModel->client_name,
                    'contact' => $billClientModel->contact,
                    'advance_received' => $billingModel->advance_receive,
                    'pending_payment' => $billingModel->pending_amount,
                    'amount_received' => $billAmountReceived,
                    'type' => 'Bill',
                ];

                $amountReceivedModel[] = $array1;


                $receivePendingPaymentModel = fetch_all($db, "SELECT * FROM `pending_payment_history` WHERE `app_bill_id`='{$billingModel->id}' AND `bill_type`='pending payment'");


                foreach ($receivePendingPaymentModel as $receivePendingPaymentKey => $receivePendingPaymentVal) {
                    $receivePendingPaymentValue = (object) $receivePendingPaymentVal;
                    $ppBranchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
                    $ppclientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$receivePendingPaymentValue->client_id}'");
                    // /$paymentMode = !empty($appointmentPaymentModeArr[$value->payment_mode]) ? $appointmentPaymentModeArr[$receivePendingPaymentValue->payment_mode] : '';

                    $array1 = [
                        'date' => $receivePendingPaymentValue->date,
                        'branch' => $ppBranchModel->branch_name,
                        'invoice_number' => $billingModel->invoice_number,
                        'client_name' => $ppclientModel->client_name,
                        'contact' => $ppclientModel->contact,
                        'advance_received' => $receivePendingPaymentValue->advance,
                        'pending_payment' => $receivePendingPaymentValue->pending,
                        'amount_received' => $receivePendingPaymentValue->paid,
                        'type' => 'Pending Payment',
                    ];

                    $amountReceivedModel[] = $array1;
                }
            }
        }
    }



    if (count($expenseModel) > 0) {
        foreach ($expenseModel as $expenseKey => $expenseVal) {
            $expenseValue = (object) $expenseVal;
            $expenseCategoryModel = fetch_object($db, "SELECT * FROM expense_type WHERE id='{$expenseValue->expense_type_id}'");

            $category = !empty($expenseCategoryModel) ? $expenseCategoryModel->title : '';

            $array2 = [
                'date' => $expenseValue->date,
                'category' => $category,
                'amount_paid' => $expenseValue->amount_paid,
                'paid_by' => 'Admin',
            ];

            $expenseBlankModel[] = $array2;
        }
    }
}

rsort($amountReceivedModel);
rsort($expenseBlankModel);

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date)." - ".formatDate($end_date);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Balance Report - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./css/site.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->
                                    <!-- <div class="col-md-4 mb-3">
                                        <div class="">
                                            <select name="" class="form-select payment-method" onchange="setBalanceReportTitle(this)">
                                                <?php
                                                foreach ($appointmentPaymentModeArr as $appointmentPaymentModeArrKey => $appointmentPaymentModeArrVal) { ?>
                                                    <option value="<?= $appointmentPaymentModeArrKey ?>"><?= $appointmentPaymentModeArrVal ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="balance-report-title">Balance Report</h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel1('xlsx')">Export</div>
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
                                                            <a href="balance-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable1">
                                            <thead>

                                                <tr style="background-color: #ddd;">
                                                    <td colspan="2"><strong>From:</strong> <?= $start_date ?></td>
                                                    <td colspan="2"><strong>To:</strong> <?= $end_date ?></td>
                                                    <td colspan="3"></td>
                                                    <td><!--<strong>Opening Balance: </strong>--></td>
                                                    <td colspan="2"><strong></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="10"><strong>Amount Received</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Branch</th>
                                                    <th>Invoice Number</th>
                                                    <th>Client Name</th>
                                                    <th>Contact</th>
                                                    <th>Advance Received</th>
                                                    <th>Pending Payment</th>
                                                    <th>Amount Received</th>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($amountReceivedModel) > 0) {
                                                    $count1 = 0;
                                                    foreach ($amountReceivedModel as $amountReceivedKey => $amountReceivedVal) {
                                                        $amountReceivedValue = (object) $amountReceivedVal;
                                                        $count1++;

                                                        //$amountReceivedArray['advance_received'][] = $amountReceivedValue->advance_received;
                                                        $amountReceivedArray['amount_received'][] = $amountReceivedValue->amount_received;
                                                ?>
                                                        <tr>
                                                            <td><?= $count1 ?></td>
                                                            <td><?= $amountReceivedValue->date ?></td>
                                                            <td><?= $amountReceivedValue->branch ?></td>
                                                            <td><?= $amountReceivedValue->invoice_number ?></td>
                                                            <td><?= $amountReceivedValue->client_name ?></td>
                                                            <td><?= $amountReceivedValue->contact ?></td>
                                                            <td><?= $amountReceivedValue->advance_received ?></td>
                                                            <td><?= $amountReceivedValue->pending_payment ?></td>
                                                            <td><?= $amountReceivedValue->amount_received ?></td>
                                                            <td><?= $amountReceivedValue->type ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>

                                                <tr style="background-color: #ddd;">
                                                    <td colspan="8"><strong>Total Received:</strong></td>
                                                    <td colspan="2">
                                                        <strong>
                                                            <?php
                                                            //$aAdvance = array_sum($amountReceivedArray['advance_received']);
                                                            $aReceived = array_sum($amountReceivedArray['amount_received']);
                                                            $tR = ($aReceived);

                                                            echo $tR;
                                                            ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->
                                    <!-- <div class="col-md-4 mb-3">
                                        <div class="">
                                            <select name="" class="form-select payment-method" onchange="setBalanceReportTitle(this)">
                                                <?php
                                                foreach ($appointmentPaymentModeArr as $appointmentPaymentModeArrKey => $appointmentPaymentModeArrVal) { ?>
                                                    <option value="<?= $appointmentPaymentModeArrKey ?>"><?= $appointmentPaymentModeArrVal ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="balance-report-title">Expense Report</h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel2('xlsx')">Export</div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable2">
                                            <thead>
                                                <tr>
                                                    <td colspan="6"><strong>Expenses</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Category</th>
                                                    <th>Amount Paid</th>
                                                    <th>Paid By</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($expenseBlankModel) > 0) {
                                                    $count2 = 0;
                                                    foreach ($expenseBlankModel as $expenseKey => $expenseVal) {
                                                        $expenseValue = (object) $expenseVal;
                                                        $count2++;

                                                        $expensePaid[] = $expenseValue->amount_paid;
                                                ?>
                                                        <tr>
                                                            <td><?= $count2 ?></td>
                                                            <td><?= $expenseValue->date ?></td>
                                                            <td><?= $expenseValue->category ?></td>
                                                            <td><?= $expenseValue->amount_paid ?></td>
                                                            <td><?= $expenseValue->paid_by ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                            <tr style="background-color: #ddd;">
                                                <td colspan="3"><strong>Total Paid:</strong></td>
                                                <td colspan="2"><strong><?= array_sum($expensePaid) ?></strong></td>
                                            </tr>
                                            <!-- <tr style="background-color: #ddd;">
                                                <td colspan="3"><strong>Closing Balance:</strong></td>
                                                <td colspan="2"><strong>0 /-</strong></td>
                                            </tr> -->
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
    <script type="text/javascript" src="./js/pages/balance-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>