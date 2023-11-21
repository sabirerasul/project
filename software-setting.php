<?php
require("./lib/db.php");
require("./classes/BranchWorkingDayHour.php");
//require("./classes/BranchSMSTemplate.php");
check_auth();

$branch_id = BRANCHID;
$branchModel = fetch_object($db, "SELECT * FROM branch WHERE id={$branch_id}");

$bwdhm = fetch_object($db, "SELECT * FROM branch_working_day_hour WHERE branch_id='{$branch_id}'");
$branchWorkingDayHourModel = !empty($bwdhm) ? $bwdhm : new BranchWorkingDayHour();

$bst = fetch_object($db, "SELECT * FROM branch_sms_template WHERE branch_id='{$branch_id}'");
//$branchSmsTemplateModel = !empty($bst) ? $bst : new BranchSMSTemplate();


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

                    <!-- Row starts -->
                    <div class="row">

                        <div>
                            <h2 class="h2 border shadow rounded d-block p-2">System Setting</h2>
                        </div>
                        <div class="col-md-10 mx-auto">

                            <div class="h3 border-0 my-4">
                                <h3>Salon Info</h3>
                            </div>
                            <div class="panel">
                                <div class="panel-body system-setting">
                                    <div class="widget-body">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#branchModal">Edit Setting</button>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <br>

                            <div class="h3 border-0 my-4">
                                <h3>Working Days & Hours</h3>
                            </div>
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="widget-body">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#branchWorkingModal">Edit Setting</button>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <br>

                            <!-- <div>
                                <h3 class="h3 border-0 my-4">SMS Templates Settings</h3>
                            </div>
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="widget-body">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smsTemplateModal">Edit Setting</button>
                                    </div>
                                </div>
                            </div>

                            <br><br><br><br><br><br> -->
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
    <script type="text/javascript" src="./js/pages/software-setting.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>

<div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form-horizontal" action="./inc/software-setting/branch-setting-save.php" id="branch_setting_save" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">Salon Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="salon_name" class="salon_name_label">Salon Name</label>
                                <input type="text" class="form-control salon_name" name="branch[salon_name]" id="salon_name" placeholder="Salon Name" value="<?= $branchModel->salon_name ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="phone_label">Phone</label>
                                <input type="text" class="form-control phone" name="branch[phone]" id="phone" placeholder="Phone" value="<?= $branchModel->phone ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="email_label">Email</label>
                                <input type="email" class="form-control email" name="branch[email]" id="email" placeholder="Email" value="<?= $branchModel->email ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="website" class="website_label">Website</label>
                                <input type="text" class="form-control website" name="branch[website]" id="website" placeholder="Website" value="<?= $branchModel->website ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gst" class="gst_label">GST</label>
                                <input type="text" class="form-control gst" name="branch[gst]" id="gst" placeholder="GST" value="<?= $branchModel->gst ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="working_hours" class="">Working Hours</label>
                                <div class="d-flex gap-2 justify-content-center">
                                    <input type="text" class="form-control working_hours_start time_picker" onchange="changeSalonTime()" name="branch[working_hours_start]" id="working_hours_start" placeholder="Start Time" value="<?= $branchModel->working_hours_start ?>" readonly>
                                    <input type="text" class="form-control working_hours_end time_picker" onchange="changeSalonTime()" name="branch[working_hours_end]" id="working_hours_end" placeholder="End Time" value="<?= $branchModel->working_hours_end ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="address_label">Address</label>
                                <textarea class="form-control address" id="address" name="branch[address]" placeholder="Address" rows="3" required><?= $branchModel->address ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo" class="">Update Logo</label>
                                <input type="file" class="form-control logo" id="logo" placeholder="Logo" name="branch[logo]" accept="image/*">
                                <div class="my-2">
                                    <img id="logo_showing" src="./web/salon-logo/<?= $branchModel->logo ?>" alt="your image" class="img-responsive img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client" name="service_submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal3">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->

