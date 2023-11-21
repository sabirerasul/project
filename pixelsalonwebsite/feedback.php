<?php
require_once("./lib/db.php");
require_once('./lib/config-details.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PAGE TITLE -->
    <title> Feedback &#8211; <?= SALONNAME ?></title>
    <?php include('./common/head.php') ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>

<body>
    <!-- START PRELOADER -->
    <?php include('./common/preloader.php') ?>
    <!-- / END PRELOADER -->

    <!-- START HOMEPAGE DESIGN AREA -->
    <?php include('./common/header.php') ?>
    <!-- / END HOMEPAGE DESIGN AREA -->

    <?php include('./common/breadcrumb.php') ?>

    <section id="features" class="features-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2>Feedback</h2>
                        <span class="title-divider">
                            <i class="fa icon-px-logo" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <?php include('./form/feedback.php') ?>
        </div>
    </section>

    <?php include('./common/footer.php') ?>

    <!-- START SCROOL UP DESIGN AREA -->
    <?php include('./common/bottom-top.php') ?>
    <!-- / END SCROOL UP DESIGN AREA -->

    <?php include('./common/script.php') ?>

    <script type="text/javascript" src="./assets/js/validation.js"></script>
    <script type="text/javascript" src="./assets/js/toastify-js.js"></script>
    <script type="text/javascript" src="./assets/js/sweetalert2@11.js"></script>
    <script type="text/javascript" src="./assets/js/main.js"></script>
    <script type="text/javascript" src="./assets/js/pages/feedback.js"></script>
    <?php include('./common/loading.php'); ?>

</body>

</html>