<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Lọc theo thương hiệu
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        // Lọc theo khoảng giá
        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case 'under_200k':
                    $query->where('price', '<', 200000);
                    break;
                case '200k_500k':
                    $query->whereBetween('price', [200000, 500000]);
                    break;
                case '500k_1m':
                    $query->whereBetween('price', [500000, 1000000]);
                    break;
                case 'over_1m':
                    $query->where('price', '>', 1000000);
                    break;
            }
        }

        // Sắp xếp
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::active()->get();

        return view('products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);
        
        if (!$product->is_active) {
            return back()->with('error', 'Sản phẩm này hiện không khả dụng');
        }

        $sessionId = session()->getId();
        $userId = Auth::id();

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existingCart = \App\Models\Cart::where('product_id', $id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingCart) {
            // Cập nhật số lượng
            $existingCart->update([
                'quantity' => $existingCart->quantity + $request->quantity
            ]);
        } else {
            // Thêm mới vào giỏ hàng
            \App\Models\Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $request->quantity,
                'session_id' => $sessionId
            ]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
}
