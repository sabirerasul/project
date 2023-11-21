<?php
include('../lib/db.php');
include('../lib/sms-config.php');


$model = fetch_object($db, "SELECT * FROM `branch_automatic_reminder`");

if ($model->birthday == 1) {
    $url = "https://pixelsalon.pxlsoftware.com/cron/birthday.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($model->anniversary == 1) {
    $url = "https://pixelsalon.pxlsoftware.com/cron/anniversary.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($model->appointment == 1) {
    $url = "https://pixelsalon.pxlsoftware.com/cron/appointment-reminder.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($model->package_expiry == 1) {
    $url = "https://pixelsalon.pxlsoftware.com/cron/package-expiry.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($model->membership_expiry == 1) {
    $url = "https://pixelsalon.pxlsoftware.com/cron/membership-expiry.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}
