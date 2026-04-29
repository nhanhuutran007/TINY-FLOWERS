<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Phiếu giao hàng - {{ $order->order_number }}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #000;
    background: #fff;
    padding: 10mm;
  }
  
  .bill-container {
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid #000;
    padding-bottom: 15px;
    margin-bottom: 20px;
  }

  .company-info h1 {
    font-size: 24px;
    margin-bottom: 5px;
    text-transform: uppercase;
  }
  
  .bill-title {
    text-align: right;
  }
  .bill-title h2 {
    font-size: 22px;
    text-transform: uppercase;
    margin-bottom: 5px;
  }

  .info-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
  }

  .customer-info, .order-info {
    width: 48%;
  }

  .info-title {
    font-weight: bold;
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    margin-bottom: 5px;
    border-bottom: 1px solid #eee;
    padding-bottom: 3px;
  }

  .info-content div {
    margin-bottom: 5px;
    line-height: 1.4;
  }

  table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
  th {
    background: #f5f5f5;
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    font-weight: bold;
  }
  td {
    padding: 10px;
    border: 1px solid #ddd;
  }
  .text-center { text-align: center; }
  .text-right { text-align: right; }

  .totals {
    width: 100%;
    display: flex;
    justify-content: flex-end;
  }

  .totals-table {
    width: 300px;
  }

  .totals-table td {
    border: none;
    padding: 5px 10px;
  }
  
  .totals-table tr.total-row td {
    border-top: 2px solid #000;
    font-weight: bold;
    font-size: 16px;
    padding-top: 10px;
  }

  .signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    text-align: center;
  }

  .signature-box {
    width: 30%;
  }
  .signature-title {
    font-weight: bold;
    margin-bottom: 70px;
  }

  /* ── Print ── */
  @media print {
    body { padding: 0; }
    .bill-container { border: none; padding: 0; }
    .no-print { display: none !important; }
  }

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

<div class="toolbar no-print">
  <button class="btn-print" onclick="window.print()">🖨 In Phiếu</button>
  <button class="btn-close-win" onclick="window.close()">✕ Đóng</button>
</div>

<div class="bill-container">
  <div class="header">
    <div class="company-info">
      <h1>TINY FLOWERS</h1>
      <div>Website: tinyflowers.com</div>
      <div>Hotline: 0869918250</div>
    </div>
    <div class="bill-title">
      <h2>PHIẾU GIAO HÀNG</h2>
      <div>Mã đơn: <strong>{{ $order->order_number }}</strong></div>
      <div>Ngày đặt: {{ $order->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</div>
      <div>Ngày in: {{ \Carbon\Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</div>
    </div>
  </div>

  <div class="info-section">
    <div class="customer-info">
      <div class="info-title">Người nhận (Khách hàng)</div>
      <div class="info-content">
        @if($order->customer)
            <div><strong>{{ $order->customer->name }}</strong></div>
            <div>SĐT: {{ $order->customer->phone ?? 'Không có' }}</div>
            <div>Địa chỉ: {{ $order->shipping_address ?? $order->customer->address ?? 'Không có' }}</div>
        @elseif($order->user)
            <div><strong>{{ $order->user->fullname }}</strong></div>
            <div>SĐT: {{ $order->user->phone ?? 'Không có' }}</div>
            <div>Địa chỉ: {{ $order->shipping_address ?? $order->user->address ?? 'Không có' }}</div>
        @else
            <div><strong>Khách mua trực tiếp</strong></div>
        @endif
      </div>
    </div>
    <div class="order-info">
      <div class="info-title">Thông tin giao hàng</div>
      <div class="info-content">
        <div>Phương thức thanh toán: <strong>{{ ucfirst($order->payment_method) }}</strong></div>
        @if(strtolower($order->status) == 'delivered' || $order->payment_status == 'paid')
            <div>Trạng thái: <strong>ĐÃ THANH TOÁN</strong></div>
        @else
            <div>Trạng thái: <strong>CHƯA THANH TOÁN</strong></div>
        @endif
        @if($order->notes)
            <div>Ghi chú: {{ $order->notes }}</div>
        @endif
      </div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th width="5%" class="text-center">STT</th>
        <th width="45%">Tên sản phẩm</th>
        <th width="15%" class="text-center">Số lượng</th>
        <th width="15%" class="text-right">Đơn giá</th>
        <th width="20%" class="text-right">Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->items as $index => $item)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>
          <strong>{{ $item->product_name }}</strong><br>
          <span style="font-size:11px; color:#666">Mã: {{ $item->product->barcode ?? 'N/A' }}</span>
        </td>
        <td class="text-center">{{ $item->quantity }}</td>
        <td class="text-right">{{ number_format($item->selling_price) }}đ</td>
        <td class="text-right">{{ number_format($item->subtotal) }}đ</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="totals">
    <table class="totals-table">
      <tr>
        <td class="text-right">Tổng phụ:</td>
        <td class="text-right">{{ number_format($order->subtotal ?? $order->total_amount + ($order->discount ?? 0) - ($order->shipping_fee ?? 30000)) }}đ</td>
      </tr>
      @if($order->discount > 0)
      <tr>
        <td class="text-right">Giảm giá:</td>
        <td class="text-right">-{{ number_format($order->discount) }}đ</td>
      </tr>
      @endif
      <tr>
        <td class="text-right">Phí vận chuyển:</td>
        <td class="text-right">{{ number_format($order->shipping_fee !== null ? $order->shipping_fee : 30000) }}đ</td>
      </tr>
      @if(strtolower($order->status) == 'delivered' || $order->payment_status == 'paid')
      <tr>
        <td class="text-right" style="color: #16a34a; font-weight: bold;">Đã thanh toán:</td>
        <td class="text-right" style="color: #16a34a; font-weight: bold;">-{{ number_format($order->total_amount) }}đ</td>
      </tr>
      <tr class="total-row">
        <td class="text-right">TỔNG CỘNG (Cần thu):</td>
        <td class="text-right">0đ</td>
      </tr>
      @else
      <tr class="total-row">
        <td class="text-right">TỔNG CỘNG (Cần thu):</td>
        <td class="text-right">{{ number_format($order->total_amount) }}đ</td>
      </tr>
      @endif
    </table>
  </div>

  <div class="signature-section">
    <div class="signature-box">
      <div class="signature-title">Người soạn hàng</div>
      <div>(Ký, ghi rõ họ tên)</div>
    </div>
    <div class="signature-box">
      <div class="signature-title">Người giao hàng</div>
      <div>(Ký, ghi rõ họ tên)</div>
    </div>
    <div class="signature-box">
      <div class="signature-title">Người nhận hàng</div>
      <div>(Ký, ghi rõ họ tên)</div>
    </div>
  </div>
  
  <div style="text-align: center; margin-top: 50px; font-style: italic; font-size: 12px; color: #555;">
    Cảm ơn quý khách đã mua sắm tại Tiny Flowers!
  </div>
</div>

<script>
  if (window.opener || window.name === 'reportExport') {
    setTimeout(() => window.print(), 400);
  }
</script>
</body>
</html>
