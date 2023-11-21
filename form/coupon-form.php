<?php
if ($couponsText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./coupon.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Coupon</a>
    </div>
<?php } ?>
<form action="./inc/coupon/coupon-<?= ($couponsText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($couponsText) ?>StaffForm">
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="coupon_code" class="coupon_code_label required">Coupon Code</label>
                <input type="text" class="form-control coupon_code" name="coupon_code" id="coupon_code" placeholder="Coupon Code" onchange="checkCoupon(this)" value="<?= $model->coupon_code ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="discount" class="discount_label required">Discount</label>
                <input type="text" class="form-control discount" id="discount" name="discount" placeholder="Discount" value="<?= $model->discount ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="discount_type" class="discount_type_label required">Discount Type</label>
                <select class="form-select discount_type" name="discount_type" id="discount_type">
                    <?php
                    foreach ($discountArr as $paymentModeKey => $paymentModeValue) {
                    ?>
                        <option value="<?= $paymentModeKey ?>" <?= ($model->discount_type == $paymentModeKey) ? 'selected' : '' ?>><?= $paymentModeValue ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="min_bill_amount" class="min_bill_amount_label required">Minimum Bill Amount</label>
                <input type="number" class="min_bill_amount form-control" maxlength="10" name="min_bill_amount" id="min_bill_amount" placeholder="Minimum Bill Amount" value="<?= $model->min_bill_amount ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="max_discount_amount" class="max_discount_amount_label required">Maximum Discount Amount</label>
                <input type="number" class="max_discount_amount form-control" maxlength="10" name="max_discount_amount" id="max_discount_amount" placeholder="Maximum Discount Amount" value="<?= $model->max_discount_amount ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="coupon_per_user" class="coupon_per_user_label required">Coupons Per User</label>
                <input type="number" class="coupon_per_user form-control" maxlength="10" name="coupon_per_user" id="coupon_per_user" placeholder="Coupons Per User" value="<?= $model->coupon_per_user ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="valid_till" class="valid_till_label required">Valid Till</label>
                <input type="text" class="form-control valid_till" name="valid_till" id="valid_till" value="<?= $model->valid_till ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="reward_point" class="reward_point_label required">Reward Points</label>
                <input type="number" class="reward_point form-control" maxlength="10" name="reward_point" id="amount_paid" placeholder="Reward Point" value="<?= $model->reward_point ?>">
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $couponsText ?> Coupon</button>
            </div>
        </div>
    </div>
</form>