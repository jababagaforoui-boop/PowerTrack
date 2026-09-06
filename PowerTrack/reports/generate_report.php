<?php
require '../vendor/autoload.php';
include '../config/db.php';
include '../includes/functions.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$user_id = 1; // Example: replace with logged-in user ID

$stmt = $conn->prepare("SELECT u.*, a.name AS appliance_name FROM usage_logs u
    JOIN appliances a ON a.id=u.appliance_id
    WHERE a.user_id=? ORDER BY usage_date DESC");
$stmt->execute([$user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1','Date');
$sheet->setCellValue('B1','Appliance');
$sheet->setCellValue('C1','Hours Used');
$sheet->setCellValue('D1','Energy (kWh)');
$sheet->setCellValue('E1','Cost');

$row = 2;
foreach($data as $log){
    $sheet->setCellValue("A$row",$log['usage_date']);
    $sheet->setCellValue("B$row",$log['appliance_name']);
    $sheet->setCellValue("C$row",$log['hours_used']);
    $sheet->setCellValue("D$row",$log['energy_consumed']);
    $sheet->setCellValue("E$row",$log['cost']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
$filename = "energy_report.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
$writer->save("php://output");
exit();
?>