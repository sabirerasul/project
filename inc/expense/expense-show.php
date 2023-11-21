<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

if (!empty($date)) {
    $dateArr = explode(' - ', $date);
    $start_date = getDateServerFormat(dateMMFormar($dateArr[0]));
    $end_date = getDateServerFormat(dateMMFormar($dateArr[1]));
} else {
    $start_date = '';
    $end_date = '';
}

$modal = fetch_all($db, "SELECT * FROM expense ORDER by id DESC");

$html = "";

$total[] = 0;

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {

        $value = (object) $val;
        if (!empty($start_date) && !empty($end_date)) {

            $dbDate = getDateServerFormat($value->date);

            if ($start_date > $dbDate || $end_date < $dbDate) {
                continue;
            }
        }

        $count++;
        $total[] = $value->amount_paid;

        $expense_type = fetch_object($db, "SELECT * FROM expense_type WHERE id='" . $value->expense_type_id . "'")->title;
        $recipient_name = fetch_object($db, "SELECT * FROM expense_recipient WHERE id='" . $value->recipient_name_id . "'")->recipient_name;

        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->date}</td>
            <td>{$expense_type}</td>
            <td>{$value->amount_paid}</td>
            <td>{$paymentModeArr[$value->payment_mode]}</td>
            <td>{$recipient_name}</td>
            <td>Admin</td>";

        $html .= "<td>
                <a href='./expense.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>";
        $html .= "<a onclick='deleteExpense({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
            </tr>";
    }

    $count++;

    $html .= "<tr>
    <td>{$count}</td>
    <td></td>
        <th colspan='' class='text-right'>
            <strong>Total Amount</strong>
        </th>
        <th>
            <strong>" . array_sum($total) . "</strong>
        </th>
    <td></td>
    <td></td>
    <td></td>
        <td colspan=''></td>
    </tr>";
}

echo $html;
