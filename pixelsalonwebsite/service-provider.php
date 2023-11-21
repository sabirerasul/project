<?php
require_once("./lib/db.php");
require_once('./lib/config-details.php');

$modal = fetch_all($db, "SELECT * FROM `service_provider` ORDER by id DESC");

$target_dir = "../web/employee_doc/";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PAGE TITLE -->
    <title> Service Provider &#8211; <?= SALONNAME ?></title>
    <?php include('./common/head.php') ?>

</head>

<body>
    <!-- START PRELOADER -->
    <?php include('./common/preloader.php') ?>
    <!-- / END PRELOADER -->

    <!-- START HOMEPAGE DESIGN AREA -->
    <?php include('./common/header.php') ?>
    <!-- / END HOMEPAGE DESIGN AREA -->

    <?php include('./common/breadcrumb.php') ?>

    <section id="features" class="features-area pb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2>Service Provider</h2>
                        <span class="title-divider">
                            <i class="fa icon-px-logo" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row membership-data">

                <?php
                if (count($modal) > 0) {
                    foreach ($modal as $key => $val) {
                        $value = (object) $val;
                        $emp_photo = (!empty($value->photo)) ? $target_dir . $value->photo : $target_dir . 'female.png';

                ?>
                        <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                            <div class="single-service text-center">
                                <div class='avatar'>
                                    <img src='<?= $emp_photo ?>' class='img-responsive'>
                                </div>
                                <h3><?= $value->name ?></h3>
                                <p><?= $value->service_provider_type ?></p>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>

                    <p colspan='13'>No Data Found</>
                    <?php
                }
                    ?>

            </div>
        </div>
    </section>

    <?php include('./common/footer.php') ?>

    <!-- START SCROOL UP DESIGN AREA -->
    <?php include('./common/bottom-top.php') ?>
    <!-- / END SCROOL UP DESIGN AREA -->

    <?php include('./common/script.php') ?>

</body>

</html>