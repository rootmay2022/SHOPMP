@extends('layouts.app')

@section('title', 'Đặt hàng thành công - Fashion Shop')

@section('content')
    <!-- Success Header -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="fw-bold text-success">Đặt hàng thành công!</h1>
                    <p class="lead text-muted">Cảm ơn bạn đã mua sắm tại Fashion Shop</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Thông tin đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Mã đơn hàng:</strong>
                                    <span class="text-primary">{{ $order->order_number }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Ngày đặt:</strong>
                                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Trạng thái:</strong>
                                    <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Phương thức thanh toán:</strong>
                                    <span>
                                        @switch($order->payment_method)
                                            @case('cod')
                                                <i class="fas fa-money-bill-wave me-1"></i>Thanh toán khi nhận hàng
                                                @break
                                            @case('bank')
                                                <i class="fas fa-university me-1"></i>Chuyển khoản ngân hàng
                                                @break
                                            @case('momo')
                                                <i class="fas fa-mobile-alt me-1"></i>Ví MoMo
                                                @break
                                            @case('vnpay')
                                                <i class="fas fa-credit-card me-1"></i>VNPay
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <h6>Thông tin khách hàng</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Họ và tên:</strong>
                                    <span>{{ $order->customer_name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong>
                                    <span>{{ $order->customer_email }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Số điện thoại:</strong>
                                    <span>{{ $order->customer_phone }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Địa chỉ:</strong>
                                    <span>{{ $order->customer_address }}</span>
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="mb-3">
                                    <strong>Ghi chú:</strong>
                                    <span>{{ $order->notes }}</span>
                                </div>
                            @endif

                            <hr>

                            <h6>Chi tiết đơn hàng</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->price) }}đ</td>
                                            <td class="text-end">{{ number_format($item->total) }}đ</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tạm tính:</span>
                                        <span>{{ number_format($order->subtotal) }}đ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển:</span>
                                        <span>{{ number_format($order->shipping_fee) }}đ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Thuế (10%):</span>
                                        <span>{{ number_format($order->tax) }}đ</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Tổng cộng:</strong>
                                        <strong class="text-primary fs-5">{{ number_format($order->total) }}đ</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('home') }}" class="btn btn-primary me-2">
                                    <i class="fas fa-home me-2"></i>Về trang chủ
                                </a>
                                <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
