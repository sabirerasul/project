<?php
require_once "lib/db.php";
check_auth();

$serviceProviderSql = "SELECT id,name as title FROM service_provider WHERE status=1 ORDER by id DESC";
$serviceProviderModel = fetch_all($db, $serviceProviderSql);

extract($_REQUEST);

if (!isset($id)) {
    header('location: ./product-use-in-salon.php');
}

$productUseInSalonSql = "SELECT * FROM product_use_in_salon WHERE id='" . $id . "'";
$productUseInSalonModel = fetch_object($db, $productUseInSalonSql);

$stockSql = "SELECT * FROM stock WHERE id='".$productUseInSalonModel->salon_product_id."'";
$stockModel = fetch_object($db, $stockSql);

$productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$stockModel->product_id}'");

$stockModelTitle = "{$productModel->product}";


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Used in salon - <?=SALONNAME?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- <link rel="stylesheet" href="./css/datepicker.min.css"> -->
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/pages/product-use-in-salon.css">
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
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Give product to service provider</h2>
                        </div>

                        <div class="col-lg-12">

                            <div class="table-responsive">
                                <form action="./inc/stock/product-use-in-salon-update.php" method="post" id="serviceUpdate">
                                    <table id="catTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                                <th>Service provider</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="service-provider-services">

                                                <td style="vertical-align: middle;">
                                                    <span class="sno"><i class="fas fa-ellipsis-v"></i></span>
                                                </td>

                                                <td>
                                                    <input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" value="<?=$stockModelTitle?>" autocomplete="off" required>
                                                    <input type="hidden" name="product_use_in_salon[salon_product_id]" class="serr" value="<?= $productUseInSalonModel->salon_product_id ?>">
                                                    <input type="hidden" name="product_use_in_salon[id]" class="" value="<?= $productUseInSalonModel->id ?>">
                                                </td>

                                                <td>
                                                    <input type="number" name="product_use_in_salon[quantity]" class="form-control form-control-sm d-input" value="<?= $productUseInSalonModel->quantity ?>" required>
                                                </td>

                                                <td>
                                                    <select name="product_use_in_salon[sp_id]" class="form-select form-select-sm staff" required>
                                                        <option value="">Service provider</option>
                                                        <?php
                                                        foreach ($serviceProviderModel as $serviceProviderKey => $serviceProviderVal) {
                                                            $serviceProviderValue = (object) $serviceProviderVal;
                                                            $isSelected = ($serviceProviderValue->id == $productUseInSalonModel->service_provider_id) ? 'selected':'';
                                                            echo "<option value='" . $serviceProviderValue->id . "' ".$isSelected.">" . $serviceProviderValue->title . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control form-control-sm product-remark w-100" placeholder="Remark" name="product_use_in_salon[remark]" value="<?= $productUseInSalonModel->remark ?>">
                                                </td>
                                            </tr>

                                            <!-- <tr id="addBefore">
                                                <td colspan="5" class="text-right">
                                                    <button type="button" id="btnAdd" class="btn btn-success" onclick="addServiceProviderServices()">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> Add service
                                                    </button>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white my-3">

                            <br>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Use product in salon history</h6>
                                </div>


                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Service Provider</th>
                                                    <th>Quantity</th>
                                                    <th>Assigned by</th>
                                                    <th>Date / Time</th>
                                                    <th style="width: 200px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
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

    <!-- <script type="text/javascript" src="./js/datepicker.min.js"></script> -->

    <script src="./js/pages/product-use-in-salon.js"></script>
    

<?php include('./comman/loading.php'); ?>
</body>

</html>