
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function stockAlerts()
    {
        $lowStockThreshold = 10;
        
        $outOfStock = Product::where('stock_quantity', '<=', 0)->get();
        $lowStock = Product::where('stock_quantity', '>', 0)
                           ->where('stock_quantity', '<', $lowStockThreshold)
                           ->get();
                           
        return response()->json([
            'total' => $outOfStock->count() + $lowStock->count(),
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock
        ]);
    }
}
