<?php
require_once("mail/index.php");
require_once("mail-body.php");

function appointmentMail($db, $appointment_id)
{
    //return true;
    $appointmentModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$appointment_id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$appointmentModel->client_id}'");
    if (!empty($clientModel->email)) {
        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$appointmentModel->branch_id}'");
        $salon_name = SALONNAME;

        $cid = explode('.', $branchModel->logo)[0];
        $cid = str_replace(' ', '-', $cid);

        $embed_img_array = [
            'filename' => $branchModel->logo,
            'cid' => $cid,
            'name' => $branchModel->logo
        ];


        $body = appointmentBody($appointmentModel, $clientModel, $branchModel, $embed_img_array);
        $subject  = "Appointment confirmation [{$salon_name}]";

        sendSMTPMail($clientModel->email, $salon_name, $body, $subject, $embed_img_array);
    }

    return true;
}

function invoiceMail($db, $billing_id, $discountArr)
{
    //return true;
    $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$billingModel->client_id}'");
    if (!empty($clientModel->email)) {

        $invoiceLinkModel = fetch_object($db, "SELECT * FROM `link_shortener` WHERE billing_id='{$billing_id}' AND link_type='invoice'");
        $feedbackLinkModel = fetch_object($db, "SELECT * FROM `link_shortener` WHERE billing_id='{$billing_id}' AND link_type='feedback'");

        $invData = !empty($invoiceLinkModel) ? $invoiceLinkModel->shortener_key : '';
        $feedData = !empty($feedbackLinkModel) ? $feedbackLinkModel->shortener_key : '';

        $invlink = "http://pxsf.in/{$invData}";
        $feedlink = "http://pxsf.in/{$feedData}";

        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
        $salon_name = SALONNAME;
        $cid = explode('.', $branchModel->logo)[0];
        $cid = str_replace(' ', '-', $cid);

        $embed_img_array = [
            'filename' => $branchModel->logo,
            'cid' => $cid,
            'name' => $branchModel->logo
        ];

        $body = billingBody($db, $billingModel, $clientModel, $branchModel, $invlink, $feedlink, $discountArr, $embed_img_array);
        $subject  = "Invoice [{$salon_name}]";
        sendSMTPMail($clientModel->email, $salon_name, $body, $subject, $embed_img_array);
    }

    return true;
}


function walletMail($db, $id, $available)
{
    //return true;
    $walletModel = fetch_object($db, "SELECT * FROM client_wallet WHERE id='{$id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$walletModel->client_id}'");
    if (!empty($clientModel->email)) {


        $credit = $walletModel->amount;

        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$walletModel->branch_id}'");
        $salon_name = SALONNAME;

        $cid = explode('.', $branchModel->logo)[0];
        $cid = str_replace(' ', '-', $cid);

        $embed_img_array = [
            'filename' => $branchModel->logo,
            'cid' => $cid,
            'name' => $branchModel->logo
        ];

        $body = walletBody($credit, $available, $clientModel, $branchModel, $embed_img_array);
        $subject  = "Wallet [{$salon_name}]";
        sendSMTPMail($clientModel->email, $salon_name, $body, $subject, $embed_img_array);
    }

    return true;
}


function pendingDueMail($db, $id, $available)
{
    //return true;
    $pendingPaymentModel = fetch_object($db, "SELECT * FROM pending_payment_history WHERE id='{$id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$pendingPaymentModel->client_id}'");
    if (!empty($clientModel->email)) {
        $paid = $pendingPaymentModel->paid;
        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$pendingPaymentModel->branch_id}'");
        $salon_name = SALONNAME;

        $cid = explode('.', $branchModel->logo)[0];
        $cid = str_replace(' ', '-', $cid);

        $embed_img_array = [
            'filename' => $branchModel->logo,
            'cid' => $cid,
            'name' => $branchModel->logo
        ];

        $body = pendingDueBody($paid, $available, $clientModel, $branchModel, $embed_img_array);
        $subject  = "Pending Payment [{$salon_name}]";
        sendSMTPMail($clientModel->email, $salon_name, $body, $subject, $embed_img_array);
    }

    return true;
}


