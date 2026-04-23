<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'username' => 'admin',
                'fullname' => 'Admin User',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'status' => 'active',
                'is_active' => 1
            ]
        );

        // 2. Clear existing data to avoid duplicates
        // OrderItem::truncate();
        // Order::truncate();
        // Product::truncate();
        // Category::truncate();

        // 3. Product Data from Source
        $sourceProducts = [
            ['id' => 'j1', 'name' => 'Áo Khoác Dù Parachute Bụi Bặm', 'price' => '193.000đ', 'image' => 'SalePage/j1.png', 'category' => 'Áo Khoác'],
            ['id' => 'j2', 'name' => 'Áo Khoác Gió Form Boxy Phối Trắng', 'price' => '210.000đ', 'image' => 'SalePage/j2.png', 'category' => 'Áo Khoác'],
            ['id' => 'j3', 'name' => 'Áo Khoác Chống Nắng UV Phom Rộng', 'price' => '185.000đ', 'image' => 'SalePage/j3.png', 'category' => 'Áo Khoác'],
            ['id' => 'j4', 'name' => 'Áo Khoác Nhẹ Cổ Đứng Minimal', 'price' => '220.000đ', 'image' => 'SalePage/j4.png', 'category' => 'Áo Khoác'],
            ['id' => 'j5', 'name' => 'Áo Khoác Denim Đen Wash Rách', 'price' => '250.000đ', 'image' => 'SalePage/j5.png', 'category' => 'Áo Khoác'],
            ['id' => 'j6', 'name' => 'Áo Khoác Bomber Da PU Cao Cấp', 'price' => '320.000đ', 'image' => 'SalePage/j6.png', 'category' => 'Áo Khoác'],
            ['id' => 'j7', 'name' => 'Áo Khoác Nỉ Form Thụng Varsity', 'price' => '199.000đ', 'image' => 'SalePage/j7.png', 'category' => 'Áo Khoác'],
            ['id' => 'j8', 'name' => 'Jacket Kaki Mỏng Mùa Thu Nhẹ Nhàng', 'price' => '215.000đ', 'image' => 'SalePage/j8.png', 'category' => 'Áo Khoác'],
            
            ['id' => 't1', 'name' => 'Áo Thun Cotton Mát Lạnh Thoáng Khí', 'price' => '99.000đ', 'image' => 'SalePage/t1.png', 'category' => 'Áo Thun'],
            ['id' => 't2', 'name' => 'Áo Baby Tee Thêu Logo Nổi Bật', 'price' => '120.000đ', 'image' => 'SalePage/t2.png', 'category' => 'Áo Thun'],
            ['id' => 't3', 'name' => 'Áo Thun Drop Shoulder Dáng Thụng', 'price' => '149.000đ', 'image' => 'SalePage/t3.png', 'category' => 'Áo Thun'],
            ['id' => 't4', 'name' => 'Áo Thun Wash Bụi Phong Cách Đường Phố', 'price' => '169.000đ', 'image' => 'SalePage/t4.png', 'category' => 'Áo Thun'],
            ['id' => 't5', 'name' => 'Polo Zip Vải Mắt Chim Hút Mồ Hôi', 'price' => '155.000đ', 'image' => 'SalePage/t5.png', 'category' => 'Áo Polo'],
            ['id' => 't6', 'name' => 'Áo Thun Graphic In Nổi Y2K', 'price' => '135.000đ', 'image' => 'SalePage/t6.png', 'category' => 'Áo Thun'],
            ['id' => 't7', 'name' => 'Tank Top Thể Thao Siêu Nhẹ', 'price' => '89.000đ', 'image' => 'SalePage/t7.png', 'category' => 'Tank Top'],
            ['id' => 't8', 'name' => 'Áo Thun Trơn Basic Dễ Phối Đồ', 'price' => '110.000đ', 'image' => 'SalePage/t8.png', 'category' => 'Áo Thun'],
            
            ['id' => 'f101', 'name' => 'Áo Cardigan Oversize Wash Bụi', 'price' => '350.000đ', 'image' => 'Products/F1/1.png', 'category' => 'Form Oversized'],
            ['id' => 'f102', 'name' => 'Hoodie Khổng Lồ Zip Local Brand', 'price' => '420.000đ', 'image' => 'Products/F1/2.png', 'category' => 'Form Oversized'],
            ['id' => 'f103', 'name' => 'Quần Hộp Oversize Trượt Ván', 'price' => '290.000đ', 'image' => 'Products/F1/3.png', 'category' => 'Quần'],
            ['id' => 'f104', 'name' => 'Áo Len Thủng Oversize Y2K', 'price' => '350.000đ', 'image' => 'Products/F1/4.png', 'category' => 'Form Oversized'],
            ['id' => 'f105', 'name' => 'Sơ Mi Flannel Kẻ Caro Form Rộng', 'price' => '280.000đ', 'image' => 'Products/F1/5.png', 'category' => 'Áo Sơ Mi'],
            ['id' => 'f106', 'name' => 'Quần Tây Oversize', 'price' => '380.000đ', 'image' => 'Products/F1/6.png', 'category' => 'Quần'],
            ['id' => 'f107', 'name' => 'Áo Bóng Rổ Layer Phom Rộng', 'price' => '210.000đ', 'image' => 'Products/F1/7.png', 'category' => 'Form Oversized'],
            ['id' => 'f108', 'name' => 'Quần Jean Rách Gối Siêu Thụng', 'price' => '390.000đ', 'image' => 'Products/F1/8.png', 'category' => 'Quần Jean'],
            
            ['id' => 'f201', 'name' => 'Quần Jean Baggy Cào Xước', 'price' => '350.000đ', 'image' => 'Products/F2/1.png', 'category' => 'Quần Jean'],
            ['id' => 'f202', 'name' => 'Quần Kaki Baggy Túi Hộp Lớn', 'price' => '320.000đ', 'image' => 'Products/F2/2.png', 'category' => 'Quần'],
            ['id' => 'f203', 'name' => 'Quần Đùi Baggy Jean Jorts', 'price' => '280.000đ', 'image' => 'Products/F2/3.png', 'category' => 'Quần Jean'],
            ['id' => 'f204', 'name' => 'Sơ Mi Denim Dáng Baggy', 'price' => '310.000đ', 'image' => 'Products/F2/4.png', 'category' => 'Áo Sơ Mi'],
            ['id' => 'f205', 'name' => 'Áo Thun Rộng Phối Tay Đôi', 'price' => '190.000đ', 'image' => 'Products/F2/5.png', 'category' => 'Áo Thun'],
            ['id' => 'f206', 'name' => 'Quần Nhung Tăm Corduroy Baggy', 'price' => '340.000đ', 'image' => 'Products/F2/6.png', 'category' => 'Quần'],
            ['id' => 'f207', 'name' => 'Quần Dù Parachute Xếp Ly Gối', 'price' => '360.000đ', 'image' => 'Products/F2/7.png', 'category' => 'Quần'],
            ['id' => 'f208', 'name' => 'Áo Khoác Kaki Bụi Bặm Dáng Thụng', 'price' => '450.000đ', 'image' => 'Products/F2/8.png', 'category' => 'Áo Khoác'],

            ['id' => 'f501', 'name' => 'Áo Thun Phom Boxy Trơn', 'price' => '210.000đ', 'image' => 'Products/F5/1.png', 'category' => 'Áo Thun'],
            ['id' => 'f503', 'name' => 'Jacket Kaki Boxy Zip Hai Chiều', 'price' => '410.000đ', 'image' => 'Products/F5/3.png', 'category' => 'Áo Khoác'],
        ];

        foreach ($sourceProducts as $item) {
            // Get or create category
            $category = Category::firstOrCreate(['name' => $item['category']]);
            
            // Clean price: '193.000đ' -> 193000
            $price = (float) str_replace(['.', 'đ'], '', $item['price']);
            
            Product::updateOrCreate(
                ['barcode' => strtoupper($item['id'])],
                [
                    'name' => $item['name'],
                    'category_id' => $category->id,
                    'cost_price' => $price * 0.7,
                    'selling_price' => $price,
                    'material' => 'Premium Fabric',
                    'stock_quantity' => rand(10, 100),
                    'status' => 1,
                    'image' => 'source/' . $item['image']
                ]
            );
        }

        // 4. Sample Customers
        $c1 = Customer::firstOrCreate(['phone' => '0912345678'], ['name' => 'Nguyễn Văn A', 'address' => 'Hà Nội', 'total_spent' => 1300000]);
        $c2 = Customer::firstOrCreate(['phone' => '0987654321'], ['name' => 'Trần Thị B', 'address' => 'TP. HCM', 'total_spent' => 450000]);

        // 5. Sample Orders (Only if no orders exist)
        if (Order::count() == 0) {
            $p1 = Product::first();
            $o1 = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_id' => $c1->id,
                'user_id' => $admin->user_id,
                'subtotal' => $p1->selling_price,
                'discount' => 0,
                'total_amount' => $p1->selling_price,
                'amount_paid' => $p1->selling_price,
                'change_amount' => 0,
                'payment_method' => 'cash',
                'status' => 'completed'
            ]);

            OrderItem::create([
                'order_id' => $o1->id,
                'product_id' => $p1->id,
                'product_name' => $p1->name,
                'cost_price' => $p1->cost_price,
                'selling_price' => $p1->selling_price,
                'quantity' => 1,
                'subtotal' => $p1->selling_price
            ]);
        }
    }
}
