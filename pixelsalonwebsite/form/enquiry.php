<?php

$allBranchArr = all_branch($db);
$serviceModel = fetch_all($db, "SELECT * FROM `service` WHERE status=1 AND hide_on_website=0 ORDER by `service_name` ASC");


?>

<form action="./inc/enquiry/enquiry-add.php" method="post" id="AddEnquiryForm">
    <div class="row mt-5">

        <div class="col-12 mb-3">
            <div class="alert alert-info" role="alert">
                You will receive all new offers and updates about our Salon via SMS and Email
            </div>
        </div>

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
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="contact" class="required form-label contact_label">Contact</label>
                <input type="number" class="form-control contact" id="contact" placeholder="Number" name="contact" maxlength="10">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="email" class="form-label email_label">Email</label>
                <input type="email" class="form-control email" id="email" placeholder="name@example.com" name="email">
                <div class="showErr"></div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="followdate" class="required form-label followdate_label">Date To Follow</label>
                <input type="text" class="form-control followdate" name="followdate" id="followdate" value="09/02/2023">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="enquiry_for" class="required form-label source_of_client_label">Interested in</label>
                <select class="form-control enquiry_for" id="enquiry_for" name="enquiry_for">
                    <option value="">Select</option>
                    <?php
                    foreach ($serviceModel as $serviceKey => $serviceVal) {
                        $serviceValue = (object) $serviceVal;
                    ?>
                        <option value="<?= $serviceValue->id ?>"><?= $serviceValue->service_name ?></option>
                    <?php } ?>
                </select>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="source_of_client" class="required form-label source_of_client_label">From where you heard about us?</label>
                <select class="form-control source_of_client" id="source_of_client" name="source_of_enquiry">
                    <option value="">Select</option>
                    <?php
                    foreach ($enquirySourceArr as $enquirySourceArrKey => $enquirySourceArrValue) {
                    ?>
                        <option value="<?= $enquirySourceArrKey ?>"><?= $enquirySourceArrValue ?></option>
                    <?php } ?>
                </select>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-12 d-flex justify-content-center my-5">
            <div class="form-group">

                <input type="hidden" name="address" value="">
                <input type="hidden" name="response" value="">
                <input type="hidden" name="leaduser" value="">
                <input type="hidden" class="enquiry_table_type" id="enquiry_table_type" name="enquiry_table_type" value="service">
                <input type="hidden" class="client_id" id="client_id" name="client_id" value="0">
                <input type="hidden" class="enquiry_type" id="enquiry_type" name="enquiry_type" value="Hot">
                <input type="hidden" name="status" value="Pending">
                <a href="./index" class="btn btn-danger"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back</a>
                <button type="submit" name="staff_submit" class="btn btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> Submit </button>
            </div>
        </div>

    </div>
</form>