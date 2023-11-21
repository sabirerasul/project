<?php
require_once "lib/db.php";
check_auth();
require_once "./classes/StockPurchase.php";
require_once "./classes/Stock.php";


$id = (isset($_GET['pid'])) ? $_GET['pid'] : 0;

$stockText = ($id != 0) ? 'Update' : 'Add';

if ($id != 0) {
    $model = fetch_object($db, "SELECT * FROM stock_purchase WHERE id='{$id}'");
    $stockModel = fetch_all($db, "SELECT * FROM stock WHERE stock_purchase_id='{$id}'");
} else {
    $model = new StockPurchase();

    $model->discount = 0;
    $model->shipping_charge = 0;
    $model->total_charge = 0;
    $model->amount_paid = 0;
    $model->pending_due = 0;

    $stockObj = new Stock();
    $stockObj->quantity = 1;
    $stockObj->mrp_price = 0;
    $stockObj->purchase_price = 0;
    $stockObj->sale_price = 0;
    $stockObj->total_price = 0;
    $stockModel[] = (array) $stockObj;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Product Stock Add - <?= SALONNAME ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="./css/site.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">

    <link rel="stylesheet" href="./css/pages/product-stock-add.css">

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('./comman/nav.php') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <form action="./inc/stock/product-stock-<?= strtolower($stockText) ?>.php" id="stock<?= $stockText ?>" method="post">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <h2 class="h2 text-gray-800 border shadow rounded d-block p-2">Purchase From Vendor / <?= $stockText ?> Stock</h2>
                            </div>
                            <div class="col-lg-3 w-20">
                                <div class="form-group">
                                    <label for="vendor">Product Vendor Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control vendor_name search_vendor_name" id="vendor" name="stock[vendor_name]" placeholder="Autocomplete (Name)" required autocomplete="off">
                                    <input type="hidden" name="stock[vendor_id]" id="vendor_id" value="<?= $model->vendor_id ?>">
                                    <input type="hidden" name="stock[branch_id]" id="branch_id" value="<?= BRANCHID ?>">
                                    <?php if (!empty($id)) { ?>
                                        <input type="hidden" name="stock[id]" value="<?= $model->id ?>">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-3 w-20">
                                <div class="form-group">
                                    <label for="cont">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control search_client_number" id="cont" name="stock[contact]" placeholder="Client Contact" maxlength="10" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-3 w-20">
                                <div class="form-group">
                                    <label for="gst_number" class="emp_email_label">GST Number</label>
                                    <input type="text" class="emp_email form-control" id="gst_number" name="stock[gst_number]" placeholder="GST Number" value="<?= $model->gst_number ?>">
                                </div>
                            </div>

                            <div class="col-lg-3 w-20">
                                <div class="form-group">
                                    <label for="invoice_number" class="invoice_number_label required">Invoice Give By Vendor </label>
                                    <input type="text" class="form-control invoice_number" id="invoice_number" onchange="checkInvoiceNumber(this)" name="stock[invoice_number]" placeholder="Invoice Number" value="<?= $model->invoice_number ?>" required>
                                    <div class="showErr"></div>
                                </div>
                            </div>

                            <div class="col-lg-3 w-20">
                                <div class="form-group">
                                    <label for="doa">Date Of Purchase <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control present_date" id="date" name="stock[purchase_date]" value="<?= $model->purchase_date ?>" required readonly>
                                </div>
                            </div>

                            <div class="col-lg-12">

                                <div class="table-responsive">
                                    <table id="catTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;"></th>
                                                <th style="width: 30%;">Product</th>
                                                <th style="width: 10%;">MRP</th>
                                                <th style="width: 10%;">Purchase Price</th>
                                                <th style="width: 10%;">Sale Price</th>
                                                <th style="width: 10%;">Quantity</th>
                                                <th style="width: 10%;">Exp. date</th>
                                                <th style="width: 10%;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($stockModel as $stockKey => $stockValue) {
                                                $productSingleModel = fetch_assoc($db, "SELECT * FROM product WHERE id='" . $stockValue['product_id'] . "'");
                                                $productTitle = !empty($productSingleModel) ? "{$productSingleModel['product']} ({$productSingleModel['volume']} {$productSingleModel['unit']})" : '';

                                            ?>

                                                <tr <?= ($stockKey == 0) ? 'id="service-provider-services"' : ''; ?>>

                                                    <td style="vertical-align: middle;">
                                                        <?= ($stockKey == 0) ? '<span class="sno"><i class="fas fa-ellipsis-v"></i></span>' : '<span class="sno text-danger" onclick="removeProduct(this)"><i class="fas fa-trash"></i></span>'; ?>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex" style="width:445px">
                                                            <div style="width:241px">
                                                                <input type="text" class="category-services form-control form-control-sm" name="stock_product_details[<?= $stockKey ?>][product]" onkeyup="searchProduct(this)" placeholder="Product (Autocomplete)" autocomplete="off" value="<?= $productTitle ?>" required>
                                                                <input type="hidden" name="stock_product_details[<?= $stockKey ?>][salon_product_id]" class="product_id" value="<?= $stockValue['product_id'] ?>">
                                                                <input type="hidden" name="stock_product_details[<?= $stockKey ?>][stock_record_id]" value="<?= $stockValue['id'] ?>">
                                                            </div>

                                                            <div style="width:100px" class="mx-1">
                                                                <input type="number" name="stock_product_details[<?= $stockKey ?>][volume]" class="qt form-control form-control-sm product_volume" placeholder="Volume" value="<?= $stockValue['volume'] ?>" required min="0" readonly>
                                                            </div>

                                                            <div style="width:100px">
                                                                <select class="form-control form-control-sm product_unit" name="stock_product_details[<?= $stockKey ?>][volume_unit]">
                                                                    <?php foreach ($unitArr as $unitKey => $unitValue) { ?>
                                                                        <option value="<?= $unitKey ?>" <?= ($unitKey == $stockValue['unit']) ? 'selected' : '' ?>><?= $unitValue ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 100px;">
                                                            <input type="number" name="stock_product_details[<?= $stockKey ?>][mrp_price]" value="<?= $stockValue['mrp_price'] ?>" class="form-control form-control-sm product_mrp" placeholder="0.00" required min="0">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 122px;">
                                                            <input type="number" name="stock_product_details[<?= $stockKey ?>][purchase_price]" value="<?= $stockValue['purchase_price'] ?>" class="form-control form-control-sm purchase_price" placeholder="0.00" onchange="changeSalePrice(this)" required min="0">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 100px;">
                                                            <input type="number" name="stock_product_details[<?= $stockKey ?>][sale_price]" value="<?= $stockValue['sale_price'] ?>" class="form-control form-control-sm sale_price" placeholder="0.00" required min="0">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 100px;">
                                                            <input type="number" class="form-control form-control-sm product_quantity" name="stock_product_details[<?= $stockKey ?>][quantity]" onchange="changeQuantity(this)" placeholder="0.00" value="<?= $stockValue['quantity'] ?>" min="0" required>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 100px;">
                                                            <input type="text" value="<?= $stockValue['exp_date'] ?>" class="form-control form-control-sm product_exp_date" name="stock_product_details[<?= $stockKey ?>][exp_date]" readonly required>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div style="width: 125px;"></div>
                                                        <input type="text" class="form-control form-control-sm product_total_price" name="stock_product_details[<?= $stockKey ?>][total_price]" placeholder="0.00" value="<?= $stockValue['total_price'] ?>" readonly>
                                                        <input type="hidden" class="original_price" value="<?= $stockValue['sale_price'] ?>">
                                                    </td>
                                                </tr>

                                            <?php } ?>

                                            <tr id="addBefore">
                                                <td colspan="8" class="text-right">
                                                    <button type="button" id="btnAdd" class="btn btn-success" onclick="addProduct()">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Product
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">Subtotal</td>
                                                <td>
                                                    <div style="display: inline;">INR <span id="sum"><?= $model->sub_total ?></span></div>
                                                    <input type="hidden" id="sum-input" value="0" name="stock[sub_total]" value="<?= $model->sub_total ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Discount</td>
                                                <td width="40%">
                                                    <input type="number" class="form-control total-discount-input" name="stock[discount]" value="<?= $model->discount ?>" placeholder="Discount Amount" onchange="setDiscount(this);checkDiscountLength(this)">
                                                </td>
                                                <td width="60%">
                                                    <select class="form-select total-discount-select" name="stock[discount_type]" onchange="setDiscount()">
                                                        <option value="percentage">%</option>
                                                        <option value="inr">INR</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Taxes</td>
                                                <td colspan="2">
                                                    <select name="stock[tax]" class="form-select appointment-tax" onchange="appointmentTax()">
                                                        <option value="">Select Taxes</option>
                                                        <?php foreach ($taxTypeArr as $taxTypeKey => $taxTypeValue) { ?>
                                                            <optgroup label="<?= ucfirst($taxTypeValue) ?> Taxes">
                                                                <?php

                                                                $gstModel = fetch_all($db, "SELECT * FROM gst_slab WHERE tax_type='{$taxTypeValue}' AND product_service_type='product' ORDER by gst ASC");
                                                                foreach ($gstModel as $gstKey => $gstVal) {
                                                                    $gstValue = (object) $gstVal;
                                                                ?>
                                                                    <option value="<?= $gstValue->id ?>" data-product-type="<?= $gstValue->product_service_type ?>" data-tax-type="<?= $gstValue->tax_type ?>" data-gst="<?= $gstValue->gst ?>" <?= ($model->tax == $gstValue->id) ? 'selected' : '' ?>><?= "GST on {$gstValue->product_service_type} ({$gstValue->gst} %)" ?></option>
                                                                <?php } ?>
                                                            </optgroup>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6">Shipping Charges</td>
                                                <td colspan="2">
                                                    <input type="number" id="shipping_charge" class="form-control" name="stock[shipping_charge]" placeholder="Total Amount" value="<?= $model->shipping_charge ?>" onchange="setShippingCharge()">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6">Total Charges</td>
                                                <td colspan="2">
                                                    <input type="number" id="total_charge" class="form-control" name="stock[total_charge]" placeholder="Total Amount" value="<?= $model->total_charge ?>" readonly>
                                                    <input type="hidden" id="original_total_charge">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6">Amount Paid</td>
                                                <td colspan="2">
                                                    <input type="number" id="amount_paid" class="form-control" name="stock[amount_paid]" placeholder="Total Amount" value="<?= $model->amount_paid ?>" onchange="advanceGiven()">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="total" colspan="6">
                                                    Payment Mode
                                                </td>

                                                <td colspan="2">
                                                    <select name="stock[payment_mode]" class="form-select adv-type" onchange="advanceGiven()">
                                                        <?php foreach ($paymentModeArr as $paymentModeKey => $paymentModeValue) { ?>
                                                            <option value="<?= $paymentModeKey ?>" <?= ($paymentModeKey == $model->payment_mode) ? 'selected' : '' ?>><?= $paymentModeValue ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    Amount Due/Credit
                                                    <p class="d-none"><span class="text-danger">Amount paid via installments : <span><b><span class="text-black">500.00</span></b></p>
                                                </td>
                                                <td colspan="2">
                                                    <input type="number" class="form-control" name="stock[pending_due]" id="pending_due" value="<?= $model->pending_due ?>" readonly>
                                                    <input type="hidden" id="installment_price" value="">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="8">
                                                    <textarea name="stock[notes]" class="form-control no-resize" rows="5" placeholder="Write notes about purchase here..." id="textArea"><?= $model->notes ?></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" id="btnStockAdd" class="btn btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i> <?= $stockText ?> Stock
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include('./comman/footer.php'); ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>





    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="./js/toastify-js.js"></script>
    <script src="./js/main.js"></script>
    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/pages/product-stock-add.js"></script>

    <script type="text/javascript" src="./js/datepicker.min.js"></script>
<?php include('./comman/loading.php'); ?>
</body>

</html>