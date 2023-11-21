<?php
require_once "lib/db.php";
check_auth();

$todayDate = date("Y-m-d");
$branch_id = BRANCHID;
$model = fetch_all($db, "SELECT * FROM `client_billing` WHERE created_at LIKE '%{$todayDate}%' AND branch_id='{$branch_id}'");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Today Sales - <?= SALONNAME ?></title>

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
                                    <h6 class="m-0 font-weight-bold text-primary">Today Sales</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date Of Bill</th>
                                                    <th>Client Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Paid</th>
                                                    <th>Advance</th>
                                                    <th>Discount</th>
                                                    <th>Pending</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php

                                                $count1 = 0;

                                                $totalDiscount = [];
                                                $totalPaid = [];
                                                $totalAdvance = [];
                                                $totalPending = [];

                                                foreach ($model as $modelKey => $modelVal) {
                                                    $modelValue = (object) $modelVal;

                                                    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$modelValue->client_id}'");
                                                    $paymentModel = fetch_object($db, "SELECT sum(advance) as paid FROM `client_billing_payment` WHERE billing_id='{$modelValue->id}'");
                                                    $paid = $paymentModel ? $paymentModel->paid : 0;
                                                    $serviceModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE billing_id='{$modelValue->id}'");
                                                    $discount = [];
                                                    foreach ($serviceModel as $serviceKey => $serviceVal) {
                                                        $discountPrice = ($serviceVal['service_discount_type'] == 'percentage') ? get_price_from_discount($serviceVal['service_discount'], $serviceVal['price']) : $serviceVal['price'];
                                                        $discount[] = $discountPrice;
                                                    }

                                                    $discount = array_sum($discount);
                                                    $pay = $modelValue->advance_receive + $paid;
                                                    $pending = $modelValue->total - $pay;

                                                    $totalDiscount[] = $discount;
                                                    $totalPaid[] = $paid;
                                                    $totalAdvance[] = $modelValue->advance_receive;
                                                    $totalPending[] = $pending;

                                                    $count1++;
                                                ?>
                                                    <tr>
                                                        <td><?= $count1 ?></td>
                                                        <td><?= $modelValue->billing_date ?></td>
                                                        <td><?= $clientModel->client_name ?></td>
                                                        <td><?= $clientModel->contact ?></td>
                                                        <td><?= $paid ?></td>
                                                        <td><?= $modelValue->advance_receive ?></td>
                                                        <td><?= $discount ?></td>
                                                        <td><?= $pending ?></td>

                                                        <td>
                                                            <?php if (USERROLE == 'superadmin') { ?>
                                                                <a href='./billing-bill.php?id=<?= $modelValue->id ?>' class='btn btn-sm btn-primary text-nowrap'><i class='fas fa-edit'></i> Edit</a>
                                                                <?php } else {
                                                                if ($modelValue->pending_amount != 0) { ?>
                                                                    <a href='./billing-bill.php?id=<?= $modelValue->id ?>' class='btn btn-sm btn-primary text-nowrap'><i class='fas fa-edit'></i> Edit</a>
                                                            <?php }
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                if ($count1 != 0) { ?>
                                                    <tr>
                                                        <td><?= $count1 + 1 ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <th>Total</th>
                                                        <th><?= array_sum($totalPaid) ?></th>
                                                        <th><?= array_sum($totalAdvance) ?></th>
                                                        <th><?= array_sum($totalDiscount) ?></th>
                                                        <th><?= array_sum($totalPending) ?></th>
                                                        <td></td>
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