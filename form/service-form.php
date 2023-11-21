<?php
require_once "./classes/Service.php";
require_once "./classes/ServiceProduct.php";

$id = (isset($_GET['sid'])) ? $_GET['sid'] : 0;
$serviceText = ($id != 0) ? 'Edit' : 'Add';
$category = '';
if ($id != 0) {
    $model = fetch_object($db, "SELECT * FROM service WHERE id='" . $id . "'");

    $sql = "SELECT name FROM service_category WHERE id='" . $model->category_id . "' AND `status` = 1";
    $catModal = fetch_object($db, $sql);
    $category = $catModal->name;

    $productModel = fetch_all($db, "SELECT * FROM service_product WHERE service_id='" . $model->id . "'");

    if (count($productModel) == 0) {
        $productModel = (array) new ServiceProduct();
        $productModel['quantity_used'] = 1;
        $productModel2[] = $productModel;

        $productModel = $productModel2;
    }
} else {
    $model = new Service();
    //$productModel = new ServiceProduct();
    $productModel = (array) new ServiceProduct();
    $productModel['quantity_used'] = 1;
    $productModel2[] = $productModel;

    $productModel = $productModel2;

    //var_dump($productModel);
}

?>
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= ucfirst($serviceText) ?> Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="./inc/service/service-<?= ($serviceText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($serviceText) ?>Service">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="category_field" class="category_field_label">Service Categroy <span class="text-danger">*</span></label>
                                <input type="text" name="service[service_category]" class="form-control" id="category_field" placeholder="Category" value="<?= $category ?>">
                                <input type="hidden" name="service[category_id]" id="category_id" value="<?= $model->category_id ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="service_name" class="service_name_label">Service Name <span class="text-danger">*</span></label>
                                <input type="text" name="service[service_name]" class="form-control service_name" id="service_name" placeholder="Service name" value="<?= $model->service_name ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="service_price" class="service_price_label">Price <span class="text-danger">*</span></label>
                                <input type="number" name="service[price]" class="form-control service_price" id="service_price" placeholder="Price" value="<?= $model->price ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="membership_price" class="membership_price_label">Membership Price <span class="text-danger">*</span></label>
                                <input type="number" name="service[membership_price]" class="form-control membership_price" id="membership_price" placeholder="Membership Price" value="<?= $model->membership_price ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="duration" class="duration_label required">Service Duration</label>
                                <input type="number" class="duration form-control" id="duration" name="service[duration]" placeholder="In Minute" value="<?= $model->duration ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="reward_point" class="reward_point_label required">Reward Point</label>
                                <input type="number" class="reward_point form-control" id="reward_point" name="service[reward_point]" placeholder="Reward Point" value="<?= $model->reward_point ?>">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="service_for" class="service_for_label required">Service For</label>
                                <select class="form-select unit mx-1" id="service_for" name="service[service_for]">
                                    <!-- <option value="">Select</option> -->
                                    <?php
                                    foreach ($serviceForArr as $serviceForKey => $serviceForValue) {
                                    ?>
                                        <option value="<?= $serviceForKey ?>" <?= ($serviceForValue == $model->service_for) ? 'selected' : '' ?>><?= ucfirst($serviceForValue) ?></option>
                                    <?php } ?>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label for="hideOnService">&nbsp;</label>
                            <div class="form-group" id="hideOnService">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="service[hide_on_website]" type="checkbox" role="switch" id="flexSwitchCheckDefault" value="1" <?= ($model->hide_on_website == 1) ? 'checked':'' ?>>
                                    <label class="form-check-label" for="flexSwitchCheckDefault"> Hide on website</label>
                                </div>
                            </div>
                        </div>


                        <?php if ($id != 0) { ?>
                            <input type="hidden" name="service[id]" value="<?= $model->id ?>">
                        <?php } ?>

                        <div class="col-12 overflow-auto">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?=$serviceText?> Product Usage</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="catTable" class="table table-bordered" style="min-width:500px">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Quantity Used ( in units )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($productModel as $productModelKey => $productModelValue) {
                                            $productSingleModel = fetch_assoc($db, "SELECT * FROM product WHERE id='" . $productModelValue['product_id'] . "'");
                                            $productTitle = !empty($productSingleModel) ? "{$productSingleModel['product']} ({$productSingleModel['volume']} {$productSingleModel['unit']})" : '';
                                        ?>
                                            <tr <?= ($productModelKey == 0) ? 'id="service-provider-services"' : '' ?>>

                                                <td style="vertical-align: middle;">

                                                <?= ($productModelKey == 0) ? '<span class="sno"><i class="fas fa-ellipsis-v"></i></span>': '<span class="sno text-danger" onclick="removeServiceProviderServices(this)"><i class="fas fa-trash"></i></span>' ?>
                                                
                                                </td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-7 pr-1">
                                                            <input type="text" class="service-category form-control form-control-sm" onkeyup="searchProduct(this)" placeholder="Product (Autocomplete)" autocomplete="off" value="<?= $productTitle ?>">
                                                            <input type="hidden" class="product_id" name="service_product[<?=$productModelKey?>][product_id]" value="<?= $productModelValue['product_id'] ?>">
                                                            <input type="hidden" class="service_product_id" name="service_product[<?=$productModelKey?>][id]" value="<?= $productModelValue['id'] ?>">
                                                        </div>
                                                        <div class="col-3 pl-1">
                                                            <input type="number" name="service_product[<?=$productModelKey?>][volume]" class="volume form-control form-control-sm d-input" placeholder="volume" value="<?= $productModelValue['volume'] ?>">
                                                        </div>

                                                        <div class="col-2 pl-1">
                                                            <select class="form-select form-select-sm unit" name="service_product[<?=$productModelKey?>][unit]">
                                                                <?php
                                                                foreach ($unitArr as $unitKey => $unitValue) {
                                                                ?>
                                                                    <option value="<?= $unitKey ?>"<?= ($productModelValue['unit'] == $unitKey) ? 'selected' : '' ?>><?= $unitValue ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <input type="number" class="form-control form-control-sm quantity_used w-100" value="<?= $productModelValue['quantity_used'] ?>" placeholder="quantity used" step="0.1" name="service_product[<?=$productModelKey?>][quantity_used]">
                                                </td>
                                            </tr>

                                        <?php } ?>

                                        <tr id="addBefore">
                                            <td colspan="5" class="text-right">
                                                <button type="button" id="btnAdd" class="btn btn-success" onclick="addServiceProviderServices()">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Service
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 my-3">
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success add-new-client" name="service_submit">Save</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>