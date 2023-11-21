<?php
$newVendorText = ($staffText == 'Update Vendor') ? 'update':'add';

?>
<form action="./inc/stock/product-vendor-<?=$newVendorText?>.php" method="post" id="<?=strtolower($newVendorText)?>ProductVendorForm">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="vendor_name" class="emp_name_label required">Enter Name </label>
                <input type="text" class="form-control emp_name" id="vendor_name" name="vendor_name" placeholder="Service Provider Name" value="<?=$model->vendor_name ?>" required>
                <div class="showErr"></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="contact" class="emp_number_label required">Contact Number </label>
                <input type="number" onkeyup="isNumberAlready(this)" class="emp_number form-control"  name="contact" id="contact" placeholder="Contact Number" value="<?=$model->contact?>" required>
                <div class="showErr"></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="email" class="emp_email_label">Email</label>
                <input type="email" class="emp_email form-control" id="email" name="email" placeholder="Email" value="<?=$model->email?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="gst_number" class="emp_email_label">GST Number</label>
                <input type="text" class="emp_email form-control" id="gst_number" name="gst_number" placeholder="Email" value="<?=$model->gst_number?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="addr">Address</label>
                <textarea class="form-control" id="addr" name="address" placeholder="Address" rows="3" style="width: 100%;"><?=$model->address?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="comp_details">Company Details</label>
                <textarea class="form-control" id="comp_details" name="company_details" placeholder="Company Details" rows="3" style="width: 100%;"><?=$model->company_details?></textarea>
            </div>
        </div>
        
        <?php
        if($editid != 0){ ?>
            <input type="hidden" name="eid" id="provider_id" value="<?=$model->id?>">
        <?php } ?>
        
        <hr>
        <div class="col-md-12 d-flex justify-content-center my-3">
            <div class="form-group ml-auto"> 
                <button type="submit" name="service_provider_submit" class="btn btn-success">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?=ucfirst($newVendorText)?> Vendor</button>
            </div>
        </div>
    </div>
</form>