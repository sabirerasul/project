<?php
require("./lib/db.php");
require("./classes/BranchAPISetting.php");
require("./classes/BranchRedeemPointsSetting.php");
require("./classes/BranchHoliday.php");
require("./classes/BranchAutomaticReminder.php");


check_auth();
extract($_REQUEST);

$branch_id = BRANCHID;

$apiModel = fetch_object($db, "SELECT * FROM branch_api_setting");
$apiModel = !empty($apiModel) ? $apiModel : new BranchAPISetting();

$redeemPointsModel = fetch_object($db, "SELECT * FROM branch_redeem_points_setting");
$redeemPointsModel = !empty($redeemPointsModel) ? $redeemPointsModel : new BranchRedeemPointsSetting();

$holidayModel = fetch_all($db, "SELECT * FROM branch_holiday");

$hid = (isset($hid) && !empty($hid)) ? $hid : 0;

$sHolidayModel = fetch_object($db, "SELECT * FROM branch_holiday WHERE id='{$hid}'");
$sHolidayModel = !empty($sHolidayModel) ? $sHolidayModel : new BranchHoliday();

$automaticReminderModel = fetch_object($db, "SELECT * FROM branch_automatic_reminder");
$automaticReminderModel = !empty($automaticReminderModel) ? $automaticReminderModel : new BranchAutomaticReminder();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Software Setting - <?= SALONNAME ?></title>

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

    <link rel="stylesheet" href="./css/pages/software-setting.css">

    <link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />


    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #eaecf4 !important;
            opacity: 1;
        }
    </style>
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

                    <div>
                        <h2 class="h2 border shadow rounded d-block p-2">Software Setting</h2>
                    </div>


                    <!-- Row starts -->
                    <div class="row my-2">

                        <div class="col-md-4 p-3">
                            <div class="py-3 shadow rounded border text-center">
                                <div>
                                    <h3 class="h3 border-0 my-4">Automatic Reminders</h3>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#automaticReminderModal">Edit Setting</button>
                            </div>
                        </div>

                        <div class="col-md-4 p-3">
                            <div class="py-3 shadow rounded border text-center">
                                <div>
                                    <h3 class="h3 border-0 my-4">Redeem Points Setting</h3>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#redeemPointModal">Edit Setting</button>
                            </div>
                        </div>

                        <div class="col-md-4 p-3">
                            <div class="py-3 shadow rounded border text-center">
                                <div>
                                    <h3 class="h3 border-0 my-4">API Settings</h3>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smsAPIModal">Edit Setting</button>
                            </div>
                        </div>

                        <div class="col-md-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List Of Holidays</h6>
                                    <div>
                                        <a class="btn btn-success" onclick="setHolidayModal()"> <i class="fas fa-plus"></i> Add</a>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Holiday Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-data">

                                                <?php
                                                $count1 = 0;
                                                foreach ($holidayModel as $holidayKey => $holidayVal) {
                                                    $holidayObj = (object) $holidayVal;

                                                    $count1++;
                                                ?>
                                                    <tr>
                                                        <td><?= $count1 ?></td>
                                                        <td><?= $holidayObj->date ?></td>
                                                        <td><?= $holidayObj->title ?></td>
                                                        <td> <a href='./software-setting-super-admin.php?hid=<?= $holidayObj->id ?>' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script type="text/javascript" src="./js/pages/software-setting-admin.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>

<div class="modal fade" id="automaticReminderModal" tabindex="-1" aria-labelledby="automaticReminderModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form class="form-horizontal" action="./inc/software-setting/branch-automatic-reminder-save.php" id="branch_automatic_reminder" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="automaticReminderModalLabelSchedule">Automatic Reminders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 my-1">
                            <p>
                                <strong>Enable</strong>
                            </p>
                        </div>

                        <div class="col-md-12 my-1">
                            <label>
                                <input type="checkbox" value="1" name="automatic_reminder[birthday]" id="birthday" <?= ($automaticReminderModel->birthday) ? 'checked' : '' ?>> <span>Birthday</span>
                            </label>
                        </div>

                        <div class="col-md-12 my-1">
                            <label>
                                <input type="checkbox" value="1" name="automatic_reminder[anniversary]" id="anniversary" <?= ($automaticReminderModel->anniversary) ? 'checked' : '' ?>> <span>Anniversary</span>
                            </label>
                        </div>

                        <div class="col-md-12 my-1">
                            <label>
                                <input type="checkbox" value="1" name="automatic_reminder[appointment]" id="appointment" <?= ($automaticReminderModel->appointment) ? 'checked' : '' ?>> <span>Appointment</span>
                            </label>
                        </div>

                        <div class="col-md-12 my-1">
                            <label>
                                <input type="checkbox" value="1" name="automatic_reminder[package_expiry]" id="package_expiry" <?= ($automaticReminderModel->package_expiry) ? 'checked' : '' ?>> <span>Package Expiry</span>
                                <input type="hidden" name="automatic_reminder[id]" value="<?= $automaticReminderModel->id ?>">
                            </label>
                        </div>

                        <div class="col-md-12 my-1">
                            <label>
                                <input type="checkbox" value="1" name="automatic_reminder[membership_expiry]" id="membership_expiry" <?= ($automaticReminderModel->membership_expiry) ? 'checked' : '' ?>> <span>Membership Expiry</span>
                            </label>
                        </div>


                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client" name="service_submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->

<div class="modal fade" id="redeemPointModal" tabindex="-1" aria-labelledby="redeemPointModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form class="form-horizontal" action="./inc/software-setting/branch-redeem-points-save.php" id="branch_redeem_points_save" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="redeemPointModalLabelSchedule">Redeem Points Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="points_redeem_point" class="points_redeem_point_label">Redeem Points</label>
                                <input type="number" class="form-control points_redeem_point" name="points[redeem_point]" id="points_redeem_point" placeholder="Redeem Points" value="<?= $redeemPointsModel->redeem_point ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="points_price" class="points_price">Price</label>
                                <input type="number" class="form-control points_price" name="points[price]" id="points_price" placeholder="Price" value="<?= $redeemPointsModel->price ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="points_max_redeem_point" class="points_max_redeem_point_label">Max Redeem Points</label>
                                <input type="number" class="form-control points_max_redeem_point" name="points[max_redeem_point]" id="points_max_redeem_point" placeholder="Max Redeem Points" value="<?= $redeemPointsModel->max_redeem_point ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success add-new-client">Save</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->

<div class="modal fade" id="smsAPIModal" tabindex="-1" aria-labelledby="smsAPIModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form class="" action="./inc/software-setting/branch-sms-api-setting-save.php" id="sms_api_setting_save" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smsAPIModalLabelSchedule">SMS API Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="api_url" class="api_url_label">API Url</label>
                                <input type="url" class="form-control api_url" name="api[url]" id="api_url" placeholder="URL" value="<?= $apiModel->url ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="api_username" class="api_username_label">API Username</label>
                                <input type="text" class="form-control api_username" name="api[username]" id="api_username" placeholder="Username" value="<?= $apiModel->username ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="api_password" class="api_password_label">API Password</label>
                                <input type="text" class="form-control api_password" name="api[password]" id="api_password" placeholder="Password" value="<?= $apiModel->password ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="api_sender_id" class="api_sender_id_label">Sender ID</label>
                                <input type="text" class="form-control api_sender_id" name="api[sender_id]" id="api_sender_id" placeholder="Sender ID" value="<?= $apiModel->sender_id ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="m-0">SMS Balance</label>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="">Transactional</label>
                                <input type="text" class="form-control disabled transbal" value="0" readonly disabled>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="">Promotional </label>
                                <input type="text" class="form-control disabled promobal" value="0" readonly disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->




<!-- Modal -->
<div class="modal fade" id="branchHolidayModal" tabindex="-1" aria-labelledby="branchHolidayModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="branchHolidayModalLabel">Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Client Form-->

            <form action="./inc/software-setting/branch-holiday-setting-save.php" method="post" id="branch_holiday_setting_save">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show server-error" role="alert" style="display: none;">
                                <strong>Error!</strong> <span id="error-message"></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="holiday_date" class="required label_holiday_date">Date</label>
                                <input type="text" class="form-control holiday_date" id="holiday_date" placeholder="Date" value="<?= $sHolidayModel->date ?>" name="holiday[date]" required>
                                <input type="hidden" name="holiday[id]" id="holiday_id" value="<?= $sHolidayModel->id ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="holiday_title" class="required label_holiday_title">Holiday Description</label>
                                <input type="text" class="form-control holiday_title" id="holiday_title" placeholder="Description" value="<?= $sHolidayModel->title ?>" name="holiday[title]" required>
                                <div class="showErr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>