<?php
include('../../lib/db.php');

throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

$em_photo = '';
$em_frontproof = '';
$em_backproof = '';

$id = $_REQUEST['eid'];

if(empty($id)){
    header("location: ../../staff.php");
}

$modelSql = mysqli_query($db, "SELECT * FROM employee WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);

if (empty($_REQUEST['name'])) {
    $errors['error'] = 'Name is required.';
}else{
    if(validName($_REQUEST['name']) == false){
        $errors['error'] = 'Name is not valid.';
    }
}

if (empty($_REQUEST['contact_number'])) {
    $errors['error'] = 'Mobile is required.';
}else{
    if(validNumber($_REQUEST['contact_number']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        if($model->contact_number != $_REQUEST['contact_number']){
            $sql = mysqli_query($db, "SELECT contact_number FROM employee WHERE contact_number='".$_REQUEST['contact_number']."'");
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
            $sql = mysqli_query($db, "SELECT email FROM employee WHERE email='".$_REQUEST['email']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Email is already registered.';
            }
        }
    }
}

if (empty($_REQUEST['working_hours_start'])) {
    $errors['error'] = 'working time start is required.';
}

if (empty($_REQUEST['working_hours_end'])) {
    $errors['error'] = 'working time end is required.';
}

if (empty($_REQUEST['salary'])) {
    $errors['error'] = 'salary is required.';
}




if (!empty($_REQUEST['emer_contact_number'])) {
    if(validNumber($_REQUEST['emer_contact_number']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        if($model->emer_contact_number != $_REQUEST['emer_contact_number']){
            $sql = mysqli_query($db, "SELECT emer_contact_number FROM employee WHERE emer_contact_number='".$_REQUEST['emer_contact_number']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Number is already registered.';
            }
        }
    }
}


if (!empty($_REQUEST['emer_contact_person'])) {
    if(validName($_REQUEST['emer_contact_person']) == false){
        $errors['error'] = 'Emer. Contact Person Name is not valid.';
    }
}

if (empty($_REQUEST['gender'])) {
    $errors['error'] = 'gender is required.';
}

if (empty($_REQUEST['date_of_joining'])) {
    $errors['error'] = 'date of joining is required.';
}

if (empty($_REQUEST['user_type'])) {
    $errors['error'] = 'user type is required.';
}

if (empty($_REQUEST['department'])) {
    $errors['error'] = 'department type is required.';
}


$photo = isset($_FILES['photo']) ? $_FILES['photo'] : '';
$frontproof = isset($_FILES['frontproof']) ? $_FILES['frontproof'] : '';
$backproof = isset($_FILES['backproof']) ? $_FILES['backproof'] : '';

$em_photo = $model->photo;
$em_frontproof = $model->frontproof;
$em_backproof = $model->backproof;


if (!empty($photo)) {
    $e1 = imageUpload($photo);
    if($e1['success'] === false){
        $errors['error'] = $e1['error'];
    }else{
        $em_photo = $e1['filename'];
    }
}

if (!empty($frontproof)) {
    $e2 = imageUpload($frontproof);
    if($e2['success'] === false){
        $errors['error'] = $e2['error'];
    }else{
        $em_frontproof = $e2['filename'];
    }
}

if (!empty($backproof)) {
    $e3 = imageUpload($backproof);
    if($e3['success'] === false){
        $errors['error'] = $e3['error'];
    }else{
        $em_backproof = $e3['filename'];
    }
}


function updateStaff($db, $v, $k, $val, $em_photo, $em_frontproof, $em_backproof, $id){

    foreach ($v as $key => $value) {
        if($key != 'staff_submit' && $key != 'confirm_password' && $key != 'photo' && $key != 'frontproof' && $key != 'backproof' && $key != 'eid'){
            $k .=  "{$key}='{$value}',";
        }
    }    
    $k = rtrim($k, ',');
    
    $mysqltime = date ('Y-m-d H:i:s', time());

    $k1 = $k.", created_at='".$mysqltime."', photo='".$em_photo."', frontproof='".$em_frontproof."', backproof='".$em_backproof."'";
    $sql = "UPDATE `employee` SET {$k1} WHERE id={$id}";
    
    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateStaff($db, $v, $k, $val, $em_photo, $em_frontproof, $em_backproof, $id);
    
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>