<div class="modal fade" id="branchWorkingModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="./inc/software-setting/branch-working-hour-setting-save.php" id="branch_working_hour_setting_save" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">Working Days & Hours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Opening time and Closing time should be between <b id="st"><?= $branchModel->working_hours_start ?></b> to <b id="et"><?= $branchModel->working_hours_end ?></b>
                            </div>
                        </div>

                        <div class="col-md-4 my-1">
                            <p>
                                <strong>Days</strong>
                            </p>
                        </div>
                        <div class="col-md-4 my-1">
                            <p>
                                <strong>Opening Time</strong>
                            </p>
                        </div>
                        <div class="col-md-4 my-1">
                            <p>
                                <strong>Closing Time</strong>
                            </p>
                        </div>

                        <!-- Monday -->
                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[monday]" id="monday" <?= ($branchWorkingDayHourModel->monday) ? 'checked' : '' ?>> <span>Monday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control monday_hour_open time_picker new_open_hour" id="monday_hour_open" placeholder="Working hours" name="branch_working_day_hour[monday_hour_open]" value="<?= $branchWorkingDayHourModel->monday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control monday_hour_close time_picker new_close_hour" id="monday_hour_close" placeholder="Working hours" name="branch_working_day_hour[monday_hour_close]" value="<?= $branchWorkingDayHourModel->monday_hour_close ?>" readonly required>
                        </div>

                        <!-- Tuesday -->


                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[tuesday]" id="tuesday" <?= ($branchWorkingDayHourModel->tuesday) ? 'checked' : '' ?>> <span>Tuesday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control tuesday_hour_open time_picker new_open_hour" id="tuesday_hour_open" placeholder="Working hours" name="branch_working_day_hour[tuesday_hour_open]" value="<?= $branchWorkingDayHourModel->tuesday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control tuesday_hour_close time_picker new_close_hour" id="tuesday_hour_close" placeholder="Working hours" name="branch_working_day_hour[tuesday_hour_close]" value="<?= $branchWorkingDayHourModel->tuesday_hour_close ?>" readonly required>
                        </div>

                        <!-- wednesday -->

                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[wednesday]" id="wednesday" <?= ($branchWorkingDayHourModel->wednesday) ? 'checked' : '' ?>> <span>Wednesday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control wednesday_hour_open time_picker new_open_hour" id="wednesday_hour_open" placeholder="Working hours" name="branch_working_day_hour[wednesday_hour_open]" value="<?= $branchWorkingDayHourModel->wednesday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control wednesday_hour_close time_picker new_close_hour" id="wednesday_hour_close" placeholder="Working hours" name="branch_working_day_hour[wednesday_hour_close]" value="<?= $branchWorkingDayHourModel->wednesday_hour_close ?>" readonly required>
                        </div>

                        <!-- thursday -->

                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[thursday]" id="thursday" <?= ($branchWorkingDayHourModel->thursday) ? 'checked' : '' ?>> <span>Thursday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control thursday_hour_open time_picker new_open_hour" id="thursday_hour_open" placeholder="Working hours" name="branch_working_day_hour[thursday_hour_open]" value="<?= $branchWorkingDayHourModel->thursday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control thursday_hour_close time_picker new_close_hour" id="thursday_hour_close" placeholder="Working hours" name="branch_working_day_hour[thursday_hour_close]" value="<?= $branchWorkingDayHourModel->thursday_hour_close ?>" readonly required>
                        </div>

                        <!-- friday -->

                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[friday]" id="friday" <?= ($branchWorkingDayHourModel->friday) ? 'checked' : '' ?>> <span>Friday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control friday_hour_open time_picker new_open_hour" id="friday_hour_open" placeholder="Working hours" name="branch_working_day_hour[friday_hour_open]" value="<?= $branchWorkingDayHourModel->friday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control friday_hour_close time_picker new_close_hour" id="friday_hour_close" placeholder="Working hours" name="branch_working_day_hour[friday_hour_close]" value="<?= $branchWorkingDayHourModel->friday_hour_close ?>" readonly required>
                        </div>

                        <!-- Saturday -->

                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[saturday]" id="saturday" <?= ($branchWorkingDayHourModel->saturday) ? 'checked' : '' ?>> <span>Saturday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control saturday_hour_open time_picker new_open_hour" id="saturday_hour_open" placeholder="Working hours" name="branch_working_day_hour[saturday_hour_open]" value="<?= $branchWorkingDayHourModel->saturday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control saturday_hour_close time_picker new_close_hour" id="saturday_hour_close" placeholder="Working hours" name="branch_working_day_hour[saturday_hour_close]" value="<?= $branchWorkingDayHourModel->saturday_hour_close ?>" readonly required>
                        </div>

                        <!-- sunday -->

                        <div class="col-md-4 my-1">
                            <label>
                                <input type="checkbox" value="1" name="branch_working_day_hour[sunday]" id="sunday" <?= ($branchWorkingDayHourModel->sunday) ? 'checked' : '' ?>> <span>Sunday</span>
                            </label>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control sunday_hour_open time_picker new_open_hour" id="sunday_hour_open" placeholder="Working hours" name="branch_working_day_hour[sunday_hour_open]" value="<?= $branchWorkingDayHourModel->sunday_hour_open ?>" readonly required>
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" class="form-control sunday_hour_close time_picker new_close_hour" id="sunday_hour_close" placeholder="Working hours" name="branch_working_day_hour[sunday_hour_close]" value="<?= $branchWorkingDayHourModel->sunday_hour_close ?>" readonly required>
                        </div>
                    </div>

                    <div>
                        <h3 class="h3 border-0 my-4">Extra Hours</h3>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group working-days">
                                <label class="mr-4">
                                    <input type="radio" value="1" class="extra_hour" name="branch_working_day_hour[extra_hour]" <?= ($branchWorkingDayHourModel->extra_hour == 1) ? 'checked' : '' ?>> <span>Yes</span>
                                </label>
                                <label>
                                    <input type="radio" value="0" class="extra_hour" name="branch_working_day_hour[extra_hour]" <?= ($branchWorkingDayHourModel->extra_hour == 0) ? 'checked' : '' ?>> <span>No</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div>
                        <h3 class="h3 border-0 my-4">Day End Report</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-4 my-2">
                            <label><span class="mr-left-0">Report Time <b class="text-danger">*</b></span></label>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="text" name="branch_working_day_hour[day_end_report_time]" value="<?= $branchWorkingDayHourModel->day_end_report_time ?>" id="day_end_report_time" class="form-control time_picker" readonly="" required>
                        </div>

                        <div class="col-md-4 my-2">
                            <label><span class="mr-left-0">Server Time <b class="text-danger"></b></span></label>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="text" value="<?= date('d-m-Y h:i:s a'); ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4 my-2">
                            <label><span class="mr-left-0">Send In <b class="text-danger">*</b></span></label>
                        </div>
                        <div class="col-md-8">
                            <label class="mr-3">
                                <input type="checkbox" value="1" class="day_end_report_send_sms" name="branch_working_day_hour[day_end_report_send_sms]" id="day_end_report_send_sms" <?= ($branchWorkingDayHourModel->day_end_report_send_sms) ? 'checked' : '' ?>> <span>SMS</span>
                            </label>
                            <label>
                                <input type="checkbox" value="1" class="day_end_report_send_mail" name="branch_working_day_hour[day_end_report_send_mail]" id="day_end_report_send_mail" <?= ($branchWorkingDayHourModel->day_end_report_send_mail) ? 'checked' : '' ?>> <span>Email</span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="branch_working_day_hour[branch_working_day_hour_id]" value="<?= $branchWorkingDayHourModel->id ?>">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal2">Close</button>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- Modal End -->

<div class="modal fade" id="smsTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="" action="./inc/software-setting/branch-sms-template-setting-save.php" id="branch_sms_template_setting_save" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">SMS Templates Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="template_for" class="col-sm-12 control-label">Template For <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select class="form-select" name="branch_sms_template[template_for]" id="template_for">
                                    <option value="">Select</option>
                                    <?php
                                    //foreach ($templateForArr as $templateForKey => $templateForValue) {
                                    ?>
                                       <?php /* <option value="<?= $templateForValue ?>"><?= $templateForValue ?></option>
                                    <?php *}*/ ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smstemplate" class="col-sm-2 control-label">Message <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <textarea style="resize: none;" class="form-control" rows="8" name="branch_sms_template[message]" id="message" placeholder="" value=""><?php // $branchSmsTemplateModel->message ?></textarea>
                                <p>
                                    <strong>
                                        <span style="cursor: pointer;" id="clientname" onclick="addTofield('message','{name}','clientname')">{name}</span>
                                        <span style="cursor: pointer;" id="salonname" onclick="addTofield('message','{salon_name}','salonname')">{salon_name}</span>
                                    </strong>
                                </p>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="template_id" id="template_id" value="">
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