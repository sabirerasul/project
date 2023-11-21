<?php

$employeeTypeArr = [
    "1" => "Service provider",
    "2" => "Staff"
];
$salaryArr = [
    "1" => "Salary",
    "2" => "Advance",
    "3" => "Incentives",
    "4" => "Bonus"
];



if ($id != 0) {
    $employeeTableName = ($model->employee_type == 1) ? "service_provider" : "employee";
    $employee_name = fetch_object($db, "SELECT * FROM {$employeeTableName} WHERE id={$model->employee_id}")->name;
} else {
    $employee_name = '';
}

if ($employeeSalaryText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./employee-salary.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Salary</a>
    </div>
<?php } ?>
<form action="./inc/employee-salary/employee-salary-<?= ($employeeSalaryText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($employeeSalaryText) ?>StaffForm">
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="date" class="date_label required">Date</label>
                <input type="text" class="form-control date" name="date" id="date" value="<?= $model->date ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="employee_type" class="employee_type_label required">Employee Type</label>
                <select class="form-select employee_type" name="employee_type" id="employee_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($employeeTypeArr as $paymentModeKey => $paymentModeValue) {
                    ?>
                        <option value="<?= $paymentModeKey ?>" <?= ($model->employee_type == $paymentModeKey) ? 'selected' : '' ?>><?= $paymentModeValue ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="employee" class="employee_label required">Employee Name</label>
                <input type="text" class="form-control employee" id="employee" onkeyup="searchEmployee(this)" placeholder="Name" value="<?= $employee_name ?>">
                <input type="hidden" name="employee_id" id="employee_id" class="employee_id" value="<?= $model->employee_id ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="salary_type" class="salary_type_label required">Salary Type</label>
                <select class="form-select salary_type" name="salary_type" id="salary_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($salaryArr as $paymentModeKey => $paymentModeValue) {
                    ?>
                        <option value="<?= $paymentModeKey ?>" <?= ($model->salary_type == $paymentModeKey) ? 'selected' : '' ?>><?= $paymentModeValue ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="amount" class="amount_label required">Amount</label>
                <input type="number" class="amount form-control" maxlength="10" name="amount" id="amount" placeholder="Enter Amount" value="<?= $model->amount ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="comments" class="comments_label required">Comments</label>
                <textarea class="form-control comments" id="comments" name="comments" placeholder="Enter Description" rows="3" style="width: 100%;"><?= $model->comments ?></textarea>
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $employeeSalaryText ?> Salary</button>
            </div>
        </div>
    </div>
</form>