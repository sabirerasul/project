<?php
require("./lib/db.php");
require("./classes/User.php");
is_auth();
extract($_REQUEST);


if (isset($_POST['user'])) {

    $user = $_POST['user'];

    $email = mysqli_real_escape_string($db, $user['email']);
    $password = mysqli_real_escape_string($db, $user['password']);

    $sql = "SELECT * FROM user WHERE email='$email'";

    $res = fetch_assoc($db, $sql);

    if (password_verify($password, $res['password'])) {
        $userModel = fetch_object($db, "SELECT * FROM user WHERE id='{$res['id']}'");

        $model = new User();
        $model->id = $userModel->id;
        $model->name = $userModel->name;
        $model->username = $userModel->username;
        $model->email = $userModel->email;
        $model->user_role = $userModel->user_role;

        $model = json_encode($model);

        $userArray =
            [
                'user' => $res['name'],
                'user_id' => $res['id'],
                'model' => $model
            ];
        $_SESSION['user'] = $userArray;
        header('location: ./index.php');
    } else {
        $m = "Invalid Password";
        header('location: ./login.php?m=1');
    }
}


if (isset($m)) {
    $_SESSION['fireAlert'] = "Invalid Password";
    $_SESSION['fireAlertColor'] = "red";
}

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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- <link rel="stylesheet" href="./css/datepicker.min.css"> -->
    <link rel="stylesheet" href="./css/site.css">
    <!-- <link rel="stylesheet" href="./css/pages/service.css"> -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />

<link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="./img/logo.png" height="70px">
                                        <p class="text-xs mb-4"><span>poweredby Pixel IT Software</span></p>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="email" name="user[email]" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="user[password]" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                    </form>

                                    <div class="text-right">
                                        <p>For support : support@pixelitsoftware.com</p>
                                        <p>+91-958-061-0023</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

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
    <script src="./js/main.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <!-- <script type="text/javascript" src="./js/datepicker.min.js"></script> -->

    

    <?php
    if (isset($_SESSION['fireAlert']) && !empty($_SESSION['fireAlert'])) {
        fireAlert($_SESSION['fireAlert'], $_SESSION['fireAlertColor']);
        //unset($_SESSION['fireAlert']);
    }

    ?>

<?php include('./comman/loading.php'); ?>
</body>

</html>