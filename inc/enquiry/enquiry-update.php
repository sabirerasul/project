<?php
include('../../lib/db.php');
throw_exception();


$enquiry = $_REQUEST;

$id = $enquiry['id'];

if (empty($id)) {
    header("location: ../../enquiry.php");
}

$errors = [];
$data = [];

/*
if (empty($_REQUEST['client_name'])) {
    $errors['error'] = 'Name is required.';
}else{
    if(validName($_REQUEST['client_name']) == false){
        $errors['error'] = 'Name is not valid.';
    }
}

if (empty($_REQUEST['contact'])) {
    $errors['error'] = 'Mobile is required.';
}else{
    if(validNumber($_REQUEST['contact']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        if($model->contact != $_REQUEST['contact']){
            $sql = mysqli_query($db, "SELECT contact FROM client WHERE contact='".$_REQUEST['contact']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Number is already registered.';
            }
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{

        if($model->email != $_REQUEST['email']){
            $sql = mysqli_query($db, "SELECT email FROM client WHERE email='".$_REQUEST['email']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Email is already registered.';
            }
        }
    }
}

if (empty($_REQUEST['gender'])) {
    $errors['error'] = 'Gender cannot be blank';
}
*/


function addClient($db, $client)
{

    $created_at = date('Y-m-d H:i:s', time());

    $sql = "INSERT INTO `client` (`branch_id`, `client_name`,`contact`,`email`,`address`,`source_of_client`,`created_at`) VALUES ('{$client['branch_id']}', '{$client['client_name']}', '{$client['contact']}', '{$client['email']}', '{$client['address']}', '{$client['source_of_enquiry']}', '{$created_at}')";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}


function updateEnquiry($db, $enquiry)
{

    $updated_at = date('Y-m-d H:i:s', time());

    $date = date('d/m/Y', time());

    $update_time = date('h:i A', time());


    $sql = "UPDATE `enquiry` SET `client_id`='{$enquiry['client_id']}',`contact`='{$enquiry['contact']}',`client_name`='{$enquiry['client_name']}',`email`='{$enquiry['email']}',`address`='{$enquiry['address']}',`enquiry_for`='{$enquiry['enquiry_for']}',`enquiry_type`='{$enquiry['enquiry_type']}',`response`='{$enquiry['response']}',`followdate`='{$enquiry['followdate']}',`source_of_enquiry`='{$enquiry['source_of_enquiry']}',`leaduser`='{$enquiry['leaduser']}',`status`='{$enquiry['status']}',`updated_at`='{$updated_at}' WHERE `id`='{$enquiry['id']}'";

    $query = mysqli_query($db, $sql);

    $last_id = $enquiry['id'];

    $historySql = "INSERT INTO `enquiry_history` (`enquiry_id`, `date`, `response`, `update_time`, `enquiry_type`, `status`, `leaduser`, `created_at`) VALUES ('{$last_id}', '{$date}', '{$enquiry['response']}', '{$update_time}', '{$enquiry['enquiry_type']}', '{$enquiry['status']}', '{$enquiry['leaduser']}', '{$updated_at}')";
    $query1 = mysqli_query($db, $historySql);



    $model = fetch_object($db, "SELECT * FROM enquiry WHERE id='{$last_id}'");
    $status = ($query) ? true : false;

    $arr = [
        'status' => $status,
        'model' => $model
    ];

    return $arr;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($enquiry['client_id'])) {
        $client = $enquiry;
        $client_id = addClient($db, $client);
        $enquiry['client_id'] = $client_id;
    }

    $m = updateEnquiry($db, $enquiry);
    $errors['error'] = 'Enquiry updated successfully';
    $data['errors'] = $errors;
    $data['success'] = $m['status'];
    $data['message'] = 'Success!';
    $data['data'] = $m['model'];

}

echo json_encode($data);
