<?php
include('../../lib/db.php');
include('../../lib/sms-config.php');
include('../../lib/whatsapp-sms-config.php');
include('../../lib/mail-config.php');

throw_exception();

//$v = $_REQUEST;
$client = $_POST['client'];
$billing = $_POST['billing'];
$billing['branch_id'] = $client['branch_id'];
$billing_product = $_POST['billing_product'];
$billing_payment = $_POST['billing_payment'];

$errors = [];
$data = [];
/*
if (empty($_REQUEST['product'])) {
    $errors['error'] = 'product is required.';
}

if (empty($_REQUEST['volume'])) {
    $errors['error'] = 'Volume is required.';
}

if (empty($_REQUEST['unit'])) {
    $errors['error'] = 'Unit is required.';
}

if (empty($_REQUEST['price'])) {
    $errors['error'] = 'Price is required.';
}

if (empty($_REQUEST['exp_date'])) {
    $errors['error'] = 'Expiry Date is required.';
}*/

function addClient($db, $client)
{

    $k = "`branch_id`, `client_name`,`contact`,`gender`,`dob`,`anniversary`,`source_of_client`";
    $val = "'{$client['branch_id']}', '" . $client['client_name'] . "', '" . $client['contact'] . "', '" . $client['gender'] . "', '" . $client['dob'] . "', '" . $client['anniversary'] . "', '" . $client['source_of_client'] . "'";

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `client` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function addBilling($db, $billing)
{
    $k = '';
    $val = '';
    foreach ($billing as $key => $value) {
        if ($key != 'id') {
            $k .=  "`{$key}`,";
            $val .=  "'{$value}',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $invoice_number = get_invoice_number();

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`, `invoice_number`";
    $val = $val . ", '{$mysqltime}', '{$invoice_number}'";

    /*add_wallet($db, 'Add_billing', $billing);*/

    $sql = "INSERT INTO `client_billing` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    if (!empty($billing['appointment_id'])) {
        $appointment_id = $billing['appointment_id'];
        mysqli_query($db, "UPDATE appointment SET status='Billed' WHERE id='{$appointment_id}'");
    }

    //$domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://localhost/sabir/pixelsalonsoftware/";

    $domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $domain .= "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

    //inc/billing/billing-add.php
    $domain = str_replace("inc/billing/billing-add.php", "", $domain);

    saveShortenerLink($db, $domain, $last_id, $invoice_number, 'invoice');
    saveShortenerLink($db, $domain, $last_id, $invoice_number, 'feedback');

    if (!empty($billing['referral_code'])) {
        add_client_referral($db, $last_id);
    }
    if (!empty($billing['coupon_code'])) {
        add_coupon_code($db, $last_id);
    }

    return $last_id;
}

function addBillingProduct($db, $billing_product, $billing_id)
{
    $sql = '';
    foreach ($billing_product as $key => $value) {

        $service_cat_id = !empty($value['service_cat_id']) ? $value['service_cat_id'] : 0;
        $service_id = $value['service_id'];
        $service_type = $value['service_type'];
        $quantity = $value['quantity'];
        $service_discount = $value['service_discount'];
        $service_discount_type = $value['service_discount_type'];
        $sp_id = $value['sp_id'];
        $start_time = $value['start_time'];
        $end_time = $value['end_time'];

        $start_timestamp = $value['start_timestamp'];
        $end_timestamp = $value['end_timestamp'];

        $price = $value['price'];
        $sql = "INSERT INTO `client_billing_product`(`billing_id`, `service_cat_id`, `service_id`, `service_type`, `quantity`, `service_discount`, `service_discount_type`, `start_time`, `end_time`, `start_timestamp`, `end_timestamp`, `price`) VALUES ('{$billing_id}', '{$service_cat_id}', '{$service_id}', '{$service_type}', '{$quantity}', '{$service_discount}', '{$service_discount_type}', '{$start_time}', '{$end_time}', '{$start_timestamp}', '{$end_timestamp}', '{$price}')";

        $query = mysqli_query($db, $sql);
        $billing_service_id = mysqli_insert_id($db);

        $created_at = date('Y-m-d H:i:s', time());

        $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");



        $pac_package_id = $value['package_id'];
        $pac_client_package_id = $value['client_package_id'];
        $pac_package_details_id = $value['package_details_id'];
        $pac_client_package_quantity = $value['client_package_quantity'];

        $use_on = date("d-m-Y");

        if ($pac_package_id != 0) {

            $pakSqlKey = "`package_details_id`, `client_package_id`, `client_id`, `branch_id`, `billing_id`, `service_id`, `quantity`, `use_on`, `created_at`";
            $pakSqlValue = "'{$pac_package_details_id}', '{$pac_client_package_id}', '{$billingModel->client_id}', '{$billingModel->branch_id}', '{$billingModel->id}', '{$service_id}', '{$pac_client_package_quantity}', '{$use_on}', '{$created_at}'";
            $pakSql = "INSERT INTO `client_package_details_usage` ({$pakSqlKey}) VALUES ({$pakSqlValue})";
            mysqli_query($db, $pakSql);
        }


        if ($service_type == 'membership') {
            $model = fetch_object($db, "SELECT * FROM `membership` WHERE id='{$service_id}'");

            $dayString = "{$model->validity} day";
            $dateModel = new DateTime(date('Y-m-d'));
            $dateModel->modify($dayString);

            $vaid_upto =  $dateModel->format("d-m-Y");

            $query1 = "INSERT INTO `client_membership`(`client_id`, `membership_id`, `billing_id`, `valid_upto`, `created_at`) VALUES ('{$billingModel->client_id}','{$service_id}','{$billing_id}','{$vaid_upto}','{$created_at}')";
            mysqli_query($db, $query1);
        }

        if ($service_type == 'package') {
            $model = fetch_object($db, "SELECT * FROM `package` WHERE id='{$service_id}'");

            $dayString = "{$model->duration} day";
            $dateModel = new DateTime(date('Y-m-d'));
            $dateModel->modify($dayString);

            $vaid_upto =  $dateModel->format("d-m-Y");

            $query1 = "INSERT INTO `client_package`(`client_id`, `package_id`, `billing_id`, `valid_upto`, `created_at`) VALUES ('{$billingModel->client_id}','{$service_id}','{$billing_id}','{$vaid_upto}','{$created_at}')";
            $clientQuery = mysqli_query($db, $query1);
            $client_package_id = mysqli_insert_id($db);

            $packageServiceModel = fetch_all($db, "SELECT * FROM `package_service` WHERE `package_id`='{$model->id}'");

            foreach ($packageServiceModel as $packageServiceKey => $packageServiceVal) {
                $packageServiceValue = (object) $packageServiceVal;

                $key22 = "`client_id`, `client_package_id`, `service_id`, `quantity`, `price`, `created_at`";
                $value22 = "'{$billingModel->client_id}', '{$client_package_id}', '{$packageServiceValue->service_id}', '{$packageServiceValue->quantity}', '{$packageServiceValue->price}', '{$created_at}'";
                $sql22 = "INSERT INTO `client_package_details` ({$key22}) VALUES ({$value22})";
                mysqli_query($db, $sql22);
            }
        }

        if ($service_type == 'stock') {
            $quer61 = mysqli_query($db, "INSERT INTO `stock_record`(`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `debit`, `created_at`) VALUES ('{$billingModel->branch_id}', '{$service_id}', '{$billingModel->client_id}', 'Bill', '{$billingModel->invoice_number}', '{$quantity}', '{$created_at}')");
            $stock_record_id = mysqli_insert_id($db);
        }

        foreach ($sp_id as $spkey => $sp_id_value) {
            $serviceProviderId = $sp_id_value['service_provider_id'];

            if (empty($serviceProviderId)) {
                continue;
            }

            $sql2 = "INSERT INTO `client_billing_assign_service_provider`(`billing_id`, `billing_service_id`, `service_provider_id`) VALUES ('{$billing_id}','{$billing_service_id}','{$sp_id_value['service_provider_id']}')";
            //$sql2 = "INSERT INTO `appointment_assign_service_provider`(`appointment_id`, `appointment_service_id`, `service_provider_id`) VALUES ('{$appointment_id}','{$appointment_service_id}','{$sp_id_value}')";
            $query2 = mysqli_query($db, $sql2);
        }
    }

    return true;
}

