<?php
require_once "../../lib/db.php";
check_auth();

$inv = $_REQUEST['inv'];

$billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE invoice_number='{$inv}'");
$billingProductModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billingModel->id}'");

$html = '';
if (count($billingProductModel) > 0) {
  $mainKey = 0;
  foreach ($billingProductModel as $billingProductKey => $billingProductVal) {
    $billingProductValue = (object) $billingProductVal;

    if ($billingProductValue->service_type == 'service') {

      $assignSPModel = fetch_object($db, "SELECT * FROM `client_billing_assign_service_provider` WHERE `billing_id`='{$billingProductValue->billing_id}' AND `billing_service_id`='{$billingProductValue->id}'");

      $serviceProviderId = !empty($assignSPModel) ? $assignSPModel->service_provider_id : 0;
      $productServiceModel = fetch_all($db, "SELECT * FROM service_product WHERE service_id='{$billingProductValue->service_id}'");
      foreach ($productServiceModel as $productServiceKey => $productServiceVal) {
        $productServiceValue = (object) $productServiceVal;
        $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$productServiceValue->product_id}'");
        $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$productServiceValue->service_id}'");

        $unitHtml = '';
        foreach ($unitArr as $unitKey => $unitValue) {
          $unitSelected = ($productServiceValue->unit == $unitKey) ? 'selected' : '';
          $unitHtml .= "<option value='{$unitKey}' {$unitSelected}>{$unitValue}</option>";
        }

        $serviceProvider = '';
        $serviceProviderArr = fetch_all($db, "SELECT * FROM service_provider WHERE id='{$serviceProviderId}' AND status=1");
        foreach ($serviceProviderArr as $serviceProviderKey => $serviceProviderValue) {
          $serviceProviderSelected = ($serviceProviderId == $serviceProviderValue['id']) ? 'selected' : '';
          $serviceProvider .= "<option value='{$serviceProviderValue['id']}' {$serviceProviderSelected}>{$serviceProviderValue['name']}</option>";
        }


        $stockModel = fetch_object($db, "SELECT * FROM stock WHERE product_id='{$productModel->id}'");
        if (empty($stockModel)) {
          $productServiceValue->quantity_used = 0;
          $errorNotice = "<p class='text-danger'>Low Stock</p>";
        } else {
          $errorNotice = '';
        }

        $html .= "
                <tr class='product_usage_row'>
                <td>
                  <input type='text' value='{$serviceModel->service_name}' class='sname form-control' placeholder='Service name' readonly />
                  <input type='hidden' name='product_consumption[$mainKey][service_id]' value='{$serviceModel->id}'/>
                  <input type='hidden' name='product_consumption[$mainKey][invoice_number]' value='{$inv}'/>
                </td>
                <td>
                  <input type='text' value='{$productModel->product}' class='form-control' placeholder='Product name' readonly/>
                  <input type='hidden' name='product_consumption[$mainKey][product_id]' value='{$productModel->id}'/>
                </td>
                <td>
                  <input type='number' name='product_consumption[$mainKey][quantity]' value='{$productServiceValue->quantity_used}' step='0.1' class='form-control' placeholder='0'/>
                  {$errorNotice}
                </td>
                <td>
                  <select class='form-select' readonly disabled>{$unitHtml}</select>
                </td>
                <td>
                  <select name='product_consumption[$mainKey][service_provider_id]' class='form-select'>
                    <option value=''>Service provider</option>
                    {$serviceProvider}
                  </select>
                </td>
              </tr>";

        $mainKey++;
      }
    }
  }
}

echo $html;
