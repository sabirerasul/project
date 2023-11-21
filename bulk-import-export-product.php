<?php
require_once "lib/db.php";
check_auth();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Import/Export - <?= SALONNAME ?></title>

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

    <link rel="stylesheet" href="./css/pages/appointment.css">

    <link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
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

                <?php include('./comman/bulk-import-export-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12 mb-2">
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Product Export</h2>
                        </div>
                        <div class="col-md-12 my-3">
                            <button class="btn btn-success" onclick="productExport()"> <i class="fas fa-file-export"></i> Export</button>
                        </div>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Product Import</h2>
                        </div>
                        <div class="col-md-12 my-3">
                            <button class="btn btn-success" onclick="productSample()"> <i class="fas fa-download"></i> Download Sample</button>
                            <button class="btn btn-success" onclick="formToggle('importFrm');"> <i class="fas fa-file-import"></i> Import</button>
                        </div>

                        <div class="col-md-12" id="importFrm" style="display: none;">

                            <div class="alert alert-info" role="alert">
                                Please download sample excel file before importing excel.
                            </div>
                            <form action="./inc/stock/product-import-save.php" id="excel_form" method="post" enctype="multipart/form-data">

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fileInput" class="fileInputLabel required">Excel FIle (file format: Excel | Size: 5000kb)</label>
                                            <input type="file" class="form-control fileInput" id="fileInput" name="file">
                                            <div class="showErr"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fileInput" class="fileInputLabel d-block">&nbsp;</label>
                                            <input type="submit" class="btn btn-primary" value="Upload">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <hr> -->
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>

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

    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <script src="./js/pages/product-import-export.js"></script>

    <?php include('./comman/loading.php'); ?>


    <script>
        function formToggle(ID) {
            var element = document.getElementById(ID);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
    </script>

</body>

</html>