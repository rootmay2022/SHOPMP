@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number . ' - Fashion Shop')

@section('styles')
<style>
	.order-header {
		background: linear-gradient(45deg, #e91e63, #ff6b9d);
		color: #fff;
	}
	.customer-header { background: linear-gradient(45deg, #e91e63, #ff6b9d); color:#fff; }
	.items-header { background: linear-gradient(45deg, #e91e63, #ff6b9d); color:#fff; }
	.product-thumb {
		width: 70px; height: 70px; object-fit: cover; border-radius: 10px; box-shadow: 0 3px 8px rgba(0,0,0,0.12);
	}
</style>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Chi tiết đơn hàng #{{ $order->order_number }}</h2>

    <div class="card mb-4">
        <div class="card-header order-header">
            Thông tin đơn hàng
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->order_number }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> 
                        @php
                            $statusClass = '';
                            switch ($order->status) {
                                case 'pending':
                                    $statusClass = 'badge bg-warning text-dark';
                                    break;
                                case 'processing':
                                    $statusClass = 'badge bg-info text-dark';
                                    break;
                                case 'completed':
                                    $statusClass = 'badge bg-success';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'badge bg-danger';
                                    break;
                                default:
                                    $statusClass = 'badge bg-secondary';
                                    break;
                            }
                        @endphp
                        <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                    </p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : ucfirst($order->payment_method) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span></p>
                    <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header customer-header">
            Thông tin khách hàng
        </div>
        <div class="card-body">
            <p><strong>Họ và tên:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->customer_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header items-header">
            Sản phẩm trong đơn hàng
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:90px">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @php
                                        $imgPath = $item->product ? $item->product->image : null;
                                    @endphp
                                    <img class="product-thumb" src="{{ $imgPath ? asset($imgPath) : 'https://via.placeholder.com/80x80?text=No+Image' }}" alt="{{ $item->product_name }}">
                                </td>
                                <td>
                                    @if($item->product)
                                        <a href="{{ route('products.show', $item->product->id) }}">{{ $item->product_name }}</a>
                                    @else
                                        {{ $item->product_name }} (Sản phẩm không còn tồn tại)
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($item->total, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Tạm tính:</th>
                            <td>{{ number_format($order->subtotal, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Phí vận chuyển:</th>
                            <td>{{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Thuế:</th>
                            <td>{{ number_format($order->tax, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        <tr class="table-primary">
                            <th colspan="4" class="text-end">Tổng cộng:</th>
                            <td class="fw-bold">{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('my.orders') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
        <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
