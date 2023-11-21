<?php

function appointmentSMS($db, $appointment_id, $template_id)
{
    //return true;
    //Getting form data
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;


    $appointmentModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$appointment_id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$appointmentModel->client_id}'");

    $name = $clientModel->client_name;
    $number = $clientModel->contact;
    $date = $appointmentModel->appointment_date;
    $time = $appointmentModel->appointment_time;
    $salon_name = SALONNAME;

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$template_id}'");
    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $templateSMS = $templateModel->template;

    $templateSMS = str_replace('{$name}', $name, $templateSMS);
    $templateSMS = str_replace('{$date}', $date, $templateSMS);
    $templateSMS = str_replace('{$time}', $time, $templateSMS);
    $templateSMS = str_replace('{$salon_name}', $salon_name, $templateSMS);

    $message = urlencode($templateSMS);

    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function walletSMS($db, $id, $available, $template_id)
{
    //return true;
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;

    $walletModel = fetch_object($db, "SELECT * FROM client_wallet WHERE id='{$id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$walletModel->client_id}'");

    $name = $clientModel->client_name;
    $number = $clientModel->contact;
    $salon_name = SALONNAME;
    $inr = $walletModel->amount;

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$template_id}'");
    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $templateSMS = $templateModel->template;

    $templateSMS = str_replace('{$name}', $name, $templateSMS);
    $templateSMS = str_replace('{$inr}', $inr, $templateSMS);
    $templateSMS = str_replace('{$available}', $available, $templateSMS);
    $templateSMS = str_replace('{$salon_name}', $salon_name, $templateSMS);

    $message = urlencode($templateSMS);

    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function invoiceSMS($db, $billing_id, $template_id)
{
    //return true;
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;

    $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");
    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$billingModel->client_id}'");


    $invoiceLinkModel = fetch_object($db, "SELECT * FROM `link_shortener` WHERE billing_id='{$billing_id}' AND link_type='invoice'");
    $feedbackLinkModel = fetch_object($db, "SELECT * FROM `link_shortener` WHERE billing_id='{$billing_id}' AND link_type='feedback'");

    $invData = !empty($invoiceLinkModel) ? $invoiceLinkModel->shortener_key : '';
    $feedData = !empty($feedbackLinkModel) ? $feedbackLinkModel->shortener_key : '';

    //$name = $clientModel->client_name;
    $number = $clientModel->contact;
    $date = $billingModel->billing_date;
    //$time = $clientModel->billing_time;
    $salon_name = SALONNAME;
    $inr = $billingModel->total;

    $invlink = "http://pxsf.in/{$invData}";
    $feedlink = "http://pxsf.in/{$feedData}";

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$template_id}'");
    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $templateSMS = $templateModel->template;

    $templateSMS = str_replace('{$inr}', $inr, $templateSMS);
    $templateSMS = str_replace('{$date}', $date, $templateSMS);
    $templateSMS = str_replace('{$invlink}', $invlink, $templateSMS);
    $templateSMS = str_replace('{$feedlink}', $feedlink, $templateSMS);
    $templateSMS = str_replace('{$salon_name}', $salon_name, $templateSMS);

    $message = urlencode($templateSMS);

    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function birthdaySMS($db, $client_id, $template_id)
{
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;
    $salon_name = SALONNAME;

    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$client_id}'");

    $name = $clientModel->client_name;
    $number = $clientModel->contact;

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$template_id}'");

    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $templateSMS = $templateModel->template;

    $templateSMS = str_replace('{$name}', $name, $templateSMS);
    $templateSMS = str_replace('{$salon_name}', $salon_name, $templateSMS);

    $message = urlencode($templateSMS);

    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response ? true : false;
}

function anniversarySMS($db, $client_id, $template_id)
{
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;
    $salon_name = SALONNAME;

    $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$client_id}'");

    $name = $clientModel->client_name;
    $number = $clientModel->contact;

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$template_id}'");

    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $templateSMS = $templateModel->template;

    $templateSMS = str_replace('{$name}', $name, $templateSMS);
    $templateSMS = str_replace('{$salon_name}', $salon_name, $templateSMS);

    $message = urlencode($templateSMS);

    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response ? true : false;
}

function bulkSMS($db, $clients_id, $message_id, $schedule)
{
    //return true;
    $username = SMSUSERNAME;
    $password = SMSPASSWORD;
    $sender = SMSSENDERID;
    $link = SMSURL;

    $smsModel = fetch_object($db, "SELECT * FROM `branch_sms_message` WHERE id='{$message_id}'");

    $clientModel = fetch_all($db, "SELECT `contact` FROM client WHERE id IN ({$clients_id})");
    $clientNumber = array_column($clientModel, 'contact');

    $number = implode(',', $clientNumber);

    $templateModel = fetch_object($db, "SELECT * FROM `branch_sms_template` WHERE id='{$smsModel->template_id}'");
    $channel = $templateModel->channel;
    $DCS = $templateModel->dcs;
    $flashsms = $templateModel->flash_sms;
    $route = $templateModel->route;
    $Peid = $templateModel->peid;
    $DLTTemplateId = $templateModel->dlt_template_id;

    $message = urlencode($smsModel->message);

    $schedules = !empty($schedule) ? "&schedtime{$schedule}" : '';
    $var = "?user={$username}&password={$password}&senderid={$sender}&channel={$channel}&DCS={$DCS}&flashsms={$flashsms}&number={$number}&text={$message}{$schedules}&route={$route}&Peid={$Peid}&DLTTemplateId={$DLTTemplateId}";

    $url = $link . $var;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response ? true : false;
}



/*
sender id
PICSAL
BOOKPX
PIXSAL
*/




/*
http://bulksms.anksms.com/api/mt/SendSMS?user=zeeshan&password=123456&senderid=PIXSAL&channel=Trans&DCS=0&flashsms=0&number=9125149648,9453179080&text=Thank You  Sabire Rasul. Your Appointment is booked for 14-03-2023 06:00 PM. From xyz.BOOKPX&schedtime=2023/03/14 16:59:59 PM&route=1&Peid=1201162462661800644&DLTTemplateId=1207167168997235967

*/