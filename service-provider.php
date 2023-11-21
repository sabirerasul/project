<?php
require('./lib/db.php');
check_auth();
require('./classes/ServiceProvider.php');
require "./classes/ServiceProductCommission.php";

$editid = (isset($_GET['editid'])) ? $_GET['editid'] : 0;

$staffText = ($editid != 0) ? 'Edit' : 'Add';

$target_dir = "./web/employee_doc/";

if ($editid != 0) {
    $que = mysqli_query($db, "SELECT * FROM service_provider WHERE id='" . $editid . "'");
    $model = mysqli_fetch_object($que);
} else {
    $model = new BlankServiceProvider();
    $model->service_commission = 0;
    $model->product_commission = 0;
}

$salonTiming = get_salon_timing($db);


$model->working_hours_start = empty($model->working_hours_start) ? $salonTiming['start'] : $model->working_hours_start;
$model->working_hours_end = empty($model->working_hours_end) ? $salonTiming['end'] : $model->working_hours_end;

$assignServiceSql = "SELECT * FROM service_provider_assign_services WHERE sp_id='" . $editid . "'";


$assignServiceResult = mysqli_query($db, $assignServiceSql);
$assignService = mysqli_num_rows($assignServiceResult);

$query = mysqli_query($db, "SELECT id FROM service_provider WHERE status=1 ORDER BY id DESC LIMIT 1");
$employeeModel = mysqli_fetch_object($query);
//$attendance_id = ($editid == 0) ?  getAttendanceId($employeeModel->id) : $model->attendence_id;
$employeeModelIid = !empty($employeeModel) ?  $employeeModel->id : 0;
$username = ($editid == 0) ? getUsername($employeeModelIid) : $model->username;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service Provider - <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/service-provider.css">
    <link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-2 text-gray-800">Client</h1> -->

                    <div class="row">

                        <div class="col-12 mb-4">
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $staffText ?> Service Provider</h2>
                        </div>


                        <?php

                        if (isset($_GET['editid'])) {


                            include('./comman/offDaySettingModal.php');
                            include('./comman/productCommissionModal.php');
                            include('./comman/serviceCommissionModal.php');
                            include('./comman/servicesModal.php');
                        ?>

                            <div class="col-12 mb-3">
                                <a href="./service-provider.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back to Service Provider</a>
                            </div>

                            <div>
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#serviceCommisionM" class="btn btn-warning"><i class="fa fa-spin fa-cog" aria-hidden="true"></i> Service Commission</button>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#productCommisionM" class="btn btn-warning"><i class="fa fa-spin fa-cog" aria-hidden="true"></i> Product Commission</button>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#offDaySettingM" class="btn btn-warning"> <i class="fa fa-spin fa-cog" aria-hidden="true"></i> Off Days Setting</button>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#servicesM" class="btn btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> Select Services <span id="s_services">(<?= $assignService ?>)</span></button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <?php include('./form/service-provider-form.php') ?>

                    </div>
                    <iframe id="txtArea1" style="display:none"></iframe>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Manage Service Provider</h6>
                            <div class="btn btn-warning" onclick="fnExcelReport()">Export</div>
                        </div>
                        <div class="card-body shadow rounded p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Profile Image</th>
                                            <th>Name</th>
                                            <th>Contact Number</th>
                                            <th>Emergency Contact Number</th>
                                            <th>Emergency Contact Person</th>
                                            <th>Last 30 Days Service Commission</th>
                                            <th>Last 30 Days Product Commission</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data active-table-data">

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
    <script src="./js/bootstrap.bundle.min.js"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

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

    <script src="./js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

    <script type="text/javascript" src="./js/pages/service-provider.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>