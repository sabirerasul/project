<?php
require_once "lib/db.php";

extract($_REQUEST);

if (empty($inv)) {
    header('location: ./feedback.php');
}

$billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$inv}'");

$branchModel = fetch_object($db, "SELECT * FROM `branch` WHERE `id`='{$billingModel->branch_id}'");

$SALONNAME = $branchModel->salon_name;
$BRANDLOGO = "./web/salon-logo/{$branchModel->logo}";
$BRANCHID = $branchModel->id;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Success Feedback - <?= $SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/feedback.css">
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
                <?php
                if (isset($_SESSION['user'])) {
                    include('./comman/nav.php');
                }
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mx-auto my-3">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-center align-items-center" style="flex-direction: column;">
                                    <div>
                                        <img src="<?= $BRANDLOGO ?>" alt="<?= $SALONNAME ?>" style="max-width:200px">
                                    </div>
                                    <h1 class="my-2">Feedback</h1>
                                </div>

                                <div class="card-body shadow rounded p-2">

                                    <div class="col-12 my-2">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong></strong> Feedback Saved Successfully
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <?php
                                        if (isset($_SESSION['user'])) { ?>
                                            <a type="button" href="./feedback.php" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i> Back</a>
                                        <?php } ?>
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

        <?php
        if (isset($_SESSION['user'])) {
            include('./comman/footer.php');
        }
        ?>

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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


    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="./js/pages/feedback.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>

<?php unset($_SESSION['clientUpdateError']);?>