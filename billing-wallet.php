<?php
require_once "lib/db.php";
check_auth();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wallet Billing - <?= SALONNAME ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="./css/site.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">

    <link rel="stylesheet" href="./css/pages/billing-wallet.css">


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
                <?php include './comman/nav.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid bg-white">

                    <!-- Row starts -->
                    <form action="./inc/billing/wallet-add.php" method="post" id="walletAdd">
                        <div class="row">

                            <div class="col-12">
                                <div class="tab">
                                    <a class="tablinks" href="./billing-bill.php" id="tabCategory">Bill</a>
                                    <a class="tablinks active" href="./billing-wallet.php" id="tabService">Wallet</a>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Add Wallet Amount</h2>
                            </div>

                            <div class="col-lg-10">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="doa">Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control present_date" id="date" name="wallet[date]" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="client">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control client_name search_client_name" id="client" name="client[client_name]" placeholder="Autocomplete (Name)" required autocomplete="off">
                                            <input type="hidden" name="wallet[client_id]" id="client_id">
                                            <input type="hidden" name="client[branch_id]" id="branch_id" value="<?= BRANCHID ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cont">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control search_client_number" id="cont" name="client[contact]" placeholder="Client Contact" maxlength="10" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paid_amount">Amount Paid <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control paid_amount" id="paid_amount" min='1' name="wallet[paid_amount]" placeholder="0" maxlength="10" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="payment_method">Payment Mode <span class="text-danger">*</span></label>
                                        <select name="wallet[payment_method]" id="payment_method" class="form-select payment_method">
                                            <?php foreach ($paymentModeArr as $paymentModeKey => $paymentModeValue) { ?>
                                                <option value="<?= $paymentModeKey ?>"><?= $paymentModeValue ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="amount">Amount To Be Credit <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control amount" id="amount" min='1' name="wallet[amount]" placeholder="0" maxlength="10" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="notes">Description</label>
                                            <textarea name="wallet[notes]" class="form-control" rows="5" placeholder="" id="notes"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="send_receipt">Send Receipt:</label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" checked value="yes" name="send_receipt">Send the deposit receipt to customer?
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-right">
                                        <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Add Wallet</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-2 grey-box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="client-view">
                                            <div class="client-view-content">
                                                <div class="row">
                                                    <div class="col-md-12 p-1">
                                                        <h5 class="h5 mb-0 text-gray-800 border shadow-sm rounded p-1"><i class="fas fa-redo-alt text-warning fa-spin"></i>&nbsp;&nbsp;Client 360° View</h5>
                                                    </div>


                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div id="customer_type"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Client Profile:</div>
                                                            <div id="branch_name">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Last Visit On:</div>
                                                            <div id="last_visit">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Total Visits:</div>
                                                            <div id="total_visit">0</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Total Spendings:</div>
                                                            <div id="total_spending">0 INR</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>My Wallet :</div>
                                                            <div id="wallet">0.00 INR</div>
                                                            <input type="hidden" id="wallet_money" value="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Reward Points:</div>
                                                            <div id="earned_points">0</div>
                                                            <input type="hidden" id="reward_point" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Pending Amount:</div>
                                                            <div id="bill_pending_amount">0 INR</div>
                                                            <input type="hidden" id="bill_pending_amount_input" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Gender:</div>
                                                            <div id="gender">
                                                                <select class="form-select" name="client[gender]" id="gender">
                                                                    <option value="">Select</option>
                                                                    <option id="gn-1" value="male" selected>Male</option>
                                                                    <option id="gn-2" value="female">Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Date Of Birth :</div>
                                                            <div id="dob"><input type="text" class="form-control dob_annv_date" name="client[dob]" id="clientdob" readonly></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Anniversary :</div>
                                                            <div><input type="text" class="form-control dob_annv_date" name="client[anniversary]" id="anniversary" readonly></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Source Of Client:</div>
                                                            <div>
                                                                <select class="form-select" name="client[source_of_client]" id="leadsource">
                                                                    <option value="">Select</option>
                                                                    <option value="Client refrence">Client refrence</option>
                                                                    <option value="Cold Calling">Cold Calling</option>
                                                                    <option value="Facebook">Facebook</option>
                                                                    <option value="Twitter">Twitter</option>
                                                                    <option value="Instagram">Instagram</option>
                                                                    <option value="Other Social Media">Other Social Media</option>
                                                                    <option value="Website">Website</option>
                                                                    <option value="Walk-In">Walk-In</option>
                                                                    <option value="Flex">Flex</option>
                                                                    <option value="Flyer">Flyer</option>
                                                                    <option value="Newspaper">Newspaper</option>
                                                                    <option value="SMS">SMS</option>
                                                                    <option value="Street Hoardings">Street Hoardings</option>
                                                                    <option value="Event">Event</option>
                                                                    <option value="TV/Radio">TV/Radio</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Membership:</div>
                                                            <div id="membership">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Active Packages:</div>
                                                            <div id="active_package">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Last Feedback:</div>
                                                            <div id="last_feedback">----</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Row ends -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './comman/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>





    <?php //include './comman/modal.php' 
    ?>
    <!-- Bootstrap core JavaScript-->
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
    <script type="text/javascript" src="./js/pages/billing-wallet.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>

<!-- Package Modal -->
<div id="packageModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="packagePaymentTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packagePaymentTitle">Client package</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Package Name</th>
                                    <th>Branch</th>
                                    <th>Valid Upto</th>
                                    <th>Package Price</th>
                                    <th>Total Services</th>
                                    <th>Service Availed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="packageTable"></tbody>
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