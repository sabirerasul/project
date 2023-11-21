<?php
require_once "./lib/db.php";
require('./classes/User.php');
require('./classes/Branch.php');
require('./classes/BranchSMSTemplate.php');


$uid = (isset($_GET['uid'])) ? $_GET['uid'] : 0;
$userText = ($uid != 0) ? 'Edit' : 'Add';
$model = ($uid != 0) ? fetch_object($db, "SELECT * FROM user WHERE id='" . $uid . "'") : new User();


$bid = (isset($_GET['bid'])) ? $_GET['bid'] : 0;
$branchText = ($bid != 0) ? 'Edit' : 'Add';
$branchModel = ($bid != 0) ? fetch_object($db, "SELECT * FROM branch WHERE id='" . $bid . "'") : new Branch();


$tid = (isset($_GET['tid'])) ? $_GET['tid'] : 0;
$templateText = ($tid != 0) ? 'Edit' : 'Add';
$sTemplateModel = ($tid != 0) ? fetch_object($db, "SELECT * FROM branch_sms_template WHERE id='" . $tid . "'") : new SMSTemplate();

$userModel = fetch_all($db, "SELECT * FROM user WHERE user_role='admin' OR user_role='superadmin'");

if (isset($_POST['signout'])) {
    session_destroy();
    header('location: super-admin.php');
}

