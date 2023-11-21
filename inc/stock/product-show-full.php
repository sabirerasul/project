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
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[0] . $rowCount, $val['product']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[1] . $rowCount, $val['volume']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[2] . $rowCount, $val['unit']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[3] . $rowCount, $val['mrp']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[4] . $rowCount, $val['barcode']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[5] . $rowCount, $val['reward_point_on_purchase']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[6] . $rowCount, $val['status']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[7] . $rowCount, $val['created_at']);
    $spreadsheet->getActiveSheet()->setCellValue($alphabetsArr[8] . $rowCount, $val['updated_at']);
    $rowCount++;
  }

  $spreadsheet->getActiveSheet()
    ->getStyle('A:'.$alphabetsArr[8])
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





















/*


$Filename = "product_" . time();

$Output = "";
$strSQL = "SELECT * FROM product";
$sql = mysqli_query($db, $strSQL);

if (mysqli_error($db)) {
  echo mysqli_error($db);
} else {

  $columns_total = mysqli_num_fields($sql);

  for ($i = 0; $i < $columns_total; $i++) {
    $Heading = mysqli_fetch_field_direct($sql, $i);
    if ($Heading->name == 'id' || $Heading->name == 'created_by' || $Heading->name == 'updated_by') {
      continue;
    }
    $Output .= '"' . $Heading->name . '",';
  }
  $Output .= "\n";

  $row = fetch_all($db, $strSQL);
  foreach ($row as $rKey => $rValue) {
    foreach ($rValue as $rrKey => $rrValue) {

      if ($rrKey == 'id' || $rrKey == 'created_by' || $rrKey == 'updated_by') {
        continue;
      }

      if ($rrKey == 'status') {
        $rrValue = ($rrValue == 1) ? 'Active' : 'Deactive';
      }

      $Output .= '"' . $rrValue . '",';
    }
    $Output .= "\n";
  }

  $TimeNow = date("YmdHis");
  $Filename .= $TimeNow . ".csv";
  header('Content-type: application/csv');
  header('Content-Disposition: attachment; filename=' . $Filename);
  echo $Output;
}
exit;


*/