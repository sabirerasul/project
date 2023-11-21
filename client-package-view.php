<?php
require_once "lib/db.php";
check_auth();
extract($_REQUEST);

$id = $_GET['id'];
$pkg_id = $_GET['pkg_id'];

$packageClientModel = fetch_object($db, "SELECT * FROM client_package WHERE client_id='{$id}' AND id='{$pkg_id}' ORDER BY id DESC");
$packageModel = fetch_object($db, "SELECT * FROM package WHERE id='{$packageClientModel->package_id}'");
$billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$packageClientModel->billing_id}'");
$branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
$packageServiceNum = fetch_object($db, "SELECT sum(quantity) as total_service FROM package_service WHERE package_id='{$packageModel->id}'");
$packageServiceModel = fetch_all($db, "SELECT * FROM client_package_details WHERE client_package_id='{$pkg_id}'");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Package View - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link rel="stylesheet" href="./css/site.css">
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
                <?php include('./comman/client-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Package View</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package Name</th>
                                                    <th>Branch</th>
                                                    <th>Service Name</th>
                                                    <th>Total Quantity</th>
                                                    <th>Remaining quantity</th>
                                                    <th>History</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($packageServiceModel) > 0) {
                                                    $count = 0;
                                                    foreach ($packageServiceModel as $packageServiceKey => $packageServiceVal) {
                                                        $count++;
                                                        $packageServiceObj = (object) $packageServiceVal;
                                                        $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$packageServiceObj->service_id}'");



                                                        $packageServiceNum = fetch_object($db, "SELECT sum(quantity) as total_service FROM client_package_details WHERE client_package_id='{$packageClientModel->id}'");
                                                        $totalService = !empty($packageServiceNum->total_service) ? $packageServiceNum->total_service : 0;


                                                        $availQuantity = fetch_object($db, "SELECT sum(quantity) as avail_service FROM `client_package_details_usage` WHERE client_package_id='{$packageServiceObj->client_package_id}' AND package_details_id='{$packageServiceObj->id}' AND client_id='{$packageServiceObj->client_id}' AND service_id='{$packageServiceObj->service_id}'");
                                                        $availQuantity = !empty($availQuantity->avail_service) ? $availQuantity->avail_service : 0;


                                                        $remainingQuantity = $totalService - $availQuantity;
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $packageModel->package_name ?></td>
                                                            <td><?= $branchModel->branch_name ?></td>
                                                            <td><?= $serviceModel->service_name ?></td>
                                                            <td><?= $packageServiceObj->quantity ?></td>
                                                            <td><?= $remainingQuantity ?></td>
                                                            <td><a onclick='package_history(<?= "{$packageServiceObj->client_package_id}, {$packageServiceObj->id}, {$packageServiceObj->client_id}, {$packageServiceObj->service_id}" ?>)' class='btn btn-warning btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-watch' aria-hidden='true'></i> History</a></td>
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
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }


        function package_history(client_package_id, package_details_id, client_id, service_id) {
            $.ajax({
                url: "./inc/package/get-package-usage.php",
                type: "POST",
                data: {
                    client_package_id: client_package_id,
                    package_details_id: package_details_id,
                    client_id: client_id,
                    service_id: service_id
                },
                success: function(data) {
                    if (data != '') {

                        const myModal = new bootstrap.Modal("#packageHistoryModal", {
                            keyboard: false,
                        });
                        const modalToggle = $("#packageHistoryModal");
                        myModal.show(modalToggle);
                        $("#packageHistoryTable").html(data);
                    }
                },
            });
        }
    </script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>



<!-- Payment Modal -->
<div id="packageHistoryModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="packageHistoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packageHistoryTitle">Package Service History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Used On</th>
                                    <th>Branch</th>
                                    <th>Quantity</th>
                                    <th>Invoice Number</th>
                                </tr>
                            </thead>
                            <tbody id="packageHistoryTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>