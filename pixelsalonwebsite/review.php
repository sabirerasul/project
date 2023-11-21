<?php
require_once("./lib/db.php");
require_once('./lib/config-details.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PAGE TITLE -->
    <title> Review &#8211; <?= SALONNAME ?></title>
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
                        <h2>Review</h2>
                        <span class="title-divider">
                            <i class="fa icon-px-logo" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-person-fill-add"></i>
                        <h4>Enquiry</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-calendar2-plus-fill"></i>
                        <h4>Book Appointment</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-menu-button-wide-fill"></i>
                        <h4>Service Menu</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-box-seam-fill"></i>
                        <h4>Package</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1s" style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-star-fill"></i>
                        <h4>Membership</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-megaphone-fill"></i>
                        <h4>Offers</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-image-fill"></i>
                        <h4>Photo Gallery</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-person-badge-fill"></i>
                        <h4>Service Provider</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-google"></i>
                        <h4>Review</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->
                <!-- START SINGLE FEATURES  DESIGN AREA -->
                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <div class="single-service text-center">
                        <i class="bi bi-emoji-smile-fill"></i>
                        <h4>Feedback</h4>
                    </div>
                </div>
                <!-- / END SINGLE FEATURES  DESIGN AREA -->

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