<?php
include('../../lib/db.php');
throw_exception();


extract($_REQUEST);

$errors = [];
$data = [];

if(!isset($week_day)){
    $errors['error'] = 'Week day is required.';
}

if (empty($week_day)) {
    $errors['error'] = 'Week Day is required.';
}

if (empty($provider_id)) {
    $errors['error'] = 'Provider is required.';
}

function addServiceProviderWeekDay($db, $new_week_day, $provider_id){

    $sql1 = "SELECT day FROM service_provider_off_week_day WHERE `sp_id`='".$provider_id."'";
    $query1 = mysqli_query($db, $sql1);
    
    $oldModel = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    $old_week_day = array_column($oldModel, 'day');

    $delKey = array_diff($old_week_day, $new_week_day);
    $addKey = array_diff($new_week_day, $old_week_day);   

    foreach ($delKey as $key33 => $delKeyValue) {
        $delete_sql = ("DELETE FROM service_provider_off_week_day WHERE day='".$delKeyValue."' AND sp_id='".$provider_id."'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    foreach ($addKey as $key => $value) {

        $mysqltime = date ('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `service_provider_off_week_day` (`sp_id`, `day`, `created_at`) VALUES ('".$provider_id."', '".$value."', '".$mysqltime."')";
        $query = mysqli_query($db, $sql);   
    }

    return true;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['status'] = false;
} else {
    $m = addServiceProviderWeekDay($db, $week_day, $provider_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['status'] = true;
}

echo json_encode($data);

?>