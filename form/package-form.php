<div class="col-lg-12">

    <div class="table-responsive">
        <form action="./inc/package/package-<?= ($packageText == 'Add') ? 'add' : 'update' ?>.php" method="post" id="<?= strtolower($packageText) ?>Package">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_name" class="package_name_label required">Name Of Package</label>
                            <input type="text" class="form-control package_name" id="package_name" name="package[package_name]" placeholder="Package Name" value="<?= $model->package_name ?>" onchange="checkPackage(this)">
                            <div class="showErr"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_duration" class="package_duration_label required">Duration (in days start from day of purchase)</label>
                            <input type="text" class="form-control package_duration" id="package_duration" name="package[duration]" placeholder="0" value="<?= $model->duration ?>">
                            <div class="showErr"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_validity" class="package_validity_label required">Package Validity Till</label>
                            <input type="text" class="form-control package_validity" id="package_validity" autocomplete="off" name="package[package_validity]" placeholder="Valid Till" value="<?= $model->package_validity ?>">
                            <div class="showErr"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_price" class="package_price_label required">Package Price</label>
                            <input type="text" class="form-control package_price" id="package_price" name="package[price]" placeholder="Price" value="<?= $model->price ?>" onchange="countPackage()">
                            <div class="showErr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="catTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Category</th>
                        <th>Service</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($productModel as $productModelKey => $productModelValue) {
                        $serviceModel = fetch_assoc($db, "SELECT * FROM service WHERE id='" . $productModelValue['service_id'] . "'");
                        $serviceTitle = !empty($serviceModel) ? "{$serviceModel['service_name']}" : '';

                        $serviceModelPrice = !empty($serviceModel['price']) ? $serviceModel['price'] : '';

                        $ServiceCategoryTitle = (!empty($serviceModel) && !empty($serviceModel['category_id'])) ? fetch_object($db, "SELECT * FROM service_category WHERE id='" . $serviceModel['category_id'] . "'")->name : '';
                    ?>
                        <tr <?= ($productModelKey == 0) ? 'id="service-provider-services"' : '' ?>>


                            <td style="vertical-align: middle;">

                                <?= ($productModelKey == 0) ? '<span class="sno"><i class="fas fa-ellipsis-v"></i></span>' : '<span class="sno text-danger" onclick="removeServiceProviderServices(this)"><i class="fas fa-trash"></i></span>' ?>

                            </td>

                            <td>
                                <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" placeholder="Category" value="<?= $ServiceCategoryTitle ?>" required>
                                <input type="hidden" class="category_id" value="">
                                <?php
                                if ($id != 0) { ?>
                                    <input type="hidden" class="package_id" name="package_service[<?= $productModelKey ?>][id]" value="<?= $productModelValue['id'] ?>">
                                <?php } ?>
                            </td>

                            <td>
                                <input type="text" name="" class="category-services form-control form-control-sm d-input" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" value="<?= $serviceTitle ?>" required>
                                <input type="hidden" name="package_service[<?= $productModelKey ?>][service_id]" class="service_id" value="<?= $productModelValue['service_id'] ?>">
                            </td>

                            <td>
                                <input type="number" name="package_service[<?= $productModelKey ?>][quantity]" class="quantity form-control form-control-sm d-input" onchange="changeQuantity(this)" placeholder="Quantity" value="<?= $productModelValue['quantity'] ?>" required>
                            </td>

                            <td>
                                <input type="number" class="form-control form-control-sm price w-100" placeholder="Price" name="package_service[<?= $productModelKey ?>][price]" onchange="countPackage()" value="<?= $productModelValue['price'] ?>" required>
                                <input type="hidden" class="original_price" value="<?= $serviceModelPrice ?>">
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

                    <tr>
                        <td colspan="4">Package Worth</td>
                        <td colspan="1">Rs. <span id="package_worth">0</span></td>
                    </tr>
                    <tr>
                        <td colspan="4">Total Savings In INR</td>
                        <td colspan="1">Rs. <span id="total_saving_inr">0</span></td>
                    </tr>
                    <tr>
                        <td colspan="4">Total Savings In %</td>
                        <td colspan="1"><span id="total_saving_per">0.00</span>%</td>
                        <?php if ($id != 0) { ?>
                            <input type="hidden" name="package[id]" value="<?= $model->id ?>">
                        <?php } ?>
                    </tr>
                </tbody>
            </table>

            <div class="text-right">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>