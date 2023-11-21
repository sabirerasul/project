<?php
require_once "lib/db.php";
check_auth();

extract($_REQUEST);
$model = fetch_object($db, "SELECT * FROM stock WHERE id='" . $id . "'");
$branch_id = BRANCHID;
if ($model != '') {
    $productAllModel = fetch_all($db, "SELECT * FROM stock_record WHERE branch_id='{$branch_id}' AND stock_main_id='" . $model->id . "'");
    $productModel = fetch_object($db, "SELECT * FROM product WHERE id='" . $model->product_id . "'");

    $purchaseReportTitle = "{$productModel->product} {$model->volume} {$model->unit}";
    $inStockTitle = availableStock($db, $model->id) . " (" . availableStock($db, $model->id) . " " . $model->unit . ")";
} else {
    $productAllModel = fetch_all($db, "SELECT * FROM stock_record WHERE branch_id='{$branch_id}' AND stock_main_id='0'");
    $productModel = fetch_object($db, "SELECT * FROM product WHERE id='0'");

    $purchaseReportTitle = "";
    $inStockTitle = "";
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

    <title>Product Details - <?= SALONNAME ?></title>

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

                        <div class="col-12 bg-white my-3">

                            <div id="service" class="tabcontent">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Purchase Reports (<?= $purchaseReportTitle ?>)</h6>
                                        <p>
                                            <i class="fas fa-shopping-basket text-danger"></i> In stock: <?= $inStockTitle ?>
                                        </p>
                                    </div>

                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Invoice</th>
                                                        <th>Type</th>
                                                        <th>Vendor/ client/ Service provider/ Branch</th>
                                                        <th>Credit</th>
                                                        <th>Debit</th>
                                                        <!-- <th>View</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <?php
                                                    if (count($productAllModel) > 0) {
                                                        foreach ($productAllModel as $key => $value) {

                                                            if ($value['type'] == 'Inventory Purchase') {
                                                                $purchaseModel = fetch_object($db, "SELECT CONCAT_WS(' - ', `vendor_name`, `contact`) as value  FROM vendor WHERE id='{$value['vendor_client_service_provider_id']}'");
                                                            }

                                                            if ($value['type'] == 'Product Used') {
                                                                $purchaseModel = fetch_object($db, "SELECT CONCAT_WS(' - ', `name`, `contact_number`) as value FROM service_provider WHERE id='{$value['vendor_client_service_provider_id']}'");
                                                            }

                                                            if ($value['type'] == 'Bill') {
                                                                $purchaseModel = fetch_object($db, "SELECT CONCAT_WS(' - ', `client_name`, `contact`) as value FROM client WHERE id='{$value['vendor_client_service_provider_id']}'");
                                                            }

                                                            if ($value['type'] == 'Bill') {
                                                                $purchaseModel = fetch_object($db, "SELECT CONCAT_WS(' - ', `client_name`, `contact`) as value FROM client WHERE id='{$value['vendor_client_service_provider_id']}'");
                                                            }

                                                            if ($value['type'] == 'Transferred' || $value['type'] == 'Received') {
                                                                $purchaseModel = fetch_object($db, "SELECT branch_name as value FROM branch WHERE id='{$value['vendor_client_service_provider_id']}'");
                                                            }

                                                            $stockModel = fetch_object($db, "SELECT * FROM stock WHERE id='{$value['stock_main_id']}'");
                                                    ?>
                                                            <tr>
                                                                <td><?= date("Y-m-d", strtotime($value['created_at'])) ?></td>
                                                                <td><?= $value['invoice'] ?></td>
                                                                <td><?= $value['type'] ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($value['type'] == 'Transferred') {
                                                                        echo "{$value['type']} to ";
                                                                    }

                                                                    if ($value['type'] == 'Received') {
                                                                        echo "{$value['type']} from ";
                                                                    }
                                                                    ?>
                                                                    <?= $purchaseModel->value ?>
                                                                </td>
                                                                <td><?= (!empty($value['credit'])) ? $value['credit'] : '-' ?></td>
                                                                <td><?= (!empty($value['debit'])) ? $value['debit'] : '-' ?></td>
                                                                <!-- <td> -->
                                                                <?php
                                                                if ($value['type'] == 'Inventory Purchase') { ?>
                                                                    <!-- <a href="./product-stock-add.php?pid=<?= $stockModel->stock_purchase_id ?>" class="btn btn-primary btn-sm btn-block" type="button"> <i class="fas fa-eye" aria-hidden="true"></i> View</a> -->
                                                                <?php } ?>

                                                                <?php
                                                                if ($value['type'] == 'Bill') {
                                                                    $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$value['invoice']}'");
                                                                    $billing_id = !empty($billingModel) ? $billingModel->id : 0;
                                                                ?>

                                                                    <!-- <a href="./billing-bill.php?id=<?= $billing_id ?>" class="btn btn-primary btn-sm btn-block" type="button"> <i class="fas fa-eye" aria-hidden="true"></i> View</a> -->
                                                                <?php } ?>
                                                                <!-- </td> -->
                                                            </tr>
                                                        <?php }
                                                    } else { ?>
                                                        <td>No record Found!</td>
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
    <script src="./js/main.js"></script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>