<?php

$productModel2 = fetch_all($db, "SELECT * FROM service_product_commission WHERE sp_id='" . $model->id . "' AND type='product'");

if (count($productModel2) == 0) {
    $productModel2 = (array) new ServiceProductCommission();
    $productModel2['type'] = 'product';
    $productModel22[] = $productModel2;
    $productModel2 = $productModel22;
}

?>

<div class="table-responsive">
    <table id="catTable" class="table table-bordered adv-service-comm-table">
        <thead>
            <tr>
                <th></th>
                <th>From</th>
                <th>To</th>
                <th>Commission %</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($productModel2 as $productModel2Key => $productModel2Value) {
            ?>
                <tr <?= ($productModel2Key == 0) ? 'id="service-provider-services2"' : '' ?>>
                    <td style="vertical-align: middle;">
                        <?= ($productModel2Key == 0) ? '<span class="sno"><i class="fas fa-ellipsis-v"></i></span>' : '<span class="sno text-danger" onclick="removeProductCommissionRow(this)"><i class="fas fa-trash"></i></span>' ?>
                    </td>
                    <td>
                        <input type="number" class="form-control sale_from2" id="sale_from2" name="commission[<?= $productModel2Key ?>][sale_from]" value="<?= $productModel2Value['sale_from'] ?>" min="0" placeholder="10000" required>
                        <input type="hidden" class="commission_id2" name="commission[<?= $productModel2Key ?>][id]" value="<?= $productModel2Value['id'] ?>">
                        <input type="hidden" class="commission_type2" name="commission[<?= $productModel2Key ?>][type]" value="<?= $productModel2Value['type'] ?>">
                        <input type="hidden" class="commission_sp_id2" name="commission[<?= $productModel2Key ?>][sp_id]" value="<?= $model->id ?>">
                    </td>
                    <td>
                        <input type="number" placeholder="100000" class="form-control sale_to2" id="sale_to2" name="commission[<?= $productModel2Key ?>][sale_to]" value="<?= $productModel2Value['sale_to'] ?>" min="0" required>
                    </td>
                    <td>
                        <input type="number" placeholder="10%" class="form-control commission2" id="commission2" name="commission[<?= $productModel2Key ?>][commission]" value="<?= $productModel2Value['commission'] ?>" min="0" required>
                    </td>
                </tr>

            <?php } ?>

            <tr id="addProductBefore">
                <td colspan="4" class="text-right">
                    <button type="button" id="btnAdd" class="btn btn-success" onclick="addProductCommisionRow()">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add More
                    </button>
                </td>
            </tr>

            <input type="hidden" name="service_provider_id" value="<?= $model->id ?>">
            <input type="hidden" name="commission_type" value="<?= $productModel2Value['type'] ?>">
            
        </tbody>
    </table>
</div>