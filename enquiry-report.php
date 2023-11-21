<?php
require('./lib/db.php');
check_auth();

$leadUserArr = fetch_all($db, "SELECT * FROM employee WHERE status='1' ORDER by name ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enquiry Report- <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/enquiry.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .enq-for-wrapper {
            display: none;
        }
    </style>
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                            <div class="d-flex justify-content-between mb-2">
                                <h6>Manage Report</h6>
                                <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                            </div>
                            <hr>

                            <div>
                                <form action="" method="POST" id="filterEnquiry">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterfollowdate" class="filterfollowdate_label required">Select Date</label>
                                                <input type="text" class="form-control filterfollowdate" name="filterfollowdate" value="Select date" id="filterfollowdate">
                                                <input type="hidden" name="filterenquiry_for" value="">
                                                <input type="hidden" name="filterenquiry_table_type" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterenquiry_type" class="filterenquiry_type_label required">Enquiry Type</label>
                                                <select class="form-select filterenquiry_type" name="filterenquiry_type" id="filterenquiry_type">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($enquiryTypeArr as $enquiryTypeKey => $enquiryTypeValue) {
                                                    ?>
                                                        <option value="<?= $enquiryTypeKey ?>"><?= $enquiryTypeValue ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filtersource_of_enquiry" class="filtersource_of_enquiry_label required">Source Of Enquiry</label>
                                                <select class="form-select filtersource_of_enquiry" name="filtersource_of_enquiry" id="filtersource_of_enquiry">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($enquirySourceArr as $enquirySourceArrKey => $enquirySourceArrValue) {
                                                    ?>
                                                        <option value="<?= $enquirySourceArrKey ?>"><?= $enquirySourceArrValue ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterleaduser" class="filterleaduser_label">Lead Representative</label>
                                                <select class="form-select filterleaduser" name="filterleaduser" id="filterleaduser">
                                                    <option value="">Select</option>
                                                    <option value="1">Admin</option>
                                                    <?php
                                                    foreach ($leadUserArr as $leadUserKey => $leadUserValue) {
                                                    ?>
                                                        <option value="<?= $leadUserValue['id'] ?>"><?= $leadUserValue['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status" class="status_label required">Lead Status</label>
                                                <select class="form-select status" name="status" id="status">
                                                    <?php
                                                    foreach ($leadStatus as $leadStatusKey => $leadStatusValue) {
                                                    ?>
                                                        <option value="<?= $leadStatusValue ?>"><?= $leadStatusValue ?></option>
                                                    <?php } ?>

                                                </select>
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
                                                    <a href="enquiry-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body shadow rounded p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <!-- <td><input type="checkbox" id="enqchk"></td> -->
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Date To Follow</th>
                                            <th>Lead Type</th>
                                            <th>Enquiry For</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('./comman/footer.php') ?>
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

    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script type="text/javascript" src="./js/pages/enquiry-report.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>