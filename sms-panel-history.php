<?php
require_once "lib/db.php";
check_auth();

$clientModel = fetch_all($db, "SELECT * FROM client ORDER BY id DESC");
$smsMessageModel = fetch_all($db, "SELECT * FROM branch_sms_message ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMS Panel History - <?= SALONNAME ?></title>

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

    <link rel="stylesheet" href="./css/pages/appointment.css">

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

                <?php include('./comman/sms-panel-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">SMS Panel History</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Message</th>
                                                    <th>Schedule</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                $count = 0;
                                                $historyModel = fetch_all($db, "SELECT * FROM `branch_sms_history` ORDER by id DESC");
                                                foreach ($historyModel as $historyKey => $historyVal) {
                                                    $count++;
                                                    $historyValue = (object) $historyVal;
                                                    $sClientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$historyValue->client_id}'");
                                                    $sMessageModel = fetch_object($db, "SELECT * FROM `branch_sms_message` WHERE id='{$historyValue->message_id}'");
                                                    $schedule = !empty($historyValue->schedule) ? $historyValue->schedule : 'Instant';
                                                ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $sClientModel->client_name ?></td>
                                                        <td><?= $sMessageModel->message ?></td>
                                                        <td><?= $schedule ?></td>
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

    <script src="./js/pages/sms-panel.js"></script>


    <?php include('./comman/loading.php'); ?>
</body>

</html>

<div class="modal fade" id="smsTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="" action="./inc/software-setting/branch-sms-template-send.php" id="branch_sms_template_send" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">Select SMS Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="doa">Schedule Date (Optional) </label>
                                <input type="text" class="form-control present_date" id="date" name="schedule_date" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="time">Schedule Time (Optional) </label>
                                <input type="text" class="form-control present_time" name="schedule_time" value="" id="appointment_time" readonly>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message_id" class="col-sm-12 message_id_label">Message <span class="text-danger">*</span></label>
                                <select class="form-select message_id" name="message_id" id="message_id" onchange="changeSMSTemplate(this)">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($smsMessageModel as $messageKey => $messageVal) {
                                        $messageValue = (object) $messageVal;
                                    ?>
                                        <option value="<?= $messageValue->id ?>" data-template-value="<?= $messageValue->message ?>"><?= $messageValue->sms_title ?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" name="clients_id" id="hiddenClientId">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-dark message-preview" role="alert">
                                <strong>Message Preview</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">Send</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal3">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>