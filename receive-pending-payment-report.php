<?php
require_once "lib/db.php";
check_auth();

$receivePendingPayment = fetch_all($db, "SELECT * FROM `pending_payment_history` WHERE `bill_type`='pending payment' ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pending Payment - <?= SALONNAME ?></title>

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Received Pending Payment Report</h6>
                                    <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Invoice ID</th>
                                                    <th>Client Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($receivePendingPayment) > 0) {
                                                    $count = 0;

                                                    foreach ($receivePendingPayment as $key => $val) {
                                                        $value = (object) $val;

                                                        $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$value->client_id}'");
                                                        $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$value->app_bill_id}'");

                                                        $paymentMode = !empty($appointmentPaymentModeArr[$value->payment_mode]) ? $appointmentPaymentModeArr[$value->payment_mode] : '';
                                                        $count++;

                                                        $deleteBtn = "<a class='btn btn-sm btn-danger text-nowrap m-1' onclick='deletePayment({$value->id})'><i class='fas fa-trash'></i> Delete </a>";
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $billingModel->billing_date ?></td>
                                                            <td><?= $billingModel->invoice_number ?></td>
                                                            <td><?= $clientModel->client_name ?></td>
                                                            <td><?= $clientModel->contact ?></td>
                                                            <td><?= $value->paid ?></td>
                                                            <td><?= $paymentMode ?></td>
                                                            <td><?= $deleteBtn ?></td>
                                                        </tr>
                                                <?php
                                                    }
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


        function ExportToExcel(type, fn, dl) {
            var mytable = document.getElementById('dataTable');
            TableToExcel.convert(mytable);
        }


        function deletePayment(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    showAlert("Payment deleted successfully");
                    Swal.fire("Deleted!", "Service deleted successfully.", "success").then((nresult) => {
                        if (nresult.isConfirmed) {

                            if (id != 0) {
                                var formValues = {
                                    id: id,
                                };
                                var url = './inc/payment/pending-payment-delete.php';
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
                                                location.reload();
                                            }
                                        },
                                        error: function(data) {},
                                    });
                                }
                            }
                        }
                    });
                }
            });
        }
    </script>


<?php include('./comman/loading.php'); ?>
</body>

</html>