$target_dir = "./web/salon-logo/";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pixel Salon Software</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./css/site.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">
    <!-- <link rel="stylesheet" href="./css/pages/service.css"> -->
    <link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body <?= !isset($_SESSION['superAdminPanel']) ? 'class="bg-gradient-primary"' : 'id="page-top"' ?>>
    <?php

    if (isset($_POST['signin'])) {

        extract($_REQUEST);
        $email = mysqli_real_escape_string($db, $email);
        $password = mysqli_real_escape_string($db, $password);

        $serverEmail = "superadmin@test.com";
        $serverPassword = "123456";

        if ($password == $serverPassword && $email == $serverEmail) {
            $_SESSION['superAdminPanel'] = 1;
            $_SESSION['fireAlert'] = "Successfully Login";
            $_SESSION['fireAlertColor'] = "green";
            header('location: ./super-admin.php');
        } else {
            $_SESSION['fireAlert'] = "Invalid Password";
            $_SESSION['fireAlertColor'] = "red";
            header('location: ./super-admin.php');
        }
    }


    if (!isset($_SESSION['superAdminPanel'])) {
    ?>
        <!-- Login Body Start -->

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-md-4">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900">Pixel Salon Software</h1>
                                            <p class="text-xs mb-4"><span>poweredby Pixel IT Software</span></p>
                                        </div>
                                        <form class="user" method="post">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter Email Address..." required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                            </div>
                                            <button type="submit" name="signin" class="btn btn-primary btn-user btn-block">Login</button>
                                            <a href="./index.php" class="btn btn-secondary btn-block">Back</a>
                                            <hr>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Login Body End -->

    <?php } else {




        if (isset($_POST['add_user'])) {

            extract($_REQUEST);

            $name = mysqli_real_escape_string($db, $name);
            $username = mysqli_real_escape_string($db, $username);
            $email = mysqli_real_escape_string($db, $email);
            $password = mysqli_real_escape_string($db, $password);
            $user_role = mysqli_real_escape_string($db, $user_role);
            $createdAt = date('Y-m-d H:i:s', time());
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $error = '';

            $domain = get_main_url();

            if (empty($name) || empty($username) || empty($email) || empty($password)) {
                $error = "Field must be required";
            }

            $chkSql = num_rows($db, "SELECT email FROM `user` WHERE email='$email'");

            if ($chkSql > 0) {
                $error = "User already exist";
            }

            if ($user_role == 'superadmin') {
                $chkAdminSql = num_rows($db, "SELECT * FROM `user` WHERE user_role='superadmin'");

                if ($chkAdminSql > 0) {
                    $error = "Super Admin already exist";
                }
            }

            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {
                $addUserSql = "INSERT INTO `user`(`name`, `username`, `email`, `password`, `plain_password`, `user_role`, `created_at`) VALUES ('{$name}', '{$username}', '{$email}', '{$hashed_password}', '{$password}', '{$user_role}', '$createdAt')";
                $mainAddUserSql = "INSERT INTO `user`(`name`, `username`, `email`, `password`, `plain_password`, `user_role`, `domain`, `created_at`) VALUES ('{$name}', '{$username}', '{$email}', '{$hashed_password}', '{$password}', '{$user_role}', '$domain', '$createdAt')";
                mysqli_query(mdbCon(), $mainAddUserSql);

                $sql = mysqli_query($db, $addUserSql);
                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Register!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }


        if (isset($_POST['update_user'])) {

            extract($_REQUEST);

            $name = mysqli_real_escape_string($db, $name);
            $username = mysqli_real_escape_string($db, $username);
            $email = mysqli_real_escape_string($db, $email);
            $password = mysqli_real_escape_string($db, $password);
            $user_role = mysqli_real_escape_string($db, $user_role);
            $createdAt = date('Y-m-d H:i:s', time());
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $error = '';

            if (empty($password)) {
                $password = $model->plain_password;
                $hashed_password = $model->password;
            }

            if (empty($name) || empty($username) || empty($email)) {
                $error = "Field must be required";
            }


            if ($model->email != $email) {

                $chkSql = num_rows($db, "SELECT email FROM `user` WHERE email='$email'");

                if ($chkSql > 0) {
                    $error = "User already exist";
                }
            }


            if ($model->user_role != 'superadmin') {

                if ($user_role == 'superadmin') {
                    $chkAdminSql = num_rows($db, "SELECT * FROM `user` WHERE user_role='superadmin'");

                    if ($chkAdminSql > 0) {
                        $error = "Super Admin already exist";
                    }
                }
            }
            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {

                $updateUserSql = "UPDATE `user` SET `name`='{$name}', `username`='{$username}', `email`='{$email}', `password`='{$hashed_password}', `plain_password`='{$password}', `user_role`='{$user_role}', `updated_at`='$createdAt' WHERE id='{$user_id}'";

                $mainUserModel = fetch_object($db, "SELECT id FROM `user` WHERE email='$email'");

                $mainUserModelId = !empty($mainUserModel) ? $mainUserModel->id : 0;

                $mainUpdateUserSql = "UPDATE `user` SET `name`='{$name}', `username`='{$username}', `email`='{$email}', `password`='{$hashed_password}', `plain_password`='{$password}', `user_role`='{$user_role}', `updated_at`='$createdAt' WHERE id='{$mainUserModelId}'";
                mysqli_query(mdbCon(), $mainUpdateUserSql);


                $sql = mysqli_query($db, $updateUserSql);
                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Updated!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }


        if (isset($_POST['add_branch'])) {

            extract($_REQUEST);

            $buid = mysqli_real_escape_string($db, $buid);
            $branch_name = mysqli_real_escape_string($db, $branch_name);
            $salon_name = mysqli_real_escape_string($db, $salon_name);
            $address = mysqli_real_escape_string($db, $address);
            $phone = mysqli_real_escape_string($db, $phone);
            $email = mysqli_real_escape_string($db, $email);
            $website = mysqli_real_escape_string($db, $website);
            $gst = mysqli_real_escape_string($db, $gst);
            $working_hours_start = mysqli_real_escape_string($db, $working_hours_start);
            $working_hours_end = mysqli_real_escape_string($db, $working_hours_end);

            $created_at = date('Y-m-d H:i:s', time());

            $token = rand(1234, 6789);

            $target_file = $target_dir . basename($token . $_FILES["logo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["logo"]["tmp_name"]);
            $kb_5 = 600000;

            $error = '';
            $iName = '';


            if ($check === false) {
                $error = "File is not an image";
            } else {
                if ($_FILES["logo"]["size"] > $kb_5) {
                    $error = "Image size should not be more than 600 KB";
                } else {
                    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                        $iName = htmlspecialchars(basename($token . $_FILES["logo"]["name"]));
                    } else {
                        $error = "Sorry, there was an error uploading your file.";
                    }
                }
            }

            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {

                $updateBranchSql = "INSERT INTO `branch`(`uid`, `branch_name`, `salon_name`, `address`, `phone`, `email`, `website`, `gst`, `working_hours_start`, `working_hours_end`, `logo`, `created_at`) VALUES ('{$buid}', '{$branch_name}', '{$salon_name}', '{$address}', '{$phone}', '{$email}', '{$website}', '{$gst}', '{$working_hours_start}', '{$working_hours_end}', '{$iName}', '{$created_at}')";

                $sql = mysqli_query($db, $updateBranchSql);
                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Register!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }


        if (isset($_POST['update_branch'])) {

            extract($_REQUEST);

            $buid = mysqli_real_escape_string($db, $buid);
            $branch_name = mysqli_real_escape_string($db, $branch_name);
            $salon_name = mysqli_real_escape_string($db, $salon_name);
            $address = mysqli_real_escape_string($db, $address);
            $phone = mysqli_real_escape_string($db, $phone);
            $email = mysqli_real_escape_string($db, $email);
            $website = mysqli_real_escape_string($db, $website);
            $gst = mysqli_real_escape_string($db, $gst);
            $working_hours_start = mysqli_real_escape_string($db, $working_hours_start);
            $working_hours_end = mysqli_real_escape_string($db, $working_hours_end);

            $error = '';
            $iName = $branchModel->logo;
            $createdAt = date('Y-m-d H:i:s', time());

            if (!empty($_FILES["logo"]['name'])) {

                $token = rand(1234, 6789);

                $target_file = $target_dir . basename($token . $_FILES["logo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["logo"]["tmp_name"]);
                $kb_5 = 600000;

                if ($check === false) {
                    $error = "File is not an image";
                } else {
                    if ($_FILES["logo"]["size"] > $kb_5) {
                        $error = "Image size should not be more than 600 KB";
                    } else {
                        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                            unlink($target_dir . $branchModel->logo);
                            $iName = htmlspecialchars(basename($token . $_FILES["logo"]["name"]));
                        } else {
                            $error = "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }

            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {
                $updateBranchSql = "UPDATE `branch` SET `uid`='{$buid}', `branch_name`='{$branch_name}', `salon_name`='{$salon_name}', `address`='{$address}', `phone`='{$phone}', `email`='{$email}', `website`='{$website}', `gst`='{$gst}', `working_hours_start`='{$working_hours_start}', `working_hours_end`='{$working_hours_end}', `logo`='{$iName}', `updated_at`='$createdAt' WHERE id='{$branch_id}'";

                $sql = mysqli_query($db, $updateBranchSql);
                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Updated!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }


        if (isset($_POST['add_template'])) {

            extract($_REQUEST);

            $branch_id = mysqli_real_escape_string($db, $branch_id);
            $template_title = mysqli_real_escape_string($db, $template_title);
            $template = mysqli_real_escape_string($db, $template);
            $priority = mysqli_real_escape_string($db, $priority);
            $s_type = mysqli_real_escape_string($db, $s_type);
            $channel = mysqli_real_escape_string($db, $channel);
            $dcs = mysqli_real_escape_string($db, $dcs);
            $flash_sms = mysqli_real_escape_string($db, $flash_sms);
            $route = mysqli_real_escape_string($db, $route);
            $peid = mysqli_real_escape_string($db, $peid);
            $dlt_template_id = mysqli_real_escape_string($db, $dlt_template_id);

            $created_at = date('Y-m-d H:i:s', time());

            $error = '';

            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {
                $addUserSql = "INSERT INTO `branch_sms_template`(`branch_id`,`template_title`,`template`,`priority`,`s_type`,`channel`,`dcs`,`flash_sms`,`route`,`peid`,`dlt_template_id`,`created_at`) VALUES ('{$branch_id}','{$template_title}','{$template}','{$priority}','{$s_type}','{$channel}','{$dcs}','{$flash_sms}','{$route}','{$peid}','{$dlt_template_id}', '{$created_at}')";

                $sql = mysqli_query($db, $addUserSql);
                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Register!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }


        if (isset($_POST['update_template'])) {

            extract($_REQUEST);

            $branch_id = mysqli_real_escape_string($db, $branch_id);
            $template_title = mysqli_real_escape_string($db, $template_title);
            $template = mysqli_real_escape_string($db, $template);
            $priority = mysqli_real_escape_string($db, $priority);
            $s_type = mysqli_real_escape_string($db, $s_type);
            $channel = mysqli_real_escape_string($db, $channel);
            $dcs = mysqli_real_escape_string($db, $dcs);
            $flash_sms = mysqli_real_escape_string($db, $flash_sms);
            $route = mysqli_real_escape_string($db, $route);
            $peid = mysqli_real_escape_string($db, $peid);
            $dlt_template_id = mysqli_real_escape_string($db, $dlt_template_id);

            $createdAt = date('Y-m-d H:i:s', time());

            $error = '';

            if (!empty($error)) {
                fireAlert($error, 'red');
            } else {

                $templateSql = "UPDATE `branch_sms_template` SET `branch_id`='{$branch_id}', `template_title`='{$template_title}', `template`='{$template}', `priority`='{$priority}', `s_type`='{$s_type}', `channel`='{$channel}', `dcs`='{$dcs}', `flash_sms`='{$flash_sms}', `route`='{$route}', `peid`='{$peid}', `dlt_template_id`='{$dlt_template_id}' WHERE id='{$tid}'";
                $sql = mysqli_query($db, $templateSql);

                if ($sql) {
                    $_SESSION['fireAlert'] = "Successfully Updated!";
                    $_SESSION['fireAlertColor'] = "green";
                    header('location: ./super-admin.php');
                } else {
                    $_SESSION['fireAlert'] = "server error";
                    $_SESSION['fireAlertColor'] = "red";
                    header('location: ./super-admin.php');
                }
            }
        }

    ?>

        <!-- Admin Panel Body Start -->

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">


                        <div class="row">

                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $userText ?> User</h2>
                                <p class="text-right">
                                <form method="post" class="text-right"><button type="submit" name="signout" class="btn btn-sm btn-secondary">Log Out</button></form>
                                </p>
                            </div>

                            <form method="post">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name" class="name_label required">Name</label>
                                            <input type="text" class="form-control name" name="name" id="name" value="<?= $model->name ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="username" class="username_label required">Username</label>
                                            <input type="text" class="form-control name" name="username" id="username" value="<?= $model->username ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" class="email_label required">Email</label>
                                            <input type="email" class="form-control name" name="email" id="email" value="<?= $model->email ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="password" class="password_label required">Password</label>
                                            <input type="password" class="form-control name" name="password" id="password" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="user_role" class="user_role_label required">User Role</label>
                                            <select class="form-select user_role" name="user_role" id="user_role" required>
                                                <?php
                                                foreach ($userRoleArr as $userRoleKey => $userRoleValue) {
                                                ?>
                                                    <option value="<?= $userRoleKey ?>" <?= ($model->user_role == $userRoleKey) ? 'selected' : '' ?>>
                                                        <?= $userRoleValue ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php if ($uid != 0) { ?>
                                        <input type="hidden" name="user_id" value="<?= $model->id ?>">
                                    <?php } ?>

                                    <hr>
                                    <div class="col-md-12 d-flex justify-content-center my-3">
                                        <div class="form-group">
                                            <button type="submit" name="<?= ($uid != 0) ? 'update' : 'add' ?>_user" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>


                        <div class="row">
                            <div class="col-12 bg-white my-3">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Manage User</h6>
                                    </div>

                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTableService" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>

                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>Email</th>
                                                        <th>Password</th>
                                                        <th>User Role</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="active-service-data">
                                                    <?php

                                                    $modal = fetch_all($db, "SELECT * FROM user ORDER by id DESC");

                                                    $html1 = "";

                                                    if (count($modal) > 0) {
                                                        $count = 0;
                                                        foreach ($modal as $key => $val) {
                                                            $count++;
                                                            $value = (object) $val;
                                                            $catStatus = ($value->user_role == 'admin') ? 'Admin' : 'Super Admin';
                                                            $catColor = ($value->user_role == 'admin') ? 'secondary' : 'success';
                                                            // /
                                                            $html1 .= "<tr>
                                                            <td>{$count}</td>
                                                            <td>{$value->name}</td>
                                                            <td>{$value->username}</td>
                                                            <td>{$value->email}</td>
                                                            <td>{$value->plain_password}</td>
                                                            <td><span class='badge rounded-pill text-bg-{$catColor}'>{$catStatus}</span></td>
                                                            <td>{$value->created_at}</td>
                                                            <td>
                                                                <a href='./super-admin.php?uid={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                                                            </td>
                                                        </tr>";
                                                        }
                                                    } else {

                                                        $html1 .= "<tr>
                                                    <td colspan='13'>No Data Found</td>
                                                    </tr>";
                                                    }

                                                    echo $html1;

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $branchText ?> Branch
                                </h2>
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="uid" class="uid_label required">Admin User</label>
                                            <select class="form-select uid" name="buid" id="uid" required>
                                                <?php
                                                foreach ($userModel as $userModelKey => $userModelValue) {
                                                ?>
                                                    <option value="<?= $userModelValue['id'] ?>" <?= ($branchModel->uid == $userModelValue['id']) ? 'selected' : '' ?>>
                                                        <?= $userModelValue['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="branch_name" class="name_label required">Branch Name</label>
                                            <input type="text" class="form-control branch_name" name="branch_name" id="branch_name" value="<?= $branchModel->branch_name ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="salon_name" class="name_label required">Salon Name</label>
                                            <input type="text" class="form-control salon_name" name="salon_name" id="salon_name" value="<?= $branchModel->salon_name ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="address" class="address_label required">Address</label>
                                            <textarea type="text" id="address" class="form-control address" name="address" cols="5" rows="2" required><?= $branchModel->address ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone" class="phone_label required">Phone</label>
                                            <input type="text" class="form-control name" name="phone" id="phone" value="<?= $branchModel->phone ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" class="email_label">Email</label>
                                            <input type="email" class="form-control name" name="email" id="email" value="<?= $branchModel->email ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="website" class="name_label">Website</label>
                                            <input type="text" class="form-control website" name="website" id="website" value="<?= $branchModel->website ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gst" class="name_label">GST</label>
                                            <input type="text" class="form-control gst" name="gst" id="gst" value="<?= $branchModel->gst ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="working_hours_start" class="name_label required">Working
                                                Hours</label>

                                            <div class="d-flex justify-content-between gap-1">
                                                <input type="text" class="form-control working_hours_start" name="working_hours_start" id="working_hours_start" value="<?= $branchModel->working_hours_start ?>" required>
                                                <input type="text" class="form-control working_hours_end" name="working_hours_end" id="working_hours_end" value="<?= $branchModel->working_hours_end ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="logo" class="name_label required">Logo</label>
                                            <input type="file" class="form-control logo" name="logo" id="logo" <?= empty($branchModel->id) ? 'required' : '' ?>>
                                        </div>

                                        <div class="my-3">
                                            <?php
                                            if (!empty($branchModel->logo)) {
                                                echo "<p>Old Iamge:</p>";
                                                echo '<img src="' . $target_dir . $branchModel->logo . '" style="width:100px">';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php if ($bid != 0) { ?>
                                        <input type="hidden" name="branch_id" value="<?= $branchModel->id ?>">
                                    <?php } ?>

                                    <hr>
                                    <div class="col-md-12 d-flex justify-content-center my-3">
                                        <div class="form-group">
                                            <button type="submit" name="<?= ($bid != 0) ? 'update' : 'add' ?>_branch" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Manage Branch</h6>
                                    </div>
                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTableCategory" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Branch Admin</th>
                                                        <th>Branch Name</th>
                                                        <th>Salon Name</th>
                                                        <th>Address</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Website</th>
                                                        <th>GST</th>
                                                        <th>Working Hours</th>
                                                        <th>Logo</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="active-category-data">

                                                    <?php

                                                    $modal1 = fetch_all($db, "SELECT * FROM branch ORDER by id DESC");

                                                    $html2 = "";

                                                    if (count($modal1) > 0) {
                                                        $count = 0;
                                                        foreach ($modal1 as $key => $val) {
                                                            $count++;
                                                            $value = (object) $val;

                                                            $singleUserModel = fetch_object($db, "SELECT * FROM user WHERE id='{$value->uid}'");

                                                            $html2 .= "
                                                        <tr>
                                                            <td>{$count}</td>
                                                            <td>{$singleUserModel->name}</td>
                                                            <td>{$value->branch_name}</td>
                                                            <td>{$value->salon_name}</td>
                                                            <td>{$value->address}</td>
                                                            <td>{$value->phone}</td>
                                                            <td>{$value->email}</td>
                                                            <td>{$value->website}</td>
                                                            <td>{$value->gst}</td>
                                                            <td>{$value->working_hours_start} - {$value->working_hours_end}</td>
                                                            <td><img src='{$target_dir}{$value->logo}' style='width:100px'></td>
                                                            <td>{$value->created_at}</td>
                                                            <td>{$value->updated_at}</td>
                                                            <td>
                                                                <a href='./super-admin.php?bid={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap my-1' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                                                            </td>
                                                        </tr>";
                                                        }
                                                    } else {

                                                        $html2 .= "<tr>
                                                        <td colspan='14'>No Data Found</td>
                                                        </tr>";
                                                    }


                                                    echo $html2;

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2"><?= $templateText ?> SMS
                                    Template</h2>
                            </div>

                            <form method="post">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="branch_id" class="uid_label required">Branch</label>
                                            <select class="form-select branch_id" name="branch_id" id="branch_id" required>
                                                <?php
                                                foreach ($modal1 as $allbranchKey => $allbranchValue) {
                                                ?>
                                                    <option value="<?= $allbranchValue['id'] ?>" <?= ($sTemplateModel->branch_id == $allbranchValue['id']) ? 'selected' : '' ?>>
                                                        <?= $allbranchValue['branch_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="template_title" class="name_label required">Template Name</label>
                                            <input type="text" class="form-control template_title" name="template_title" id="template_title" value="<?= $sTemplateModel->template_title ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="template" class="name_label required">Template</label>
                                            <textarea class="form-control template" name="template" id="template" cols="5" rows="4" required><?= $sTemplateModel->template ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="priority" class="address_label required">Priority</label>
                                            <input type="text" id="priority" class="form-control priority" name="priority" value="<?= $sTemplateModel->priority ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="s_type" class="phone_label required">sType</label>
                                            <input type="text" class="form-control name" name="s_type" id="s_type" value="<?= $sTemplateModel->s_type ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="channel" class="email_label required">Channel</label>
                                            <input type="text" class="form-control channel" name="channel" id="channel" value="<?= $sTemplateModel->channel ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dcs" class="name_label required">DCS</label>
                                            <input type="text" class="form-control dcs" name="dcs" id="dcs" value="<?= $sTemplateModel->dcs ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="flash_sms" class="name_label required">Flash SMS</label>
                                            <input type="number" class="form-control flash_sms" name="flash_sms" id="flash_sms" value="<?= $sTemplateModel->flash_sms ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="route" class="name_label" required>Route</label>
                                            <input type="number" class="form-control route" name="route" id="route" value="<?= $sTemplateModel->route ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="peid" class="name_label" required>PE ID</label>
                                            <input type="number" class="form-control peid" name="peid" id="peid" value="<?= $sTemplateModel->peid ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dlt_template_id" class="name_label required">DLT ID</label>
                                            <input type="number" class="form-control dlt_template_id" name="dlt_template_id" id="dlt_template_id" value="<?= $sTemplateModel->dlt_template_id ?>" required>
                                        </div>
                                    </div>

                                    <?php if ($tid != 0) { ?>
                                        <input type="hidden" name="id" value="<?= $sTemplateModel->id ?>">
                                    <?php } ?>

                                    <hr>
                                    <div class="col-md-12 d-flex justify-content-center my-3">
                                        <div class="form-group">
                                            <button type="submit" name="<?= ($tid != 0) ? 'update' : 'add' ?>_template" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Manage SMS Template</h6>
                                    </div>
                                    <div class="card-body shadow rounded p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTableTemplate" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Branch Name</th>
                                                        <th>Template Name</th>
                                                        <th>Template</th>
                                                        <th>Priority</th>
                                                        <th>sType</th>
                                                        <th>Channel</th>
                                                        <th>DCS</th>
                                                        <th>Flash SMS</th>
                                                        <th>Route</th>
                                                        <th>Pe ID</th>
                                                        <th>DLT Template ID</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="active-category-data">

                                                    <?php

                                                    $templateModel = fetch_all($db, "SELECT * FROM branch_sms_template ORDER by id DESC");

                                                    $html3 = "";

                                                    if (count($templateModel) > 0) {
                                                        $count = 0;
                                                        foreach ($templateModel as $templateKey => $templateVal) {
                                                            $count++;
                                                            $templateValue = (object) $templateVal;

                                                            $count++;
                                                            $branchModel22 = fetch_object($db, "SELECT * FROM branch WHERE id='{$templateValue->branch_id}'");
                                                            $html3 .= "
                                                        <tr>
                                                            <td>{$count}</td>
                                                            <td>{$branchModel22->branch_name}</td>
                                                            <td>{$templateValue->template_title}</td>
                                                            <td>{$templateValue->template}</td>
                                                            <td>{$templateValue->priority}</td>
                                                            <td>{$templateValue->s_type}</td>
                                                            <td>{$templateValue->channel}</td>
                                                            <td>{$templateValue->dcs}</td>
                                                            <td>{$templateValue->flash_sms}</td>
                                                            <td>{$templateValue->route}</td>
                                                            <td>{$templateValue->peid}</td>
                                                            <td>{$templateValue->dlt_template_id}</td>
                                                            <td>
                                                                <a href='./super-admin.php?tid={$templateValue->id}' class='btn btn-primary btn-sm btn-block text-nowrap my-1' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                                                            </td>
                                                        </tr>";
                                                        }
                                                    } else {

                                                        $html3 .= "<tr>
                                                        <td colspan='14'>No Data Found</td>
                                                        </tr>";
                                                    }


                                                    echo $html3;

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->


        <!-- End of Page Wrapper -->




        <!-- Admin Panel Body End -->

    <?php } ?>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="./js/toastify-js.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>
    <script src="./js/main.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script src="./js/bootstrap-datetimepicker.min.js"></script>



    <script src="./js/pages/super-admin.js"></script>

    <?php
    if (isset($_SESSION['fireAlert']) && !empty($_SESSION['fireAlert'])) {
        fireAlert($_SESSION['fireAlert'], $_SESSION['fireAlertColor']);
        //unset($_SESSION['fireAlert']);
    }

    ?>
    <?php include('./comman/loading.php'); ?>
</body>

</html>