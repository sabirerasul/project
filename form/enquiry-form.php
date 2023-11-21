<?php


$leadUserArr = fetch_all($db, "SELECT * FROM employee WHERE status='1' ORDER by name ASC");

$clientModel = fetch_assoc($db, "SELECT * FROM client WHERE id='{$model->client_id}'");

$clientText = ($clientModel != '') ? $clientModel['client_name'] : '';

$arrayField = [
    'service' => 'service_name',
    'membership' => 'membership_name',
    'package' => 'package_name',
    'stock' => 'product_id'
];

if ($id != 0) {

    $enquiryForModel = fetch_object($db, "SELECT * FROM {$model->enquiry_table_type} WHERE id='{$model->enquiry_for}'");

    $fieldName = $arrayField[$model->enquiry_table_type];
    //$enquiryForText = $enquiryForModel->$fieldName;

    if ($model->enquiry_table_type == 'stock') {
        $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
        $enquiryForText = $productModel->product;
    } else {
        $enquiryForText = $enquiryForModel->$fieldName;
    }

} else {
    $enquiryForText = '';
}




?>
<form action="./inc/enquiry/enquiry-<?= ($enquiryText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= $enquiryText ?>EnquiryForm">
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label for="client_name" class="client_id_label required">Client Name</label>
                <input type="text" class="form-control client_name" id="client_name" name="client_name" placeholder="Client Name" value="<?= $clientText ?>">
                <input type="hidden" class="client_id" id="client_id" name="client_id" value="<?= $model->client_id ?>">
                <input type="hidden" class="banch_id" id="branch_id" name="branch_id" value="<?= BRANCHID ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="contact" class="contact_label required">Contact Number</label>
                <input type="number" class="contact form-control" maxlength="10" name="contact" id="contact" placeholder="Contact Number" value="<?= $model->contact ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="email" class="email_label">Email</label>
                <input type="text" class="email form-control" name="email" id="email" placeholder="Email" value="<?= $model->email ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="followdate" class="followdate_label required">Date To Follow</label>
                <input type="text" class="form-control followdate" name="followdate" id="followdate" value="<?= $model->followdate ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="enquiry_for_title" class="enquiry_for_title_label required">Enquiry For</label>
                <input type="text" class="form-control enquiry_for_title" id="enquiry_for_title" placeholder="Services / Products / Packages / Membership" value="<?= $enquiryForText ?>">
                <input type="hidden" class="enquiry_for" id="enquiry_for" name="enquiry_for" value="<?= $model->enquiry_for ?>">
                <input type="hidden" class="enquiry_table_type" id="enquiry_table_type" name="enquiry_table_type" value="<?= $model->enquiry_table_type ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="enquiry_type" class="enquiry_type_label required">Enquiry Type</label>
                <select class="form-select enquiry_type" name="enquiry_type" id="enquiry_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($enquiryTypeArr as $enquiryTypeKey => $enquiryTypeValue) {
                    ?>
                        <option value="<?= $enquiryTypeKey ?>" <?= ($model->enquiry_type == $enquiryTypeValue) ? 'selected' : '' ?>><?= $enquiryTypeValue ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="source_of_enquiry" class="source_of_enquiry_label required">Source Of Enquiry</label>
                <select class="form-select source_of_enquiry" name="source_of_enquiry" id="source_of_enquiry">
                    <option value="">Select</option>
                    <?php
                    foreach ($enquirySourceArr as $enquirySourceArrKey => $enquirySourceArrValue) {
                    ?>
                        <option value="<?= $enquirySourceArrKey ?>" <?= ($model->source_of_enquiry == $enquirySourceArrValue) ? 'selected' : '' ?>><?= $enquirySourceArrValue ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="leaduser" class="leaduser_label">Lead Representative</label>
                <select class="form-select leaduser" name="leaduser" id="leaduser">
                    
                    <option value="1" <?=($model->leaduser == 1) ? 'selected':''?>>Admin</option>
                    <?php
                    foreach ($leadUserArr as $leadUserKey => $leadUserValue) {
                    ?>
                        <option value="<?= $leadUserValue['id'] ?>" <?= ($model->leaduser == $leadUserValue['id']) ? 'selected' : '' ?>><?= $leadUserValue['name'] ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="address" class="address_label">Address</label>
                <textarea class="form-control address" id="address" name="address" placeholder="Address" rows="3"><?= $model->address ?></textarea>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="response" class="response_label">Response</label>
                <textarea class="form-control response" id="response" name="response" placeholder="Response" rows="3"><?= $model->response ?></textarea>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="status" class="status_label required">Lead Status</label>
                <select class="form-select status" name="status" id="status">
                    <?php
                    foreach ($leadStatus as $leadStatusKey => $leadStatusValue) {
                    ?>
                        <option value="<?= $leadStatusValue ?>" <?= ($model->status == $leadStatusValue) ? 'selected' : '' ?>><?= $leadStatusValue ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <?php
        if ($id != 0) { ?>
            <input type="hidden" name="id" value="<?= $model->id ?>">
        <?php } ?>

        <hr>
        <div class="col-md-12 d-flex justify-content-center my-3">
            <div class="form-group">

                <?php if ($model->status == "Converted" || $model->status == "Close") { ?>
                    <a href="./enquiry.php" class="btn btn-danger"> <i class="fas fa-angle-left" aria-hidden="true"></i> Go Back</a>
                <?php } else { ?>
                    <button type="submit" name="staff_submit" class="btn btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> <?= $enquiryText ?> Enquiry</button>
                <?php } ?>
            </div>
        </div>
    </div>
</form>