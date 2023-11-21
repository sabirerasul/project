<?php
require_once "lib/db.php";
//check_auth();
extract($_REQUEST);



if (!empty(BRANCHID)) {
    $SALONNAME = SALONNAME;
    $BRANDLOGO = BRANDLOGO;
    $BRANCHID = BRANCHID;
} else {

    $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$inv}'");

    $branchModel = fetch_object($db, "SELECT * FROM `branch` WHERE `id`='{$billingModel->branch_id}'");

    $SALONNAME = $branchModel->salon_name;
    $BRANDLOGO = "./web/salon-logo/{$branchModel->logo}";
    $BRANCHID = $branchModel->id;

    if (empty($inv)) {
        //header('location: ./feedback.php');
    }
}



$status = 0;

if (isset($adm)) {
    $status = 1;
}

if (isset($inv) && !empty($inv)) {
    $model = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$inv}'");
    if (!empty($model)) {
        $feedNum = num_rows($db, "SELECT * FROM feedback WHERE invoice_number='{$inv}'");

        if ($feedNum > 0) {
            unset($_SESSION['clientUpdateError']);
            $errors['error'] = "Feedback already added";
            $data['success'] = false;
            $data['errors'] = $errors;
            $_SESSION['clientUpdateError'] = $data;
            //header('location: ./feedback-add.php');
            echo js_redirect('./feedback-already.php?inv=' . $inv);
        }
        $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$model->client_id}'");
        $clientName = $clientModel->client_name;
        $clientEmail = $clientModel->email;
        $clientId = $clientModel->id;
    } else {
        unset($_SESSION['clientUpdateError']);
        $errors['error'] = "Invalid Invoice Number";
        $data['success'] = false;
        $data['errors'] = $errors;
        $_SESSION['clientUpdateError'] = $data;
        //header('location: ./feedback-add.php');
        echo js_redirect('./feedback-add.php?inv=' . $inv);
    }
}


