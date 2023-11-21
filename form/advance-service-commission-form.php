<?php

$productModel1 = fetch_all($db, "SELECT * FROM service_product_commission WHERE sp_id='" . $model->id . "' AND type='service'");

if (count($productModel1) == 0) {
    $productModel1 = (array) new ServiceProductCommission();
    $productModel1['type'] = 'service';
    $productModel12[] = $productModel1;
    $productModel1 = $productModel12;
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
            foreach ($productModel1 as $productModel1Key => $productModel1Value) {
            ?>
                <tr <?= ($productModel1Key == 0) ? 'id="service-provider-services1"' : '' ?>>
                    <td style="vertical-align: middle;">
                        <?= ($productModel1Key == 0) ? '<span class="sno"><i class="fas fa-ellipsis-v"></i></span>' : '<span class="sno text-danger" onclick="removeServiceCommissionRow(this)"><i class="fas fa-trash"></i></span>' ?>
                    </td>
                    <td>
                        <input type="number" class="form-control sale_from1" id="sale_from1" name="commission[<?= $productModel1Key ?>][sale_from]" value="<?= $productModel1Value['sale_from'] ?>" min="0" placeholder="10000" required>
                        <input type="hidden" class="commission_id1" name="commission[<?= $productModel1Key ?>][id]" value="<?= $productModel1Value['id'] ?>">
                        <input type="hidden" class="commission_type1" name="commission[<?= $productModel1Key ?>][type]" value="<?= $productModel1Value['type'] ?>">
                        <input type="hidden" class="commission_sp_id1" name="commission[<?= $productModel1Key ?>][sp_id]" value="<?= $model->id ?>">
                    </td>
                    <td>
                        <input type="number" placeholder="100000" class="form-control sale_to1" id="sale_to1" name="commission[<?= $productModel1Key ?>][sale_to]" value="<?= $productModel1Value['sale_to'] ?>" min="0" required>
                    </td>
                    <td>
                        <input type="number" placeholder="10%" class="form-control commission1" id="commission1" name="commission[<?= $productModel1Key ?>][commission]" value="<?= $productModel1Value['commission'] ?>" min="0" required>
                    </td>
                </tr>

            <?php } ?>

            

            <tr id="addServiceBefore">
                <td colspan="4" class="text-right">
                    <button type="button" id="btnAdd" class="btn btn-success" onclick="addServiceCommisionRow()">
                        <i class="fa fa-plus" aria-hidden="true"></i> add more
                    </button>
                </td>
            </tr>

            <input type="hidden" name="service_provider_id" value="<?= $model->id ?>">
            <input type="hidden" name="commission_type" value="<?= $productModel1Value['type'] ?>">
            
        </tbody>
    </table>
</div>