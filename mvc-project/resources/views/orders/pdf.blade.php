<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách đơn hàng</title>
<style>
  /* ── Reset ── */
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 13px;
    color: #111;
    background: #fff;
    padding: 14mm 14mm 10mm;
  }

  /* ── Header block (top-left company info) ── */
  .hdr-company { font-size: 11px; font-weight: bold; text-transform: uppercase; }
  .hdr-address { font-size: 10px; margin-top: 2px; }

  /* ── Main title (centered) ── */
  .rpt-title {
    text-align: center;
    margin: 14px 0 4px;
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .rpt-period {
    text-align: center;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
  }
  .rpt-export-date {
    text-align: right;
    font-size: 11px;
    color: #444;
    margin-bottom: 8px;
  }

  /* ── Table ── */
  table { width: 100%; border-collapse: collapse; font-size: 11px; }
  thead th {
    background: #d0d0d0;
    color: #000;
    padding: 5px 6px;
    text-align: center;
    font-weight: bold;
    border: 1px solid #888;
  }
  tbody td {
    padding: 4px 6px;
    border: 1px solid #bbb;
    vertical-align: middle;
  }
  .tfoot-row td {
    font-weight: bold;
    border: 1px solid #888;
    padding: 5px 6px;
    text-align: center;
  }
  .text-right  { text-align: right; }
  .text-center { text-align: center; }

  /* ── Notes ── */
  .notes {
    margin-top: 12px;
    font-size: 11px;
    line-height: 1.7;
  }
  .notes p { margin-bottom: 2px; }

  /* ── Signature (2-column) ── */
  .sig-section {
    margin-top: 28px;
    display: table;
    width: 100%;
  }
  .sig-right-date {
    text-align: right;
    font-size: 11px;
    font-style: italic;
    margin-bottom: 8px;
  }
  .sig-cols {
    display: flex;
    justify-content: space-between;
  }
  .sig-col {
    width: 45%;
    text-align: center;
  }
  .sig-col-title {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 11px;
  }
  .sig-col-note {
    font-size: 10px;
    font-style: italic;
    color: #444;
    margin-top: 2px;
  }
  .sig-space { height: 52px; }

  /* ── Print ── */
  @media print {
    body { padding: 10mm 12mm 8mm; }
    .no-print { display: none !important; }
    @page { size: A4 portrait; margin: 10mm 12mm; }
    table { page-break-inside: auto; }
    tr    { page-break-inside: avoid; }
  }

  /* ── Toolbar (screen only) ── */
  .toolbar {
    position: fixed; top: 14px; right: 20px;
    display: flex; gap: 8px; z-index: 999;
  }
  .btn-print, .btn-close-win {
    padding: 8px 18px; border: none; border-radius: 5px;
    font-size: 13px; cursor: pointer; font-weight: 600;
  }
  .btn-print     { background: #1a1a2e; color: #fff; }
  .btn-close-win { background: #e2e8f0; color: #333; }
</style>
</head>
<body>

<!-- Toolbar (ẩn khi in) -->
<div class="toolbar no-print">
  <button class="btn-print"     onclick="window.print()">🖨 In / Lưu PDF</button>
  <button class="btn-close-win" onclick="window.close()">✕ Đóng</button>
</div>

<!-- ===== HEADER TRÁI ===== -->
<div class="hdr-company">TINY FLOWERS – HỆ THỐNG QUẢN LÝ BÁN HÀNG</div>
<div class="hdr-address">Website: tinyflowers.com</div>

<!-- ===== TIÊU ĐỀ GIỮA ===== -->
<div class="rpt-title">DANH SÁCH ĐƠN HÀNG</div>
<div class="rpt-period">
  @if($dateFrom || $dateTo)
      Từ ngày: {{ $dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '...' }} &nbsp;Đến ngày: {{ $dateTo ? date('d/m/Y', strtotime($dateTo)) : '...' }}
  @else
      Tất cả đơn hàng
  @endif
</div>

<!-- Ngày xuất phải -->
<div class="rpt-export-date">Xuất lúc: {{ $reportDate }}</div>

<!-- ===== BẢNG ĐƠN HÀNG ===== -->
<?php
  $totalAmt = 0;
?>
<table>
  <thead>
    <tr>
      <th style="width:5%">STT</th>
      <th style="width:15%">Mã đơn hàng</th>
      <th style="width:15%">Ngày tạo</th>
      <th style="width:25%">Khách hàng</th>
      <th style="width:15%">Thanh toán</th>
      <th style="width:15%">Trạng thái</th>
      <th style="width:10%">Tổng tiền (₫)</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($orders->isEmpty()): ?>
    <tr><td colspan="7" class="text-center" style="padding:12px;color:#888;">Không có đơn hàng nào</td></tr>
    <?php else: ?>
      <?php
        $i = 1;
        foreach ($orders as $o):
          $totalAmt += $o->total_amount;
          $pmLabel = ['cash'=>'Tiền mặt','credit_card'=>'Thẻ','bank_transfer'=>'CK', 'vnpay' => 'VNPay'][$o->payment_method] ?? ucfirst($o->payment_method);
          $customerName = $o->user ? $o->user->fullname : ($o->customer ? $o->customer->name : 'Khách lẻ');
          
          $statusLabel = $o->status;
          if($o->status === 'Pending') $statusLabel = 'Chờ xử lý';
          elseif($o->status === 'Processing') $statusLabel = 'Chuẩn bị';
          elseif($o->status === 'Shipped') $statusLabel = 'Đang giao';
          elseif($o->status === 'Delivered') $statusLabel = 'Đã giao';
          elseif($o->status === 'Cancelled') $statusLabel = 'Đã hủy';
          else $statusLabel = 'Hoàn thành';
      ?>
      <tr>
        <td class="text-center"><?= $i++ ?></td>
        <td class="text-center"><?= htmlspecialchars($o->order_number) ?></td>
        <td class="text-center"><?= date('d/m/Y H:i', strtotime($o->created_at)) ?></td>
        <td><?= htmlspecialchars($customerName) ?></td>
        <td class="text-center"><?= $pmLabel ?></td>
        <td class="text-center"><?= $statusLabel ?></td>
        <td class="text-right"><?= number_format($o->total_amount, 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
  <!-- TỔNG CỘNG row -->
  <tr class="tfoot-row">
    <td colspan="6" class="text-center" style="font-weight:bold;">TỔNG CỘNG:</td>
    <td class="text-right"><?= number_format($totalAmt, 0, ',', '.') ?></td>
  </tr>
</table>

<!-- ===== CHỮ KÝ ===== -->
<div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:28px;">
  <!-- Cột trái: Người lập biểu -->
  <div style="width:45%; text-align:center;">
    <div class="sig-col-title">Người lập biểu</div>
    <div class="sig-col-note">(Ký, họ tên)</div>
    <div class="sig-space"></div>
    <div style="font-weight: bold;"><?= htmlspecialchars($reporterName) ?></div>
  </div>
  <!-- Cột phải: Ngày + Quản lý -->
  <div style="width:45%; text-align:center;">
    <div style="font-size:11px; font-style:italic; margin-bottom:4px;">Ngày.....tháng.....năm..........</div>
    <div class="sig-col-title">Người kiểm duyệt</div>
    <div class="sig-col-note">(Ký, họ tên)</div>
    <div class="sig-space"></div>
  </div>
</div>

<script>
  if (window.opener || window.name === 'reportExport') {
    setTimeout(() => window.print(), 400);
  }
</script>
</body>
</html>
