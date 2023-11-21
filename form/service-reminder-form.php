<?php
if ($serviceReminderText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./service-reminder.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Service Reminder</a>
    </div>
<?php } ?>
<form action="./inc/service-reminder/service-reminder-<?= ($serviceReminderText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($serviceReminderText) ?>StaffForm">
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="service_id" class="service_id_label required">Service</label>
                <input type="text" class="form-control service" onkeyup="searchService(this)" name="" id="service" value="<?= $service?>" placeholder="Service (Autocomplete)">
                <input type="hidden" class="service_id" name="service_id" id="service_id" value="<?= $model->service_id ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="interval_days" class="interval_days_label required">Interval days</label>
                <input type="number" class="interval_days form-control" maxlength="10" name="interval_days" min="0" max="365" id="interval_days" placeholder="Enter Amount Paid" value="<?= $model->interval_days ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="message" class="message_label required">Message</label>
                <textarea class="form-control message" id="message" name="message" placeholder="Enter Message" rows="3" style="width: 100%;"><?= empty($model->message) ? 
                '{name} &#13;&#10;Content goes here&#13;&#10;{salon_name}': $model->message ?></textarea>
                <p>Client name : {name} , Salon name : {salon_name}</p>
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $serviceReminderText ?> Reminder</button>
            </div>
        </div>
    </div>
</form>