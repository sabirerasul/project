<?php
require_once "lib/db.php";
check_auth();

$modal1 = fetch_all($db, "SELECT * FROM branch ORDER by id DESC");

$target_dir = "./web/salon-logo/";


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>All Branches - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- <link rel="stylesheet" href="./css/datepicker.min.css"> -->
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/pages/product-use-in-salon.css">
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
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Branches Details</h6>
                                </div>


                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Branch Admin</th>
                                                    <th>Branch Name</th>
                                                    <th>Salon Name</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Website</th>
                                                    <th>GST</th>
                                                    <th>Working Hours</th>
                                                    <th>Logo</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-category-data">

                                                <?php

                                                $html = "";

                                                if (count($modal1) > 0) {
                                                    $count = 0;
                                                    foreach ($modal1 as $key => $val) {
                                                        $count++;
                                                        $value = (object) $val;

                                                        $singleUserModel = fetch_object($db, "SELECT * FROM user WHERE id='{$value->uid}'");

                                                        $branchSelectedBtn = (BRANCHID == $value->id) ? "<a class='btn btn-success btn-sm'>Selected</a>" : "";
                                                        $html .= "
                                                        <tr>
                                                            <td>{$count}</td>
                                                            <td>{$singleUserModel->name}</td>
                                                            <td>{$value->branch_name}</td>
                                                            <td>{$value->salon_name}</td>
                                                            <td>{$value->address}</td>
                                                            <td>{$value->phone}</td>
                                                            <td>{$value->email}</td>
                                                            <td>{$value->website}</td>
                                                            <td>{$value->gst}</td>
                                                            <td>{$value->working_hours_start} - {$value->working_hours_end}</td>
                                                            <td><img src='{$target_dir}{$value->logo}' style='width:100px'></td>
                                                            <td>{$value->created_at}</td>
                                                            <td>{$value->updated_at}</td>
                                                            <td>{$branchSelectedBtn}</td>
                                                        </tr>";
                                                    }
                                                }


                                                echo $html;

                                                ?>
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
    <script src="./js/main.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <!-- <script type="text/javascript" src="./js/datepicker.min.js"></script> -->


    <!-- <script src="./js/pages/product-use-in-salon.js"></script> -->

<?php include('./comman/loading.php'); ?>
</body>

</html>