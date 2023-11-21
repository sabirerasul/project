<?php
include('../../lib/db.php');

throw_exception();


$rawData = $_POST;

$errors = [];
$data = [];



function addProductVendor($db, $value)
{
    $sql = '';
    $vendor_name = $value['vendor_name'];
    $contact = $value['contact'];
    $email = $value['email'];
    $gst_number = $value['gst_number'];
    $address = $value['address'];
    $company_details = $value['company_details'];
    $createdAt = date('Y-m-d H:i:s', time());
    $branch_id = BRANCHID;

    $sql = "INSERT INTO `vendor`(`branch_id`, `vendor_name`, `contact`, `email`, `address`, `gst_number`, `company_details`, `created_at`) VALUES ('{$branch_id}', '{$vendor_name}', '{$contact}', '{$email}', '{$address}', '{$gst_number}', '{$company_details}', '{$createdAt}')";

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = addProductVendor($db, $rawData);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
