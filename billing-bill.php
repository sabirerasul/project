<?php
require_once("lib/db.php");

include("./classes/Billing.php");
include("./classes/BillingPayment.php");
include("./classes/BillingAssignServiceProvider.php");
include("./classes/BillingProduct.php");
include("./classes/Client.php");

check_auth();
extract($_REQUEST);

/*
if (isset($aid) || isset($id)) {
    if (isset($aid)) {
        $model = fetch_object($db, "SELECT * FROM appointment WHERE id='{$aid}'");
        $productModel = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id='{$aid}'");
    } else {
        $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$id}'");
        $productModel = fetch_object($db, "SELECT * FROM client_billing_product WHERE billing_id='{$id}'");
    }

    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$model->client_id}'");
} else {
    $model = new Billing();
    $model->sub_total = 0;
    $productModel = new BillingProduct();
    $clientModel = new CLient();
}
*/

$id = isset($id) ? $id : 0;
$aid = isset($aid) ? $aid : 0;
$leadid = isset($leadid) ? $leadid : 0;
$isBilled = 0;

$rewardPointModel = fetch_object($db, "SELECT * FROM branch_redeem_points_setting");

if ($id != 0) {
    $billing = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$id}'");
    $billingPayment = fetch_all($db, "SELECT * FROM client_billing_payment WHERE billing_id='{$billing->id}'");

    if (count($billingPayment) == 0) {
        $billingPayment1 = (array) new BillingPayment();
        $billingPayment1['advance'] = 0;
        $billingPayment2[] = $billingPayment1;
        $billingPayment = $billingPayment2;
    }


    $billingProduct = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing->id}'");
    if (count($billingProduct) == 0) {
        $billingProduct1 = (array) new BillingProduct();
        $billingProduct2[] = $billingProduct1;
        $billingProduct = $billingProduct2;
    }

    //phpClientView($billing->client_id);
} else {
    $billing = new Billing();
    $billing->branch_id = BRANCHID;
    $billing->sub_total = 0;
    $billing->discount = 0;
    $billing->total = 0;
    $billing->advance_receive = 0;
    $billing->pending_amount = 0;
    $billing->appointment_id = 0;

    $billingPayment1 = (array) new BillingPayment();
    $billingPayment1['advance'] = 0;
    $billingPayment2[] = $billingPayment1;
    $billingPayment = $billingPayment2;

    if ($leadid != 0) {
        $enquiryModel = fetch_object($db, "SELECT * FROM enquiry WHERE id='{$leadid}'");
        if ($enquiryModel) {
            $billing->client_id = $enquiryModel->client_id;
            $billingProduct1 = (array) new BillingProduct();
            $billingProduct1['service_id'] = $enquiryModel->enquiry_for;
            $billingProduct1['service_type'] = $enquiryModel->enquiry_table_type;
            $billingProduct1['service_discount'] = 0;
            $billingProduct2[] = $billingProduct1;
            $billingProduct = $billingProduct2;
        }
    } else if ($aid != 0) {
        $appointment = fetch_object($db, "SELECT * FROM appointment WHERE id='{$aid}'");
        $appointmentService = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id='{$aid}'");
        $billing->appointment_id = $appointment->id;
        $billing->client_id = $appointment->client_id;
        $billing->membership_id = $appointment->membership_id;
        $billing->service_for = $appointment->service_for;
        $billing->sub_total = $appointment->sub_total;
        $billing->discount = ($appointment->discount != '') ? $appointment->discount : 0;
        $billing->discount_type = $appointment->discount_type;
        $billing->tax = $appointment->tax;
        $billing->total = $appointment->total;
        $billing->advance_receive = $appointment->total - $appointment->pending_due;
        $billing->pending_amount = $appointment->pending_due;

        $billingProduct1 = [];
        foreach ($appointmentService as $appointmentServiceKey => $appointmentServiceVal) {
            $appointmentServiceValue = (object) $appointmentServiceVal;

            $billingProduct1 = (array) new BillingProduct();
            $billingProduct1['service_cat_id'] = $appointmentServiceValue->service_cat_id;
            $billingProduct1['service_id'] = $appointmentServiceValue->service_id;
            $billingProduct1['service_type'] = 'service';
            $billingProduct1['quantity'] = 1;
            $billingProduct1['service_cat_id'] = $appointmentServiceValue->service_cat_id;
            $billingProduct1['service_discount'] = ($appointmentServiceValue->service_discount != '') ? $appointmentServiceValue->service_discount : 0;
            $billingProduct1['service_discount_type'] = $appointmentServiceValue->service_discount_type;
            $billingProduct1['start_time'] = $appointmentServiceValue->start_time;
            $billingProduct1['end_time'] = $appointmentServiceValue->end_time;
            $billingProduct1['start_timestamp'] = $appointmentServiceValue->start_timestamp;
            $billingProduct1['end_timestamp'] = $appointmentServiceValue->end_timestamp;
            $billingProduct1['price'] = $appointmentServiceValue->price;
            $billingProduct1['appointment_service_id'] = $appointmentServiceValue->id;

            $billingProduct[] = $billingProduct1;
        }
    } else {
        $billingProduct1 = (array) new BillingProduct();
        $billingProduct1['quantity'] = 1;
        $billingProduct1['service_discount'] = 0;
        $billingProduct1['price'] = 0;
        $billingProduct2[] = $billingProduct1;
        $billingProduct = $billingProduct2;
    }
}

