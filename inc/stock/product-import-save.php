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

function saveProduct($db, $files)
{

    $model = [
        'msg' => '',
        'status' => true
    ];

    $tableName = "product";

    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

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
                        $vvVal = !empty($vvVal) ? "'" . $vvVal . "'" : "''";
                        $v .= $vvVal . ",";
                    }
                    $v =  $v . "'" . $created_at . "'";
                    $value .= "(" . $v . "),";
                }

                $value = rtrim($value, ',');

                $mySql = "INSERT INTO `{$tableName}` ({$keys}) VALUES {$value}";
                $query = mysqli_query($db, $mySql);

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
