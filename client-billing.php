<?php
require_once "lib/db.php";
check_auth();

$id = $_GET['id'];
$model = fetch_object($db, "SELECT * FROM client WHERE id='{$id}'");

$billingModel = fetch_all($db, "SELECT * FROM client_billing WHERE client_id='{$id}' AND status='1' ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Billing - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link rel="stylesheet" href="./css/site.css">
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
                <?php include('./comman/client-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Billing</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Branch</th>
                                                    <th>Bill ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Amount</th>
                                                    <th>Advance</th>
                                                    <th>Paid</th>
                                                    <th>Pending</th>
                                                    <th>Earned Points</th>
                                                    <th>Services</th>
                                                    <th>Providers</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($billingModel) > 0) {
                                                    $count = 0;
                                                    foreach ($billingModel as $billingKey => $billingVal) {
                                                        $billingValue = (object) $billingVal;
                                                        $count++;
                                                        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingValue->branch_id}'");
                                                        $billingSeviceModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billingValue->id}'");
                                                        $advancePaymentModel = fetch_object($db, "SELECT sum(advance) as advance FROM client_billing_payment WHERE billing_id='{$billingValue->id}'");
                                                        $serviceTitle = get_client_billing_service($db, $billingValue->id);
                                                        $providerTitle = get_client_billing_service_provider($db, $billingValue->id);

                                                        //$isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$billingValue->id}'");

                                                        $rewardPoint = getBillingReward_point($db, $billingValue->id);



                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $billingValue->billing_date ?></td>
                                                            <td><?= $branchModel->branch_name ?></td>
                                                            <td><?= $billingValue->id ?></td>
                                                            <td><?= $billingValue->invoice_number ?></td>
                                                            <td><?= $billingValue->total ?></td>
                                                            <td><?= $billingValue->advance_receive ?></td>
                                                            <td><?= ($billingValue->total - $billingValue->pending_amount) ?></td>
                                                            <td><?= $billingValue->pending_amount ?></td>
                                                            <td><?= $rewardPoint ?></td>
                                                            <td><?= $serviceTitle ?></td>
                                                            <td><?= $providerTitle ?></td>
                                                            <td>
                                                                <?php if ($billingValue->pending_amount == 0) { ?>
                                                                    <a class="btn btn-sm btn-success text-nowrap m-1"> <i class='fas fa-money-bill'></i> Paid</a>
                                                                <?php } else { ?>
                                                                    <a class="btn btn-sm btn-danger text-nowrap m-1" onclick='client_check_pending_payment(<?= $billingValue->client_id ?>)'> <i class='fas fa-money-bill'></i> Pay</a>
                                                                <?php } ?>

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

    <script>
        $(document).ready(function() {
            dataTableLoad()
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }


        function pendingPayment(elem) {
            var id = $(elem).parent().parent().find(".pending_id").val();
            var paid = $(elem).parent().parent().find(".amtpay").val();
            var mode = $(elem).parent().parent().find(".mthd").val();

            if (paid != 0) {
                var formValues = {
                    id: id,
                    paid: paid,
                    mode: mode
                };
                var url = './inc/payment/pending-payment-add.php';
                var error = false;
                var ErrorMsg = "";

                if (error == false) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formValues,
                        success: function(data) {
                            const myObj = JSON.parse(data);

                            if (myObj.success == true) {
                                showAlert("Pending payment Saved Successfully");
                                Swal.fire(
                                    "Good job!",
                                    "Pending payment Saved Successfully",
                                    "success"
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                $(".server-error").css("display", "block");
                                $("#error-message").html(myObj.errors.error);
                                showAlert(myObj.errors.error, "red");
                            }
                        },
                        error: function(data) {
                            $(".server-error").show();
                            $("#error-message").html(myObj.errors.error);
                            showAlert("Something went wrong", "red");
                        },
                    });
                }
            }
        }

        function client_check_pending_payment(client_id) {
            $.ajax({
                url: "./inc/payment/get-pending-payment.php",
                type: "POST",
                data: {
                    client_id: client_id
                },
                success: function(data) {
                    if (data != '') {

                        const myModal = new bootstrap.Modal("#paymentModal", {
                            keyboard: false,
                        });
                        const modalToggle = $("#paymentModal");
                        myModal.show(modalToggle);
                        $("#pendingPaymentTable").html(data);
                    }
                },
            });
        }
    </script>


<?php include('./comman/loading.php'); ?>
</body>

</html>


<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="pendingPaymentTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingPaymentTitle">Pending payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Pending amount</th>
                                    <th>Pay amount</th>
                                    <th>Pay mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pendingPaymentTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>