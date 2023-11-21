<?php
require_once "lib/db.php";
check_auth();

$id = $_GET['id'];

$model = fetch_object($db, "SELECT * FROM client WHERE id='{$id}'");

$genderArr = [
    'male' => 'Male',
    'female' => 'Female'
];

$sourceArr = [
    'Client refrence' => 'Client refrence',
    'Cold Calling' => 'Cold Calling',
    'Facebook' => 'Facebook',
    'Twitter' => 'Twitter',
    'Instagram' => 'Instagram',
    'Other Social Media' => 'Other Social Media',
    'Website' => 'Website',
    'Walk-In' => 'Walk-In',
    'Flex' => 'Flex',
    'Flyer' => 'Flyer',
    'Newspaper' => 'Newspaper',
    'SMS' => 'SMS',
    'Street Hoardings' => 'Street Hoardings',
    'Event' => 'Event',
    'TV/Radio' => 'TV/Radio',
];

$appointmentModel = fetch_all($db, "SELECT * FROM appointment WHERE client_id='{$id}' ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Appointment - <?= SALONNAME ?></title>

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

                <?php include('./comman/client-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Appointment</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Branch</th>
                                                    <th>Appointment ID</th>
                                                    <th>Source</th>
                                                    <th>Amount Payable</th>
                                                    <th>Advance Paid</th>
                                                    <th>Status</th>
                                                    <th>Services</th>
                                                    <th>Providers</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($appointmentModel) > 0) {
                                                    $count = 0;
                                                    foreach ($appointmentModel as $appointmentKey => $appointmentVal) {
                                                        $appointmentValue = (object) $appointmentVal;
                                                        $count++;
                                                        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$appointmentValue->branch_id}'");
                                                        $appointmentSeviceModel = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id='{$appointmentValue->id}'");
                                                        $advancePaymentModel = fetch_object($db, "SELECT sum(advance) as advance FROM appointment_advance_payment WHERE appointment_id='{$appointmentValue->id}'");
                                                        $serviceTitle = '';
                                                        $providerTitle = '';
                                                        $isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$appointmentValue->id}'");


                                                        foreach ($appointmentSeviceModel as $serviceKey => $serviceValue) {
                                                            $serviceObject = (object) $serviceValue;
                                                            $serviceModel = fetch_object($db, "SELECT service_name FROM service WHERE id='{$serviceObject->service_id}'");
                                                            $serviceTitle .= $serviceModel->service_name . ", ";


                                                            $appointmentAssignSPModel = fetch_all($db, "SELECT service_provider_id FROM appointment_assign_service_provider WHERE appointment_service_id='{$serviceObject->id}'");
                                                            $appointmentAssignSPIds = array_column($appointmentAssignSPModel, 'service_provider_id');
                                                            $appointmentAssignSPIds = implode(",", $appointmentAssignSPIds);

                                                            $appointmentAssignSPIds = !empty($appointmentAssignSPIds) ? $appointmentAssignSPIds : 0;

                                                            $appointmentSPModel = fetch_all($db, "SELECT * FROM service_provider WHERE id IN ({$appointmentAssignSPIds})");

                                                            foreach ($appointmentSPModel as $appointmentSPKey => $appointmentSPValue) {
                                                                $providerTitle .= $appointmentSPValue['name'] . ", ";
                                                            }
                                                        }
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $appointmentValue->appointment_date ?></td>
                                                            <td><?= $branchModel->branch_name ?></td>
                                                            <td><?= $appointmentValue->id ?></td>
                                                            <td><?= $appointmentValue->appointment_source ?></td>
                                                            <td><?= $appointmentValue->pending_due ?></td>
                                                            <td><?= $advancePaymentModel->advance ?></td>
                                                            <td><?= $appointmentValue->status ?></td>
                                                            <td><?= $serviceTitle ?></td>
                                                            <td><?= $providerTitle ?></td>
                                                            <td><?= $appointmentValue->notes; ?></td>
                                                            <td>
                                                                <?php if ($isBilled == 0) { ?>
                                                                    <?php if ($appointmentValue->status != "Cancelled") { ?>
                                                                        <a href="./appointment.php?id=<?= $appointmentValue->id ?>" class="btn btn-sm btn-warning text-nowrap m-1"> <i class='fas fa-edit'></i> Edit</a>
                                                                        <a href="./billing-bill.php?aid=<?= $appointmentValue->id ?>" class="btn btn-sm btn-secondary text-nowrap m-1"> <i class='fas fa-money-bill'></i> Create Bill</a>
                                                                    <?php } else { ?>
                                                                        <a class="btn btn-sm btn-danger text-nowrap m-1"> <i class='fas fa-time'></i> Cancelled</a>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <a href="./appointment.php?id=<?= $appointmentValue->id ?>" class="btn btn-sm btn-primary text-nowrap m-1"><i class='fas fa-eye'></i> View</a>
                                                                    <a class="btn btn-sm btn-success text-nowrap m-1"> <i class='fas fa-money-bill'></i> Bill Paid</a>
                                                                <?php } ?>
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
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }
    </script>

<?php include('./comman/loading.php'); ?>
</body>

</html>