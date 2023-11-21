<?php

if ($id != 0) {
    $expense_type = fetch_object($db, "SELECT * FROM expense_type WHERE id='" . $model->expense_type_id . "'")->title;
    $recipient_name = fetch_object($db, "SELECT * FROM expense_recipient WHERE id='" . $model->recipient_name_id . "'")->recipient_name;
} else {
    $expense_type = '';
    $recipient_name = '';
}


if ($expensesText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./expense.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back to Expense</a>
    </div>
<?php } ?>
<form action="./inc/expense/expense-<?= ($expensesText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($expensesText) ?>StaffForm">
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="date" class="today_date_label required">Date</label>
                <input type="text" class="form-control today_date" name="date" id="date" value="<?= $model->date ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="expense_type" class="expense_type_label required">Type Of Expense</label>
                <input type="text" class="form-control expense_type" id="expense_type" name="expense_type" placeholder="Enter Category" value="<?= $expense_type ?>">
                <input type="hidden" class="expense_type_id" id="expense_type_id" name="expense_type_id" value="<?= $model->expense_type_id ?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="amount_paid" class="amount_paid_label required">Amount Paid</label>
                <input type="number" class="amount_paid form-control" maxlength="10" name="amount_paid" id="amount_paid" placeholder="Enter Amount Paid" value="<?= $model->amount_paid ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="payment_mode" class="payment_mode_label required">Mode Of Payment</label>
                <select class="form-select payment_mode" name="payment_mode" id="payment_mode">
                    <option value="">Select</option>
                    <?php
                    foreach ($paymentModeArr as $paymentModeKey => $paymentModeValue) {
                    ?>
                        <option value="<?= $paymentModeKey ?>" <?= ($model->payment_mode == $paymentModeKey) ? 'selected' : '' ?>><?= $paymentModeValue ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="recipient_name" class="recipient_name_label required">Recipient Name</label>
                <input type="text" class="form-control recipient_name" id="recipient_name" name="recipient_name" placeholder="Enter Recipient name" value="<?= $recipient_name ?>">
                <input type="hidden" class="recipient_name_id" id="recipient_name_id" name="recipient_name_id" value="<?= $model->recipient_name_id ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="description" class="description_label required">Description</label>
                <textarea class="form-control description" id="description" name="description" placeholder="Enter Description" rows="3" style="width: 100%;"><?= $model->description ?></textarea>
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $expensesText ?> Expenses</button>
            </div>
        </div>
    </div>
</form>