<?php

$discountArr = [
    "percentage" => "%",
    "inr" => "INR",
];

$rewardPointBoostArr = [
    "1" => "1X",
    "2" => "2X",
    "3" => "3X",
    "4" => "4X",
];

$conditionArr = [
    "1" => "AND",
    "2" => "OR",
];

if ($membershipText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./membership.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Membership</a>
    </div>
<?php } ?>
<form action="./inc/membership/membership-<?= ($membershipText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($membershipText) ?>StaffForm">
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="membership_name" class="membership_name_label required">Membership Name</label>
                <input type="text" class="form-control membership_name" name="membership_name" id="membership_name" placeholder="Membership Name" value="<?= $model->membership_name ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="price" class="price_label required">Membership Price</label>
                <input type="text" class="form-control price" id="price" name="price" placeholder="Membership Price" value="<?= $model->price ?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="validity" class="validity_label required">Duration (in days start from day of purchase) </label>
                <input type="number" class="validity form-control" maxlength="10" name="validity" id="validity" placeholder="0" value="<?= $model->validity ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="reward_point" class="reward_point_label required">Reward Points On Purchase </label>
                <input type="number" class="reward_point form-control" maxlength="10" name="reward_point" id="reward_point" placeholder="0" value="<?= $model->reward_point ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="discount_on_service" class="discount_on_service_label required">Discount On Services </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" class="discount_on_service form-control" maxlength="10" name="discount_on_service" id="discount_on_service" placeholder="0" value="<?= $model->discount_on_service ?>">
                        <div class="showErr"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-select discount_on_service_type" name="discount_on_service_type" id="discount_on_service_type">
                            <?php
                            foreach ($discountArr as $discountOnServiceTypeKey => $discountOnServiceTypeValue) {
                            ?>
                                <option value="<?= $discountOnServiceTypeKey ?>" <?= ($model->discount_on_service_type == $discountOnServiceTypeKey) ? 'selected' : '' ?>><?= $discountOnServiceTypeValue ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="discount_on_product" class="discount_on_product_label required">Discount On Products </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" class="discount_on_product form-control" maxlength="10" name="discount_on_product" id="discount_on_product" placeholder="0" value="<?= $model->discount_on_product ?>">
                        <div class="showErr"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-select discount_on_product_type" name="discount_on_product_type" id="discount_on_product_type">
                            <?php
                            foreach ($discountArr as $discountOnProductTypeKey => $discountOnProductTypeValue) {
                            ?>
                                <option value="<?= $discountOnProductTypeKey ?>" <?= ($model->discount_on_product_type == $discountOnProductTypeKey) ? 'selected' : '' ?>><?= $discountOnProductTypeValue ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label for="discount_on_package" class="discount_on_package_label required">Discount On Packages </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" class="discount_on_package form-control" maxlength="10" name="discount_on_package" id="discount_on_package" placeholder="0" value="<?= $model->discount_on_package ?>">
                        <div class="showErr"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-select discount_on_package_type" name="discount_on_package_type" id="discount_on_package_type">
                            <?php
                            foreach ($discountArr as $discountOnPackageTypeKey => $discountOnPackageTypeValue) {
                            ?>
                                <option value="<?= $discountOnPackageTypeKey ?>" <?= ($model->discount_on_package_type == $discountOnPackageTypeKey) ? 'selected' : '' ?>><?= $discountOnPackageTypeValue ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="reward_point_boost" class="reward_point_boost_label required">Reward Points Boost</label>
                <select class="form-select reward_point_boost" name="reward_point_boost" id="reward_point_boost">
                    <?php
                    foreach ($rewardPointBoostArr as $rewardPointBoostKey => $rewardPointBoostValue) {
                    ?>
                        <option value="<?= $rewardPointBoostKey ?>" <?= ($model->reward_point_boost == $rewardPointBoostKey) ? 'selected' : '' ?>><?= $rewardPointBoostValue ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="min_reward_point_earned" class="min_reward_point_earned_label required">Min. Reward Points Earned </label>
                <input type="number" class="min_reward_point_earned form-control" maxlength="10" name="min_reward_point_earned" id="min_reward_point_earned" placeholder="0" value="<?= $model->min_reward_point_earned ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="membership_condition" class="membership_condition_label required">Condition</label>
                <select class="form-select membership_condition" name="membership_condition" id="membership_condition">
                    <?php
                    foreach ($conditionArr as $membershipConditionKey => $membershipConditionValue) {
                    ?>
                        <option value="<?= $membershipConditionKey ?>" <?= ($model->membership_condition == $membershipConditionKey) ? 'selected' : '' ?>><?= $membershipConditionValue ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="min_bill_amount" class="min_bill_amount_label required">Min. Billed Amount</label>
                <input type="number" class="min_bill_amount form-control" maxlength="10" name="min_bill_amount" id="min_bill_amount" placeholder="0" value="<?= $model->min_bill_amount ?>">
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $membershipText ?> Membership</button>
            </div>
        </div>
    </div>
</form>