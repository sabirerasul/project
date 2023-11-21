<?php
require("lib/db.php");
extract($_REQUEST);

if (!isset($inv)) {
    header('location: ./index.php');
}
$billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$inv}'");
$billingProductModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billingModel->id}'");
$billingPaymentModel = fetch_all($db, "SELECT * FROM `client_billing_payment` WHERE `billing_id`='{$billingModel->id}'");

$membershipModel = fetch_object($db, "SELECT * FROM membership WHERE id='{$billingModel->membership_id}'");
$membershipName = !empty($membershipModel) ? $membershipModel->membership_name : '';
$paymentMode = '';

foreach ($billingPaymentModel as $billingPaymentKey => $billingPaymentVal) {
    $paymentMode .= "<br>" . $appointmentPaymentModeArr[$billingPaymentVal['method']];
}

$clientModel = fetch_object($db, "SELECT * FROM `client` WHERE `id`='{$billingModel->client_id}'");
$branchModel = fetch_object($db, "SELECT * FROM `branch` WHERE `id`='{$billingModel->branch_id}'");

$SALONNAME = $branchModel->salon_name;
$BRANDLOGO = "./web/salon-logo/{$branchModel->logo}";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice - <?= $SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- <link href="css/sb-admin-2.min.css" rel="stylesheet"> -->

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <!-- <link rel="stylesheet" href="./css/site.css"> -->
    <link rel="stylesheet" href="./css/pages/invoice.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>
    <!-- Begin Page Content -->
    <div class="body w-100">

        <div style="width: 300px;">

            <!-- Company profile -->

            <div style="text-align:center;font-size:40px">
                <p><img src="<?= $BRANDLOGO ?>" alt="<?= $SALONNAME ?>" style="max-width:200px"></p>
                <p style="font-size:12px;max-width:250px;text-align:center;margin:0px auto;text-transform:uppercase;margin-bottom:2px;"><b><?= $branchModel->address ?></b></p>
                <p style="font-size:12px;max-width:250px;text-align:center;margin:0px auto;"><b>Contact : <?= $branchModel->phone ?></b></p>
                <p style="font-size:12px;max-width:250px;text-align:center;margin:0px auto;"><b>Email : <?= $branchModel->email ?></b></p>
                <p style="font-size:12px;max-width:250px;text-align:center;margin:0px auto;"><b>Website : <?= $branchModel->website ?></b></p>
            </div>
            <h4 style="letter-spacing:4px;text-align:center;">SALES INVOICE</h4>
            <p style="font-size:14px;max-width:250px;text-align:center;margin:0px auto;"><b>(Branch : </b><?= $branchModel->branch_name ?>)</p>
            <hr style="margin-top:9px;margin-bottom:9px;border-color:#8c8c8c;">

            <!-- Customer Info -->
            <div style="padding:0px 12px;">
                <table style="width:100%;font-size:12px;font-weight:600;">
                    <tbody>
                        <tr style="vertical-align: top;">
                            <td>Customer Name</td>
                            <td> : <?= $clientModel->client_name ?></td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Mobile No</td>
                            <td> : <?= $clientModel->contact ?></td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Email Id </td>
                            <td> : <?= $clientModel->email ?></td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Address </td>
                            <td> : <?= $clientModel->address ?></td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Wallet Balance:</td>
                            <td> : INR 911 /-</td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Invoice No </td>
                            <td> : #<?= $billingModel->invoice_number ?></td>
                        </tr>
                        <!-- <tr style="vertical-align: top;">
                            <td>Membership id</td>
                            <td> : #MEM0002</td>
                        </tr> -->
                        <tr style="vertical-align: top;">
                            <td>Membership name</td>
                            <td> : <?= $membershipName ?></td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>Invoice Date </td>
                            <td> : <?= $billingModel->billing_date ?> <?= $billingModel->billing_time ?></td>
                        </tr>

                        <?php if (!empty($billingModel->coupon_code)) { ?>
                            <tr style="vertical-align: top;">
                                <td>Coupon Code </td>
                                <td> : <?= $billingModel->coupon_code ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Order summary -->

            <hr style="margin-top:9px;margin-bottom:9px;border-color:#8c8c8c;">
            <div>
                <table style="width:100%;font-size:12px;font-weight:600;border-collapse:collapse;">
                    <thead>
                        <tr style="font-size: 11px;">
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Service &amp; Product</strong></td>
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Provider</strong></td>
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Rate</strong></td>
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Dis</strong></td>
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Qty</strong></td>
                            <td style="padding:0px 7px 12px 7px;border-bottom:1px solid #8c8c8c;"><strong>Total</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalQty = [];
                        foreach ($billingProductModel as $billingProductKey => $billingProductVal) {
                            $billingProductValue = (object) $billingProductVal;
                            $serviceTypeText = ($billingProductValue->service_type == 'stock') ? 'product' : $billingProductValue->service_type;
                            $enquiryForModel = fetch_object($db, "SELECT * FROM {$billingProductValue->service_type} WHERE id='{$billingProductValue->service_id}'");

                            $arrayField = [
                                'service' => 'service_name',
                                'membership' => 'membership_name',
                                'package' => 'package_name',
                                'stock' => 'product_id'
                            ];

                            $fieldName = $arrayField[$billingProductValue->service_type];

                            $enquiryForText = '';
                            if ($billingProductValue->service_type == 'stock') {
                                $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
                                $enquiryForText = $productModel->product;
                            } else {
                                $enquiryForText = $enquiryForModel->$fieldName;
                            }

                            if ($billingProductValue->service_discount == 0) {
                                $rate = $billingProductValue->price;
                            } else {
                                if ($billingProductValue->service_discount_type == 'percentage') {
                                    $rate = round(($billingProductValue->price * 100) / (100 - $billingProductValue->service_discount));
                                } else {
                                    $rate = round(($billingProductValue->price + $billingProductValue->service_discount));
                                }
                            }

                            $totalQty[] = $billingProductValue->quantity;

                            $serviceProviderAssignModel = fetch_all($db, "SELECT * FROM client_billing_assign_service_provider WHERE billing_id='{$billingProductValue->billing_id}' AND billing_service_id='{$billingProductValue->id}'");

                            $serviceProvider = '';
                            foreach ($serviceProviderAssignModel as $serviceProviderAssignKey => $serviceProviderAssignVal) {
                                $serviceProviderAssignValue = (object) $serviceProviderAssignVal;
                                $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='{$serviceProviderAssignValue->service_provider_id}'");

                                $serviceProvider .= !empty($serviceProviderModel) ? $serviceProviderModel->name . ",<br>" : '';
                            }

                            $serviceProvider = rtrim($serviceProvider, ',<br>');

                            $discountedPrice = 0;
                            if ($billingModel->discount_type == "percentage") {
                                $discountedPrice1 = (($billingModel->sub_total * $billingModel->discount) / 100);
                                $discountedPrice = ($billingModel->sub_total - $discountedPrice1);
                            } else {
                                $discountedPrice = ($billingModel->sub_total - $billingModel->discount);
                            }

                            $discountedPrice = number_format($discountedPrice, 2, '.', '');

                        ?>
                            <tr style="font-size:12px;">
                                <td style="padding:5px 7px;vertical-align:top;"> <?= $serviceTypeText . " - " . $enquiryForText ?>
                                    <?php
                                    if ($billingProductValue->service_type == "package") {
                                        $tPackageServiceModel = fetch_all($db, "SELECT * FROM `package_service` WHERE `package_id`='{$billingProductValue->service_id}'");
                                        if (count($tPackageServiceModel) > 0) {
                                            echo "<ul>";
                                            foreach ($tPackageServiceModel as $tPackageServiceKey => $tPackageServiceVal) {
                                                $tPackageServiceValue = (object) $tPackageServiceVal;
                                                $packageService = fetch_object($db, "SELECT * FROM `service` WHERE id='{$tPackageServiceValue->service_id}'");
                                    ?>
                                                <li><?= $packageService->service_name ?></li>
                                        <?php }
                                            echo "</ul>";
                                        }
                                    } else {
                                        ?>
                                        <br>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td style="padding:5px 7px;vertical-align:top;"> <?= $serviceProvider ?></td>
                                <td style="padding:5px 7px;vertical-align:top;"><?= $rate ?></td>
                                <td style="padding:5px 7px;vertical-align:top;"><?= $billingProductValue->service_discount ?> <?= $discountArr[$billingProductValue->service_discount_type] ?></td>
                                <td style="padding:5px 7px;vertical-align:top;"><?= $billingProductValue->quantity ?></td>
                                <td style="padding:5px 7px;vertical-align:top;"><?= $billingProductValue->price ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr style="margin-top:9px;margin-bottom:9px;border-color:#8c8c8c;">
                <table style="width:100%;font-size:12px;font-weight:600;border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td style="padding:0px 7px;"><strong>Total Qty </strong></td>
                            <td style="padding:0px 7px;"> : <?= array_sum($totalQty) ?></td>
                            <td style="text-align:right;padding:0px 7px;">Amount :</td>
                            <td style="text-align:right;padding:0px 7px;"><?= $billingModel->sub_total ?></td>
                        </tr>
                        <tr>
                            <td rowspan="10" colspan="2" style="vertical-align:top;padding:0px 7px;">Payment Mode : <?= $paymentMode ?> </td>
                            <?php if (!empty($billingModel->coupon_code)) {
                                $couponModel = fetch_object($db, "SELECT * FROM `coupon` WHERE coupon_code='{$billingModel->coupon_code}'");
                                if (!empty($couponModel)) {
                                    $coupon_discount = "{$couponModel->discount} {$discountArr[$couponModel->discount_type]}";
                                } else {
                                    $coupon_discount = '0 %';
                                }
                            ?>


                                <td style="text-align:right;padding:0px 7px;">Coupon Dis :</td>
                                <td style="text-align:right;padding:0px 7px;"><?= $coupon_discount ?></td>

                            <?php } else { ?>
                                <td style="text-align:right;padding:0px 7px;">Coupon Dis :</td>
                                <td style="text-align:right;padding:0px 7px;">0 %</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;">Discount : </td>
                            <td style="text-align:right;padding:0px 7px;"><?= $billingModel->discount ?> <?= $discountArr[$billingModel->discount_type] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;">Sub Total : </td>
                            <td style="text-align:right;padding:0px 7px;"><?= $discountedPrice ?></td>
                        </tr>
                        <?php if (empty($billingModel->tax)) { ?>
                            <tr>
                                <td style="text-align:right;padding:0px 7px;"><strong>Tax : </strong></td>
                                <td style="text-align:right;padding:0px 7px;">0</td>
                            </tr>
                        <?php } else {

                            $taxModel = fetch_object($db, "SELECT * FROM gst_slab WHERE id='{$billingModel->tax}'");

                            $taxType = ucfirst($taxModel->tax_type);
                            $taxPercentage = $taxModel->gst;
                            $halfTaxPer = ($taxPercentage / 2);


                            if ($billingModel->discount_type == 'percentage') {
                                $subTotal = get_price_from_discount($billingModel->discount, $billingModel->sub_total);
                            } else {
                                $subTotal = ($billingModel->discount - $billingModel->sub_total);
                            }

                            $subTotal = ($billingModel->sub_total - $subTotal);

                            $taxPrice = (($subTotal * $halfTaxPer) / 100);
                        ?>
                            <tr>
                                <td style="text-align:right;padding:0px 7px;"><strong>Tax Type : </strong></td>
                                <td style="text-align:right;padding:0px 7px;"><?= $taxType ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;padding:0px 7px;"><strong>SGST(<?= $halfTaxPer ?>%) : </strong></td>
                                <td style="text-align:right;padding:0px 7px;"><?= $taxPrice ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;padding:0px 7px;"><strong>CGST(<?= $halfTaxPer ?>%) : </strong></td>
                                <td style="text-align:right;padding:0px 7px;"><?= $taxPrice ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;"><strong>Total : </strong></td>
                            <td style="text-align:right;padding:0px 7px;"><?= $billingModel->total ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;"><strong>Advance : </strong></td>
                            <td style="text-align:right;padding:0px 7px;"><?= $billingModel->advance_receive ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;"><strong>Amount Paid : </strong></td>
                            <td style="text-align:right;padding:0px 7px;"><?= ($billingModel->total - $billingModel->pending_amount) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding:0px 7px;"><strong>Amount Due : </strong></td>
                            <td style="text-align:right;padding:0px 7px;"><?= $billingModel->pending_amount ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr style="margin-top:9px;margin-bottom:9px;border-color:#8c8c8c;">
                <!--<h4 style="font-size:13px;font-weight:600;"><u>Terms &amp; Condition:</u></h4>-->
                <!--<p style="font-size:14px;font-weight:600;">1. Discounts are not applicable on Products. MRP mentioned are inclusive of taxes<br >-->
                <!--2. We are open 7 Days from 10:30 A.M TO 8:00 P.M <br />-->
                <!--3. For Appointments call at 9836402666 or 033-24546540 for Elgin road Branch <br />-->
                <!--4. Products once sold are not returnable. <br />-->
                <!--5. Follow us on facebook page or visit www.trendzsalon.co.in-->
                <!--</p>-->
                <br>
                <p style="text-align:center;font-size:12px;font-weight:600;">****THANK YOU. PLEASE VISIT AGAIN****</p>
            </div>
            <div>
                <center>
                    <button onclick="window.print();" class="printbtn btn btn-info">Print</button>
                </center>
            </div>

        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <!-- <script src="js/sb-admin-2.min.js"></script> -->
    <!-- Page level plugins -->
    <script src="./js/pages/invoice.js"></script>

    <?php include('./comman/loading.php'); ?>
</body>

</html>