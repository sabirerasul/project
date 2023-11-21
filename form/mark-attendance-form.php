<?php

$branch_id = BRANCHID;
$serviceProvider = fetch_all($db, "SELECT * FROM service_provider WHERE status=1 AND `branch_id`='{$branch_id}' ORDER by name ASC");
$employee = fetch_all($db, "SELECT * FROM employee ORDER by name ASC");

$serviceProviderArr = [];
foreach ($serviceProvider as $key2 => $value2) {
    $serviceProviderArr[$key2] = $value2;
    $serviceProviderArr[$key2]['type'] = 'Service Provider';
}

$employeeArr = [];
foreach ($employee as $key1 => $value1) {
    $employeeArr[$key1] = $value1;
    $employeeArr[$key1]['type'] = 'Staff';
}

$modal = array_merge($serviceProviderArr, $employeeArr);

?>

<form action="./inc/expenses/expenses-add.php" method="post" id="StaffForm">
    <div class="row">

        <div class="col-md-2">
            <div class="form-group">
                <label for="doa">Attendance Is On <span class="text-danger">*</span></label>
                <input type="text" class="form-control present_date" id="date" name="date" required readonly>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="payment_mode" class="payment_mode_label required">Service Provider / Staff</label>
                <select class="form-select payment_mode" name="payment_mode" id="payment_mode">
                    <?php
                    foreach ($modal as $modelKey => $modelValue) {
                        $employee_type = ($modelValue['type'] == 'Staff') ? 'staff' : 'service_provider';
                    ?>
                        <option value="<?= $modelValue['id'] ?>" data-type="<?= $employee_type ?>"><?= $modelValue['name'] ?> (<?= $modelValue['contact_number'] ?>)</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="date" class="today_date_label required">Time</label>
                <input type="text" class="form-control today_date" name="date" id="date" required readonly>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="submitBtn">Mark Attendance</label>
                <button type="button" id="submitBtn" onclick="checkIn()" name="staff_submit" class="form-control btn btn-success m-1"> <i class="fa fa-plus" aria-hidden="true"></i> Mark</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="submitBtn">Mark Absent</label>
                <button type="button" id="submitBtn1" onclick="absent()" name="staff_submit" class="form-control btn btn-danger m-1"> <i class="fa fa-door-closed" aria-hidden="true"></i> Absent</button>
            </div>
        </div>
    </div>
</form>