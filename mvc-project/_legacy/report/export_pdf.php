<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
// require_once __DIR__ . '/../vendor/autoload.php'; // Uncomment sau khi chạy composer install

/**
 * Export dữ liệu ra file PDF
 * Sử dụng thư viện: tecnickcom/tcpdf
 *
 * Ví dụ sử dụng:
 *   require_once 'export_pdf.php';
 *   exportToPDF($htmlContent, 'filename.pdf');
 */
function exportToPDF(string $htmlContent, string $filename = 'export.pdf') {
    // $pdf = new TCPDF();
    // $pdf->AddPage();
    // $pdf->writeHTML($htmlContent);
    // $pdf->Output($filename, 'D');
    // exit();

    // Placeholder khi chưa cài composer
    header('Content-Type: text/plain');
    echo "Cần chạy 'composer install' để sử dụng tính năng xuất PDF.";
    exit();
}
?>
