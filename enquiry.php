<?php
require('./lib/db.php');
check_auth();
require('./classes/Enquiry.php');

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

$enquiryText = ($id != 0) ? 'Edit' : 'Add';

$model = ($id != 0) ? fetch_object($db, "SELECT * FROM enquiry WHERE id='" . $id . "'") : new Enquiry();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enquiry - <?= SALONNAME ?></title>

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
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $enquiryText ?> Enquiry</h2>
                        </div>

                        <?php include('./form/enquiry-form.php') ?>

                    </div>

                    <?php
                    if ($id != 0) {

                        $enquiryHistoryModel = fetch_all($db, "SELECT * FROM enquiry_history WHERE enquiry_id='{$id}' ORDER by id DESC");

                    ?>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Enquiry Update History</h6>
                            </div>
                            <div class="card-body shadow rounded p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Response</th>
                                                <th>Time Updated</th>
                                                <th>Enquiry Type</th>
                                                <th>Lead Status</th>
                                                <th>Representative</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($enquiryHistoryModel) > 0) {
                                                $ehc = 0;
                                                foreach ($enquiryHistoryModel as $enquiryHistorKyey => $enquiryHistoryValue) {
                                                    $enquiryHistoryObj = (object) $enquiryHistoryValue;
                                                    $ehc++;

                                                    $leadUserName = ($enquiryHistoryObj->leaduser != 1) ? fetch_object($db, "SELECT * FROM employee WHERE status='1' AND id='{$enquiryHistoryObj->leaduser}'")->name : 'Admin';
                                            ?>
                                                    <tr>
                                                        <td><?= $ehc ?></td>
                                                        <td><?= $enquiryHistoryObj->date ?></td>
                                                        <td><?= $enquiryHistoryObj->response ?></td>
                                                        <td><?= $enquiryHistoryObj->update_time ?></td>
                                                        <td><?= $enquiryHistoryObj->enquiry_type ?></td>
                                                        <td><?= $enquiryHistoryObj->status ?></td>
                                                        <td><?= $leadUserName ?></td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="5">No Record Found!</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <?php if ($id == 0) { ?>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                                <div class="d-flex justify-content-between mb-2">
                                    <h6>Manage Enquiry</h6>
                                    <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                                </div>
                                <hr>

                                <div>
                                    <?php include('./form/enquiry-filter-form.php') ?>
                                </div>
                            </div>
                            <div class="card-body shadow rounded p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <!-- <td><input type="checkbox" id="enqchk"></td> -->
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Date To Follow</th>
                                                <th>Lead Type</th>
                                                <th>Enquiry For</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-data">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

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
    <script type="text/javascript" src="./js/pages/enquiry.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>