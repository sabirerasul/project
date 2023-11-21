<?php

$unitArr = [
    'l' => 'l',
    'ml' => 'ml',
    'mg' => 'mg',
    'gram' => 'gram',
    'pcs' => 'pcs',
    'pkt' => 'pkt',
];

?>

<div class="row">
    <div class="col-12 mb-4">
        <div class="border shadow rounded p-2 d-flex justify-content-between">
            <h2 class="h2 text-gray-800 m-0"><?= ucfirst($productText) ?> Product</h2>
        </div>
    </div>
</div>

<form action="./inc/stock/product-<?= $productText ?>.php" method="post" id="<?= $productText ?>Product">

    <div class="row">


        <?php
        if ($editid != 0) { ?>
            <div class="col-12 mb-3">
                <a href="./product.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Product</a>
            </div>

        <?php } ?>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="product" class="product_label">Product <span class="text-danger">*</span></label>
                <input type="text" name="product" onchange="isProductAlready(this)" class="product form-control" id="product_field" placeholder="Product Title" value="<?= $model->product ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="volume" class="volume_label">Volume <span class="text-danger">*</span></label>
                <input type="number" name="volume" class="volume form-control" id="volume" placeholder="Volume" value="<?= $model->volume ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="unit" class="unit_label">Unit <span class="text-danger">*</span></label>
                <select class="form-select unit mx-1" id="unit" name="unit">
                    <option value="">Select Unit</option>
                    <?php
                    foreach ($unitArr as $unitKey => $unitValue) {
                    ?>
                        <option value="<?= $unitValue ?>" <?= ($unitValue == $model->unit) ? 'selected' : '' ?>><?= ucfirst($unitValue) ?></option>
                    <?php } ?>
                </select>
                <div class="showErr"></div>
            </div>
        </div>


        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="price" class="price_label">MRP <span class="text-danger">*</span></label>
                <input type="number" name="mrp" class="price form-control" id="price" placeholder="Price" value="<?= $model->mrp ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="barcode" class="barcode_label">Barcode </label>
                <input type="text" name="barcode" class="barcode form-control" id="barcode" placeholder="Enter barcode" value="<?= $model->barcode ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="reward_point_on_purchase" class="reward_point_on_purchase_label">Reward Points On Purchase</label>
                <input type="number" name="reward_point_on_purchase" class="reward_point_on_purchase form-control" id="reward_point_on_purchase" placeholder="Reward Point" value="<?= $model->reward_point_on_purchase ?>">
                <div class="showErr"></div>
            </div>
        </div>


        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="form-group">
                <label for="submitBtn" class="">&nbsp; </label>
                <button type="submit" id="submitBtn" name="product_submit" class="btn btn-success d-block mx-auto">
                    <i class="fas fa-plus"></i> <?= ucfirst($productText) ?> Product
                </button>
            </div>
        </div>

        <?php
        if ($editid != 0) { ?>
            <input type="hidden" name="id" value="<?= $model->id ?>">
        <?php } ?>





        <div class="col-md-12">

            <div class="form-group">
                
            </div>

        </div>
    </div>
</form>