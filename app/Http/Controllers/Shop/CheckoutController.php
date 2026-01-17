<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Validate input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cod,bank,momo,vnpay',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = collect();
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            } else {
                $sessionId = session()->getId();
                $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
            }

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            $shipping = 30000; // 30,000 VND
            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $shipping + $tax;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . time(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->product->price * $item->quantity
                ]);
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', session()->getId())->delete();
            }

            DB::commit();

            // Redirect based on payment method
            if ($request->payment_method === 'cod') {
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');
            } else {
                // For online payment methods, redirect to payment gateway
                return $this->redirectToPaymentGateway($order, $request->payment_method);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    private function redirectToPaymentGateway($order, $paymentMethod)
    {
        // Placeholder for payment gateway integration
        // In real implementation, you would integrate with VNPay, MoMo, etc.
        
        switch ($paymentMethod) {
            case 'vnpay':
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công! VNPay integration coming soon.');
            case 'momo':
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công! MoMo integration coming soon.');
            case 'bank':
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công! Bank transfer details will be sent to your email.');
            default:
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');
        }
    }

    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}
