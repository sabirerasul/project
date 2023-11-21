<form action="./inc/client/client-update.php" method="post" id="clientUpdate">
    <div class="row">

        <div class="col-12">
            <div class="alert alert-info" role="alert">
                <?= $model->client_name ?> - Client Since <?= formatDate($model->created_at) ?>
            </div>
        </div>

        <div class="col-12">
            <?php

            $serverError = isset($_SESSION['clientUpdateError']) ? $_SESSION['clientUpdateError'] : false;

            if ($serverError) {

                $alertType = ($serverError['success'] == true) ? 'success' : 'danger';

                echo '
                    <div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">
                    <strong></strong> ' . $serverError['errors']['error'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }


            ?>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12 ">
            <div class="form-group">
                <label for="userName">Client Name <span class="text-danger">*</span></label>
                <input type="text" name="client_name" value="<?= $model->client_name ?>" class="form-control" id="userName" placeholder="name" required="">
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Contact <span class="text-danger">*</span></label>
                <input type="number" maxlength="10" value="<?= $model->contact ?>" class="form-control" id="userName" placeholder="Number" name="contact">
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Email</label>
                <input type="text" name="email" value="<?= $model->email ?>" class="form-control" id="userName" placeholder="name@example.com">
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Gender <span class="text-danger">*</span></label>
                <select name="gender" data-validation="required" class="form-control">
                    <option value="">Select</option>

                    <?php
                    foreach ($genderArr as $genKey => $genValue) {
                    ?>
                        <option value="<?= $genKey ?>" <?= ($model->gender == $genKey) ? 'selected' : '' ?>><?= $genValue ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Date Of Birth</label>
                <input type="text" name="dob" value="<?= $model->dob ?>" class="form-control dob_annv_date user-dob" id="userName" placeholder="dd/mm/yyyy" autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Anniversary</label>
                <input type="text" name="anniversary" value="<?= $model->anniversary ?>" class="form-control dob_annv_date user-anniversary" id="userName" placeholder="dd/mm/yyyy" autocomplete="off" readonly>
            </div>
        </div>



        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="userName">Source Of Client</label>
                <select class="form-control" name="source_of_client">
                    <option value="">Select</option>

                    <?php
                    foreach ($sourceArr as $sourceKey => $sourceValue) {
                    ?>
                        <option value="<?= $sourceKey ?>" <?= ($model->source_of_client == $sourceKey) ? 'selected' : '' ?>>
                            <?= $sourceValue ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-xs-12">
            <div class="form-group">
                <label for="userName">Address</label>
                <textarea name="address" class="form-control" id="userName" placeholder="Address" style="width: 100%;" rows="3"><?= $model->address ?></textarea>
            </div>
        </div>

        <input type="hidden" name="cid" value="<?= $model->id ?>">
        <div class="clearfix"></div>
        <div class="col-md-12 my-3">

            <button type="submit" name="client_submit" class="btn btn-success d-block mx-auto">


                <i class="fas fa-edit"></i> Update Profile
            </button>
        </div>
    </div>
</form>