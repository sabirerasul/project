<?php
require_once("./lib/db.php");
require_once('./lib/config-details.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PAGE TITLE -->
    <title> Dashboard &#8211; <?= SALONNAME ?></title>
    <?php include('./common/head.php') ?>
</head>

<body>
    <!-- START PRELOADER -->
    <?php include('./common/preloader.php') ?>
    <!-- / END PRELOADER -->

    <!-- START HOMEPAGE DESIGN AREA -->
    <?php include('./common/header.php') ?>
    <!-- / END HOMEPAGE DESIGN AREA -->

    <!-- START ABOUT US DESIGN AREA -->
    <section id="about" class="about-us-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2>About us</h2>
                        <span class="title-divider">
                            <i class="fa icon-px-logo" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- START ABOUT US TEXT DESIGN AREA -->
                <div class="col-md-12">
                    <div class="about-text wow fadeInUp" data-wow-delay=".2s">
                        <h2 class="text-center">Welcome to Pixel Salon Website</h2>
                        <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                            an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>
                <!-- / END ABOUT US TEXT DESIGN AREA -->

            </div>
        </div>
    </section>
    <!-- / END ABOUT US DESIGN AREA -->

    <section id="features" class="features-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2>Web Features</h2>
                        <span class="title-divider">
                            <i class="fa icon-px-logo" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="home-service-container">

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <a href="./enquiry">
                        <div class="single-service text-center">
                            <i class="bi bi-person-fill-add"></i>
                            <h4>Enquiry</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                    <a href="./book-appointment">
                        <div class="single-service text-center">
                            <i class="bi bi-calendar2-plus-fill"></i>
                            <h4>Book Appointment</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                    <a href="./service-menu">
                        <div class="single-service text-center">
                            <i class="bi bi-menu-button-wide-fill"></i>
                            <h4>Service Menu</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay=".8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">
                    <a href="./package">
                        <div class="single-service text-center">
                            <i class="bi bi-box-seam-fill"></i>
                            <h4>Package</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1s" style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                    <a href="./membership">
                        <div class="single-service text-center">
                            <i class="bi bi-star-fill"></i>
                            <h4>Membership</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <a href="./offers">
                        <div class="single-service text-center">
                            <i class="bi bi-megaphone-fill"></i>
                            <h4>Offers</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <a href="./photo-gallery">
                        <div class="single-service text-center">
                            <i class="bi bi-image-fill"></i>
                            <h4>Photo Gallery</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <a href="./service-provider">
                        <div class="single-service text-center">
                            <i class="bi bi-person-badge-fill"></i>
                            <h4>Service Provider</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <a href="./review">
                        <div class="single-service text-center">
                            <i class="bi bi-google"></i>
                            <h4>Review</h4>
                        </div>
                    </a>
                </div>

                <div class="wow fadeInUp home-service-wrapper" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                    <a href="./feedback">
                        <div class="single-service text-center">
                            <i class="bi bi-emoji-smile-fill"></i>
                            <h4>Feedback</h4>
                        </div>
                    </a>
                </div>

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