if (isset($verify2)) {

    $branch_id = $BRANCHID;
    $created_at = date('Y-m-d H:i:s', time());

    $sql = "INSERT INTO `feedback`(`branch_id`, `client_id`, `invoice_number`, `name`, `email`, `review`, `overall_experience`, `timely_response`, `our_support`, `overall_satisfaction`, `rating`, `suggestion`, `status`, `created_at`) VALUES ('{$branch_id}', '{$cid}', '{$inv}', '{$name}', '{$email}', '{$review}', '{$overall_experience}', '{$timely_response}', '{$our_support}', '{$overall_satisfaction}', '{$rating}', '{$suggestion}', '{$status}', '{$created_at}')";
    $query = mysqli_query($db, $sql);

    if ($query) {
        unset($_SESSION['clientUpdateError']);
        $errors['error'] = "Feedback added successfully";
        $data['success'] = true;
        $data['errors'] = $errors;

        $_SESSION['clientUpdateError'] = $data;
        //header('location: ./feedback-add.php');
        echo js_redirect('./feedback-success.php?inv=' . $inv);
    } else {
        unset($_SESSION['clientUpdateError']);
        $errors['error'] = "Invalid error, please try again some time";
        $data['success'] = true;
        $data['errors'] = $errors;
        $_SESSION['clientUpdateError'] = $data;
    }
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

    <title>Add Feedback - <?= $SALONNAME ?></title>

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
    <link rel="stylesheet" href="./css/pages/feedback.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                if (isset($_SESSION['user'])) {
                    include('./comman/nav.php');
                }
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mx-auto my-3">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-center align-items-center" style="flex-direction: column;">
                                    <div>
                                        <img src="<?= $BRANDLOGO ?>" alt="<?= $SALONNAME ?>" style="max-width:200px">
                                    </div>
                                    <h1 class="my-2">Feedback</h1>
                                </div>

                                <div class="col-12 my-2">
                                    <?php

                                    $serverError = isset($_SESSION['clientUpdateError']) ? $_SESSION['clientUpdateError'] : false;

                                    if ($serverError) {

                                        $alertType = ($serverError['success'] == true) ? 'success' : 'danger';

                                        echo '
                                            <div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">
                                            <strong></strong> ' . $serverError['errors']['error'] . '
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                                    }
                                    ?>
                                </div>
                                <?php if (!isset($inv) && empty($inv)) { ?>
                                    <div class="card-body shadow rounded p-2">
                                        <form action="" method="get">
                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Enter Invoice Number </label>
                                                <input type="text" class="form-control" name="inv" placeholder="Invoice Number" required="">
                                                <input type="hidden" name="adm" value="1" required="">
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" name="verify1" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>

                                    <div class="card-body shadow rounded p-2">
                                        <form method="post">

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Your Name </label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter Your Name" value="<?= $clientName ?>" required="">
                                                <input type="hidden" name="cid" value="<?= $clientId ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?= $clientEmail ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Your Review</label>
                                                <textarea name="review" class="form-control" id="review" required=""></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Overall Experience</label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_experience" id="inlineRadio1" checked value="Very Good">
                                                        <label class="form-check-label" for="inlineRadio1">Very Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_experience" id="inlineRadio2" value="Good">
                                                        <label class="form-check-label" for="inlineRadio2">Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_experience" id="inlineRadio3" value="Fair">
                                                        <label class="form-check-label" for="inlineRadio3">Fair</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_experience" id="inlineRadio4" value="Poor">
                                                        <label class="form-check-label" for="inlineRadio4">Poor</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Timely Response</label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="timely_response" id="inlineRadio11" checked value="Very Good">
                                                        <label class="form-check-label" for="inlineRadio11">Very Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="timely_response" id="inlineRadio21" value="Good">
                                                        <label class="form-check-label" for="inlineRadio21">Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="timely_response" id="inlineRadio31" value="Fair">
                                                        <label class="form-check-label" for="inlineRadio31">Fair</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="timely_response" id="inlineRadio41" value="Poor">
                                                        <label class="form-check-label" for="inlineRadio41">Poor</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Our Support</label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="our_support" id="inlineRadio1" checked value="Very Good">
                                                        <label class="form-check-label" for="inlineRadio1">Very Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="our_support" id="inlineRadio2" value="Good">
                                                        <label class="form-check-label" for="inlineRadio2">Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="our_support" id="inlineRadio3" value="Fair">
                                                        <label class="form-check-label" for="inlineRadio3">Fair</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="our_support" id="inlineRadio4" value="Poor">
                                                        <label class="form-check-label" for="inlineRadio4">Poor</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Overall Satisfaction</label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="inlineRadio1" checked value="Very Good">
                                                        <label class="form-check-label" for="inlineRadio1">Very Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="inlineRadio2" value="Good">
                                                        <label class="form-check-label" for="inlineRadio2">Good</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="inlineRadio3" value="Fair">
                                                        <label class="form-check-label" for="inlineRadio3">Fair</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="inlineRadio4" value="Poor">
                                                        <label class="form-check-label" for="inlineRadio4">Poor</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5>Want to rate with us for customer services?</h5>
                                            <span class="starRating">
                                                <input id="rating5" type="radio" name="rating" value="5" checked="">
                                                <label for="rating5">5</label>
                                                <input id="rating4" type="radio" name="rating" value="4">
                                                <label for="rating4">4</label>
                                                <input id="rating3" type="radio" name="rating" value="3">
                                                <label for="rating3">3</label>
                                                <input id="rating2" type="radio" name="rating" value="2">
                                                <label for="rating2">2</label>
                                                <input id="rating1" type="radio" name="rating" value="1">
                                                <label for="rating1">1</label>
                                            </span>

                                            <div class="form-group">
                                                <label for="name" class="emp_name_label required">Is there anything you would like to tell us?</label>
                                                <textarea id="othernotes" class="form-control" required="" name="suggestion"> </textarea>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="button" onclick="window.location = './feedback-add.php'" name="reset" class="btn btn-danger"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back</button>
                                                <button type="submit" name="verify2" class="btn btn-success"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Send Feedback</button>
                                            </div>
                                        </form>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php
        if (isset($_SESSION['user'])) {
            include('./comman/footer.php');
        }
        ?>

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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


    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="./js/pages/feedback.js"></script>

<?php include('./comman/loading.php'); ?>
</body>

</html>

<?php
if (isset($_SESSION['clientUpdateError'])) {
    //unset($_SESSION['clientUpdateError']);
}
?>