function addBillingPayment($db, $billing_payment, $billing_id)
{
    $sql = '';
    foreach ($billing_payment as $key => $value) {
        $transaction_id = $value['transaction_id'];
        $advance = $value['advance'];
        $method = $value['method'];

        $sql .= "('" . $billing_id . "', '" . $transaction_id . "', '" . $advance . "', '" . $method . "'), ";

        if ($method == 7) {
            client_wallet_debit($db, $value, $billing_id, 'bill');
        }

        if ($method == 9) {
            subtractRewardPoint($db, $advance, $billing_id, 'bill');
        }
    }

    $sql = rtrim($sql, ', ');

    $sq = "INSERT INTO `client_billing_payment`(`billing_id`, `transaction_id`, `advance`, `method`) VALUES ";

    $sql = $sq . $sql;

    $query = mysqli_query($db, $sql);
    return $query ? true : false;
}


function addPaymentHistory($db, $billing_id)
{
    $created_at = date('Y-m-d H:i:s', time());

    $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");

    $appointmentModel = fetch_all($db, "SELECT * FROM appointment WHERE id='{$model->appointment_id}'");

    $paid = (($model->total - $model->advance_receive) - $model->pending_amount);

    if (!empty($appointmentModel)) {
        $sql = "UPDATE `pending_payment_history` SET `date`='{$model->billing_date}', `app_bill_id`='{$model->id}', `total`='{$model->total}', `advance`='{$model->advance_receive}', `paid`='{$paid}', `pending`='{$model->pending_amount}', `appointment_id`='{$model->appointment_id}', `bill_type`='bill', `paid_branch_id`='{$model->branch_id}', `updated_at`='{$created_at}' WHERE `app_bill_id`='{$model->appointment_id}'";
    } else {
        $sql = "INSERT INTO `pending_payment_history`(`date`, `branch_id`, `client_id`, `app_bill_id`, `total`, `advance`, `paid`, `pending`, `appointment_id`, `bill_type`, `paid_branch_id`, `created_at`) VALUES ('{$model->billing_date}', '{$model->branch_id}', '{$model->client_id}', '{$model->id}', '{$model->total}', '{$model->advance_receive}', '{$paid}', '{$model->pending_amount}', '{$model->appointment_id}', 'bill', '{$model->branch_id}', '{$created_at}')";
    }
    mysqli_query($db, $sql);
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($billing['client_id'])) {
        $client_id = addClient($db, $client);
        $billing['client_id'] = $client_id;
    }
    $billing_id = addBilling($db, $billing);
    $m2 = addBillingProduct($db, $billing_product, $billing_id);

    $m = addBillingPayment($db, $billing_payment, $billing_id);
    $invoice_number = !empty($billing_id) ? fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'")->invoice_number : '0';
    addPaymentHistory($db, $billing_id);
    $cd = addRewardPoint($db, $billing_id);
    addServiceProductPackageCommission($db, $billing_id);
    invoiceSMS($db, $billing_id, 5);
    invoiceWASMS($db, $billing_id);
    invoiceMail($db, $billing_id, $discountArr);

    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['data'] = $invoice_number;
}

echo json_encode($data);
