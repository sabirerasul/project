<?php
require('./lib/db.php');
check_auth();

$id = $_REQUEST['eid'];

$sql = "SELECT * FROM employee WHERE id='" . $id . "'";

$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_object($modalSql);


$target_dir = "./web/employee_doc/";

$cGender = ucfirst($modal->gender);

$status = ($modal->status == 1) ? 'Active' : 'Deactive';
$oppStatus = ($modal->status == 1) ? 'Deactive' : 'Active';
$statusColor = ($modal->status == 1) ? 'success' : 'danger';
$oppStatusColor = ($modal->status == 1) ? 'danger' : 'success';
$deactiveStyle = ($modal->status == 0) ? "style='background-color:#f1f1f1'" : "";
$emp_photo = (!empty($modal->photo)) ? $target_dir . $modal->photo : $target_dir . 'female.png';
$emp_frontproof = (!empty($modal->frontproof)) ? $target_dir . $modal->frontproof : $target_dir . 'female.png';
$emp_backproof = (!empty($modal->backproof)) ? $target_dir . $modal->backproof : $target_dir . 'female.png';
$statusIcon = ($modal->status == 1) ? 'down' : 'up';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Staff Profile - <?= SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/staff.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <!-- Custom fonts for this template -->


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
                            <h2 class="h2 text-gray-800 border shadow-sm rounded d-block p-2"><?= $modal->name ?> - Profile</h2>
                        </div>

                        <div class="col-md-10 mx-auto">
                            <div class="card-body shadow rounded p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <td><?= $modal->name ?></td>

                                            <th>DOB</th>
                                            <td><?= $modal->dob ?></td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td><?= $modal->contact_number ?></td>

                                            <th>Email</th>
                                            <td><?= $modal->email ?></td>
                                        </tr>
                                        <tr>
                                            <th>Working Time</th>
                                            <td><?= $modal->working_hours_start . ' - ' . $modal->working_hours_end ?></td>

                                            <th>Salary</th>
                                            <td><?= $modal->salary ?></td>
                                        </tr>
                                        <tr>
                                            <th>Emergency Contact Number</th>
                                            <td><?= $modal->emer_contact_person ?></td>

                                            <th>Emergency Contact Person</th>
                                            <td><?= $modal->emer_contact_number ?></td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td><?= $modal->address ?></td>

                                            <th>Username</th>
                                            <td><?= $modal->username ?></td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td><?= $cGender ?></td>

                                            <th>Date Of Joining</th>
                                            <td><?= $modal->date_of_joining ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td><?= $modal->department ?></td>

                                            <th>User Type</th>
                                            <td><?= $modal->user_type ?></td>
                                        </tr>
                                        <tr>
                                            <th>User Since</th>
                                            <td><?= date("d-m-Y", strtotime($modal->created_at)) ?></td>

                                            <th>Status</th>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <tr>
                                            <th>Photo</th>
                                            <td colspan="3" class='avatar'><img src='<?= $emp_photo ?>' class='img-responsive'></td>
                                        </tr>
                                        <tr>
                                            <th>Front ID Proof</th>
                                            <td colspan="3" class='avatar'><embed style="width:100%" src='<?= $emp_frontproof ?>' class='img-responsive'></embed></td>
                                        </tr>
                                        <tr>
                                            <th>Back ID Proof</th>
                                            <td colspan="3" class='avatar'><embed style="width:100%" src='<?= $emp_backproof ?>' class='img-responsive'></embed></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12"></div>

                        <div class="col-md-4 mx-auto my-3">
                            <a href="staff.php" class="btn btn-success mx-auto d-block">Back</a>
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
    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>