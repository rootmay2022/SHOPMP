<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Danh sách đơn hàng
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->filled('customer_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }
        $orders = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->all());
        return view('admin.order.index', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    // Cập nhật trạng thái
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        if ($order->status === 'completed') {
            return back()->with('error', 'Đơn hàng đã hoàn thành, không thể thay đổi');
        }

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
