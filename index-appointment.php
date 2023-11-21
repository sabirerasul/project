<?php
require_once "lib/db.php";
check_auth();

$todayDate = date("d/m/Y");
$branch_id = BRANCHID;
$model = fetch_all($db, "SELECT * FROM appointment WHERE appointment_date='{$todayDate}' AND branch_id='{$branch_id}'");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Today Appointment - <?= SALONNAME ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


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
                <?php include('./comman/dashboard-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Today Appointment</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date Of Appointment</th>
                                                    <th>Client Name</th>
                                                    <th>Contact</th>
                                                    <th>Appointment Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php

                                                $count1 = 0;
                                                foreach ($model as $modelKey => $modelVal) {
                                                    $modelValue = (object) $modelVal;
                                                    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$modelValue->client_id}'");
                                                    $count1++;

                                                    $isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$modelValue->id}'");
                                                ?>
                                                    <tr>
                                                        <td><?= $count1 ?></td>
                                                        <td><?= $modelValue->appointment_date ?></td>
                                                        <td><?= $clientModel->client_name ?></td>
                                                        <td><?= $clientModel->contact ?></td>
                                                        <td><?= $modelValue->appointment_time ?></td>
                                                        <td><?= $modelValue->status ?></td>
                                                        <td>
                                                            <a href='./appointment.php?id=<?= $modelValue->id ?>' class='btn btn-sm btn-primary text-nowrap'><i class='fas fa-edit'></i> Edit</a>
                                                            <?php if ($isBilled) { ?>
                                                                <a class='btn btn-sm btn-success text-nowrap'><i class='fas fa-money-bill'></i> Bill Paid</a>
                                                            <?php } else { ?>
                                                                <a href='./billing-bill.php?aid=<?= $modelValue->id ?>' class='btn btn-sm btn-secondary text-nowrap'><i class='fas fa-money-bill'></i> Create Bill</a>
                                                            <?php } ?>
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

    <script>
        $(document).ready(function() {
            dataTableLoad('dataTable1')
            dataTableLoad('dataTable2')
        })

        function dataTableLoad(id) {
            $(`#${id}`).DataTable();
        }
    </script>


<?php include('./comman/loading.php'); ?>
</body>

</html>