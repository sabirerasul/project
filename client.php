<?php
require_once "lib/db.php";
check_auth();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client - <?= SALONNAME ?></title>
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

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-2 text-gray-800">Client</h1> -->

                    <div class="row">

                        <div class="col-12 mb-4">
                            <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Clients Segmentation</h2>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4" onclick="loadClientTable({type:'existing'})">
                            <div class="card border-primary shadow-lg h-100 py-4 client-box-overview overview-purple">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-center">
                                            <div class="h1 mb-0 font-weight-bold text-gray-800 overview-number overview-existing"><?= get_existing_client($db) ?></div>
                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1 overview-text">
                                                Existing Clients</div>
                                            <p class="px-3 mt-3">Clients who are existing in the software.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4" onclick="loadClientTable({type:'active'})">
                            <div class="card border-success shadow-lg h-100 py-4 client-box-overview overview-green">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-center">
                                            <div class="h1 mb-0 font-weight-bold text-gray-800 overview-number"><?= get_active_client($db) ?></div>
                                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1 overview-text">
                                                Active</div>
                                            <p class="px-3 mt-3">Clients who visit your outlet at regular intervals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4" onclick="loadClientTable({type:'churnprediction'})">
                            <div class="card border-warning shadow-lg h-100 py-4 client-box-overview overview-yellow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-center">
                                            <div class="h1 mb-0 font-weight-bold text-gray-800 overview-number"><?= get_churn_client($db) ?></div>
                                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1 overview-text">
                                                Churn prediction</div>
                                            <p class="px-3 mt-3">Clients who haven't visited your outlet and who are
                                                likely to leave.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4" onclick="loadClientTable({type:'inactive'})">
                            <div class="card border-danger shadow-lg h-100 py-4 client-box-overview overview-red">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-center">
                                            <div class="h1 mb-0 font-weight-bold text-gray-800 overview-number"><?= get_defected_client($db) ?></div>
                                            <div class="text-sm font-weight-bold text-danger text-uppercase mb-1 overview-text">
                                                Defected clients</div>
                                            <p class="px-3 mt-3">Clients who haven't visited your outlet and become
                                                inactive.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">Manage Client</h6> -->

                            <div class="d-flex justify-content-between mb-2">
                                <h6>Manage clients</h6>
                                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fas fa-plus"></i> Add New Client</a>
                            </div>
                            <hr>

                            <div>
                                <?php //include('./form/client-filter-form.php') 
                                ?>
                            </div>
                        </div>
                        <div class="card-body shadow rounded p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Contact Number</th>
                                            <th>Your Invite Code</th>
                                            <th>First Visit</th>
                                            <th>Last Visit</th>
                                            <th>Last Service</th>
                                            <th>Last Service Provider</th>
                                            <th>Last Bill Amount</th>
                                            <th>Gender</th>
                                            <th>Points</th>
                                            <th>Followup Comment</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-html">

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





    <?php include('./form/client-form.php') ?>


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
    <script type="text/javascript" src="./js/pages/client.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>


<?php include('./comman/loading.php'); ?>
</body>

</html>


<!-- Modal End -->

<div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form class="" action="./inc/client/client-followup-add.php" id="followup_form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">Add New Followup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Next Followup Date : <span class="text-danger">*</span></label>
                                <input type="text" name="followup_date" placeholder="" class="followup_date form-control" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Next Followup Time : <span class="text-danger">*</span></label>
                                <input type="text" name="followup_time" placeholder="" class="followup_time form-control" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="userName">Response : <span class="text-danger">*</span></label>
                                <textarea name="response" style="resize: none" rows="5" class="form-control" required=""></textarea>
                                <input type="hidden" name="representative" value="<?= USERROLE ?>">
                                <input type="hidden" name="response_type" value="client">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="client_id" id="client_id" value="">
                                <input type="hidden" name="branch_id" value="<?= BRANCHID ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal3">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->