<?php

if ($SmsMessageText != 'Add') { ?>
    <div class="col-12 mb-3">
        <a href="./sms-message.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back to SMS Message</a>
    </div>
<?php } ?>
<form action="./inc/sms-panel/sms-message-<?= ($SmsMessageText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($SmsMessageText) ?>StaffForm">
    <div class="row">

        <div class="col-md-3">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="sms_title" class="sms_title_label required">Message Title</label>
                        <input type="text" class="form-control sms_title" id="sms_title" name="sms_title" placeholder="Title" value="<?= $model->sms_title ?>">
                        <div class="showErr"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="template_id" class="template_id_label required">SMS Template</label>
                        <select class="form-select template_id" name="template_id" id="template_id" onchange="changeSMSTemplate(this)">
                            <option value="">Select</option>
                            <?php
                            foreach ($allSmsTemplateModel as $sallSmsTemplateModelKey => $sallSmsTemplateModelValue) {

                                $smsTemplateText = '';
                                if ($model->template_id == $sallSmsTemplateModelValue['id']) {
                                    $smsTemplateText = empty($model->message) ? $sallSmsTemplateModelValue['template'] : $model->message;
                                } else {
                                    $smsTemplateText = $sallSmsTemplateModelValue['template'];
                                }

                            ?>
                                <option value="<?= $sallSmsTemplateModelValue['id'] ?>" data-template-value="<?= $smsTemplateText ?>" <?= ($model->template_id == $sallSmsTemplateModelValue['id']) ? 'selected' : '' ?>><?= $sallSmsTemplateModelValue['template_title'] ?></option>
                            <?php } ?>

                        </select>
                        <input type="hidden" name="branch_id" value="<?= BRANCHID ?>">
                        <input type="hidden" name="date" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9">
            <div class="form-group">
                <label for="description" class="message_label required">Message</label>
                <textarea class="form-control description" id="message" name="message" placeholder="Enter Message" rows="5" style="width: 100%;"><?= $model->message ?></textarea>
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
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $SmsMessageText ?> SMS Message</button>
            </div>
        </div>
    </div>
</form>