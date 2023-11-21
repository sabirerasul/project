<?php
require_once('./lib/db.php');
check_auth();

if (isset($_POST['submit'])) {

    extract($_REQUEST);

    $oldPassword = mysqli_real_escape_string($db, $oldPassword);
    $newPassword = mysqli_real_escape_string($db, $newPassword);
    $confirmPassword = mysqli_real_escape_string($db, $confirmPassword);
    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
    $updatedAt = date('Y-m-d H:i:s', time());

    $user = $_SESSION['user'];

    $userId = $user['user_id'];

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Field must be required";
    }

    if ($newPassword != $confirmPassword) {
        $error = "New Password and Confirm Password must be equal";
    }
    //else{
    //     $s = "SELECT * FROM `user` WHERE email='$email'";
    //     $query = mysqli_query($db, $s);
    //     $res = mysqli_fetch_assoc($query);

    //     $chkSql = mysqli_num_rows($query);

    //     if($chkSql > 0){
    //         if(!password_verify($oldPassword, $res['password'])) {
    //             $error = "Invalid Password";
    //         }
    //     }
    // }

    if (!empty($error)) {
        $_SESSION['fireAlert'] = $error;
        $_SESSION['fireAlertColor'] = "red";
        header('location: ./change-password.php');
    } else {
        $sql = "UPDATE user SET `password`='{$hashed_password}', `plain_password`='{$newPassword}', `updated_at`='{$updatedAt}' WHERE `id`='{$userId}'";
        if (mysqli_query($db, $sql)) {
            $error = "Password Successfully Updated.";
            $_SESSION['fireAlert'] = $error;
            $_SESSION['fireAlertColor'] = "green";
            header('location: ./change-password.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Password - <?= SALONNAME ?></title>

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
    <!-- <link rel="stylesheet" href="./css/pages/expense.css"> -->
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="col-12 mb-4">
                        <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Update Password</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mx-auto text-center my-2 py-5">

                            <div class="card shadow mb-4">
                                <div class="card-body shadow rounded p-2">
                                    <form action="" method="post">
                                        <div class="my-3">

                                            <div class="mb-3">
                                                <input type="password" id="formCategory" class="form-control" name="oldPassword" placeholder="Old Password" required />
                                            </div>

                                            <div class="mb-3">
                                                <input type="password" id="formCategory1" class="form-control" name="newPassword" placeholder="New Password" required />
                                            </div>

                                            <div class="mb-3">
                                                <input type="password" id="formCategory2" class="form-control" name="confirmPassword" placeholder="Confirm Password" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Update Password" />
                                        </div>
                                    </form>
                                </div>
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

    <!-- <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script> -->

    <!-- <script type="text/javascript" src="./js/pages/expense.js"></script> -->

    <?php
    if (isset($_SESSION['fireAlert']) && !empty($_SESSION['fireAlert'])) {
        fireAlert($_SESSION['fireAlert'], $_SESSION['fireAlertColor']);
        //unset($_SESSION['fireAlert']);
    }

    ?>
<?php include('./comman/loading.php'); ?>
</body>

</html>