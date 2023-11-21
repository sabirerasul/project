<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$branch_sms_template = $_POST['branch_sms_template'];
$branch_id = BRANCHID;

$errors = [];
$data = [];


function saveBranchSmsTemplate($db, $model, $branch_id)
{
    if (!empty($model)) {
        extract($model);

        $sql = "INSERT INTO `branch_sms_template`(`branch_id`, `template_for`, `message`) VALUES ('{$branch_id}', '{$template_for}', '{$message}')";

        $query = mysqli_query($db, $sql);
        return $query ? true : false;
    } else {
        return true;
    }
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveBranchSmsTemplate($db, $branch_sms_template, $branch_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
