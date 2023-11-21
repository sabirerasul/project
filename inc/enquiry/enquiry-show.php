<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$cond = 1;

if ($_POST) {

    if (!empty($filterfollowdate)) {
        $dateArr = explode(' - ', $filterfollowdate);
        $start_date = getDateServerFormat(dateMMFormar($dateArr[0]));
        $end_date = getDateServerFormat(dateMMFormar($dateArr[1]));
    } else {
        $start_date = '';
        $end_date = '';
    }

    $cond = "`enquiry_for` LIKE '%{$filterenquiry_for}%' AND `enquiry_table_type` LIKE '%{$filterenquiry_table_type}%' AND `enquiry_type` LIKE '%{$filterenquiry_type}%' AND `source_of_enquiry` LIKE '%{$filtersource_of_enquiry}%' AND `leaduser` LIKE '%{$filterleaduser}%'";
}

$sql = "SELECT * FROM enquiry WHERE {$cond} ORDER by id DESC";

$modal = fetch_all($db, $sql);


$html = "";

if (count($modal) > 0) {
    $count = 1;
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        if (!empty($start_date) && !empty($end_date)) {

            $dbDate = getDateServerFormat($value->followdate);

            if ($start_date > $dbDate || $end_date < $dbDate) {
                continue;
            }
        }

        $enquiryForModel = fetch_object($db, "SELECT * FROM {$value->enquiry_table_type} WHERE id='{$value->enquiry_for}'");

        $arrayField = [
            'service' => 'service_name',
            'membership' => 'membership_name',
            'package' => 'package_name',
            'stock' => 'product_id'
        ];

        $fieldName = $arrayField[$value->enquiry_table_type];

        $enquiryForText = '';
        if ($value->enquiry_table_type == 'stock') {
            $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
            $enquiryForText = $productModel->product;
        } else {
            $enquiryForText = $enquiryForModel->$fieldName;
        }

        $btn1 = ($value->status == 'Converted' || $value->status == 'Close') ? "<a href='./enquiry.php?id={$value->id}' class='btn btn-sm btn-secondary text-nowrap m-1'><i class='fas fa-eye'></i> View</a>" : "<a href='./enquiry.php?id={$value->id}' class='btn btn-sm btn-primary text-nowrap m-1'><i class='fas fa-edit'></i> Edit</a>";

        if ($value->status == 'Converted') {
            $btn2 = "<a class='btn btn-sm btn-success text-nowrap' ><i class='fas fa-check'></i> {$value->status}</a>";
        } else if ($value->status == 'Close') {
            $btn2 = "<a class='btn btn-sm btn-danger text-nowrap' ><i class='fas fa-times'></i> {$value->status}</a>";
        } else {
            $btn2 =  "<a data-id='{$value->id}' class='btn btn-sm btn-danger text-nowrap' onclick='clientDelete({$value->id})'><i class='fas fa-trash'></i></a>";
        }

        $html .= "<tr>
            <td>{$count}</td>";
            //<td><input type='checkbox' class='chkk' value='{$value->id}' data-contact='{$value->contact}' data-name='{$value->client_name}' data-service='{$enquiryForText}'></td>
        $html .="<td>{$value->client_name}</td>
            <td>{$value->email}</td>
            <td>{$value->contact}</td>
            <td>{$value->followdate}</td>
            <td>{$value->enquiry_type}</td>
            <td>{$enquiryForText}</td>
            <td style='padding: 0px'>
            <div class='text-nowrap'>
                {$btn1}
                {$btn2}
            </div>
            </td>
            </tr>
        ";

        $count++;
    }
} else {

    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";*/
}


echo $html;
