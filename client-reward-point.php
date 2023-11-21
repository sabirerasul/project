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

    <title>Client Reward Point - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/pages/client-tab.css">

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

                        <div class="col-12">
                            <?php include('./comman/client-tabs.php') ?>
                        </div>

                        <div class="col-12 bg-white">
                            <div id="reward_point" class="tabcontent">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="d-block p-2 bg-dark rounded text-white">Reward Point</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTableAppointment" width="100%" cellspacing="0">
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
                                                <tbody class="table-data">
                                                    <?php
                                                    if (count($rewardPointModel) > 0) {
                                                        $count = 0;
                                                        foreach ($rewardPointModel as $walletKey => $rewardPointVal) {
                                                            $rewardPointValue = (object) $rewardPointVal;
                                                            $count++;
                                                            //$branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$rewardPointValue->branch_id}'");
                                                    ?>
                                                            <tr>
                                                                <td><?= $count ?></td>
                                                                <td><?= formatDate($rewardPointValue->created_at) ?></td>
                                                                <td><?php /*= $branchModel->branch_name */ ?></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><?= $rewardPointValue->transaction_type ?></td>
                                                                <td><?= $rewardPointValue->points ?></td>
                                                                <td></td>
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
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script>
        $(document).ready(function() {
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTableAppointment').DataTable();
        }
    </script>

<?php include('./comman/loading.php'); ?>
</body>

</html>