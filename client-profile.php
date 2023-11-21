<?php
require_once "lib/db.php";
check_auth();

$id = $_GET['id'];
$modelSql = mysqli_query($db, "SELECT * FROM client WHERE id='{$id}'");
//$model = mysqli_fetch_all($modelSql, MYSQLI_ASSOC);
$model = mysqli_fetch_object($modelSql);



$genderArr = [
    'male' => 'Male',
    'female' => 'Female'
];

$sourceArr = [
    'Client refrence' => 'Client refrence',
    'Cold Calling' => 'Cold Calling',
    'Facebook' => 'Facebook',
    'Twitter' => 'Twitter',
    'Instagram' => 'Instagram',
    'Other Social Media' => 'Other Social Media',
    'Website' => 'Website',
    'Walk-In' => 'Walk-In',
    'Flex' => 'Flex',
    'Flyer' => 'Flyer',
    'Newspaper' => 'Newspaper',
    'SMS' => 'SMS',
    'Street Hoardings' => 'Street Hoardings',
    'Event' => 'Event',
    'TV/Radio' => 'TV/Radio',
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client Profile - <?= SALONNAME ?></title>

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
                                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <form action="./inc/client/client-update.php" method="post" id="clientUpdate">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="alert alert-info" role="alert">
                                                    <?= $model->client_name ?> - Client Since <?= formatDate($model->created_at) ?>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <?php

                                                $serverError = isset($_SESSION['clientUpdateError']) ? $_SESSION['clientUpdateError'] : false;

                                                if ($serverError) {

                                                    $alertType = ($serverError['success'] == true) ? 'success' : 'danger';

                                                    echo '
                                                    <div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">
                                                    <strong></strong> ' . $serverError['errors']['error'] . '
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>';
                                                }
                                                ?>
                                            </div>

                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <label for="userName">Client Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="client_name" value="<?= $model->client_name ?>" class="form-control" id="userName" placeholder="name" required="">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Contact <span class="text-danger">*</span></label>
                                                    <input type="number" maxlength="10" value="<?= $model->contact ?>" class="form-control" id="userName" placeholder="Number" name="contact">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Email</label>
                                                    <input type="text" name="email" value="<?= $model->email ?>" class="form-control" id="userName" placeholder="name@example.com">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Gender <span class="text-danger">*</span></label>
                                                    <select name="gender" data-validation="required" class="form-control">
                                                        <option value="">Select</option>

                                                        <?php
                                                        foreach ($genderArr as $genKey => $genValue) {
                                                        ?>
                                                            <option value="<?= $genKey ?>" <?= ($model->gender == $genKey) ? 'selected' : '' ?>><?= $genValue ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Date Of Birth</label>
                                                    <input type="text" name="dob" value="<?= $model->dob ?>" class="form-control dob_annv_date user-dob" id="userName" placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Anniversary</label>
                                                    <input type="text" name="anniversary" value="<?= $model->anniversary ?>" class="form-control dob_annv_date user-anniversary" id="userName" placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="userName">Source Of Client</label>
                                                    <select class="form-select" name="source_of_client">
                                                        <option value="">Select</option>

                                                        <?php
                                                        foreach ($sourceArr as $sourceKey => $sourceValue) {
                                                        ?>
                                                            <option value="<?= $sourceKey ?>" <?= ($model->source_of_client == $sourceKey) ? 'selected' : '' ?>>
                                                                <?= $sourceValue ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-8 col-xs-12">
                                                <div class="form-group">
                                                    <label for="userName">Address</label>
                                                    <textarea name="address" class="form-control" id="userName" placeholder="Address" style="width: 100%;" rows="3"><?= $model->address ?></textarea>
                                                </div>
                                            </div>

                                            <input type="hidden" name="cid" value="<?= $model->id ?>">
                                            <div class="col-md-12 my-3">

                                                <button type="submit" name="client_submit" class="btn btn-success d-block mx-auto">
                                                    <i class="fas fa-edit"></i> Update Profile
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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


    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>
    <script src="./js/main.js"></script>
    <script>
        const picker1 = datepicker('.user-dob', {
            formatter: (input, date, instance) => {
                const value = date.toLocaleDateString()
                input.value = dateFormatter(value)
            }
        })
        const picker2 = datepicker('.user-anniversary', {
            formatter: (input, date, instance) => {
                const value = date.toLocaleDateString()
                input.value = dateFormatter(value)
            }
        })
    </script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>

<?php
unset($_SESSION['clientUpdateError']);
?>