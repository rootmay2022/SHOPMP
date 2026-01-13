@extends('layouts.app')

@section('title', 'Giỏ hàng - Fashion Shop')

@section('content')
    <!-- Page Header -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold">Giỏ hàng</h1>
                    <p class="lead text-muted">Kiểm tra và thanh toán đơn hàng của bạn</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sản phẩm trong giỏ hàng</h5>
                            @if(count($cartItems) > 0)
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                        <i class="fas fa-trash me-1"></i>Xóa tất cả
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="card-body">
                            @if(count($cartItems) > 0)
                                @foreach($cartItems as $item)
                                <div class="row align-items-center py-3 border-bottom">
                                    <div class="col-md-2">
                                        <img src="{{ $item->product->image ?? 'https://via.placeholder.com/100x100?text=Product' }}" alt="{{ $item->product->name }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Mã SP: {{ $item->product->id }}</small>
                                        @if($item->product->hasDiscount())
                                            <br><small class="text-danger">Giảm {{ $item->product->getDiscountPercentage() }}%</small>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $item->id }}, -1)">-</button>
                                                <input type="number" class="form-control text-center" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="price">{{ number_format($item->product->price) }}đ</span>
                                        @if($item->product->hasDiscount())
                                            <br><small class="text-decoration-line-through text-muted">{{ number_format($item->product->old_price) }}đ</small>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5>Giỏ hàng trống</h5>
                                    <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($subtotal) }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span>{{ number_format($shipping) }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Thuế (10%):</span>
                                <span>{{ number_format($tax) }}đ</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng cộng:</strong>
                                <strong class="price">{{ number_format($total) }}đ</strong>
                            </div>

                            @if(count($cartItems) > 0)
                                <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                    <i class="fas fa-credit-card me-2"></i>Thanh toán ngay
                                </button>
                            @else
                                <button class="btn btn-primary w-100 mb-3" disabled>
                                    <i class="fas fa-credit-card me-2"></i>Thanh toán ngay
                                </button>
                            @endif

                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    Thanh toán an toàn với SSL
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Mã giảm giá</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                                <button class="btn btn-outline-primary" type="button">Áp dụng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Thông tin giao hàng</h6>
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="customer_email" value="{{ auth()->user()->email ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" name="customer_phone" value="{{ auth()->user()->phone ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" name="customer_address" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Phương thức thanh toán</h6>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Thanh toán khi nhận hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                                        <label class="form-check-label" for="bank">
                                            <i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                        <label class="form-check-label" for="momo">
                                            <i class="fas fa-mobile-alt me-2"></i>Ví MoMo
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                        <label class="form-check-label" for="vnpay">
                                            <i class="fas fa-credit-card me-2"></i>VNPay
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Ghi chú</h6>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Ghi chú cho đơn hàng (không bắt buộc)"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" form="checkoutForm" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Xác nhận đặt hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function updateQuantity(cartId, change) {
        const input = document.querySelector(`input[name="cart_id"][value="${cartId}"]`).closest('form').querySelector('input[name="quantity"]');
        let newValue = parseInt(input.value) + change;
        if (newValue < 1) newValue = 1;
        input.value = newValue;
        input.closest('form').submit();
    }
</script>
@endsection 