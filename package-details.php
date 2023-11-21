<?php
require_once "lib/db.php";
check_auth();
require_once "./classes/Package.php";
require_once "./classes/PackageService.php";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($id != 0) {
    $model = fetch_object($db, "SELECT * FROM package WHERE id='" . $id . "'");
    $productModel = fetch_all($db, "SELECT * FROM package_service WHERE package_id='" . $model->id . "'");
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

    <title>Packages Details - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/pages/package.css">
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

                            <?php if ($id != 0) { ?>
                                <div class="col-12 mb-3">
                                    <a href="./package.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Package</a>
                                </div>
                            <?php } ?>


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Package Services</h6>
                                </div>


                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package</th>
                                                    <th>Service Category</th>
                                                    <th>Service Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                $count = 0;
                                                foreach ($productModel as $productModelKey => $productModelValue) {
                                                    $count++;
                                                    $serviceModel = fetch_assoc($db, "SELECT * FROM service WHERE id='" . $productModelValue['service_id'] . "'");
                                                    $serviceTitle = !empty($serviceModel) ? "{$serviceModel['service_name']}" : '';

                                                    $serviceModelPrice = !empty($serviceModel['price']) ? $serviceModel['price'] : '';

                                                    $ServiceCategoryTitle = (!empty($serviceModel) && !empty($serviceModel['category_id'])) ? fetch_object($db, "SELECT * FROM service_category WHERE id='" . $serviceModel['category_id'] . "'")->name : '';
                                                }

                                                ?>

                                                <td><?= $count ?></td>
                                                <td><?= $model->package_name ?></td>
                                                <td><?= $ServiceCategoryTitle ?></td>
                                                <td><?= $serviceTitle ?></td>
                                                <td><?= $productModelValue['quantity'] ?></td>
                                                <td><?= $productModelValue['price'] ?></td>

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
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="./js/toastify-js.js"></script>
    <script src="./js/main.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <!-- <script src="./js/pages/package.js"></script> -->


    <?php include('./comman/loading.php'); ?>
</body>

</html>