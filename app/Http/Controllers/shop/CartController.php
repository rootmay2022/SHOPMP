<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);
        $shipping = 30000;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:beauty_products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Kiểm tra sản phẩm có tồn tại và đang bán không
        if (!$product || !$product->is_active) {
            return back()->with('error', 'Sản phẩm không khả dụng');
        }

        $sessionId = session()->getId();
        $userId = Auth::id();

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existingCart = Cart::where('product_id', $request->product_id)
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
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'session_id' => $sessionId
            ]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        
        // Kiểm tra quyền sở hữu
        if (!$this->canModifyCart($cart)) {
            return back()->with('error', 'Không có quyền thay đổi giỏ hàng này');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Đã cập nhật số lượng!');
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        
        // Kiểm tra quyền sở hữu
        if (!$this->canModifyCart($cart)) {
            return back()->with('error', 'Không có quyền xóa sản phẩm này');
        }

        $cart->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        Cart::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    private function getCartItems()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        return Cart::with('product')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }

    private function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
    }

    private function canModifyCart($cart)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        if ($userId) {
            return $cart->user_id === $userId;
        } else {
            return $cart->session_id === $sessionId;
        }
    }
}
