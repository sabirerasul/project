<?php
require_once "lib/db.php";
check_auth();

$id = $_GET['id'];
$model = fetch_object($db, "SELECT * FROM client WHERE id='{$id}'");
$rewardPointModel = fetch_all($db, "SELECT * FROM reward_point WHERE client_id='{$id}' ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reward Point - <?= SALONNAME ?></title>

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

                <?php include('./comman/client-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Reward Point</h6>
                                    <p class="text-bold text-success"><?= "Reward Points " . get_client_reward_point($db, $id) ?></p>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date/Time</th>
                                                    <th>Branch</th>
                                                    <th>Bill / Appointment ID</th>
                                                    <th>Point On</th>
                                                    <th>Transaction Type</th>
                                                    <th>Points</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($rewardPointModel) > 0) {
                                                    $count = 0;
                                                    foreach ($rewardPointModel as $walletKey => $rewardPointVal) {
                                                        $rewardPointValue = (object) $rewardPointVal;
                                                        $count++;
                                                        $transaction_type = ($rewardPointValue->transaction_type == 'Credit') ? "<span class='text-success'>{$rewardPointValue->transaction_type}</span>" : "<span class='text-danger'>{$rewardPointValue->transaction_type}</span>";
                                                        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$rewardPointValue->branch_id}'");

                                                        $notes = '';
                                                        $point_on = '';
                                                        if ($rewardPointValue->type == 'billing') {
                                                            $billModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$rewardPointValue->app_bill_id}'");
                                                            $notes = !empty($billModel) ? $billModel->notes : '';
                                                            $point_on = !empty($billModel) ? get_client_billing_service($db, $billModel->id) : '';
                                                        } else {
                                                            $appModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$rewardPointValue->app_bill_id}'");
                                                            $notes = $appModel->notes;

                                                            $serviceTitle = '';
                                                            $billingProductModel = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id='{$appModel->id}'");
                                                            foreach ($billingProductModel as $serviceKey => $serviceValue) {
                                                                $serviceObject = (object) $serviceValue;

                                                                $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$serviceObject->service_id}'");
                                                                $enquiryForText = $serviceModel->service_name;
                                                                $serviceTitle .= $enquiryForText . ", ";
                                                            }

                                                            $point_on = $serviceTitle;
                                                        }
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= date("d/m/Y g:i A", strtotime($rewardPointValue->created_at)) ?></td>
                                                            <td><?= $branchModel->branch_name ?></td>
                                                            <td><?= "{$rewardPointValue->type}, {$rewardPointValue->app_bill_id}" ?></td>
                                                            <td><?= $point_on ?></td>
                                                            <td><?= $transaction_type ?></td>
                                                            <td><?= $rewardPointValue->points ?></td>
                                                            <td><?= $notes ?></td>
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