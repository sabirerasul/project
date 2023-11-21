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

    <title>Transfer Option - <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/service-provider.css">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 bg-white my-3">

                            <br>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Transfer Service Provider</h6>
                                </div>


                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Profile Image</th>
                                                    <th>Name</th>
                                                    <th>Contact</th>
                                                    <th>Designation</th>
                                                    <th>Working Hours</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
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
    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="./js/toastify-js.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>
    <script src="./js/main.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>


    <script src="./js/pages/transfer-option.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form action="./inc/transfer-option/transfer-option-add.php" id="transferAdd" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="transfer_type" class="transfer_type"> Transfer Type : </label>
                                <select class="form-select transfer_type" name="transfer_type" id="transfer_type" required>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Temporary">Temporary</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="transfer_date" class="transfer_date_label">Select Date: </label>
                                <input type="text" name="transfer_date" class="form-control transfer_date" id="transfer_date" placeholder="Date" value="" required>
                                <input type="hidden" name="service_provider_id" id="service_provider_id" value="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="move_branch" class="move_branch_label"> Move to Branch : </label>
                                <select class="form-select move_branch" name="transfer_branch_id" id="move_branch" required>
                                    <option value="">Select</option>
                                    <?php
                                    $allBranchArr = get_filter_branch(BRANCHID, $db);
                                    foreach ($allBranchArr as $allBranchKey => $allBranchValue) {
                                    ?>
                                        <option value="<?= $allBranchValue['id'] ?>"><?= $allBranchValue['branch_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->