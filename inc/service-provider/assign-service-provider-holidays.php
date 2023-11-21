<?php
include('../../lib/db.php');
throw_exception();


extract($_REQUEST);

$errors = [];
$data = [];

if (empty($startDate)) {
    $errors['error'] = 'startdate is required.';
}

if (empty($endDate)) {
    $errors['error'] = 'enddate is required.';
}

if (empty($provider_id)) {
    $errors['error'] = 'Provider is required.';
}

function addServiceProviderHolidays($db, $startDate, $endDate, $provider_id){

    $dateArr = [];
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($endDate);
    $realEnd->add($interval);

    $format = 'd-m-Y';

    $period = new DatePeriod(new DateTime($startDate), $interval, $realEnd);

    foreach($period as $date) { 
        $dateArr[] = $date->format($format); 
    }

    foreach ($dateArr as $key => $value) {

        $sql1 = "SELECT * FROM service_provider_holiday WHERE `sp_id`='".$provider_id."' AND date='".$value."'";
        $query1 = mysqli_query($db, $sql1);

        if(mysqli_num_rows($query1) == 0){
            $mysqltime = date ('Y-m-d H:i:s', time());
            $sql = "INSERT INTO `service_provider_holiday` (`sp_id`, `date`, `created_at`) VALUES ('".$provider_id."', '".$value."', '".$mysqltime."')";
            $query = mysqli_query($db, $sql);   
        }

    }

    return true;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['status'] = false;
} else {

    $m = addServiceProviderHolidays($db, $startDate, $endDate, $provider_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['status'] = true;
}

echo json_encode($data);

?>