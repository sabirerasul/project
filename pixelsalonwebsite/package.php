<?php
require_once("./lib/db.php");
require_once('./lib/config-details.php');

$modal = fetch_all($db, "SELECT * FROM package ORDER by id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PAGE TITLE -->
    <title> Package &#8211; <?= SALONNAME ?></title>
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
                        <h2>Package</h2>
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

                        $packageServiceModel = fetch_all($db, "SELECT * FROM `package_service` WHERE `package_id`='{$value->id}'");

                ?>
                        <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                            <div class="single-service text-center">
                                <h3><?= $value->package_name ?></h3>
                                <h1>INR <?= $value->price ?></h1>
                                <?php
                                foreach ($packageServiceModel as $packageServiceKey => $packageServiceVal) {
                                    $packageServiceValue = (object) $packageServiceVal;
                                    $serviceModel = fetch_object($db, "SELECT * FROM `service` WHERE id='{$packageServiceValue->service_id}'");
                                    echo "<p>{$packageServiceValue->quantity} - {$serviceModel->service_name}</p>";
                                }
                                ?>
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