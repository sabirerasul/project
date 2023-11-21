<?php
require_once "../../lib/db.php";
throw_exception();

$serviceProvider = fetch_all($db, "SELECT * FROM service_provider WHERE status=1 ORDER by name ASC");
$employee = fetch_all($db, "SELECT * FROM employee WHERE status=1 ORDER by name ASC");

$serviceProviderArr = [];
foreach ($serviceProvider as $key2 => $value2) {
    $serviceProviderArr[$key2] = $value2;
    $serviceProviderArr[$key2]['type'] = 'Service Provider';
}

$employeeArr = [];
foreach ($employee as $key1 => $value1) {
    $employeeArr[$key1] = $value1;
    $employeeArr[$key1]['type'] = 'Staff';
}

$modal = array_merge($serviceProviderArr, $employeeArr);

$html = "";


$date = date("d/m/Y");

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {
        $count++;
        $value = (object) $val;

        $type = ($value->type == 'Staff') ? 'staff' : 'service_provider';

        $checkStatusSql1 = "SELECT * FROM attendance WHERE employee_id='{$value->id}' AND employee_type='{$type}' AND date='{$date}'";
        $checkStatusSql = num_rows($db, $checkStatusSql1);

        $checkInDisabled = $checkStatusSql ? 'disabled' : '';

        if ($checkStatusSql) {


            $checkStatusModel = fetch_object($db, $checkStatusSql1);

            if ($checkStatusModel->status == 1) {

                if (empty($checkStatusModel->check_out_time)) {
                    $checkOutDisabled = '';
                } else {
                    $checkOutDisabled = 'disabled';
                }
            } else {
                $checkInDisabled = 'disabled';
                $checkOutDisabled = 'disabled';
            }
        } else {
            $checkOutDisabled = 'disabled';
        }

        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->name}</td>
            <td>{$value->contact_number}</td>
            <td>{$value->type}</td>
            <td>{$value->username}</td>";

        $html .= "<td class='multi-action-btn'>
                <a data-id='{$value->id}' data-src='{$type}' onclick='checkInTable(this)' class='btn btn-primary btn-block {$checkInDisabled}' type='button'> <i class='fas fa-door-open' aria-hidden='true'></i> In Time</a></td><td>";
        $html .= "<a data-id='{$value->id}' data-src='{$type}' onclick='checkOut(this)' class='btn btn-danger btn-block {$checkOutDisabled}' type='button'> <i class='fas fa-door-closed' aria-hidden='true'></i> Out Time</a>
        </td>
            </tr>";
    }
} else {

    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}

echo $html;
