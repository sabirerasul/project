<?php
require_once "lib/db.php";
check_auth();
require('./classes/ProductVendor.php');

extract($_REQUEST);

$id = $_GET['editid'];

$purchaseModel = fetch_all($db, "SELECT * FROM stock_purchase WHERE vendor_id='" . $id . "'");
$paymentModel = fetch_all($db, "SELECT * FROM payment_history WHERE vendor_id='" . $id . "'");

$editid = (isset($_GET['editid'])) ? $_GET['editid'] : 0;

$staffText = ($editid != 0) ? 'Update Vendor' : 'Manage product vendor';

if ($editid != 0) {
    $model = fetch_object($db, "SELECT * FROM vendor WHERE id='" . $editid . "'");
} else {
    $model = new BlankProductVendor();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Profile - <?=SALONNAME?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/pages/product-details.css">
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


                    <div class="row">

                        <div class="col-12 mb-4">
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $staffText ?></h2>
                        </div>

                        <?php include('./form/product-vendor-form.php') ?>

                    </div>


                    <div class="row">

                        <div class="col-12 bg-white my-3">

                            <div id="service" class="tabcontent">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Purchase history</h6>
                                    </div>

                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Invoice</th>
                                                        <th>Amount payable</th>
                                                        <th>Amount paid</th>
                                                        <th>Payment mode</th>
                                                        <th>Pending amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <?php foreach ($purchaseModel as $key1 => $value1) {
                                                    ?>
                                                        <tr>
                                                            <td><?= date("Y-m-d", strtotime($value1['created_at'])) ?></td>
                                                            <td><?= $value1['invoice_number'] ?></td>
                                                            <td><?= $value1['total_charge'] ?></td>
                                                            <td><?= $value1['amount_paid'] ?></td>
                                                            <td><?= $paymentModeArr[$value1['payment_mode']] ?></td>
                                                            <td><?= $value1['pending_due'] ?></td>
                                                            <td>
                                                                <a href="./product-stock-add.php?pid=<?= $value1['id'] ?>" class="btn btn-primary btn-sm btn-block" type="button"> <i class="fas fa-eye" aria-hidden="true"></i> View</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 bg-white my-3">
                            <div id="service" class="tabcontent">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Payment history</h6>
                                    </div>

                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Invoice</th>
                                                        <th>Amount paid</th>
                                                        <th>Payment mode</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <?php foreach ($paymentModel as $key2 => $value2) {
                                                    ?>

                                                        <tr>
                                                            <td><?= date("Y-m-d", strtotime($value2['created_at'])) ?></td>
                                                            <td><?= $value2['invoice'] ?></td>
                                                            <td><?= $value2['amount_paid'] ?></td>
                                                            <td><?= $value2['payment_mode'] ?></td>
                                                            <td><?= $value2['notes']  ?></td>
                                                        </tr>
                                                    <?php } ?>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/pages/product-vendor-profile.js"></script>
    <script src="./js/main.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>