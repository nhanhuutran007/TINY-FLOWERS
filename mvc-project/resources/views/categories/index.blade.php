@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Quản lý danh mục</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Danh mục</span>
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
                <h2 class="panel-title">Danh sách danh mục</h2>
                <button class="btn-primary-custom" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Thêm danh mục
                </button>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th style="text-align: right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>
                            <td style="font-weight: 600; color: #319DFF;">{{ $category->name }}</td>
                            <td>{{ $category->description ?: 'Không có mô tả' }}</td>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align: right;">
                                <button class="btn-action edit" onclick="openEditModal({{ json_encode($category) }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
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
                            <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-folder-open" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                Chưa có danh mục nào được tạo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal (Custom CSS) -->
    <div id="categoryModal" class="modal-custom">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3 id="modalTitle">Thêm danh mục mới</h3>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            <form id="categoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body-custom">
                    <div class="form-group">
                        <label>Tên danh mục <span style="color: red;">*</span></label>
                        <input type="text" name="name" id="catName" required placeholder="Nhập tên danh mục...">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" id="catDesc" rows="4" placeholder="Nhập mô tả danh mục..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-secondary-custom" onclick="closeModal()">Hủy</button>
                    <button type="submit" class="btn-primary-custom">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .btn-primary-custom {
            background: #319DFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary-custom:hover { background: #0076e4; transform: translateY(-1px); }

        .btn-secondary-custom {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-secondary-custom:hover { background: #e2e8f0; }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            margin-left: 5px;
        }
        .btn-action.edit { background: #e0f2fe; color: #0ea5e9; }
        .btn-action.edit:hover { background: #0ea5e9; color: white; }
        .btn-action.delete { background: #fee2e2; color: #ef4444; }
        .btn-action.delete:hover { background: #ef4444; color: white; }

        /* Modal Styles */
        .modal-custom {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }
        .modal-content-custom {
            background-color: #fff;
            margin: 10% auto;
            width: 500px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal-header-custom {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header-custom h3 { margin: 0; font-size: 18px; color: #1e293b; }
        .close-modal { font-size: 24px; cursor: pointer; color: #64748b; }
        .modal-body-custom { padding: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569; }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #319DFF;
            box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1);
        }
        .modal-footer-custom {
            padding: 20px;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>

    <script>
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const catName = document.getElementById('catName');
        const catDesc = document.getElementById('catDesc');

        function openAddModal() {
            modalTitle.innerText = 'Thêm danh mục mới';
            form.action = "{{ route('categories.store') }}";
            methodField.innerHTML = '';
            catName.value = '';
            catDesc.value = '';
            modal.style.display = 'block';
        }

        function openEditModal(category) {
            modalTitle.innerText = 'Chỉnh sửa danh mục';
            form.action = `/categories/${category.id}`;
            methodField.innerHTML = '@method("PUT")';
            catName.value = category.name;
            catDesc.value = category.description || '';
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }
    </script>
@endsection
