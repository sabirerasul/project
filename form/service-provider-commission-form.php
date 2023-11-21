<form action="" method="post" id="ServiceProviderForm">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="./expense.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back to Service Provider</a>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="scom" class="service-commision_label">Select dates</label>
                <input type="text" class="form-control filter_date" name="daterange" value="Select date" id="filter_date">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="emp_gender" class="emp_gender_label required">Service type</label>
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
                <label for="emp_gender" class="emp_gender_label required">Commission for</label>
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

        <div class="col-md-2">
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" id="filter" name="filter" class="btn btn-primary btn-filter btn-block"><i class="fa fa-filter" aria-hidden="true"></i>Filter</button>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times" aria-hidden="true"></i>Clear</button>
                </div>
            </div>
        </div>


    </div>
</form>