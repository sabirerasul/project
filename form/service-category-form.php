<?php

require_once "./classes/ServiceCategory.php";

$csid = (isset($_GET['csid'])) ? $_GET['csid'] : 0;
$categoryText = ($csid != 0) ? 'Edit' : 'Add';

if ($csid != 0) {
    $model = fetch_object($db, "SELECT * FROM service_category WHERE id='" . $csid . "'");
} else {
    $model = new ServiceCategory();
}
?>

<div class="modal fade" id="exampleModal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal1Label"><?=ucfirst($categoryText)?> Service Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./inc/service/service-category-<?= ($categoryText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($categoryText) ?>ServiceCategory">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="userName" class="service_category_label">Service Categroy <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="service_category_field" placeholder="categroy" value="<?= $model->name ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>
                        <?php
                        if ($csid != 0) { ?>
                            <input type="hidden" name="id" id="provider_id" value="<?= $model->id ?>">
                        <?php } ?>

                        <div class="col-md-12 pt-4 mt-2">

                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success add-new-client" name="service_category_submit">Save</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal1">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>