<?php
require_once '../../lib/db.php';
throw_exception();

extract($_REQUEST);

$paymentModel = fetch_all($db, "SELECT * FROM `pending_payment_history` WHERE client_id='{$client_id}' AND pending!=0 AND `bill_type`='bill'");

$html = '';
if (count($paymentModel) > 0) {
	foreach ($paymentModel as $paymentKey => $paymentVal) {
		$paymentValue = (object) $paymentVal;

		$model = fetch_object($db, "SELECT sum(total) as total, sum(advance) as advance, sum(paid) as paid FROM `pending_payment_history` WHERE app_bill_id='{$paymentValue->app_bill_id}'");
		//$pendingPaymentModel = fetch_object($db, "SELECT sum(total) as total, sum(advance) as advance, sum(paid) as paid FROM `pending_payment_history` WHERE app_bill_id='{$paymentValue->app_bill_id}' AND bill_type='pending payment'");
		if (!empty($model)) {

			$pendingPaid = 0;//!empty($pendingPaymentModel->paid) ? $pendingPaymentModel->paid : 0;

			$total = $model->total;
			$advance = $model->advance;
			$paid = $model->paid + $pendingPaid;

			$pending = ($total - $advance - $paid);

			if ($pending == 0) {
				continue;
			}

			if ($paymentValue->bill_type == "appointment") {
				continue;
			}

			if ($paymentValue->bill_type == "pending payment") {
				continue;
			}
		}

		$branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$paymentValue->branch_id}'");
		$billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$paymentValue->app_bill_id}'");

		$html .= "
		<tr>
			<td style='text-align:center;vertical-align:middle;' class='text-nowrap'>{$branchModel->branch_name}</td>
			<td style='text-align:center;vertical-align:middle;'>{$paymentValue->app_bill_id}</td>
			<td style='vertical-align:middle;'>{$paymentValue->date}</td>
			<td style='vertical-align:middle;'>{$paymentValue->bill_type}</td>
			<td style='vertical-align:middle;' class='pri'>{$pending}</td>
			<td>
				<input type='number' class='form-control amtpay' min='0' value='0' />
				<input type='hidden' class='form-control pending_id' value='{$paymentValue->id}' />
				<input type='hidden' class='form-control pendtotal' min='0' value='{$pending}' />
			</td>
			<td>
				<select class='form-select mthd' onchange='pendingpaymode(this.value,$(this))'>
					<option value='1'>Cash</option> 
					<option value='3'>Credit/Debit card</option> 
					<option value='4'>Cheque</option> 
					<option value='5'>Online payment</option> 
					<option value='6'>Paytm</option> 
					<!--<option value='7'>E-wallet</option> 
					<option value='9'>Reward points</option> -->
					<option value='10'>PhonePe</option> 
					<option value='11'>Gpay</option>
				</select>
			</td>
			<td>
				<a type='button' onclick='pendingPayment($(this))' class='btn btn-sm btn-danger text-nowrap m-1'><i class='fas fa-money-bill' aria-hidden='true'></i> Pay</a>
				<a class='btn btn-sm btn-success text-nowrap m-1' target='_blank' href='./invoice.php?inv={$billingModel->invoice_number}'><i class='fas fa-eye' aria-hidden='true'></i> View </a>
			</td>
		</tr>";
	}
}


echo $html;
