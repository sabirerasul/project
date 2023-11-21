<?php
require('./lib/db.php');
check_auth();

$id = (isset($_GET['pid'])) ? $_GET['pid'] : 0;
$model = fetch_all($db, "SELECT * FROM `service_provider_commission_history` WHERE service_provider_id='{$id}'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service Provider Commission - <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/expense.css">
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
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Commission</h2>
                        </div>

                        <?php //include('./form/service-provider-commission-form.php') ?>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body shadow rounded p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Service/Product</th>
                                            <th>Commission</th>
                                            <th>Bill ID</th>
                                            <th>Invoice Number</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                        <?php

                                        $count1 = 0;

                                        $totalCommission = [];
                                        foreach ($model as $modelKey => $modelVal) {
                                            $modelValue = (object) $modelVal;

                                            $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$modelValue->billing_id}'");

                                            $enquiryForModel = fetch_object($db, "SELECT * FROM {$modelValue->service_type} WHERE id='{$modelValue->service_id}'");

                                            $arrayField = [
                                                'service' => 'service_name',
                                                'membership' => 'membership_name',
                                                'package' => 'package_name',
                                                'stock' => 'product_id'
                                            ];

                                            $fieldName = $arrayField[$modelValue->service_type];

                                            $serviceForText = '';
                                            if ($modelValue->service_type == 'stock') {
                                                $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
                                                $serviceForText = $productModel->product;
                                            } else {
                                                $serviceForText = $enquiryForModel->$fieldName;
                                            }

                                            $commission = $modelValue->commission;

                                            $totalCommission[] = $commission;
                                            $count1++;
                                        ?>
                                            <tr>
                                                <td><?= $count1 ?></td>
                                                <td><?= $billingModel->billing_date ?></td>
                                                <td><?= $modelValue->price ?></td>
                                                <td><?= "({$modelValue->service_type}) {$serviceForText}" ?></td>
                                                <td><?= $commission ?></td>
                                                <td><?= $billingModel->id ?></td>
                                                <td><?= $billingModel->invoice_number ?></td>
                                            </tr>
                                        <?php }
                                        if ($count1 != 0) { ?>
                                            <tr>
                                                <td><?= $count1 + 1 ?></td>
                                                <td></td>
                                                <td></td>
                                                <th>Total</th>
                                                <th><?= array_sum($totalCommission) ?></th>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } ?>
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

    <script type="text/javascript" src="./js/pages/service-provider-commission.js"></script>
<?php include('./comman/loading.php'); ?>
</body>

</html>