<?php
require_once "../../lib/db.php";
throw_exception();

$modal = fetch_all($db, "SELECT * FROM self_assessment_data ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $html .= "<tr>
            <td>
            " . date("d-m-Y", strtotime($value->created_at)) . "</td>
            <td>{$value->name}</td>
            <td>{$value->email}</td>
            <td>{$value->mobile}</td>
            <td>{$value->address}</td>
            <td>{$value->affected_countries_last}</td>
            <td>{$value->confirmed_case_coronavirus}</td>
            <td>{$value->experiencing_symptoms}</td>
            </tr>";
    }
}

echo $html;
