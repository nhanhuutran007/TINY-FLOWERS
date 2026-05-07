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

        $apiKey = env('OPENROUTER_API_KEY');
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
}
