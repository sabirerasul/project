<?php

if ($gstText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./expense.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back to Expense</a>
    </div>
<?php } ?>
<form action="./inc/gst-slab/gst-slab-<?= ($gstText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($gstText) ?>StaffForm">
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label for="product_service_type" class="product_service_type_label required">Service/Product</label>
                <select class="form-select product_service_type" name="product_service_type" id="product_service_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($productServiceArr as $productServiceKey => $productServiceValue) {
                    ?>
                        <option value="<?= $productServiceValue ?>" <?= ($model->product_service_type == $productServiceArr) ? 'selected' : '' ?>><?= $productServiceValue ?></option>
                    <?php } ?>

                </select>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="tax_type" class="tax_type_label required">Tax Type</label>
                <select class="form-select tax_type" name="tax_type" id="tax_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($taxTypeArr as $taxTypeKey => $taxTypeValue) {
                    ?>
                        <option value="<?= $taxTypeValue ?>" <?= ($model->tax_type == $taxTypeValue) ? 'selected' : '' ?>><?= $taxTypeValue ?></option>
                    <?php } ?>

                </select>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="gst" class="gst_label required">GST Slab</label>
                <input type="number" class="gst form-control" maxlength="10" name="gst" id="gst" placeholder="In Percentage" value="<?= $model->gst ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <?php
        if ($id != 0) { ?>
            <input type="hidden" name="id" value="<?= $model->id ?>">
        <?php } ?>

        <hr>
        <div class="col-md-12 d-flex justify-content-center my-3">
            <div class="form-group">
                <button type="submit" name="staff_submit" class="btn btn-success">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $gstText ?> GST</button>
            </div>
        </div>
    </div>
</form>