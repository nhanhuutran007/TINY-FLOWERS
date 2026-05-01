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
            <div class="alert alert-success"
                style="background: #e6fffa; border: 1px solid #38b2ac; color: #234e52; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="panel" style="margin-bottom: 30px; border-top: 4px solid #319DFF;">
            <div class="panel-header">
                <h2 class="panel-title" style="font-size: 16px;"> Danh mục cha (Dùng làm menu Header)</h2>
                <button class="btn-primary-custom" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Thêm danh mục mới
                </button>
            </div>
            <div
                style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                @foreach($parentCategories as $parent)
                    <div
                        style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">{{ $parent->name }}</div>
                            <div style="font-size: 11px; color: #64748b;">{{ $parent->children->count() }} danh mục con</div>
                        </div>
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-action edit" onclick="openEditModal({{ json_encode($parent) }})"
                                style="width: 28px; height: 28px;">
                                <i class="fas fa-edit" style="font-size: 12px;"></i>
                            </button>
                            <form action="{{ route('categories.destroy', $parent->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete"
                                    onclick="return confirm('CẢNH BÁO: Xóa danh mục cha sẽ ảnh hưởng đến các danh mục con. Bạn vẫn muốn xóa?')"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-trash" style="font-size: 12px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Danh sách danh mục con</h2>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục con</th>
                        <th>Thuộc danh mục cha</th>
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
                            <td>
                                <span
                                    style="background: #e0f2fe; padding: 4px 12px; border-radius: 20px; font-size: 12px; color: #0369a1; font-weight: 600;">
                                    <i class="fas fa-folder"></i> {{ $category->parent->name }}
                                </span>
                            </td>
                            <td>{{ $category->description ?: 'Không có mô tả' }}</td>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align: right;">
                                <button class="btn-action edit" onclick="openEditModal({{ json_encode($category) }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục con này?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-folder-open"
                                    style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                Chưa có danh mục con nào.
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
                        <label>Loại danh mục <span style="color: red;">*</span></label>
                        <div style="display: flex; gap: 20px; margin-bottom: 10px;">
                            <label
                                style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                                <input type="radio" name="cat_type" value="parent" checked
                                    onclick="toggleParentSelect(false)"> Danh mục cha
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                                <input type="radio" name="cat_type" value="child" onclick="toggleParentSelect(true)"> Danh
                                mục con
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tên danh mục <span style="color: red;">*</span></label>
                        <input type="text" name="name" id="catName" required placeholder="Nhập tên danh mục...">
                    </div>

                    <div class="form-group" id="parentSelectGroup" style="display: none;">
                        <label>Chọn danh mục cha <span style="color: red;">*</span></label>
                        <select name="parent_id" id="catParent"
                            style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <option value="">-- Chọn danh mục cha --</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" class="parent-opt-{{ $parent->id }}">{{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
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

        .btn-primary-custom:hover {
            background: #0076e4;
            transform: translateY(-1px);
        }

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

        .btn-secondary-custom:hover {
            background: #e2e8f0;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            margin-left: 5px;
        }

        .btn-action.edit {
            background: #e0f2fe;
            color: #0ea5e9;
        }

        .btn-action.edit:hover {
            background: #0ea5e9;
            color: white;
        }

        .btn-action.delete {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-action.delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Modal Styles */
        .modal-custom {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content-custom {
            background-color: #fff;
            margin: 5% auto;
            width: 500px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header-custom {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header-custom h3 {
            margin: 0;
            font-size: 18px;
            color: #1e293b;
        }

        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #64748b;
        }

        .modal-body-custom {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #475569;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
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
        const catParent = document.getElementById('catParent');
        const catDesc = document.getElementById('catDesc');
        const parentSelectGroup = document.getElementById('parentSelectGroup');

        function toggleParentSelect(show) {
            parentSelectGroup.style.display = show ? 'block' : 'none';
            if (show) {
                catParent.setAttribute('required', 'required');
            } else {
                catParent.removeAttribute('required');
                catParent.value = '';
            }
        }

        function openAddModal() {
            modalTitle.innerText = 'Thêm danh mục mới';
            form.action = "{{ route('categories.store') }}";
            methodField.innerHTML = '';
            catName.value = '';
            catParent.value = '';
            catDesc.value = '';
            // Hiện lại tất cả option
            document.querySelectorAll('#catParent option').forEach(opt => opt.style.display = 'block');
            document.querySelector('input[name="cat_type"][value="parent"]').checked = true;
            toggleParentSelect(false);
            modal.style.display = 'block';
        }

        function openEditModal(category) {
            modalTitle.innerText = 'Chỉnh sửa danh mục';
            form.action = `/categories/${category.id}`;
            methodField.innerHTML = '@method("PUT")';
            catName.value = category.name;
            catDesc.value = category.description || '';

            // Hiện lại tất cả option trước
            document.querySelectorAll('#catParent option').forEach(opt => opt.style.display = 'block');
            // Ẩn chính nó trong danh sách cha để tránh chọn chính mình làm cha
            const selfOpt = document.querySelector(`.parent-opt-${category.id}`);
            if (selfOpt) selfOpt.style.display = 'none';

            if (category.type === 'child' || category.parent_id) {
                document.querySelector('input[name="cat_type"][value="child"]').checked = true;
                catParent.value = category.parent_id;
                toggleParentSelect(true);
            } else {
                document.querySelector('input[name="cat_type"][value="parent"]').checked = true;
                catParent.value = '';
                toggleParentSelect(false);
            }

            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == modal) closeModal();
        }

        form.onsubmit = function () {
            const isChild = document.querySelector('input[name="cat_type"][value="child"]').checked;
            if (isChild && !catParent.value) {
                alert('Vui lòng chọn danh mục cha cho danh mục con!');
                return false;
            }
            return true;
        };
    </script>
@endsection