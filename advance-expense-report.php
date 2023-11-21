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
    $expense_type_id = 0;
    $payment_method_id = 0;
}

$mainModel = [];

$expenseTypeModel = fetch_all($db, "SELECT id,title FROM `expense_type` WHERE created_at BETWEEN '{$start_date}' AND '{$end_date}'");

$cond = query_maker(['expense_type_id' => $expense_type_id, 'payment_mode' => $payment_method_id]);

$expenseModel = fetch_all($db, "SELECT * FROM `expense` WHERE {$cond}");

foreach ($expenseModel as $expenseKey => $expenseVal) {
    $expenseValue = (object) $expenseVal;

    $dbDate = getDateServerFormat($expenseValue->date);

    if ($start_date > $dbDate || $end_date < $dbDate) {
        continue;
    }

    $type_of_expense = fetch_object($db, "SELECT `title` FROM `expense_type` WHERE `id`='{$expenseValue->expense_type_id}'")->title;
    $recipient_name = fetch_object($db, "SELECT `recipient_name` FROM `expense_recipient` WHERE `id`='{$expenseValue->recipient_name_id}'")->recipient_name;

    $payment_mode = $paymentModeArr[$expenseValue->payment_mode];

    $modelArray = [
        'date' => $expenseValue->date,
        'type_of_expense' => $type_of_expense,
        'amount' => $expenseValue->amount_paid,
        'payment_mode' => $payment_mode,
        'recipient_name' => $recipient_name,
        'paid_by' => 'admin',
        'notes' => $expenseValue->description,
    ];

    $mainModel[] = $modelArray;
}

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date) . " - " . formatDate($end_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Advance Expense Report- <?= SALONNAME ?></title>

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
                                <h6>Expense Report</h6>
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
                                                <label for="expense_type_id" class="expense_type_id_label required">Expense Type</label>
                                                <select name="expense_type_id" id="expense_type_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($expenseTypeModel as $expenseTypeKey => $expenseTypeVal) {
                                                        $expenseTypeValue = (object) $expenseTypeVal; ?>
                                                        <option value="<?= $expenseTypeValue->id ?>" <?= ($expenseTypeValue->id == $expense_type_id) ? 'selected' : '' ?>><?= $expenseTypeValue->title ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="payment_method_id" class="payment_method_id_label required">Payment Method</label>
                                                <select name="payment_method_id" id="payment_method_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($paymentModeArr as $paymentModeArrKey => $paymentModeArrVal) {
                                                    ?>
                                                        <option value="<?= $paymentModeArrKey ?>" <?= ($paymentModeArrKey == $payment_method_id) ? 'selected' : '' ?>><?= $paymentModeArrVal ?></option>
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
                                                    <a href="advance-expense-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
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
                                            <th>Date</th>
                                            <th>Type Of Expense</th>
                                            <th>Amount</th>
                                            <th>Payment Mode</th>
                                            <th>Recipient Name</th>
                                            <th>Paid By</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php
                                        $count = 0;

                                        $sAmount = [0];
                                        foreach ($mainModel as $modelKey => $modelVal) {
                                            $modelValue = (object) $modelVal;
                                            $count++;

                                            $sAmount[] = $modelValue->amount;
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= $modelValue->date ?></td>
                                                <td><?= $modelValue->type_of_expense ?></td>
                                                <td><?= $modelValue->amount ?></td>
                                                <td><?= $modelValue->payment_mode ?></td>
                                                <td><?= $modelValue->recipient_name ?></td>
                                                <td><?= $modelValue->paid_by ?></td>
                                                <td><?= $modelValue->notes ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        $tAmount = array_sum($sAmount);
                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th><?= $tAmount ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
    <script type="text/javascript" src="./js/pages/advance-expense-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>