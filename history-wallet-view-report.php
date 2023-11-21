<?php
require_once "lib/db.php";
check_auth();

$id = $_GET['cid'];
$model = fetch_object($db, "SELECT * FROM client WHERE id='{$id}'");
$walletModel = fetch_all($db, "SELECT * FROM client_wallet WHERE client_id='{$id}' ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wallet Report - <?= SALONNAME ?></title>

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

    <link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
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
                <?php include('./comman/history-report-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div>
                                        <h6 class="m-0 font-weight-bold text-primary"><?= $model->client_name ?>'s Wallet Credit/Debit History</h6>
                                        <div class="alert alert-success mt-3">
                                            <i class="fas fa-solid fa-wallet"></i> <strong>Your Wallet Balance </strong>INR <?= get_client_wallet($db, $model->id) ?> /-
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date/Time</th>
                                                    <th>Branch</th>
                                                    <th>Transaction Type</th>
                                                    <th>Advance Paid</th>
                                                    <th>Wallet Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Amount Received From</th>
                                                    <th>Description</th>
                                                    <th>Bill ID</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($walletModel) > 0) {
                                                    $count = 0;
                                                    foreach ($walletModel as $walletKey => $walletVal) {
                                                        $walletValue = (object) $walletVal;
                                                        $count++;
                                                        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$walletValue->branch_id}'");
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $walletValue->date ?></td>
                                                            <td><?= $branchModel->branch_name ?></td>
                                                            <td><?= $walletValue->transaction_type ?></td>
                                                            <td><?= $walletValue->paid_amount ?></td>
                                                            <td><?= $walletValue->amount ?></td>
                                                            <td><?= !empty($appointmentPaymentModeArr[$walletValue->payment_method]) ? $appointmentPaymentModeArr[$walletValue->payment_method] : ''; ?></td>
                                                            <td></td>
                                                            <td><?= $walletValue->notes ?></td>
                                                            <td><?= $walletValue->bill_id ?></td>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>

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
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }
    </script>

<?php include('./comman/loading.php'); ?>
</body>

</html>