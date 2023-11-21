<?php
require_once "../../lib/db.php";

throw_exception();

require '../../lib/PhpSpreadsheet/vendor/autoload.php';;

use PhpOffice\PhpSpreadsheet\Reader\Xls;

$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

$em_file = '';

$em_file = isset($_FILES['file']) ? $_FILES['file'] : '';

if (empty($em_file)) {
    $errors['error'] = 'Excel file required!';
}


function addServiceCategory($db, $category)
{
    $chkSql = "SELECT * FROM `service_category` WHERE `name`='" . $category . "'";

    if (num_rows($db, $chkSql) == 0) {
        $created_at = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `service_category` (`name`, `status`, `created_at`) VALUES ('" . $category . "','1','" . $created_at . "')";
        mysqli_query($db, $sql);
        $last_id = mysqli_insert_id($db);
    } else {
        $model = fetch_object($db, $chkSql);
        $last_id = $model->id;
    }

    return $last_id;
}


function addServiceProviderServices($db, $newSId1)
{
    $newSId[] = $newSId1;

    $serviceProviderModels = fetch_all($db, "SELECT id FROM `service_provider` WHERE status=1");
    $serviceProviderIds = array_column($serviceProviderModels, 'id');

    foreach ($serviceProviderIds as $serviceProviderIdskey => $serviceProviderIdsValue) {
        $provider_id = $serviceProviderIdsValue;

        $sql1 = "SELECT s_id FROM service_provider_assign_services WHERE `sp_id`='" . $provider_id . "'";
        $query1 = mysqli_query($db, $sql1);

        $oldModel = mysqli_fetch_all($query1, MYSQLI_ASSOC);
        $oldSId = array_column($oldModel, 's_id');

        $delKey = array_diff($oldSId, $newSId);
        $addKey = array_diff($newSId, $oldSId);

        /*
        $delStringKey = implode(',', $delKey);

        if (!empty($delStringKey)) {
            $delete_sql = ("DELETE FROM service_provider_assign_services WHERE s_id in($delStringKey) AND sp_id='" . $provider_id . "'");
            $delete_query = mysqli_query($db, $delete_sql);
        }
        */

        foreach ($addKey as $key => $value) {

            $mysqltime = date('Y-m-d H:i:s', time());
            $sql = "INSERT INTO `service_provider_assign_services` (`sp_id`, `s_id`, `created_at`) VALUES ('" . $provider_id . "', '" . $value . "', '" . $mysqltime . "')";
            $query = mysqli_query($db, $sql);
        }
    }

    return true;
}


function saveProduct($db, $files)
{

    $model = [
        'msg' => '',
        'status' => true
    ];

    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $tableName = "service";

    //$inputFileType = $files['type'];

    if (!empty($files['name']) && in_array($files['type'], $excelMimes)) {

        // If the file is uploaded 
        if (is_uploaded_file($files['tmp_name'])) {

            //$reader = new Xls();

            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($files['tmp_name']);

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

            $spreadsheet = $reader->load($files['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            $originalHeader = $worksheet_arr[0];
            $tableHeader = fetch_object($db, "SELECT * FROM `{$tableName}`");

            if (!check_excel_header($tableHeader, $originalHeader)) {
                $model = [
                    'msg' => 'This is not a valid excel file.',
                    'status' => false
                ];
            } else {

                $header = $worksheet_arr[0];
                // Remove header row 
                $header[] = 'created_at';

                $keys = implode(',', $header);

                unset($worksheet_arr[0]);

                $created_at = date('Y-m-d H:i:s', time());

                $value = '';
                foreach ($worksheet_arr as $vKey => $vVal) {
                    $v = '';

                    foreach ($vVal as $vvKey => $vvVal) {

                        if ($vvKey == 0) {
                            $category_id = addServiceCategory($db, $vvVal);
                            $vvVal = $category_id;
                        }

                        $vvVal = !empty($vvVal) ? "'" . $vvVal . "'" : "''";
                        $v .= $vvVal . ",";
                    }
                    $v =  $v . "'" . $created_at . "'";
                    $value .= "(" . $v . "),";
                }

                $value = rtrim($value, ',');

                $mySql = "INSERT INTO `{$tableName}` ({$keys}) VALUES {$value}";
                $query = mysqli_query($db, $mySql);

                $newSId1 = mysqli_insert_id($db);

                // /addServiceProviderServices($db, $newSId1);

                if ($query) {
                    $model = [
                        'msg' => 'File imported successfully!',
                        'status' => true
                    ];
                } else {
                    $model = [
                        'msg' => 'Internal server error.',
                        'status' => false
                    ];
                }
            }
        } else {
            $model = [
                'msg' => 'File not uploaded, server issue, please reload the page.',
                'status' => false
            ];
        }
    } else {
        $model = [
            'msg' => 'Invalid File',
            'status' => false
        ];
    }

    return $model;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveProduct($db, $em_file);

    $status = $m['status'];
    $msg = $m['msg'];

    $data['success'] = $status;
    $data['errors'] = $msg;
}

echo json_encode($data);
