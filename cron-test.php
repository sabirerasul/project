<?php

$url = "https://pixelsalon.pxlsoftware.com/cron/day-summary-report.php";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    
    var_dump($response);

?>