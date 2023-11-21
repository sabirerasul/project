<?php
include('../../lib/db.php');

$service = $_REQUEST;

$errors = [];
$data = [];

function addSessionService($db, $service)
{
    extract($service);


    $oldArray = !empty($_SESSION['appointment']) ? explode(',', $_SESSION['appointment']) : [];

    if ($type == 'add') {
        $oldArray[] = $id;
        $string = implode(',', $oldArray);
        $_SESSION['appointment'] = $string;
    } else {

        if (($key = array_search($id, $oldArray)) !== false) {
            unset($oldArray[$key]);
        }

        $string1 = implode(',', $oldArray);
        $_SESSION['appointment'] = $string1;
    }

    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = addSessionService($db, $service);
    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['data'] = '';
}

echo json_encode($data);
