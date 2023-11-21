<?php

$genderArr = [
    'male' => 'Male',
    'female' => 'Female'
];

?>

<form action="./inc/service-provider/service-provider-<?= ($staffText == 'Add') ? 'add' : 'update' ?>.php" method="post" enctype="multipart/form-data" id="<?= strtolower($staffText) ?>ServiceProviderForm">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="name" class="emp_name_label required">Enter Name </label>
                <input type="text" class="form-control emp_name" id="name" name="name" placeholder="Service Provider Name" value="<?= $model->name ?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="scom" class="service-commision_label">Service Commission %
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Advance service commission setting will available on service provider edit page.">
                        <i class="fa mr-left-0 fa-info-circle"></i>
                    </span>
                </label>
                <input type="number" class="form-control service-commision" name="service_commission" value="<?= $model->service_commission ?>" id="service_commision" placeholder="Service Commission">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="pcom" class="product-commision_label">Product Commission %
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Advance product commission setting will available on service provider edit page.">
                        <i class="fa mr-left-0 fa-info-circle"></i>
                    </span>
                </label>
                <input type="number" class="form-control product-commision" name="product_commission" value="<?= $model->product_commission ?>" id="product_commision" placeholder="Product Commission">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="cont" class="emp_number_label required">Contact Number </label>
                <input type="number" class="emp_number form-control" maxlength="10" name="contact_number" id="emp_number" placeholder="Contact Number" value="<?= $model->contact_number ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="cont" class="service_provider_type_label required">Service Provider Type </label>
                <input type="text" class="service_provider_type form-control" name="service_provider_type" id="service_provider_type" placeholder="Service Provider Type" value="<?= $model->service_provider_type ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="working_hours_start" class="working_hours_start_label required">Working Hours Start</label>
                <input type="text" class="form-control working_hours_start" id="working_hours_start" name="working_hours_start" placeholder="Start Time" value="<?= $model->working_hours_start ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="working_hours_end" class="working_hours_end_label required">Working Hours End</label>
                <input type="text" class="form-control working_hours_end" id="working_hours_end" name="working_hours_end" placeholder="End Time" value="<?= $model->working_hours_end ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="salary" class="emp_salary_label required">Monthly Salary</label>
                <input type="number" class="emp_salary form-control" id="month_sal" name="salary" placeholder="Monthly Salary" value="<?= $model->salary ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="userName" class="emp_username_label required">Username</label>
                <input type="text" class="emp_username form-control" name="" id="userName" placeholder="Username" value="<?= $username ?>" readonly>
                <input type="hidden" name="username" value="<?= $username ?>">
                <div class="showErr"></div>
            </div>
        </div>
        <?php /* ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="password" class="emp_password_label required">Password</label>
                <input type="password" class="emp_password form-control" name="password" id="password" placeholder="Password">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="confirm-password" class="emp_confirm_password_label required">Confirm password</label>
                <input type="password" class="emp_confirm_password form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                <div class="showErr"></div>
            </div>
        </div>
        <?php */ ?>

        <div class="col-md-3">
            <div class="form-group">
                <label for="emp_gender" class="emp_gender_label required">Gender</label>
                <select class="form-select emp_gender" id="emp_gender" class="emp_user_type" name="gender">
                    <option value="">Select</option>
                    <?php
                    foreach ($genderArr as $genKey => $genValue) {
                    ?>
                        <option value="<?= $genKey ?>" <?= ($model->gender == $genKey) ? 'selected' : '' ?>><?= $genValue ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="dob emp_dob_label">Date Of Birth</label>
                <input type="text" class="form-control emp_dob" id="dob" name="dob" readonly value="<?= $model->dob ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="email" class="emp_email_label">Email</label>
                <input type="email" class="emp_email form-control" id="email" name="email" placeholder="Email" value="<?= $model->email ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="econt">Emergency Contact Number</label>
                <input type="number" class="form-control" maxlength="10" name="emer_contact_number" id="econt" placeholder="Emergency Contact Number" value="<?= $model->emer_contact_number?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="eperson">Emergency Contact Person</label>
                <input type="text" class="form-control" id="eperson" name="emer_contact_person" placeholder="Emergency Contact Person" value="<?= $model->emer_contact_person ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="photo" class="photo_label">Upload Photo (file format: jpg,png | Size: 500kb)</label>
                <input type="file" class="form-control photo" id="photo" name="photo" placeholder="profile">
                <div class="showErr"></div>

                <?php
                if ($editid != 0) {
                    $photoImg = (!empty($model->photo)) ? $model->photo : 'male.png';
                    echo "<img src='" . $target_dir . $photoImg . "' class='img-responsive edit-avt-img img-thumbnail'>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="proof" class="id_front_proof_label">Upload Front ID Proof (file format: jpg,png,pdf | Size: 500kb)</label>
                <input type="file" class="form-control frontproof" id="id_front_proof" name="frontproof" placeholder="idproof">
                <div class="showErr"></div>

                <?php
                if ($editid != 0) {
                    $frontproofImg = (!empty($model->frontproof)) ? $model->frontproof : 'male.png';
                    echo "<embed src='" . $target_dir . $frontproofImg . "' class='img-responsive edit-avt-img img-thumbnail'></embed>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="proof" class="id_back_proof_label">Upload Back ID Proof (file format: jpg,png,pdf | Size: 500kb)</label>
                <input type="file" class="form-control backproof" id="id_back_proof" name="backproof" placeholder="idproof">
                <div class="showErr"></div>

                <?php
                if ($editid != 0) {
                    $backproofImg = (!empty($model->backproof)) ? $model->backproof : 'male.png';
                    echo "<embed src='" . $target_dir . $backproofImg . "' class='img-responsive edit-avt-img img-thumbnail'></embed>";
                }
                ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="addr">Address</label>
                <textarea class="form-control" id="addr" name="address" placeholder="Address" rows="3" style="width: 100%;"><?= $model->address ?></textarea>
            </div>
        </div>

        <?php
        if ($editid != 0) { ?>
            <input type="hidden" name="eid" id="provider_id" value="<?= $model->id ?>">
        <?php } ?>

        <input type="hidden" name="branch_id" value="<?=BRANCHID?>">

        <hr>
        <div class="col-md-12 d-flex justify-content-center my-3">
            <div class="form-group">
                <button type="submit" name="service_provider_submit" class="btn btn-success">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $staffText ?> Service Provider</button>
            </div>
        </div>
    </div>
</form>