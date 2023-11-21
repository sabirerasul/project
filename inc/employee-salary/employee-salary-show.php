<?php
require_once "../../lib/db.php";
throw_exception();


$modal = fetch_all($db, "SELECT * FROM employee_salary ORDER by id DESC");

$html = "";


$employeeType = [
    "1" => "Service provider",
    "2" => "Staff"
];

$employeeType = [
    "1" => "Service provider",
    "2" => "Staff"
];

$salaryType = [
    "1" => "Salary",
    "2" => "Advance",
    "3" => "Incentives",
    "4" => "Bonus",
];

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $employeeTableName = ($value->employee_type == 1) ? "service_provider" : "employee";
        $employeeModel = fetch_object($db, "SELECT * FROM {$employeeTableName} WHERE id={$value->employee_id}");
        $html .= "<tr>
            <td>{$value->date}</td>
            <td>{$employeeType[$value->employee_type]}</td>
            <td>{$employeeModel->name}</td>
            <td>{$salaryType[$value->salary_type]}</td>
            <td>{$value->amount}</td>
            <td>{$value->comments}</td>";

        $html .= "<td class='multi-action-btn'>
                <a href='./employee-salary.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>";
        $html .= "<a onclick='deleteSalary({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
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
