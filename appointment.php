<?php
require_once("./lib/db.php");
include_once("./classes/Appointment.php");
include_once("./classes/AppointmentAdvancePayment.php");
include_once("./classes/AppointmentAssignServiceProvider.php");
include_once("./classes/AppointmentService.php");
include_once("./classes/Client.php");

check_auth();
extract($_REQUEST);

$id = isset($id) ? $id : 0;
$leadid = isset($leadid) ? $leadid : 0;
$isBilled = 0;

$rewardPointModel = fetch_object($db, "SELECT * FROM branch_redeem_points_setting");

if ($id != 0) {
    $appointmentModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$id}'");
    $AppointmentAdvancePaymentModel = fetch_all($db, "SELECT * FROM appointment_advance_payment WHERE appointment_id='{$appointmentModel->id}'");

    if (count($AppointmentAdvancePaymentModel) == 0) {
        $paymentModel = (array) new AppointmentAdvancePayment();
        $paymentModel['advance'] = 0;
        $paymentModel1[] = $paymentModel;
        $AppointmentAdvancePaymentModel = $paymentModel1;
    }


    //$AppointmentAssignServiceProvider = fetch_all($db, "SELECT * FROM appointment_advance_payment WHERE appointment_id='{$model->id}'");
    $AppointmentServiceModel = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id='{$appointmentModel->id}'");

    if (count($AppointmentServiceModel) == 0) {
        $paymentModel1 = (array) new AppointmentService();
        //$paymentModel['advance'] = 0;
        $paymentModel2[] = $paymentModel1;
        $AppointmentServiceModel = $paymentModel2;
    }


    //$clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$appointmentModel->client_id}'");

    $isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$appointmentModel->id}'");

    //phpClientView($appointmentModel->client_id);
} else {
    $appointmentModel = new Appointment();
    $appointmentModel->branch_id = BRANCHID;
    $appointmentModel->discount = 0;

    //$AppointmentAssignServiceProvider = new AppointmentAssignServiceProvider();
    $paymentModel = (array) new AppointmentAdvancePayment();
    $paymentModel['advance'] = 0;
    $paymentModel1[] = $paymentModel;
    $AppointmentAdvancePaymentModel = $paymentModel1;

    if ($leadid != 0) {
        $enquiryModel = fetch_object($db, "SELECT * FROM enquiry WHERE id='{$leadid}'");
        if ($enquiryModel) {
            $appointmentModel->client_id = $enquiryModel->client_id;

            $enqServiceModel1 = (array) new AppointmentService();
            $enqServiceModel1['service_id'] = $enquiryModel->enquiry_for;
            $enqServiceModel1['service_discount'] = 0;
            $enqServiceModel2[] = $enqServiceModel1;
            $AppointmentServiceModel = $enqServiceModel2;
        }
    } else {

        $serviceModel1 = (array) new AppointmentService();
        $serviceModel1['service_discount'] = 0;
        $serviceModel2[] = $serviceModel1;
        $AppointmentServiceModel = $serviceModel2;
    }

    // /$clientModel = new Client();
}


$appointmentStatusArr = $appointmentStatusArr;
if ($id == 0) {
    unset($appointmentStatusArr['Cancelled']);
}

if ($id != 0) {
    $btnText = 'Update Appointment';
} else {
    $btnText = 'Create Appointment';
}


