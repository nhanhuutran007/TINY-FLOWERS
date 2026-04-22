<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
// require_once __DIR__ . '/../vendor/autoload.php'; // Uncomment sau khi chạy composer install

/**
 * Export dữ liệu ra file Excel
 * Sử dụng thư viện: shuchkin/simplexlsxgen
 *
 * Ví dụ sử dụng:
 *   require_once 'export_excel.php';
 *   exportToExcel($data, $headers, 'filename.xlsx');
 */
function exportToExcel(array $data, array $headers, string $filename = 'export.xlsx') {
    // $xlsx = \Shuchkin\SimpleXLSXGen::fromArray(array_merge([$headers], $data));
    // $xlsx->downloadAs($filename);
    // exit();

    // Placeholder khi chưa cài composer
    header('Content-Type: text/plain');
    echo "Cần chạy 'composer install' để sử dụng tính năng xuất Excel.\n";
    echo "Dữ liệu: " . count($data) . " dòng.";
    exit();
}
?>
