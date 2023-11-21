<?php
include('../../lib/db.php');
throw_exception();

$enquiry = $_REQUEST;

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
        $sql = mysqli_query($db, "SELECT contact FROM client WHERE contact='".$_REQUEST['contact']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Number is already registered.';
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT email FROM client WHERE email='".$_REQUEST['email']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Email is already registered.';
        }
    }
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


function addEnquiry($db, $enquiry)
{

    $created_at = date('Y-m-d H:i:s', time());

    $date = date('d/m/Y', time());

    $update_time = date('h:i A', time());

    $sql = "INSERT INTO `enquiry` (`branch_id`, `client_id`, `client_name`, `contact`, `email`, `address`, `enquiry_for`, `enquiry_table_type`, `enquiry_type`, `response`, `followdate`, `source_of_enquiry`, `leaduser`, `status`, `created_at`) VALUES ('{$enquiry['branch_id']}', '{$enquiry['client_id']}', '{$enquiry['client_name']}', '{$enquiry['contact']}', '{$enquiry['email']}', '{$enquiry['address']}', '{$enquiry['enquiry_for']}', '{$enquiry['enquiry_table_type']}', '{$enquiry['enquiry_type']}', '{$enquiry['response']}', '{$enquiry['followdate']}', '{$enquiry['source_of_enquiry']}', '{$enquiry['leaduser']}', '{$enquiry['status']}', '{$created_at}')";

    $query = mysqli_query($db, $sql);

    $last_id = mysqli_insert_id($db);


    $historySql = "INSERT INTO `enquiry_history` (`enquiry_id`, `date`, `response`, `update_time`, `enquiry_type`, `status`, `leaduser`, `created_at`) VALUES ('{$last_id}', '{$date}', '{$enquiry['response']}', '{$update_time}', '{$enquiry['enquiry_type']}', '{$enquiry['status']}', '{$enquiry['leaduser']}', '{$created_at}')";
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

    $m = addEnquiry($db, $enquiry);
    $data['success'] = $m['status'];
    $data['message'] = 'Success!';
    $data['data'] = $m['model'];
}

echo json_encode($data);