$salonTiming = get_salon_timing($db);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment - <?= SALONNAME ?></title>
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
                <?php include './comman/nav.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid bg-white">

                    <!-- Row starts -->
                    <form action="./inc/appointment/appointment-<?= ($id == 0) ? 'add' : 'update' ?>.php" method="post" id="appointment<?= ($id == 0) ? 'Add' : 'Update' ?>">
                        <div class="row">

                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $btnText ?></h2>
                            </div>

                            <div class="col-xl-10">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="member_ship_message">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="client">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control client_name search_client_name" id="client" value="" name="client[client_name]" placeholder="Autocomplete (Name)" required autocomplete="off">
                                            <input type="hidden" name="appointment[client_id]" id="client_id" value="<?= $appointmentModel->client_id ?>">
                                            <input type="hidden" name="appointment[id]" id="appointment_id" value="<?= $appointmentModel->id ?>">
                                            <input type="hidden" name="client[branch_id]" id="branch_id" value="<?= $appointmentModel->branch_id ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="cont">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control search_client_number" id="cont" name="client[contact]" value="" placeholder="Client Contact" maxlength="10" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="doa">Appointment Is On <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control present_date" id="date" name="appointment[appointment_date]" onclick="changeAppointmentDate()" value="<?= $appointmentModel->appointment_date ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="time">Time Of Appointment <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control present_time" name="appointment[appointment_time]" value="<?= $appointmentModel->appointment_time ?>" id="appointment_time" onchange="changeAppointmentTime()" required>
                                            <input type="hidden" class="hidden" id="close_time" value="<?= time_24($salonTiming['end']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="role">Source Of Appointment</label>
                                            <select class="form-select" name="appointment[appointment_source]">
                                                <?php
                                                foreach ($appointmentSourceArr as $appointmentSourceArrKey1 => $appointmentSourceArrVal1) { ?>
                                                    <option value="<?= $appointmentSourceArrKey1 ?>" <?= ($appointmentModel->appointment_source == $appointmentSourceArrKey1) ? 'selected' : '' ?>><?= $appointmentSourceArrVal1 ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="points">Service For</label>
                                            <select name="appointment[service_for]" id="service_for" class="form-select">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($serviceForArr as $serviceForArrKey1 => $serviceForArrVal1) { ?>
                                                    <option value="<?= $serviceForArrKey1 ?>" <?= ($appointmentModel->service_for == $serviceForArrKey1) ? 'selected' : '' ?>><?= $serviceForArrVal1 ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">&nbsp;</label>
                                            <button type="button" onclick="checkSchedule()" class="btn btn-warning btn-block text-white" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-calendar mr-1" aria-hidden="true"></i>Check Schedule</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 overflow-auto">
                                        <div class="">
                                            <table id="catTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Select Service</th>
                                                        <th>Discount</th>
                                                        <th>Service Provider</th>
                                                        <th>Start &amp; End Time</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($AppointmentServiceModel as $AppointmentServiceKey => $AppointmentServiceVal) {
                                                        $AppointmentServiceValue = (object) $AppointmentServiceVal;

                                                        $service_id = ($AppointmentServiceValue->service_id != '') ? $AppointmentServiceValue->service_id : 0;
                                                        $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$service_id}'");

                                                        $serviceProviderModel = ($AppointmentServiceValue->id != '') ? get_available_service_provider($db, $appointmentModel->appointment_date, $AppointmentServiceValue->service_id, $AppointmentServiceValue->end_timestamp) : [];
                                                        $original_price = 0;

                                                        if ($AppointmentServiceValue->service_discount_type == 'inr') {
                                                            $original_price = ($AppointmentServiceValue->price * 100) / (100 - $AppointmentServiceValue->service_discount);
                                                        }


                                                        if ($AppointmentServiceValue->service_discount_type == 'inr') {
                                                            $original_price = $AppointmentServiceValue->price + $AppointmentServiceValue->service_discount;
                                                        }

                                                        if ($appointmentModel->id != 0) {
                                                            $AppointmentAssignServiceProviderModel = fetch_all($db, "SELECT * FROM appointment_assign_service_provider WHERE appointment_service_id='{$AppointmentServiceValue->id}' AND appointment_id='{$AppointmentServiceValue->appointment_id}'");
                                                            if (count($AppointmentAssignServiceProviderModel) == 0) {
                                                                $AppointmentAssignServiceProvider = new AppointmentAssignServiceProvider();
                                                                $AppointmentAssignServiceProvider1[] = (array) $AppointmentAssignServiceProvider;
                                                                $AppointmentAssignServiceProviderModel = $AppointmentAssignServiceProvider1;
                                                            }
                                                        } else {
                                                            $AppointmentAssignServiceProvider = new AppointmentAssignServiceProvider();
                                                            $AppointmentAssignServiceProvider1[] = (array) $AppointmentAssignServiceProvider;
                                                            $AppointmentAssignServiceProviderModel = $AppointmentAssignServiceProvider1;
                                                        }

                                                        if (!empty($serviceModel)) {

                                                            $serviceText = $serviceModel->service_name;
                                                            $serviceCategoryModel = fetch_object($db, "SELECT * FROM service_category WHERE id='{$serviceModel->category_id}'");
                                                            $categoryText = $serviceCategoryModel->name;
                                                            $service_duration = $serviceModel->duration;
                                                        } else {
                                                            $categoryText = '';
                                                            $serviceText = '';
                                                            $service_duration = '';
                                                        }
                                                    ?>
                                                        <tr <?= ($AppointmentServiceKey == 0) ? 'id="service-provider-services"' : '' ?>>
                                                            <td style="vertical-align: middle;">
                                                                <?= ($AppointmentServiceKey == 0) ? "<span class='sno'><i class='fas fa-ellipsis-v'></i></span>" : "<span class='sno text-danger' onclick='removeServiceProviderServices(this);changeTiming(this)'><i class='fas fa-trash'></i></span>" ?>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 250px;">
                                                                    <div class="col-4 pr-1">
                                                                        <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" value="<?= $categoryText ?>" placeholder="Category" autocomplete="off">
                                                                        <input type="hidden" class="ser_cat_id" value="<?= $AppointmentServiceValue->service_cat_id ?>" name="appointment_service[<?= $AppointmentServiceKey ?>][service_cat_id]">
                                                                        <input type="hidden" class="appointment_service_id" value="<?= $AppointmentServiceValue->id ?>" name="appointment_service[<?= $AppointmentServiceKey ?>][id]">
                                                                    </div>
                                                                    <div class="col-8 pl-1">
                                                                        <input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" value="<?= $serviceText ?>" placeholder="Service (Autocomplete)" required autocomplete="off">
                                                                        <input type="hidden" name="appointment_service[<?= $AppointmentServiceKey ?>][service_id]" value="<?= $AppointmentServiceValue->service_id ?>" class="serr serviceids">

                                                                        <input type="hidden" name="service[]" value="<?= $AppointmentServiceValue->service_id ?>" class="serr">
                                                                        <input type="hidden" name="durr[]" value="" class="durr">
                                                                        <input type="hidden" name="pa_ser[]" value="" class="pa_ser">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 200px;">
                                                                    <div class="col-6 pr-1">
                                                                        <input type="number" oninput="addDiscount(this)" name="appointment_service[<?= $AppointmentServiceKey ?>][service_discount]" class="form-control form-control-sm d-input service-discount" value="<?= $AppointmentServiceValue->service_discount ?>">
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                        <select class="form-select form-select-sm discount-type" name="appointment_service[<?= $AppointmentServiceKey ?>][service_discount_type]" onchange="changeDiscountType(this)">
                                                                            <?php
                                                                            foreach ($discountArr as $discountArrKey1 => $discountArrVal1) { ?>
                                                                                <option value="<?= $discountArrKey1 ?>" <?= ($AppointmentServiceValue->service_discount_type == $discountArrKey1) ? 'selected' : '' ?>><?= $discountArrVal1 ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                foreach ($AppointmentAssignServiceProviderModel as $AppointmentAssignServiceProviderKey => $AppointmentAssignServiceProviderVal) {

                                                                ?>
                                                                    <div class="row mb-1" id="service-provider-box" style="width: 200px;">
                                                                        <div class="col-9 pr-1">

                                                                            <select name="appointment_service[<?= $AppointmentServiceKey ?>][sp_id][<?= $AppointmentAssignServiceProviderKey ?>][service_provider_id]" class="form-select form-select-sm staff" onchange="checkAvailabalityServiceProvider(this)" required>
                                                                                <option value="">Service Provider</option>

                                                                                <?php foreach ($serviceProviderModel as $serviceProviderKey => $serviceProviderVal) {
                                                                                    $serviceProviderValue = (object) $serviceProviderVal;
                                                                                ?>
                                                                                    <option value="<?= $serviceProviderValue->id ?>" <?= ($serviceProviderValue->id == $AppointmentAssignServiceProviderVal['service_provider_id']) ? 'selected' : '' ?>><?= $serviceProviderValue->name ?></option>

                                                                                <?php } ?>
                                                                            </select>
                                                                            <input type="hidden" name="appointment_service[<?= $AppointmentServiceKey ?>][sp_id][<?= $AppointmentAssignServiceProviderKey ?>][id]" value="<?= $AppointmentAssignServiceProviderVal['id'] ?>">
                                                                        </div>
                                                                        <div class="col-3 pl-1">
                                                                            <span class="input-group-btn">
                                                                                <?php if ($AppointmentAssignServiceProviderKey == 0) { ?>
                                                                                    <button class="btn btn-plus btn-sm btn-success" type="button" onclick="addServiceProvider(this)">
                                                                                        <i class="fas fa-plus"></i>
                                                                                    </button>
                                                                                <?php } else { ?>
                                                                                    <button class="btn btn-minus btn-sm btn-danger" type="button" onclick="removeServiceProvider(this)">
                                                                                        <i class="fas fa-minus"></i>
                                                                                    </button>
                                                                                <?php } ?>

                                                                            </span>
                                                                        </div>
                                                                        <input type="hidden" name="duration[]" value="<?= $service_duration ?>" class="duration">
                                                                        <input type="hidden" name="ser_stime[]" value="<?= $AppointmentServiceValue->start_timestamp ?>" class="ser_stime">
                                                                        <input type="hidden" name="ser_etime[]" value="<?= $AppointmentServiceValue->end_timestamp ?>" class="ser_etime">
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 200px;">
                                                                    <div class="col-6 pr-1">
                                                                        <input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" value="<?= $AppointmentServiceValue->start_time ?>" name="appointment_service[<?= $AppointmentServiceKey ?>][start_time]" onchange="changeTimeValue(this)" readonly>
                                                                        <input type="hidden" class='start_timestamp' name='appointment_service[<?= $AppointmentServiceKey ?>][start_timestamp]' value="<?= $AppointmentServiceValue->start_timestamp ?>">
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                        <input type="text" class="form-control form-control-sm end_time1 w-100" name="appointment_service[<?= $AppointmentServiceKey ?>][end_time]" value="<?= $AppointmentServiceValue->end_time ?>" placeholder="End Time" readonly>
                                                                        <input type="hidden" class='end_timestamp' name='appointment_service[<?= $AppointmentServiceKey ?>][end_timestamp]' value="<?= $AppointmentServiceValue->end_timestamp ?>">
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control form-control-sm service-price" name="appointment_service[<?= $AppointmentServiceKey ?>][price]" placeholder="0" value="<?= $AppointmentServiceValue->price ?>" readonly>
                                                                <input type="hidden" class="old-price" value="<?= $original_price ?>">
                                                            </td>

                                                        </tr>
                                                    <?php } ?>

                                                    <tr id="addBefore">
                                                        <td colspan="6" class="text-right">
                                                            <button type="button" id="btnAdd" class="btn btn-success" onclick="addServiceProviderServices()">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> Add Service
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Subtotal</td>
                                                        <td>
                                                            <input type="number" class="form-control" id="sum-input" value="<?= $appointmentModel->sub_total ?>" name="appointment[sub_total]" readonly required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">Discount</td>
                                                        <td width="40%">
                                                            <input type="number" class="form-control total-discount-input" name="appointment[discount]" value="<?= $appointmentModel->discount ?>" placeholder="Discount Amount" onchange="setDiscount()">
                                                        </td>
                                                        <td width="60%">
                                                            <select class="form-select total-discount-select" name="appointment[discount_type]" onchange="setDiscount()">
                                                                <?php
                                                                foreach ($discountArr as $discountArrKey2 => $discountArrVal2) { ?>
                                                                    <option value="<?= $discountArrKey2 ?>" <?= ($appointmentModel->discount_type == $discountArrKey2) ? 'selected' : '' ?>><?= $discountArrVal2 ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">Taxes</td>
                                                        <td colspan="2">
                                                            <select name="appointment[tax]" class="form-select appointment-tax" onchange="appointmentTax()">
                                                                <option value="">Select Taxes</option>
                                                                <?php foreach ($taxTypeArr as $taxTypeKey => $taxTypeValue) { ?>
                                                                    <optgroup label="<?= ucfirst($taxTypeValue) ?> Taxes">
                                                                        <?php

                                                                        $gstModel = fetch_all($db, "SELECT * FROM gst_slab WHERE tax_type='{$taxTypeValue}' AND product_service_type='service' ORDER by gst ASC");
                                                                        foreach ($gstModel as $gstKey => $gstVal) {
                                                                            $gstValue = (object) $gstVal;
                                                                        ?>
                                                                            <option value="<?= $gstValue->id ?>" data-product-type="<?=$gstValue->product_service_type?>" data-tax-type="<?=$gstValue->tax_type?>" data-gst="<?=$gstValue->gst?>" <?= ($appointmentModel->tax == $gstValue->id) ? 'selected' : '' ?>><?= "GST on {$gstValue->product_service_type} ({$gstValue->gst} %)" ?></option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" id="tot" colspan="5">Total</td>
                                                        <td>
                                                            <input type="number" id="total" class="form-control" name="appointment[total]" placeholder="Total Amount" value="<?= $appointmentModel->total ?>" readonly>
                                                            <input type="hidden" id="original_total_charge" value="<?= $appointmentModel->sub_total ?>">
                                                        </td>
                                                    </tr>
                                                    <tr id="TextBoxContainerPayment" class="TextBoxContainerPayment">
                                                        <Td Class="Total" Colspan="3">Advance Given <Br>
                                                            <span class="text-danger">*Reward Points:- <?= $rewardPointModel->price ?> INR = <?= $rewardPointModel->redeem_point ?> points</span>
                                                            <input type="hidden" id="price_reward_setting" value="<?= $rewardPointModel->price ?>">
                                                            <input type="hidden" id="redeem_point_reward_setting" value="<?= $rewardPointModel->redeem_point ?>">
                                                            <input type="hidden" id="max_redeem_point_reward_setting" value="<?= $rewardPointModel->max_redeem_point ?>">
                                                        </td>

                                                        <td colspan="3" id="transaction-row">
                                                            <?php
                                                            foreach ($AppointmentAdvancePaymentModel as $AppointmentAdvancePaymentKey => $AppointmentAdvancePaymentVal) {
                                                                $AppointmentAdvancePaymentValue = (object) $AppointmentAdvancePaymentVal;
                                                            ?>
                                                                <div class="row <?= ($AppointmentAdvancePaymentKey != 0) ? 'my-1' : '' ?> ">
                                                                    <div class="col-4">
                                                                        <input type="text" name="appointment_advance_payment[<?= $AppointmentAdvancePaymentKey ?>][transaction_id]" class="key form-control transid" value="<?= $AppointmentAdvancePaymentValue->transaction_id ?>" placeholder="TXN ID" onchange="advanceGiven(this)">
                                                                        <input type="hidden" name="appointment_advance_payment[<?= $AppointmentAdvancePaymentKey ?>][id]" value="<?= $AppointmentAdvancePaymentValue->id ?>">
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <input type="number" name="appointment_advance_payment[<?= $AppointmentAdvancePaymentKey ?>][advance]" class="key form-control adv advance-amount" value="<?= $AppointmentAdvancePaymentValue->advance ?>" step="0.1" onchange="advanceGiven(this)">
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <select name="appointment_advance_payment[<?= $AppointmentAdvancePaymentKey ?>][method]" class="form-select adv-type" onchange="advanceGiven(this)">
                                                                            <?php
                                                                            foreach ($appointmentPaymentModeArr as $appointmentPaymentModeArrKey => $appointmentPaymentModeArrVal) { ?>
                                                                                <option value="<?= $appointmentPaymentModeArrKey ?>" <?= ($AppointmentAdvancePaymentValue->method == $appointmentPaymentModeArrKey) ? 'selected' : '' ?>><?= $appointmentPaymentModeArrVal ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-2">

                                                                        <?php if ($AppointmentAdvancePaymentKey != 0) { ?>
                                                                            <button style="pointer-events: initial;" class="btn btn-minus btn-danger" type="button" onclick="removeMultiTransaction(this)">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>

                                                                        <?php } else { ?>

                                                                            <button style="pointer-events: initial;" class="btn btn-plus btn-success" type="button" onclick="addMultiTransaction()">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="row" id="addBeforeTransaction"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" colspan="5">Pending Dues</td>
                                                        <td>
                                                            <input type="number" name="appointment[pending_due]" class="form-control" id="pending_due" value="<?= $appointmentModel->pending_due ?>" readonly required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" colspan="5">Appointment Status</td>
                                                        <td>
                                                            <select name="appointment[status]" class="form-select appointment_status">
                                                                <?php foreach ($appointmentStatusArr as $appointmentStatusArrKey => $appointmentStatusArrVal) { ?>
                                                                    <option value="<?= $appointmentStatusArrKey ?>" <?= ($appointmentModel->status == $appointmentStatusArrKey) ? 'selected' : '' ?>><?= $appointmentStatusArrVal ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="8">
                                                            <textarea name="appointment[notes]" class="form-control no-resize" rows="5" placeholder="Write Notes About Appointment here..." id="textArea"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right mb-5">
                                        <input type="hidden" id="discount_on_package" value="">
                                        <input type="hidden" id="discount_on_package_type" value="">
                                        <input type="hidden" id="discount_on_product" value="">
                                        <input type="hidden" id="discount_on_product_type" value="">
                                        <input type="hidden" id="discount_on_service" value="">
                                        <input type="hidden" id="discount_on_service_type" value="">
                                        <input type="hidden" id="membership_condition" value="0">
                                        <input type="hidden" id="mem_reward_point" value="0">
                                        <input type="hidden" id="min_bill_amount" value="0" />
                                        <input type="hidden" name="appointment[membership_id]" id="membership_id" value="0">
                                        <?php if ($isBilled == 0 && $appointmentModel->status != 'Cancelled') { ?>
                                            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?= $btnText ?></button>
                                            <button type="reset" name="" class="btn mr-left-5 btn-danger">Reset</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 grey-box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="client-view">
                                            <div class="client-view-content">
                                                <div class="row">


                                                    <div class="col-md-12 p-1">
                                                        <h5 class="h5 mb-0 text-gray-800 border shadow-sm rounded p-1"><i class="fas fa-redo-alt text-warning fa-spin"></i>&nbsp;&nbsp;Client 360° View</h5>
                                                    </div>


                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div id="customer_type"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Client Profile:</div>
                                                            <div id="branch_name">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Last Visit On:</div>
                                                            <div id="last_visit">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Total Visits:</div>
                                                            <div id="total_visit">0</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Total Spendings:</div>
                                                            <div id="total_spending">0 INR</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>My Wallet :</div>
                                                            <div id="wallet">0.00 INR</div>
                                                            <input type="hidden" id="wallet_money" value="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Reward Points:</div>
                                                            <div id="earned_points">0</div>
                                                            <input type="hidden" id="reward_point" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Pending Amount:</div>
                                                            <div id="bill_pending_amount">0 INR</div>
                                                            <input type="hidden" id="bill_pending_amount_input" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Gender:</div>
                                                            <div id="gender">
                                                                <select class="form-select" name="client[gender]" id="gender">
                                                                    <option value="">Select</option>
                                                                    <option id="gn-1" value="male" selected>Male</option>
                                                                    <option id="gn-2" value="female">Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Date Of Birth :</div>
                                                            <div id="dob"><input type="text" class="form-control dob_annv_date" name="client[dob]" id="clientdob" readonly></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Anniversary :</div>
                                                            <div><input type="text" class="form-control dob_annv_date" name="client[anniversary]" id="anniversary" readonly></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Source Of Client:</div>
                                                            <div>
                                                                <select class="form-select" name="client[source_of_client]" id="leadsource">
                                                                    <option value="">Select</option>
                                                                    <option value="Client refrence">Client refrence</option>
                                                                    <option value="Cold Calling">Cold Calling</option>
                                                                    <option value="Facebook">Facebook</option>
                                                                    <option value="Twitter">Twitter</option>
                                                                    <option value="Instagram">Instagram</option>
                                                                    <option value="Other Social Media">Other Social Media</option>
                                                                    <option value="Website">Website</option>
                                                                    <option value="Walk-In">Walk-In</option>
                                                                    <option value="Flex">Flex</option>
                                                                    <option value="Flyer">Flyer</option>
                                                                    <option value="Newspaper">Newspaper</option>
                                                                    <option value="SMS">SMS</option>
                                                                    <option value="Street Hoardings">Street Hoardings</option>
                                                                    <option value="Event">Event</option>
                                                                    <option value="TV/Radio">TV/Radio</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Membership:</div>
                                                            <div id="membership">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Active Packages:</div>
                                                            <div id="active_package">----</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 p-1">
                                                        <div class="p-1 shadow-sm rounded border">
                                                            <div>Last Feedback:</div>
                                                            <div id="last_feedback">----</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script type="text/javascript" src="./js/pages/appointment.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>

<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelSchedule"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Service Provider</th>
                            <th>Client Name</th>
                            <th>Service Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>

                    <tbody id="todaySchedule">


                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<div class="modal fade" id="serviceProviderScheduleModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="serviceProviderScheduleModelLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceProviderScheduleModelLabelSchedule">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Service Provider</th>
                            <th>Client Name</th>
                            <th>Service Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>

                    <tbody id="serviceProviderScheduleTable">


                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="pendingPaymentTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingPaymentTitle">Pending Payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Pending Amount</th>
                                    <th>Pay Amount</th>
                                    <th>Pay Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pendingPaymentTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Package Modal -->
<div id="packageModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="packagePaymentTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packagePaymentTitle">Client Package</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Package Name</th>
                                    <th>Branch</th>
                                    <th>Valid Upto</th>
                                    <th>Package Price</th>
                                    <th>Total Services</th>
                                    <th>Service Availed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="packageTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



<!-- Payment Modal -->
<div id="packageHistoryModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="packageHistoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packageHistoryTitle">Available Package Services</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Service Name</th>
                                    <th>Unit</th>
                                    <th>Package Name</th>
                                    <th>Purchased On</th>
                                    <th>Expired On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="packageHistoryTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>