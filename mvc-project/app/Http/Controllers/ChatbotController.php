<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['error' => 'No message provided'], 400);
        }

        $apiKey = config('services.openrouter.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'OpenRouter API key not configured'], 500);
        }

        // Fetch products to provide context
        $products = Product::where('status', 1)
            ->select('id', 'name', 'selling_price', 'description', 'image')
            ->get();

        $context = "Bạn là trợ lý bán hàng thông minh của Tiny Flowers - thương hiệu thời trang Streetwear cao cấp dành cho Gen Z tại Việt Nam. ";
        $context .= "Dưới đây là danh sách sản phẩm hiện có tại cửa hàng (Sử dụng thông tin này để tư vấn):\n";
        
        foreach ($products as $product) {
            $context .= "- ID: {$product->id} | Tên: {$product->name} | Giá: " . number_format($product->selling_price, 0, ',', '.') . " VNĐ | Mô tả: {$product->description}\n";
        }

        $context .= "\nNGUYÊN TẮC TRẢ LỜI:
1. Thân thiện, trẻ trung, sử dụng ngôn ngữ phù hợp với Gen Z.
2. Khi tư vấn sản phẩm, hãy nhắc chính xác Tên sản phẩm để hệ thống có thể hiển thị thẻ sản phẩm.
3. Nếu khách hỏi về style, hãy dựa vào mô tả sản phẩm để gợi ý (ví dụ: Boxy, Baggy, Oversize).
4. Câu trả lời ngắn gọn, sử dụng icon phù hợp.
5. Nếu không tìm thấy sản phẩm yêu cầu, hãy khéo léo giới thiệu các mẫu Streetwear bán chạy khác của shop.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'Tiny Flowers',
                'Content-Type' => 'application/json',
            ])->post("https://openrouter.ai/api/v1/chat/completions", [
                'model' => 'google/gemini-2.0-flash-001',
                'messages' => [
                    ['role' => 'system', 'content' => $context],
                    ['role' => 'user', 'content' => $message]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? "Xin lỗi, tôi gặp chút trục trặc khi suy nghĩ. Bạn thử lại nhé!";
                
                // Check for suggested products
                $suggestedProducts = [];
                $replyLower = mb_strtolower($reply);
                
                foreach ($products as $product) {
                    $productNameLower = mb_strtolower($product->name);
                    if (str_contains($replyLower, $productNameLower)) {
                        $suggestedProducts[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => number_format($product->selling_price, 0, ',', '.') . " VNĐ",
                            'image' => $product->image_url,
                            'url' => route('shop.show', $product->id)
                        ];
                        
                        if (count($suggestedProducts) >= 3) break;
                    }
                }

                return response()->json([
                    'reply' => $reply,
                    'suggested_products' => array_slice($suggestedProducts, 0, 3)
                ]);
            } else {
                Log::error('OpenRouter API Error: ' . $response->body());
                return response()->json(['error' => 'API Error: ' . $response->status()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function adminChat(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = $request->input('message');
        if (!$message) {
            return response()->json(['error' => 'No message provided'], 400);
        }

        $apiKey = config('services.openrouter.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'OpenRouter API key not configured'], 500);
        }

        // Gather Business Intelligence Data
        $totalRevenue = \App\Models\Order::where('status', 'Delivered')->sum('total_amount');
        $totalOrders = \App\Models\Order::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)->get();
        $topSelling = \App\Models\OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();
        
        $recentOrders = \App\Models\Order::latest()->take(5)->get();

        $context = "Bạn là Trợ lý AI Quản trị (Admin AI Assistant) của TINY FLOWERS. ";
        $context .= "Nhiệm vụ của bạn là hỗ trợ chủ doanh nghiệp quản lý cửa hàng, phân tích dữ liệu và đề xuất chiến lược kinh doanh.\n\n";
        $context .= "DỮ LIỆU KINH DOANH HIỆN TẠI:\n";
        $context .= "- Tổng doanh thu (Đã giao): " . number_format($totalRevenue, 0, ',', '.') . " VNĐ\n";
        $context .= "- Tổng số đơn hàng: {$totalOrders}\n";
        $context .= "- Tổng số sản phẩm trong kho: {$totalProducts}\n";
        
        $context .= "\nSẢN PHẨM BÁN CHẠY NHẤT:\n";
        foreach ($topSelling as $item) {
            $context .= "- {$item->product->name}: Bán được {$item->total_quantity} sản phẩm, mang lại " . number_format($item->total_sales, 0, ',', '.') . " VNĐ\n";
        }

        $context .= "\nSẢN PHẨM SẮP HẾT HÀNG (Dưới 10 cái):\n";
        foreach ($lowStockProducts as $p) {
            $context .= "- {$p->name} (Còn {$p->stock_quantity} cái)\n";
        }

        $context .= "\nĐƠN HÀNG GẦN ĐÂY:\n";
        foreach ($recentOrders as $order) {
            $context .= "- Mã đơn #{$order->id} | Tổng: " . number_format($order->total_amount, 0, ',', '.') . " VNĐ | Trạng thái: {$order->status}\n";
        }

        $context .= "\nNGUYÊN TẮC TRẢ LỜI:
1. Chuyên nghiệp, am hiểu về kinh doanh thời trang Streetwear.
2. Cung cấp số liệu cụ thể khi được hỏi về doanh thu hoặc hàng tồn.
3. Luôn đưa ra các gợi ý chiến lược dựa trên dữ liệu (ví dụ: cần nhập thêm hàng cho sản phẩm bán chạy, hoặc xả kho sản phẩm tồn lâu).
4. Sử dụng ngôn ngữ tiếng Việt tự nhiên, ngắn gọn, súc tích.
5. Nếu nhận thấy doanh thu tốt, hãy khích lệ Admin. Nếu có vấn đề (như nhiều đơn bị hủy hoặc hàng tồn quá ít), hãy cảnh báo.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'Tiny Flowers Admin',
                'Content-Type' => 'application/json',
            ])->post("https://openrouter.ai/api/v1/chat/completions", [
                'model' => 'google/gemini-2.0-flash-001',
                'messages' => [
                    ['role' => 'system', 'content' => $context],
                    ['role' => 'user', 'content' => $message]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? "Tôi gặp chút sự cố khi phân tích dữ liệu. Vui lòng thử lại!";
                
                return response()->json(['reply' => $reply]);
            } else {
                return response()->json(['error' => 'API Error'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Admin Chatbot Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