if ($id != 0) {
    $btnText = 'Update Bill';
} else {
    $btnText = 'Create Bill';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Billing - <?= SALONNAME ?></title>
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

    <link rel="stylesheet" href="./css/pages/billing-bill.css">

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
                    <form action="./inc/billing/billing-<?= ($btnText == 'Create Bill') ? 'add' : 'update' ?>.php" method="post" id="billing<?= ($btnText == 'Create Bill') ? 'Add' : 'Update' ?>">
                        <div class="row">

                            <div class="col-12">
                                <div class="tab">
                                    <a class="tablinks active" href="./billing-bill.php" id="tabCategory">Bill</a>
                                    <a class="tablinks " href="./billing-wallet.php" id="tabService">Wallet</a>
                                </div>
                            </div>




                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= ($btnText == 'Create Bill') ? 'Generate Bill' : $btnText ?></h2>
                            </div>

                            <div class="col-xl-10">


                                <div class="row">

                                    <div class="col-md-12">
                                        <div id="member_ship_message">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="billing_date">Date Of Billing <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control billing_date" id="billing_date" value="<?= $billing->billing_date ?>" name="billing[billing_date]" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="client" class="client_name_label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control client_name search_client_name" id="client" name="client[client_name]" placeholder="Autocomplete (Name)" required autocomplete="off" autofocus>
                                            <input type="hidden" name="billing[client_id]" id="client_id" value="<?= $billing->client_id ?>">
                                            <input type="hidden" name="billing[id]" id="billing_id" value="<?= $billing->id ?>">
                                            <input type="hidden" name="billing[appointment_id]" id="appointment_id" value="<?= $billing->appointment_id ?>">
                                            <input type="hidden" name="client[branch_id]" id="branch_id" value="<?= BRANCHID ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="cont">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control search_client_number" id="cont" name="client[contact]" placeholder="Client Contact" maxlength="10" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="billing_time">Time Of Billing <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control billing_time" value="<?= $billing->billing_time ?>" name="billing[billing_time]" id="billing_time" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="points">Service For</label>
                                            <select name="billing[service_for]" id="service_for" class="form-select">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($serviceForArr as $serviceForArrKey1 => $serviceForArrVal1) { ?>
                                                    <option value="<?= $serviceForArrKey1 ?>" <?= ($billing->service_for == $serviceForArrKey1) ? 'selected' : '' ?>><?= $serviceForArrVal1 ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 overflow-auto">
                                        <div class="">
                                            <table id="catTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Service / Products / Packages</th>
                                                        <th>Quantity</th>
                                                        <th>Discount</th>
                                                        <th>Service Provider</th>
                                                        <th>Start &amp; End Time</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($billingProduct as $billingProductKey => $billingProductVal) {
                                                        $billingProductValue = (object) $billingProductVal;
                                                        $categoryText = '';
                                                        $serviceText = '';
                                                        $service_duration = 0;

                                                        if (empty($billing->billing_date)) {
                                                            $billing->billing_date = !empty($appointment) ? $appointment->appointment_date : todayDate();
                                                        }
                                                        $serviceProviderModel = ($billingProductValue->id != '' || $aid != 0) ? get_available_service_provider($db, $billing->billing_date, $billingProductValue->service_id, $billingProductValue->end_timestamp, $billingProductValue->service_type) : [];
                                                        $original_price = 0;

                                                        if ($billingProductValue->service_discount_type == 'percentage') {
                                                            $original_price = round(($billingProductValue->price * 100) / (100 - $billingProductValue->service_discount));
                                                        }

                                                        if ($billingProductValue->service_discount_type == 'inr') {
                                                            $original_price = round($billingProductValue->price + $billingProductValue->service_discount);
                                                        }

                                                        if ($billing->id != 0) {
                                                            $billingAssignServiceProvider = fetch_all($db, "SELECT * FROM client_billing_assign_service_provider WHERE billing_service_id='{$billingProductValue->id}' AND billing_id='{$billingProductValue->billing_id}'");

                                                            $enquiryForModel = fetch_object($db, "SELECT * FROM {$billingProductValue->service_type} WHERE id='{$billingProductValue->service_id}'");

                                                            $arrayField = [
                                                                'service' => 'service_name',
                                                                'membership' => 'membership_name',
                                                                'package' => 'package_name',
                                                                'stock' => 'product_id'
                                                            ];

                                                            $fieldName = $arrayField[$billingProductValue->service_type];

                                                            if ($billingProductValue->service_type == 'stock') {
                                                                $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
                                                                $serviceText = $productModel->product;
                                                            } else {
                                                                $serviceText = $enquiryForModel->$fieldName;

                                                                if ($billingProductValue->service_type == 'service') {
                                                                    $service_category = fetch_object($db, "SELECT * FROM service_category WHERE id='{$billingProductValue->service_cat_id}'");
                                                                    $categoryText = $service_category->name;
                                                                }
                                                            }

                                                            if ($billingProductValue->service_type == 'service' || $billingProductValue->service_type == 'package') {
                                                                $service_duration = $enquiryForModel->duration;
                                                            }
                                                        } else {

                                                            if (!empty($appointment)) {
                                                                $billingAssignServiceProvider = fetch_all($db, "SELECT id, appointment_service_id as billing_service_id, service_provider_id FROM appointment_assign_service_provider WHERE appointment_service_id='{$billingProductValue->appointment_service_id}' AND appointment_id='{$appointment->id}'");
                                                            } else {
                                                                $billingAssignServiceProvider1 = new BillingAssignServiceProvider();
                                                                $billingAssignServiceProvider2[] = (array) $billingAssignServiceProvider1;
                                                                $billingAssignServiceProvider = $billingAssignServiceProvider2;
                                                            }

                                                            if (!empty($billingProductValue->service_id) && !empty($billingProductValue->service_type)) {



                                                                $enquiryForModel = fetch_object($db, "SELECT * FROM {$billingProductValue->service_type} WHERE id='{$billingProductValue->service_id}'");

                                                                $arrayField = [
                                                                    'service' => 'service_name',
                                                                    'membership' => 'membership_name',
                                                                    'package' => 'package_name',
                                                                    'stock' => 'product_id'
                                                                ];

                                                                $fieldName = $arrayField[$billingProductValue->service_type];

                                                                if ($billingProductValue->service_type == 'stock') {
                                                                    $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
                                                                    $serviceText = $productModel->product;
                                                                } else {
                                                                    $serviceText = $enquiryForModel->$fieldName;

                                                                    if ($billingProductValue->service_type == 'service') {
                                                                        $service_category = fetch_object($db, "SELECT * FROM service_category WHERE id='{$billingProductValue->service_cat_id}'");
                                                                        $categoryText = $service_category->name;
                                                                    }
                                                                }
                                                            }
                                                        }

                                                    ?>

                                                        <tr id="service-provider-services" data-id='tr-0'>

                                                            <td style="vertical-align: middle;">
                                                                <span class="sno"><i class="fas fa-ellipsis-v"></i></span>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 250px;">
                                                                    <div class="col-4 pr-1">
                                                                        <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" name="" value="<?= $categoryText ?>" placeholder="Category" autocomplete="off">
                                                                        <input type="hidden" class="ser_cat_id" value="<?= $billingProductValue->service_cat_id; ?>" name="billing_product[<?= $billingProductKey ?>][service_cat_id]">
                                                                        <input type="hidden" class="billing_product_id" value="<?= $billingProductValue->id; ?>" name="billing_product[<?= $billingProductKey ?>][id]">
                                                                    </div>
                                                                    <div class="col-8 pl-1">
                                                                        <input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" name="" value="<?= $serviceText ?>" placeholder="Service (Autocomplete)" required autocomplete="off">
                                                                        <input type="hidden" name="billing_product[<?= $billingProductKey ?>][service_id]" value="<?= $billingProductValue->service_id; ?>" class="serr serviceids">
                                                                        <input type="hidden" name="billing_product[<?= $billingProductKey ?>][service_type]" value="<?= $billingProductValue->service_type; ?>" class="service_type">

                                                                        <input type="hidden" name="service[]" value="" class="serr">
                                                                        <input type="hidden" name="durr[]" value="" class="durr">
                                                                        <input type="hidden" name="pa_ser[]" value="" class="pa_ser">

                                                                        <input type="hidden" name="billing_product[0][package_id]" value="0" class="package_id">
                                                                        <input type="hidden" name="billing_product[0][client_package_id]" value="0" class="client_package_id">
                                                                        <input type="hidden" name="billing_product[0][package_details_id]" value="0" class="package_details_id">
                                                                        <input type="hidden" name="billing_product[0][client_package_quantity]" value="0" class="client_package_quantity">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">

                                                                    <div class="col-12">
                                                                        <input type="number" name="billing_product[<?= $billingProductKey ?>][quantity]" min="1" class="form-control form-control-sm d-input service-quantity" value="<?= $billingProductValue->quantity; ?>" onchange="changeQuantity(this)">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 200px;">
                                                                    <div class="col-6 pr-1">
                                                                        <input type="number" oninput="addDiscount(this)" name="billing_product[<?= $billingProductKey ?>][service_discount]" class="form-control form-control-sm d-input service-discount" value="<?= $billingProductValue->service_discount; ?>">
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                        <select class="form-select form-select-sm discount-type" name="billing_product[<?= $billingProductKey ?>][service_discount_type]" onchange="changeDiscountType(this)">
                                                                            <?php
                                                                            foreach ($discountArr as $discountArrKey1 => $discountArrVal1) { ?>
                                                                                <option value="<?= $discountArrKey1 ?>" <?= ($discountArrKey1 == $billingProductValue->service_discount_type) ? 'selected' : '' ?>><?= $discountArrVal1 ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                foreach ($billingAssignServiceProvider as $billingAssignServiceProviderKey => $billingAssignServiceProviderVal) {
                                                                ?>
                                                                    <div class="row mb-1" id="service-provider-box" style="width: 200px;">
                                                                        <div class="col-9 pr-1">
                                                                            <select name="billing_product[<?= $billingProductKey ?>][sp_id][<?= $billingAssignServiceProviderKey ?>][service_provider_id]" class="form-select form-select-sm staff">
                                                                                <option value="">Service provider</option>
                                                                                <?php foreach ($serviceProviderModel as $serviceProviderKey => $serviceProviderVal) {
                                                                                    $serviceProviderValue = (object) $serviceProviderVal;
                                                                                ?>
                                                                                    <option value="<?= $serviceProviderValue->id ?>" <?= ($serviceProviderValue->id == $billingAssignServiceProviderVal['service_provider_id']) ? 'selected' : '' ?>><?= $serviceProviderValue->name ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <input type="hidden" name="billing_product[<?= $billingProductKey ?>][sp_id][<?= $billingAssignServiceProviderKey ?>][id]" value="<?= $billingAssignServiceProviderVal['id'] ?>">
                                                                        </div>
                                                                        <div class="col-3 pl-1">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn btn-plus btn-sm btn-success" type="button" onclick="addServiceProvider(this)">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                        <input type="hidden" name="duration[]" value="<?= $service_duration ?>" class="duration">
                                                                        <input type="hidden" name="ser_stime[]" value="<?= $billingProductValue->start_timestamp ?>" class="ser_stime">
                                                                        <input type="hidden" name="ser_etime[]" value="<?= $billingProductValue->end_timestamp ?>" class="ser_etime">
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="row" style="width: 200px;">
                                                                    <div class="col-6 pr-1">
                                                                        <input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" name="billing_product[<?= $billingProductKey ?>][start_time]" value="<?= $billingProductValue->start_time; ?>" onchange="changeTimeValue(this)" readonly>
                                                                        <input type="hidden" class='start_timestamp' name='billing_product[<?= $billingProductKey ?>][start_timestamp]' value="<?= $billingProductValue->start_timestamp; ?>">
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                        <input type="text" class="form-control form-control-sm end_time1 w-100" name="billing_product[<?= $billingProductKey ?>][end_time]" value="<?= $billingProductValue->end_time; ?>" placeholder="End Time" readonly>
                                                                        <input type="hidden" class='end_timestamp' name='billing_product[<?= $billingProductKey ?>][end_timestamp]' value="<?= $billingProductValue->end_timestamp; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="number" class="form-control form-control-sm service-price" name="billing_product[<?= $billingProductKey ?>][price]" placeholder="0" value="<?= $billingProductValue->price; ?>" oninput="changeBillingPrice(this)">
                                                                        <input type="hidden" class="old-price" value="<?= $original_price; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                    <?php } ?>

                                                    <tr id="addBefore">
                                                        <td colspan="7" class="text-right">
                                                            <button type="button" id="btnAdd" class="btn btn-success" onclick="addServiceProviderServices()">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> Add Service / Product / Package
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="sub_total_label">Subtotal</td>
                                                        <td>
                                                            <input type="number" class="form-control" id="sum-input" value="<?= $billing->sub_total ?>" name="billing[sub_total]" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" id="tot" colspan="5" class="coupon_code_label">Coupon</td>
                                                        <td colspan="2">
                                                            <input type="text" id="coupon_code" class="form-control" name="billing[coupon_code]" onchange="check_coupon_code(this)" placeholder="Coupon Code" value="<?= $billing->coupon_code ?>">
                                                            <?php
                                                            if (!empty($billing->coupon_code)) {
                                                                $couponModel = fetch_object($db, "SELECT * FROM `coupon` WHERE coupon_code='{$billing->coupon_code}'");
                                                                $coupon_discount = $couponModel->discount;
                                                                $coupon_discount_type = $couponModel->discount_type;
                                                                $coupon_max_dis_amt = $couponModel->max_discount_amount;

                                                                if ($coupon_discount_type == "percentage") {
                                                                    $maxDiscount = (100 - $coupon_discount);
                                                                    $leftPrice = round((($billing->sub_total * $maxDiscount) / 100));
                                                                } else {
                                                                    $leftPrice = round(($billing->sub_total - $coupon_discount));
                                                                }

                                                                $leftPrice = ($leftPrice > $coupon_max_dis_amt) ? $coupon_max_dis_amt : $leftPrice;
                                                                $leftPrice = round(($billing->sub_total - $leftPrice));

                                                                $coupon_discount_amount = $leftPrice;
                                                            } else {
                                                                $coupon_discount = 0;
                                                                $coupon_discount_type = "percentage";
                                                                $coupon_max_dis_amt = 0;
                                                                $coupon_discount_amount = 0;
                                                            }
                                                            ?>
                                                            <input type="hidden" class="coupon-discount" value="<?= $coupon_discount ?>">
                                                            <input type="hidden" class="coupon-discount-type" value="<?= $coupon_discount_type ?>">
                                                            <input type="hidden" class="coupon-max-dis-amt" value="<?= $coupon_max_dis_amt ?>">
                                                            <input type="hidden" class="coupon-discount-amount" value="<?= $coupon_discount_amount ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Discount</td>
                                                        <td width="40%">
                                                            <input type="number" class="form-control total-discount-input" name="billing[discount]" value="<?= $billing->discount ?>" placeholder="Discount Amount" onchange="setDiscount()">
                                                        </td>
                                                        <td width="60%">
                                                            <select class="form-select total-discount-select" name="billing[discount_type]" onchange="setDiscount()">
                                                                <?php
                                                                foreach ($discountArr as $discountArrKey2 => $discountArrVal2) { ?>
                                                                    <option value="<?= $discountArrKey2 ?>" <?= ($billing->discount_type == $discountArrKey2) ? 'selected' : '' ?>><?= $discountArrVal2 ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Taxes</td>
                                                        <td colspan="2">
                                                            <select name="billing[tax]" class="form-select appointment-tax" onchange="appointmentTax()">
                                                                <option value="">Select Taxes</option>

                                                                <?php foreach ($taxTypeArr as $taxTypeKey => $taxTypeValue) { ?>
                                                                    <optgroup label="<?= ucfirst($taxTypeValue) ?> Taxes">
                                                                        <?php

                                                                        $gstModel = fetch_all($db, "SELECT * FROM gst_slab WHERE tax_type='{$taxTypeValue}'");
                                                                        foreach ($gstModel as $gstKey => $gstVal) {
                                                                            $gstValue = (object) $gstVal;
                                                                        ?>
                                                                            <option value="<?= $gstValue->id ?>" data-product-type="<?= $gstValue->product_service_type ?>" data-tax-type="<?= $gstValue->tax_type ?>" data-gst="<?= $gstValue->gst ?>" <?= ($billing->tax == $gstValue->id) ? 'selected' : '' ?>><?= "GST on {$gstValue->product_service_type} ({$gstValue->gst} %)" ?></option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" id="tot" colspan="6">Total</td>
                                                        <td><input type="number" id="total" class="form-control" name="billing[total]" placeholder="Total Amount" value="<?= $billing->total ?>" readonly></td>
                                                        <input type="hidden" id="original_total_charge">
                                                    </tr>

                                                    <tr>
                                                        <td class="referral_code_label" colspan="5">Referral Code (Optional)</td>
                                                        <td colspan="2">
                                                            <input type="text" id="referral_code" class="form-control referral_code" name="billing[referral_code]" onchange="check_referral_code(this)" placeholder="Referral Code">
                                                            <p class="referral_code_message"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="total" id="tot" colspan="6">Give reward point</td>
                                                        <td>
                                                            <div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input mt-1" type="radio" name="billing[give_reward_point]" <?= (empty($billing->give_reward_point) || $billing->give_reward_point == 1) ? 'checked' : '' ?> id="give_reward_point1" value="1">
                                                                    <label class="form-check-label" for="give_reward_point1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input mt-1" type="radio" name="billing[give_reward_point]" <?= ($billing->give_reward_point == '0') ? 'checked' : '' ?> id="give_reward_point2" value="0">
                                                                    <label class="form-check-label" for="give_reward_point2">No</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="advance_receive" id="advance_receive_label" colspan="6">Advance Received</td>
                                                        <td><input type="number" id="advance_receive" class="form-control" name="billing[advance_receive]" placeholder="" value="<?= $billing->advance_receive ?>" readonly></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total" id="tot" colspan="6">Amount Payable</td>
                                                        <td><input type="number" class="form-control" id="payble_amount" value="0" readonly></td>
                                                    </tr>
                                                    <tr id="TextBoxContainerPayment" class="TextBoxContainerPayment">
                                                        <td class="total" colspan="4">Amount Paid <br>
                                                            <span class="text-danger">*Reward Points:- <?= $rewardPointModel->price ?> INR = <?= $rewardPointModel->redeem_point ?> Points</span>
                                                            <input type="hidden" id="price_reward_setting" value="<?= $rewardPointModel->price ?>">
                                                            <input type="hidden" id="redeem_point_reward_setting" value="<?= $rewardPointModel->redeem_point ?>">
                                                            <input type="hidden" id="max_redeem_point_reward_setting" value="<?= $rewardPointModel->max_redeem_point ?>">
                                                        </td>

                                                        <td colspan="3" id="transaction-row">

                                                            <?php
                                                            foreach ($billingPayment as $billingPaymentKey => $billingPaymentVal) {
                                                                $billingPaymentValue = (object) $billingPaymentVal;
                                                            ?>

                                                                <div class="row <?= ($billingPaymentKey != 0) ? 'my-1' : '' ?>">
                                                                    <div class="col-4">
                                                                        <input type="text" name="billing_payment[<?= $billingPaymentKey ?>][transaction_id]" class="key form-control transid" placeholder="TXN ID" value="<?= $billingPaymentValue->transaction_id ?>" onchange="advanceGiven(this)">
                                                                        <input type="hidden" name="billing_payment[<?= $billingPaymentKey ?>][id]" value="<?= $billingPaymentValue->id ?>">
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <input type="number" name="billing_payment[<?= $billingPaymentKey ?>][advance]" class="key form-control adv advance-amount" value="<?= $billingPaymentValue->advance ?>" onchange="advanceGiven(this)" step="0.1">
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <select name="billing_payment[<?= $billingPaymentKey ?>][method]" class="form-select adv-type" onchange="advanceGiven(this)">
                                                                            <?php
                                                                            foreach ($appointmentPaymentModeArr as $appointmentPaymentModeArrKey => $appointmentPaymentModeArrVal) { ?>
                                                                                <option value="<?= $appointmentPaymentModeArrKey ?>" <?= ($billingPaymentValue->method == $appointmentPaymentModeArrKey) ? 'selected' : '' ?>><?= $appointmentPaymentModeArrVal ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-2">

                                                                        <?php if ($billingPaymentKey != 0) { ?>
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
                                                        <td class="total" colspan="6">Amount Due/Credit</td>
                                                        <td>
                                                            <input type="number" class="form-control" name="billing[pending_amount]" id="pending_due" value="<?= $billing->pending_amount ?>" readonly>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="8">
                                                            <textarea name="billing[notes]" class="form-control no-resize" rows="5" placeholder="Write Notes About billing here..." id="textArea"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                        <input type="hidden" id="discount_on_package" value="">
                                        <input type="hidden" id="discount_on_package_type" value="">
                                        <input type="hidden" id="discount_on_product" value="">
                                        <input type="hidden" id="discount_on_product_type" value="">
                                        <input type="hidden" id="discount_on_service" value="">
                                        <input type="hidden" id="discount_on_service_type" value="">
                                        <input type="hidden" id="membership_condition" value="0">
                                        <input type="hidden" id="mem_reward_point" value="0">
                                        <input type="hidden" id="min_bill_amount" value="0" />
                                        <input type="hidden" name="billing[membership_id]" id="membership_id" value="0">


                                        <?php if (USERROLE == 'superadmin') { ?>
                                            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?= $btnText ?></button>

                                            <?php } else {
                                            if (empty($billing->invoice_number)) { ?>
                                                <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?= $btnText ?></button>
                                            <?php } else { ?>
                                                <a href="./invoice.php?inv=<?= $billing->invoice_number ?>" class="btn btn-info text-nowrap m-1"> <i class='fas fa-eye'></i> View Invoice</a>
                                        <?php }
                                        } ?>

                                        <?php if ($btnText == "Create Bill") { ?>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>

    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

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
    <script type="text/javascript" src="./js/pages/billing-bill.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>

<!-- Bill success modal -->
<div class="modal fade" id="bill_options" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabelSchedule1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <form class="table-responsive" id="consumption_form" action="./inc/stock/add-product-consumption.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule1">Bill Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="b_status">
                                <div class="alert alert-success">Bill Created Successfully.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <a id="print_bill" class="btn btn-dark btn-block"> <i class="fa fa-print" aria-hidden="true"></i> Print Bill </a>
                        </div>
                        <div class="col-md-4">
                            <a id="sms_bill" class="btn btn-dark btn-block"> <i class="fa fa-paper-plane" aria-hidden="true"></i> SMS Bill </a>
                        </div>
                        <div class="col-md-4">
                            <a id="email_bill" class="btn btn-dark btn-block"> <i class="fa fa-envelope" aria-hidden="true"></i> Email Bill </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row product-consumption-wrapper">
                        <div class="col-md-12">
                            <div id="product_usage">
                                <h4>Enter Product Usage (Optional)</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Service Name</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Used by</th>
                                        </tr>
                                    </thead>

                                    <tbody id="product_cons_table">


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bill success modal end-->


<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pendingPaymentTitle" aria-hidden="true">
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


<div id="clientPackageModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="clientPackageTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="clientPackageTitle">Available package services</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Service name</th>
                                    <th>Unit</th>
                                    <th>Package name</th>
                                    <th>Purchased on</th>
                                    <th>Expired on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="availablePackage">
                            </tbody>
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