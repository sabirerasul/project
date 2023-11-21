<?php
require_once "lib/db.php";
check_auth();

$branch_id = BRANCHID;
$model = fetch_all($db, "SELECT id,client_name,contact,dob,anniversary FROM client WHERE branch_id='{$branch_id}'");

$startDate = date("Y-m-d");

$dayString = "7 day";
$dateModel = new DateTime($startDate);
$dateModel->modify($dayString);

$endDate =  $dateModel->format("Y-m-d");

$birthdayArr = [];
$anniversaryArr = [];

$c1 = 0;
foreach ($model as $key1 => $val1) {
    $dbDate1 = (!empty($val1['dob'])) ? getDateServerFormat($val1['dob']) : "00/00/0000";

    if ($startDate <= $dbDate1 && $endDate >= $dbDate1) {

        $datetime1 = new DateTime($startDate);
        $datetime2 = new DateTime($dbDate1);
        $difference1 = $datetime2->diff($datetime1);

        foreach ($val1 as $val1key => $val1value) {
            $birthdayArr[$c1][$val1key] = $val1value;
            $birthdayArr[$c1]['diff'] = $difference1->days;
        }

        $c1++;
    }
}

$c2 = 0;
foreach ($model as $key2 => $val2) {

    $dbDate2 = (!empty($val2['anniversary'])) ? getDateServerFormat($val2['anniversary']) : "00/00/0000";

    if ($startDate <= $dbDate2 && $endDate >= $dbDate2) {

        $datetime3 = new DateTime($startDate);
        $datetime4 = new DateTime($dbDate1);
        $difference2 = $datetime4->diff($datetime3);

        foreach ($val2 as $val2key => $val2value) {
            $anniversaryArr[$c2][$val2key] = $val2value;
            $anniversaryArr[$c2]['diff'] = $difference2->days;
        }

        $c2++;
    }
}

$key_values1 = array_column($birthdayArr, 'diff');
array_multisort($key_values1, SORT_ASC, $birthdayArr);

$key_values2 = array_column($anniversaryArr, 'diff');
array_multisort($key_values2, SORT_ASC, $anniversaryArr);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Birthday & Anniversary - <?= SALONNAME ?></title>
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
                <?php include('./comman/notification-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-6 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Birthday (7 Days)</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th><input type='checkbox'></th> -->
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Date Of Birth</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php

                                                $count1 = 0;
                                                foreach ($birthdayArr as $birthdayKey => $birthdayVal) {
                                                    $birthdayValue = (object) $birthdayVal;
                                                    $count1++;
                                                ?>
                                                    <tr>
                                                        <td><?= $count1 ?></td>
                                                        <!-- <td><input type='checkbox'></td> -->
                                                        <td><?= $birthdayValue->client_name ?></td>
                                                        <td><?= $birthdayValue->contact ?></td>
                                                        <td><?= $birthdayValue->dob ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Anniversary (7 Days)</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th><input type='checkbox'></th> -->
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Anniversary Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                $count2 = 0;
                                                foreach ($anniversaryArr as $anniversaryKey => $anniversaryVal) {
                                                    $anniversaryValue = (object) $anniversaryVal;
                                                    $count2++;
                                                ?>
                                                    <tr>
                                                        <td><?= $count2 ?></td>
                                                        <!-- <td><input type='checkbox'></td> -->
                                                        <td><?= $anniversaryValue->client_name ?></td>
                                                        <td><?= $anniversaryValue->contact ?></td>
                                                        <td><?= $anniversaryValue->anniversary ?></td>
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