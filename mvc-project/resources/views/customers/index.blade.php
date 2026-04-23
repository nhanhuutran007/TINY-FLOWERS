@extends('layouts.app')

@section('title', 'Quản lý khách hàng')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Quản lý khách hàng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Khách hàng</span>
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
                <h2 class="panel-title">Danh sách khách hàng</h2>
                <button class="btn-primary-custom" onclick="openAddCustomerModal()">
                    <i class="fas fa-plus"></i> Thêm khách hàng
                </button>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Tổng chi tiêu</th>
                        <th style="text-align: right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td style="font-weight: 600; color: #1e293b;">{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address ?: 'N/A' }}</td>
                            <td><div style="font-weight: 600; color: #10B981;">{{ number_format($customer->total_spent) }}đ</div></td>
                            <td style="text-align: right;">
                                <button class="btn-action edit" onclick="openEditCustomerModal({{ json_encode($customer) }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
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
                                <i class="fas fa-users" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                Chưa có khách hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Modal -->
    <div id="customerModal" class="modal-custom">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3 id="customerModalTitle">Thêm khách hàng mới</h3>
                <span class="close-modal" onclick="closeCustomerModal()">&times;</span>
            </div>
            <form id="customerForm" action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div id="customerMethodField"></div>
                <div class="modal-body-custom">
                    <div class="form-group">
                        <label>Tên khách hàng <span style="color: red;">*</span></label>
                        <input type="text" name="name" id="custName" required placeholder="Nhập tên khách hàng...">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại <span style="color: red;">*</span></label>
                        <input type="text" name="phone" id="custPhone" required placeholder="Ví dụ: 0912345678">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea name="address" id="custAddress" rows="3" placeholder="Nhập địa chỉ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-secondary-custom" onclick="closeCustomerModal()">Hủy</button>
                    <button type="submit" class="btn-primary-custom">Lưu khách hàng</button>
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
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #319DFF; box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1); }
        .modal-footer-custom { padding: 20px; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px; }
    </style>

    <script>
        const cModal = document.getElementById('customerModal');
        const cForm = document.getElementById('customerForm');
        const cTitle = document.getElementById('customerModalTitle');
        const cMethod = document.getElementById('customerMethodField');

        function openAddCustomerModal() {
            cTitle.innerText = 'Thêm khách hàng mới';
            cForm.action = "{{ route('customers.store') }}";
            cMethod.innerHTML = '';
            cForm.reset();
            cModal.style.display = 'block';
        }

        function openEditCustomerModal(customer) {
            cTitle.innerText = 'Chỉnh sửa khách hàng';
            cForm.action = `/customers/${customer.id}`;
            cMethod.innerHTML = '@method("PUT")';
            document.getElementById('custName').value = customer.name;
            document.getElementById('custPhone').value = customer.phone;
            document.getElementById('custAddress').value = customer.address || '';
            cModal.style.display = 'block';
        }

        function closeCustomerModal() { cModal.style.display = 'none'; }
        window.onclick = function(event) { if (event.target == cModal) closeCustomerModal(); }
    </script>
@endsection
