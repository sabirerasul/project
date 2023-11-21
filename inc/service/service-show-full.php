<?php
require_once "../../lib/db.php";

throw_exception();

require '../../lib/PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;


$strSQL = "SELECT * FROM `service`";
$sql = mysqli_query($db, $strSQL);


$columns = mysqli_num_fields($sql);

$model = fetch_all($db, $strSQL);

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setTitle("product_table");
$spreadsheet->setActiveSheetIndex(0);

$num1 = 0;
$lastColumn = '';
for ($i = 0; $i < $columns; $i++) {

  $Heading = mysqli_fetch_field_direct($sql, $i);

  if ($Heading->name == 'id' || $Heading->name == 'created_by' || $Heading->name == 'updated_by') {
    continue;
  }


  $cols_name = strtoupper(rep_under_space($Heading->name));
  $spreadsheet->getActiveSheet()->SetCellValue($alphabetsArr[$num1] . '1', $cols_name);
  $lastColumn = $alphabetsArr[$num1] . '1';
  $num1++;
}

$spreadsheet->getActiveSheet()
  ->getStyle("A1:" . $lastColumn)
  ->getFont()
  ->setBold(true);

$rowCount = 2;

if (!empty($model)) {
  foreach ($model as $k => $val) {

    $category_id = $val['category_id'];
    $catModel = fetch_object($db, "SELECT * FROM `service_category` WHERE id='{$category_id}'");
    $category_id = $catModel->name;

    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[0] . $rowCount, $category_id);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[1] . $rowCount, $val['service_name']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[2] . $rowCount, $val['price']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[3] . $rowCount, $val['membership_price']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[4] . $rowCount, $val['duration']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[5] . $rowCount, $val['reward_point']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[6] . $rowCount, $val['service_for']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[7] . $rowCount, $val['hide_on_website']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[8] . $rowCount, $val['status']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[9] . $rowCount, $val['created_at']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[10] . $rowCount, $val['updated_at']);

    $rowCount++;
  }

  $spreadsheet->getActiveSheet()
    ->getStyle('A:' . $alphabetsArr[10])
    ->getAlignment()
    ->setWrapText(true);

  $spreadsheet->getActiveSheet()
    ->getRowDimension($rowCount)
    ->setRowHeight(-1);
}


$writer = IOFactory::createWriter($spreadsheet, 'Xls');
header('Content-Type: text/xls');
$fileName = 'product_excel_' . time() . '.xls';
$headerContent = 'Content-Disposition: attachment;filename="' . $fileName . '"';
header($headerContent);
$writer->save('php://output');