function daySummaryReportMail($db)
{
    $todayDate = todayDate();
    $start_date = getDateServerFormat($todayDate);
    $end_date = getDateServerFormat($todayDate);

    $walletModel = fetch_object($db, "SELECT sum(amount) as amount FROM `client_wallet` WHERE amount_receive_from='Add_wallet' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
    $pendingPaymentModel = fetch_object($db, "SELECT sum(paid) as paid FROM `pending_payment_history` WHERE bill_type='pending payment' AND `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
    $commissionModel = fetch_object($db, "SELECT sum(commission) as commission FROM `service_provider_commission_history` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
    $expenseModel = fetch_object($db, "SELECT sum(amount_paid) as amount_paid FROM `expense` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");

    $sql = "SELECT * FROM client_billing";
    $model = fetch_all($db, $sql);

    $totalInvoiceAmount = [0];
    $pendingPaymentClient = [0];
    $totalCollection = 0;
    $productSale = [0];
    $serviceSale = [0];
    $pendingPaymentReceived = !empty($pendingPaymentModel->paid) ? $pendingPaymentModel->paid : 0;
    $appointmentAdvance = [0];
    $walletRecharge = !empty($walletModel->amount) ? $walletModel->amount : 0;
    $cash = [0];
    $onlinePayment = [0];
    $creditDebitCard = [0];
    $cheque = [0];
    $wallet = [0];
    $paytm = [0];
    $gPay = [0];
    $phonePe = [0];
    $rewardPoint = [0];
    $totalDiscountGiven = 0;
    $inclusiveTax = [0];
    $exclusiveTax = [0];
    $totalCommisionsPayable = !empty($commissionModel->commission) ? $commissionModel->commission : 0;
    $todayClient = 0;
    $todayNewClients = num_rows($db, "SELECT id FROM `client` WHERE `created_at` BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59'");
    $expensesToday = !empty($expenseModel->amount_paid) ? $expenseModel->amount_paid : 0;
    $count = 0;

    $branchid = 0;
    foreach ($model as $key => $val) {

        $modelValue = (object) $val;
        $branchid = $modelValue->branch_id;

        if (!empty($start_date) && !empty($end_date)) {

            $dbDate = getDateServerFormat($modelValue->billing_date);

            if ($start_date > $dbDate || $end_date < $dbDate) {
                continue;
            }
        }

        $count++;

        $serviceSale[] = get_billing_product_amount($db, $modelValue->id, 'service');
        $productSale[] = get_billing_product_amount($db, $modelValue->id, 'stock');
        $packageAmount[] = get_billing_product_amount($db, $modelValue->id, 'package');
        $membershipAmount[] = get_billing_product_amount($db, $modelValue->id, 'membership');

        $totalInvoiceAmount[] = $modelValue->total;
        $pendingPaymentClient[] = $modelValue->pending_amount;
        $appointmentAdvance[] = $modelValue->advance_receive;



        $cash[] = getTotalPaymentMode($db, $modelValue->id, 1);
        $creditDebitCard[] = getTotalPaymentMode($db, $modelValue->id, 3);
        $cheque[] = getTotalPaymentMode($db, $modelValue->id, 4);
        $onlinePayment[] = getTotalPaymentMode($db, $modelValue->id, 5);
        $paytm[] = getTotalPaymentMode($db, $modelValue->id, 6);
        $wallet[] = getTotalPaymentMode($db, $modelValue->id, 7);
        $rewardPoint[] = getTotalPaymentMode($db, $modelValue->id, 9);
        $phonePe[] = getTotalPaymentMode($db, $modelValue->id, 10);
        $gPay[] = getTotalPaymentMode($db, $modelValue->id, 11);

        $taxValue = get_tax_value($db, $modelValue->tax, $modelValue->sub_total);

        $inclusiveTax[] = $taxValue['inclusive'];
        $exclusiveTax[] = $taxValue['exclusive'];
    }

    $serviceSale = array_sum($serviceSale);
    $productSale = array_sum($productSale);
    $totalInvoiceAmount = array_sum($totalInvoiceAmount);
    $pendingPaymentClient = array_sum($pendingPaymentClient);
    $totalCollection = $totalInvoiceAmount - $pendingPaymentClient;
    $appointmentAdvance = array_sum($appointmentAdvance);

    $inclusiveTax = array_sum($inclusiveTax);
    $exclusiveTax = array_sum($exclusiveTax);

    $cash = array_sum($cash);
    $onlinePayment = array_sum($onlinePayment);
    $creditDebitCard = array_sum($creditDebitCard);
    $cheque = array_sum($cheque);
    $wallet = array_sum($wallet);
    $paytm = array_sum($paytm);
    $gPay = array_sum($gPay);
    $phonePe = array_sum($phonePe);
    $rewardPoint = array_sum($rewardPoint);
    $todayClient = $count;


    $summary_array = [
        'totalInvoiceAmount' => $totalInvoiceAmount,
        'pendingPaymentClient' => $pendingPaymentClient,
        'totalCollection' => $totalCollection,
        'productSale' => $productSale,
        'serviceSale' => $serviceSale,
        'pendingPaymentReceived' => $pendingPaymentReceived,
        'appointmentAdvance' => $appointmentAdvance,
        'walletRecharge' => $walletRecharge,
        'cash' => $cash,
        'onlinePayment' => $onlinePayment,
        'creditDebitCard' => $creditDebitCard,
        'cheque' => $cheque,
        'wallet' => $wallet,
        'paytm' => $paytm,
        'gPay' => $gPay,
        'phonePe' => $phonePe,
        'rewardPoint' => $rewardPoint,
        'totalDiscountGiven' => $totalDiscountGiven,
        'inclusiveTax' => $inclusiveTax,
        'exclusiveTax' => $exclusiveTax,
        'totalCommisionsPayable' => $totalCommisionsPayable,
        'todayClient' => $todayClient,
        'todayNewClients' => $todayNewClients,
        'expensesToday' => $expensesToday,
    ];

    $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$branchid}'");
    $salon_name = $branchModel->salon_name;
    $email = $branchModel->email;

    $cid = explode('.', $branchModel->logo)[0];
    $cid = str_replace(' ', '-', $cid);

    $embed_img_array = [
        'filename' => $branchModel->logo,
        'cid' => $cid,
        'name' => $branchModel->logo
    ];

    $body = daySummaryReportBody($todayDate, $branchModel, $embed_img_array, $summary_array);
    $subject  = "Daily summary report for {$todayDate} [{$salon_name}]";
    sendSMTPMail($email, $salon_name, $body, $subject, $embed_img_array);
    return true;
}
