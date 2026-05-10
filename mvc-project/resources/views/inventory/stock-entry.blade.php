@extends('layouts.app')

@section('title', 'Nhập kho sản phẩm')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Nhập kho sản phẩm</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Nhập kho</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success" style="background: #e6fffa; border: 1px solid #38b2ac; color: #234e52; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Danh sách sản phẩm nhập kho</h2>
                <div class="panel-actions">
                    <form action="{{ route('inventory.stock-entry') }}" method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="search" placeholder="Tìm tên hoặc mã..." value="{{ request('search') }}" 
                               style="padding: 8px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;">
                        <button type="submit" class="btn-primary-custom" style="padding: 8px 15px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Mã vạch / Tên</th>
                            <th>Danh mục</th>
                            <th>Hiện tại</th>
                            <th>Trạng thái</th>
                            <th style="text-align: right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->image_url }}" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                </td>
                                <td>
                                    <div style="font-size: 11px; color: #94a3b8;">{{ $product->barcode }}</div>
                                    <div style="font-weight: 600;">{{ $product->name }}</div>
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-weight: 700; color: {{ $product->stock_quantity < 10 ? '#ef4444' : '#1e293b' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->status)
                                        <span style="color: #10B981; font-size: 12px;"><i class="fas fa-check-circle"></i> Đang bán</span>
                                    @else
                                        <span style="color: #ef4444; font-size: 12px;"><i class="fas fa-times-circle"></i> Ngừng bán</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <button class="btn-stock-entry" onclick="openStockModal({{ json_encode($product) }})">
                                        <i class="fas fa-plus-square"></i> Nhập kho
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock Entry Modal -->
    <div id="stockModal" class="modal-custom">
        <div class="modal-content-custom" style="width: 450px;">
            <div class="modal-header-custom">
                <h3>Nhập kho sản phẩm</h3>
                <span class="close-modal" onclick="closeStockModal()">&times;</span>
            </div>
            <form action="{{ route('inventory.store-stock-entry') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modal_product_id">
                <div class="modal-body-custom">
                    <div style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center;">
                        <img id="modal_product_image" src="" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                        <div>
                            <div id="modal_product_name" style="font-weight: 700; color: #1e293b;"></div>
                            <div style="font-size: 12px; color: #64748b;">Tồn kho hiện tại: <span id="modal_current_stock" style="font-weight: 700;"></span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Số lượng nhập thêm <span style="color: red;">*</span></label>
                        <input type="number" name="quantity" required min="1" placeholder="Nhập số lượng..." style="font-size: 16px; padding: 12px;">
                    </div>

                    <div class="form-group">
                        <label>Ghi chú (Tùy chọn)</label>
                        <textarea name="notes" rows="2" placeholder="VD: Nhập hàng từ nhà cung cấp A..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-secondary-custom" onclick="closeStockModal()">Hủy</button>
                    <button type="submit" class="btn-primary-custom">Xác nhận nhập kho</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .btn-stock-entry {
            background: #e0f2fe;
            color: #0ea5e9;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-stock-entry:hover {
            background: #0ea5e9;
            color: white;
        }
        .btn-primary-custom { background: #319DFF; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-primary-custom:hover { background: #0076e4; }
        .btn-secondary-custom { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        
        /* Modal Styles sync with Products page */
        .modal-custom { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
        .modal-content-custom { background-color: #fff; margin: 10% auto; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header-custom { padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .modal-header-custom h3 { margin: 0; font-size: 18px; color: #1e293b; }
        .close-modal { font-size: 24px; cursor: pointer; color: #64748b; }
        .modal-body-custom { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box; }
        .modal-footer-custom { padding: 20px; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px; }
    </style>

    <script>
        const sModal = document.getElementById('stockModal');
        
        function openStockModal(product) {
            document.getElementById('modal_product_id').value = product.id;
            document.getElementById('modal_product_name').innerText = product.name;
            document.getElementById('modal_current_stock').innerText = product.stock_quantity;
            document.getElementById('modal_product_image').src = product.image_url;
            sModal.style.display = 'block';
        }

        function closeStockModal() {
            sModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == sModal) closeStockModal();
        }
    </script>
@endsection
