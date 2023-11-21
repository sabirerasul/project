<?php
require_once "lib/db.php";
check_auth();
extract($_REQUEST);
$cond = 1;

if ($_REQUEST) {

    if (!empty($filterfollowdate)) {
        $dateArr = explode(' - ', $filterfollowdate);
        $start_date = getDateServerFormat(dateMMFormar($dateArr[0]));
        $end_date = getDateServerFormat(dateMMFormar($dateArr[1]));
    } else {
        $todayDate = todayDate();
        $start_date = getDateServerFormat($todayDate);
        $end_date = getDateServerFormat($todayDate);
    }
} else {

    $todayDate = todayDate();
    $start_date = getDateServerFormat($todayDate);
    $end_date = getDateServerFormat($todayDate);
    $service_provider_id = 0;
    $service_type = 0;
    $service_id = 0;
}


$mainModel = [];


$dateArray = displayDates($start_date, $end_date, $format = 'd/m/Y');

foreach ($dateArray as $key => $val) {

    $billingModel1 = fetch_all($db, "SELECT * FROM client_billing WHERE billing_date='{$val}' AND status='1'");
    if (count($billingModel1) > 0) {
        foreach ($billingModel1 as $billingKey1 => $billingVal1) {
            $billingValue1 = (object) $billingVal1;

            if ($service_provider_id != 0) {
                $checkServiceProvider = num_rows($db, "SELECT * FROM `client_billing_assign_service_provider` WHERE `billing_id`='{$billingValue1->id}' AND `service_provider_id`='{$service_provider_id}'");
                if ($checkServiceProvider == 0) {
                    continue;
                }
            }

            if ($service_id != 0) {
                $checkService = num_rows($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billingValue1->id}' AND `service_id`='{$service_id}' AND `service_type`='{$service_type}'");
                if ($checkService == 0) {
                    continue;
                }
            }

            $mainModel[] = $billingVal1;
        }
    }
}

rsort($mainModel);

$inputDate = !empty($filterfollowdate) ? $filterfollowdate : formatDate($start_date)." - ".formatDate($end_date);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Billing Report - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./css/site.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Billing Report</h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                                    </div>
                                    <hr>

                                    <div>
                                        <form action="" method="POST" id="filterEnquiry">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="filterfollowdate" class="filterfollowdate_label required">Select Date</label>
                                                        <input type="text" class="form-control filterfollowdate" name="filterfollowdate" value="<?= $inputDate ?>" id="filterfollowdate">
                                                        <input type="hidden" id="start_date" value="<?= dateMMFormar(formatDate($start_date)) ?>">
                                                        <input type="hidden" id="end_date" value="<?= dateMMFormar(formatDate($end_date)) ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="filterfollowdate" class="filterfollowdate_label required">Service Provider</label>
                                                        <input type="text" class="form-control employee ui-autocomplete-input whatever" id="employee" onkeyup="searchEmployee(this)" placeholder="Service Provider" value="" autocomplete="off">
                                                        <input type="hidden" name="service_provider_id" id="employee_id" class="employee_id" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="filterfollowdate" class="filterfollowdate_label required">Service</label>
                                                        <input type="text" class="form-control enquiry_for_title" id="enquiry_for_title" placeholder="Services / Products / Packages / Membership" value="">
                                                        <input type="hidden" class="enquiry_for" id="enquiry_for" name="service_id" value="">
                                                        <input type="hidden" class="enquiry_table_type" id="enquiry_table_type" name="service_type" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <a href="billing-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bill Date</th>
                                                    <th>Bill ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Client Name</th>
                                                    <th>Contact</th>
                                                    <th>Total</th>
                                                    <th>Paid</th>
                                                    <th>Payment Details</th>
                                                    <th>Pending</th>
                                                    <th>Type</th>
                                                    <th style="white-space:nowrap">Products / Service</th>
                                                    <th style="white-space:nowrap">Service Provider</th>
                                                    <th>Remark</th>
                                                    <th>User</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($mainModel) > 0) {
                                                    $count = 0;
                                                    foreach ($mainModel as $mainKey => $billingVal) {
                                                        $billingValue = (object) $billingVal;
                                                        $count++;
                                                        $branchModel = fetch_object($db, "SELECT * FROM `branch` WHERE id='{$billingValue->branch_id}'");
                                                        $clientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$billingValue->client_id}'");
                                                        $billingSeviceModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billingValue->id}'");
                                                        $advancePaymentModel = fetch_object($db, "SELECT sum(advance) as advance FROM client_billing_payment WHERE billing_id='{$billingValue->id}'");
                                                        $serviceTitle = get_client_billing_service($db, $billingValue->id);
                                                        $providerTitle = get_client_billing_service_provider($db, $billingValue->id);

                                                        $payment_mode = '';


                                                        $billingPayment = fetch_all($db, "SELECT * FROM client_billing_payment WHERE billing_id='{$billingValue->id}'");

                                                        if (count($billingPayment) > 0) {
                                                            foreach ($billingPayment as $billingPaymentKey => $billingPaymentVal) {
                                                                $billingPaymentValue = (object) $billingPaymentVal;
                                                                $payment_mode .= $appointmentPaymentModeArr[$billingPaymentValue->method] . "<br>";
                                                            }
                                                        }


                                                        //$isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$billingValue->id}'");
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $billingValue->billing_date ?></td>
                                                            <td><?= $billingValue->id ?></td>
                                                            <td><?= $billingValue->invoice_number ?></td>
                                                            <td><?= $clientModel->client_name ?></td>
                                                            <td><?= $clientModel->contact ?></td>
                                                            <td><?= $billingValue->total ?></td>
                                                            <td><?= ($billingValue->total - $billingValue->pending_amount) ?></td>
                                                            <td><?= $payment_mode ?></td>
                                                            <td><?= $billingValue->pending_amount ?></td>
                                                            <td>Billing</td>
                                                            <td><?= $serviceTitle ?></td>
                                                            <td><?= $providerTitle ?></td>
                                                            <td><?= $billingValue->notes ?></td>
                                                            <td>Admin</td>
                                                            <td>

                                                                <?php if (USERROLE == 'superadmin') { ?>
                                                                    <a href="./billing-bill.php?id=<?= $billingValue->id ?>" class="btn btn-sm btn-warning text-nowrap m-1"> <i class='fas fa-edit'></i> Edit</a>
                                                                    <?php } else {
                                                                    if ($billingValue->pending_amount != 0) { ?>
                                                                        <a href="./billing-bill.php?id=<?= $billingValue->id ?>" class="btn btn-sm btn-warning text-nowrap m-1"> <i class='fas fa-edit'></i> Edit</a>
                                                                <?php }
                                                                } ?>
                                                                <a href="./invoice.php?inv=<?= $billingValue->invoice_number ?>" target='_blank' class="btn btn-sm btn-primary text-nowrap m-1"><i class='fas fa-eye'></i> View</a>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } ?>
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
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript" src="./js/toastify-js.js"></script>

    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script type="text/javascript" src="./js/pages/billing-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>