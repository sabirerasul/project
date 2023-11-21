<?php
include('../../lib/db.php');

throw_exception();

$rawData = $_POST;

$errors = [];
$data = [];



function updateProductVendor($db, $value)
{
    $sql = '';

    $id = $value['eid'];
    $vendor_name = $value['vendor_name'];
    $contact = $value['contact'];
    $email = $value['email'];
    $gst_number = $value['gst_number'];
    $address = $value['address'];
    $company_details = $value['company_details'];
    $updatedAt = date('Y-m-d H:i:s', time());

    $sql = "UPDATE `vendor` SET `vendor_name`='" . $vendor_name . "', `contact`='" . $contact . "', `email`='" . $email . "', `gst_number`='" . $gst_number . "', `address`='" . $address . "', `company_details`='" . $company_details . "', `updated_at`='" . $updatedAt . "' WHERE id='" . $id . "'";

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = updateProductVendor($db, $rawData);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
