<?php
require_once "../../lib/db.php";

throw_exception();

require '../../lib/PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;


$strSQL = "SELECT * FROM product";
$sql = mysqli_query($db, $strSQL);


$columns = mysqli_num_fields($sql);

$model = fetch_all($db, $strSQL);

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setTitle("product_sample");
$spreadsheet->setActiveSheetIndex(0);

$num1 = 0;
$lastColumn = '';
for ($i = 0; $i < $columns; $i++) {

  $Heading = mysqli_fetch_field_direct($sql, $i);

  if ($Heading->name == 'id' || $Heading->name == 'created_by' || $Heading->name == 'updated_by' || $Heading->name == 'created_at' || $Heading->name == 'updated_at') {
    continue;
  }

  $spreadsheet->getActiveSheet()->SetCellValue($alphabetsArr[$num1] . '1', $Heading->name);
  $lastColumn = $alphabetsArr[$num1] . '1';
  $num1++;
}

$spreadsheet->getActiveSheet()
  ->getStyle("A1:" . $lastColumn)
  ->getFont()
  ->setBold(true);

$rowCount = 2;

$spreadsheet->getActiveSheet()
  ->getRowDimension($rowCount)
  ->setRowHeight(-1);


$writer = IOFactory::createWriter($spreadsheet, 'Xls');
header('Content-Type: text/xls');
$fileName = 'product_sample_excel_' . time() . '.xls';
$headerContent = 'Content-Disposition: attachment;filename="' . $fileName . '"';
header($headerContent);
$writer->save('php://output');
