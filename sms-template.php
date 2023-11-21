<?php
require_once "lib/db.php";
require_once "./lib/mail-config.php";
check_auth();

$smsTemplateModel = fetch_all($db, "SELECT * FROM branch_sms_template ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMS Template - <?= SALONNAME ?></title>

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

                <?php include('./comman/sms-panel-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-12 py-3">

                            <div class="alert alert-info" role="alert">
                                If you want to add more sms template, please contact on email <a href="mailto:support@pixelitsoftware.com">( support@pixelitsoftware.com )</a> or contact number <a href="tel:+91-958-061-0023">( +91-958-061-0023 )</a>
                            </div>

                        </div>

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">SMS Template</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Branch Name</th>
                                                    <th>Template Name</th>
                                                    <th>Template</th>
                                                    <th>Priority</th>
                                                    <th>sType</th>
                                                    <th>Channel</th>
                                                    <th>DCS</th>
                                                    <th>Flash SMS</th>
                                                    <th>Route</th>
                                                    <th>Pe ID</th>
                                                    <th>DLT Template ID</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php

                                                $count = 0;
                                                foreach ($smsTemplateModel as $smsTemplateKey => $smsTemplateVal) {
                                                    $smsTemplateValue = (object) $smsTemplateVal;
                                                    $count++;
                                                    $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$smsTemplateValue->branch_id}'");

                                                ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $branchModel->branch_name ?></td>
                                                        <td><?= $smsTemplateValue->template_title ?></td>
                                                        <td><?= $smsTemplateValue->template ?></td>
                                                        <td><?= $smsTemplateValue->priority ?></td>
                                                        <td><?= $smsTemplateValue->s_type ?></td>
                                                        <td><?= $smsTemplateValue->channel ?></td>
                                                        <td><?= $smsTemplateValue->dcs ?></td>
                                                        <td><?= $smsTemplateValue->flash_sms ?></td>
                                                        <td><?= $smsTemplateValue->route ?></td>
                                                        <td><?= $smsTemplateValue->peid ?></td>
                                                        <td><?= $smsTemplateValue->dlt_template_id ?></td>
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

    <script>
        $(document).ready(function() {
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }
    </script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>