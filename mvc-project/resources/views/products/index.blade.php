@extends('layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Quản lý sản phẩm</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Sản phẩm</span>
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
                <h2 class="panel-title">Danh sách sản phẩm</h2>
                <button class="btn-primary-custom" onclick="openAddProductModal()">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Mã vạch / Tên</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Giá nhập / Bán</th>
                            <th>Kho</th>
                            <th>Trạng thái</th>
                            <th style="text-align: right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->image_url }}" 
                                         alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                                </td>
                                <td>
                                    <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">{{ $product->barcode }}</div>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $product->name }}</div>
                                </td>
                                <td style="max-width: 200px; font-size: 13px; color: #64748b;">
                                    {{ Str::limit($product->description, 50) ?: 'Chưa có mô tả' }}
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 12px; color: #475569;">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 12px; text-decoration: line-through; color: #94a3b8;">{{ number_format($product->cost_price) }}đ</div>
                                    <div style="font-weight: 600; color: #10B981;">{{ number_format($product->selling_price) }}đ</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; {{ $product->stock_quantity < 10 ? 'color: #ef4444;' : 'color: #1e293b;' }}">
                                        {{ $product->stock_quantity }}
                                    </div>
                                </td>
                                <td>
                                    @if($product->status)
                                        <span style="color: #10B981; font-size: 12px; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i> Đang bán</span>
                                    @else
                                        <span style="color: #94a3b8; font-size: 12px; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i> Ngừng bán</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <button class="btn-action edit" onclick="openEditProductModal({{ json_encode($product) }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fas fa-box-open" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                    Chưa có sản phẩm nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="modal-custom">
        <div class="modal-content-custom" style="width: 700px; margin: 5% auto;">
            <div class="modal-header-custom">
                <h3 id="productModalTitle">Thêm sản phẩm mới</h3>
                <span class="close-modal" onclick="closeProductModal()">&times;</span>
            </div>
            <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="productMethodField"></div>
                <div class="modal-body-custom">
                    @if ($errors->any())
                        <div style="background: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label>Mã vạch <span style="color: red;">*</span></label>
                            <input type="text" name="barcode" id="pBarcode" required placeholder="Ví dụ: SP001">
                        </div>
                        <div class="form-group">
                            <label>Tên sản phẩm <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="pName" required placeholder="Nhập tên sản phẩm...">
                        </div>
                        <div class="form-group">
                            <label>Danh mục <span style="color: red;">*</span></label>
                            <select name="category_id" id="pCategory" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Chất liệu</label>
                            <input type="text" name="material" id="pMaterial" placeholder="Ví dụ: Cotton, Silk...">
                        </div>
                        <div class="form-group">
                            <label>Giá nhập <span style="color: red;">*</span></label>
                            <input type="number" name="cost_price" id="pCost" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Giá bán <span style="color: red;">*</span></label>
                            <input type="number" name="selling_price" id="pSelling" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Số lượng kho <span style="color: red;">*</span></label>
                            <input type="number" name="stock_quantity" id="pStock" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Ảnh sản phẩm</label>
                            <input type="file" name="image" id="pImage" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" id="pDescription" rows="3" placeholder="Nhập mô tả sản phẩm..."></textarea>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="status" id="pStatus" value="1" checked style="width: auto; margin-right: 10px;">
                            Đang kinh doanh
                        </label>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-secondary-custom" onclick="closeProductModal()">Hủy</button>
                    <button type="submit" class="btn-primary-custom">Lưu sản phẩm</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .btn-primary-custom { background: #319DFF; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-primary-custom:hover { background: #0076e4; transform: translateY(-1px); }
        .btn-secondary-custom { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-secondary-custom:hover { background: #e2e8f0; }
        .btn-action { width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer; transition: all 0.2s; margin-left: 5px; }
        .btn-action.edit { background: #e0f2fe; color: #0ea5e9; }
        .btn-action.edit:hover { background: #0ea5e9; color: white; }
        .btn-action.delete { background: #fee2e2; color: #ef4444; }
        .btn-action.delete:hover { background: #ef4444; color: white; }
        .modal-custom { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
        .modal-content-custom { background-color: #fff; margin: 10% auto; width: 500px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header-custom { padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .modal-header-custom h3 { margin: 0; font-size: 18px; color: #1e293b; }
        .close-modal { font-size: 24px; cursor: pointer; color: #64748b; }
        .modal-body-custom { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #319DFF; box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1); }
        .modal-footer-custom { padding: 20px; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px; }
    </style>

    <script>
        const pModal = document.getElementById('productModal');
        const pForm = document.getElementById('productForm');
        const pTitle = document.getElementById('productModalTitle');
        const pMethod = document.getElementById('productMethodField');
        
        function openAddProductModal() {
            pTitle.innerText = 'Thêm sản phẩm mới';
            pForm.action = "{{ route('products.store') }}";
            pMethod.innerHTML = '';
            pForm.reset();
            pModal.style.display = 'block';
        }

        function openEditProductModal(product) {
            pTitle.innerText = 'Chỉnh sửa sản phẩm';
            pForm.action = `{{ url('products') }}/${product.id}`;
            pMethod.innerHTML = '@method("PUT")';
            
            document.getElementById('pBarcode').value = product.barcode;
            document.getElementById('pName').value = product.name;
            document.getElementById('pCategory').value = product.category_id;
            document.getElementById('pMaterial').value = product.material || '';
            document.getElementById('pCost').value = product.cost_price;
            document.getElementById('pSelling').value = product.selling_price;
            document.getElementById('pStock').value = product.stock_quantity;
            document.getElementById('pDescription').value = product.description || '';
            document.getElementById('pStatus').checked = product.status == 1;
            
            pModal.style.display = 'block';
        }

        function closeProductModal() { pModal.style.display = 'none'; }
        window.onclick = function(event) { if (event.target == pModal) closeProductModal(); }

        @if ($errors->any())
            openAddProductModal();
        @endif
    </script>
@endsection
