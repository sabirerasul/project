<?php

$allBranchArr = all_branch($db);

$serviceCategoryModel = fetch_all($db, "SELECT * FROM `service_category` WHERE status=1 ORDER by `name` ASC");

$oldArray = !empty($_SESSION['appointment']) ? explode(',', $_SESSION['appointment']) : [];

?>

<form action="./inc/enquiry/enquiry-add.php" method="post" id="AddEnquiryForm">
    <div class="row mt-5">

        <div class="col-md-8">

            <div class="row">

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="branch_id" class="required form-label branch_id_label"> Select Branch </label>
                        <select class="form-control branch_id" name="branch_id" id="branch_id">
                            <?php
                            $allBranchArr = all_branch($db);
                            foreach ($allBranchArr as $allBranchKey => $allBranchValue) {
                            ?>
                                <option value="<?= $allBranchValue['id'] ?>" <?= (BRANCHID == $allBranchValue['id']) ? 'selected' : '' ?>><?= $allBranchValue['branch_name'] ?> - <?= $allBranchValue['salon_name'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="showErr"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="client_name" class="required form-label client_name_label">Name</label>
                        <input type="text" class="form-control client_name" id="client_name" placeholder="Name" name="client_name">
                        <div class="showErr"></div>
                        <input type="hidden" name="client_id" value="0" id="client_id">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="contact" class="required form-label contact_label">Contact</label>
                        <input type="number" class="form-control contact" id="contact" oninput="checkClientNumber(this)" placeholder="Number" name="contact" maxlength="10">
                        <div class="showErr"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="appointment_date" class="required form-label appointment_date_label">Appointment Date</label>
                        <input type="text" class="form-control appointment_date" name="appointment_date" id="appointment_date" value="09/02/2023">
                        <div class="showErr"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="appointment_time" class="required form-label appointment_time_label">Appointment Time</label>
                        <input type="text" class="form-control appointment_time" name="appointment_time" id="appointment_time" value="09/02/2023">
                        <div class="showErr"></div>
                    </div>
                </div>

                <div class="col-md-12 my-5">
                    <h3>Select Services</h3>

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <?php
                        foreach ($serviceCategoryModel as $serviceCategoryKey => $serviceCategoryVal) {
                            $serviceCategoryValue = (object) $serviceCategoryVal;
                        ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-heading<?= $serviceCategoryKey ?>">
                                    <button class="accordion-button <?= ($serviceCategoryKey != 0) ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $serviceCategoryKey ?>" aria-expanded="<?= ($serviceCategoryKey != 0) ? 'true' : 'false' ?>" aria-controls="panelsStayOpen-collapse<?= $serviceCategoryKey ?>">
                                        <?= $serviceCategoryValue->name ?>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapse<?= $serviceCategoryKey ?>" class="accordion-collapse collapse <?= ($serviceCategoryKey == 0) ? 'show' : '' ?>" aria-labelledby="panelsStayOpen-heading<?= $serviceCategoryKey ?>">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group service-wrapper">

                                            <?php

                                            $serviceModel = fetch_all($db, "SELECT * FROM `service` WHERE status=1 AND hide_on_website=0 AND category_id='{$serviceCategoryValue->id}' ORDER by `service_name` ASC");
                                            foreach ($serviceModel as $serviceKey => $serviceVal) {
                                                $serviceValue = (object) $serviceVal;
                                                if (($key = array_search($serviceValue->id, $oldArray)) !== false) {
                                            ?>

                                                    <li class="list-group-item active" data-id="<?= $serviceValue->id ?>" onclick="addToCart(this)">
                                                        <span class="bg-white py-1 px-2 me-2 rounded"><i class="fa text-success fa-check"></i></span>
                                                        <span><?= $serviceValue->service_name ?> - ₹ <span class='service-price'><?= $serviceValue->price ?></span></span>
                                                    </li>

                                                <?php
                                                } else {
                                                ?>

                                                    <li class="list-group-item" data-id="<?= $serviceValue->id ?>" onclick="addToCart(this)">
                                                        <span><?= $serviceValue->service_name ?> - ₹ <span class='service-price'><?= $serviceValue->price ?></span></span>
                                                    </li>
                                            <?php }
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>




            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card">
                <div class="m-3">
                    <button type="button" class="btn btn-primary position-relative">
                        Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span class="cart-count"><?= getAppointmentCart() ?></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                </div>

                <div>
                    <ul class="list-group cart-wrapper">



                    </ul>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="m-1">

                        <label for="coupon_code" class="d-none coupon_code_label"></label>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control coupon_code" id="coupon_code" placeholder="Coupon Code" name="coupon_code" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-success" type="button" id="button-addon2" onclick="check_coupon_code(this)">Apply</button>
                            </div>

                            

                            <input type="hidden" class="coupon-discount" name="">
                            <input type="hidden" class="coupon-discount-type" name="">
                            <input type="hidden" class="coupon-max-dis-amt" name="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>
                                    <b>Total</b>
                                </span>
                                <span>₹ <span class="total_price">0.00</span></span>
                                <input type="hidden" id="totalPrice" value="0">
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="m-1 d-flex justify-content-center">
                            <a href="./index" class="btn btn-sm btn-danger m-1"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back</a>
                            <button type="submit" name="staff_submit" class="btn btn-sm btn-success m-1"> <i class="fa fa-plus" aria-hidden="true"></i> Submit </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>