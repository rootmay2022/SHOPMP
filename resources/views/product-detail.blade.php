@extends('layouts.app')

@section('title', $product->name . ' - Fashion Shop')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}?category={{ $product->category }}" class="text-decoration-none">{{ $product->category }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="product-gallery">
                    <div class="main-image mb-3">
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">

                            
                    </div>
                    <div class="thumbnail-images d-flex gap-2">
                       
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <span class="category-badge mb-3">{{ $product->category }}</span>
                    
                    <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                    
                    @if($product->brand)
                    <p class="text-muted mb-3">
                        <i class="fas fa-tag me-2"></i>Thương hiệu: <strong>{{ $product->brand }}</strong>
                    </p>
                    @endif

                    <!-- Price Section -->
                    <div class="price-section mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="price fs-2 fw-bold">{{ $product->getFormattedPrice() }}</span>
                            @if($product->hasDiscount())
                                <span class="old-price fs-5">{{ $product->getFormattedOldPrice() }}</span>
                                <span class="badge bg-danger fs-6">Giảm {{ $product->getDiscountPercentage() }}%</span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="stock-status mb-4">
                        @if($product->stock > 0)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>Còn hàng ({{ $product->stock }} sản phẩm)
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times-circle me-1"></i>Hết hàng
                            </span>
                        @endif
                    </div>

                    <!-- Add to Cart Section -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Thêm vào giỏ hàng</h5>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Số lượng</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                                    </div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions mb-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100" onclick="buyNow()" 
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-bolt me-2"></i>Mua ngay
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-secondary w-100" onclick="addToWishlist()">
                                    <i class="fas fa-heart me-2"></i>Yêu thích
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Features -->
                    <div class="product-features mb-4">
                        <h6 class="fw-bold mb-3">Tính năng nổi bật:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Chính hãng 100%
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Giao hàng toàn quốc
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Đổi trả trong 30 ngày
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Hỗ trợ 24/7
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Description -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                                        data-bs-target="#description" type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>Mô tả
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                                        data-bs-target="#specifications" type="button" role="tab">
                                    <i class="fas fa-list me-2"></i>Thông số
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                                        data-bs-target="#reviews" type="button" role="tab">
                                    <i class="fas fa-star me-2"></i>Đánh giá
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-4" id="productTabsContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <h5 class="fw-bold mb-3">Mô tả sản phẩm</h5>
                                <div class="product-description">
                                    {!! nl2br(e($product->description ?? 'Chưa có mô tả chi tiết cho sản phẩm này.')) !!}
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="specifications" role="tabpanel">
                                <h5 class="fw-bold mb-3">Thông số kỹ thuật</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Tên sản phẩm:</td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Danh mục:</td>
                                                <td>{{ $product->category }}</td>
                                            </tr>
                                            @if($product->brand)
                                            <tr>
                                                <td class="fw-bold">Thương hiệu:</td>
                                                <td>{{ $product->brand }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td class="fw-bold">Tình trạng:</td>
                                                <td>
                                                    @if($product->stock > 0)
                                                        <span class="text-success">Còn hàng</span>
                                                    @else
                                                        <span class="text-danger">Hết hàng</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <h5 class="fw-bold mb-3">Đánh giá sản phẩm</h5>
                                <div class="text-center py-4">
                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                                    <button class="btn btn-primary">Viết đánh giá đầu tiên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Miễn phí vận chuyển từ 500k
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>Giao hàng trong 2-4 ngày
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-shield-alt text-warning me-2"></i>Đảm bảo chất lượng
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-headset me-2"></i>Hỗ trợ khách hàng
                        </h6>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>0123 456 789
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2"></i>support@beautyshop.com
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-clock me-2"></i>24/7
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm liên quan</h2>
            <p class="text-muted">Những sản phẩm tương tự bạn có thể thích</p>
        </div>
        
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">
                    <img src="{{ $relatedProduct->image }}" class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                    @if($relatedProduct->hasDiscount())
                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">Giảm {{ $relatedProduct->getDiscountPercentage() }}%</span>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span class="category-badge mb-2">{{ $relatedProduct->category }}</span>
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="text-decoration-none text-dark">
                                {{ $relatedProduct->name }}
                            </a>
                        </h6>
                        <div class="mb-3">
                            <span class="price">{{ $relatedProduct->getFormattedPrice() }}</span>
                            @if($relatedProduct->hasDiscount())
                            <span class="old-price ms-2">{{ $relatedProduct->getFormattedOldPrice() }}</span>
                            @endif
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Change main image when clicking thumbnails
    function changeImage(thumbnail) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = thumbnail.src;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.classList.remove('active');
        });
        thumbnail.classList.add('active');
    }

    // Quantity controls
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }

    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const maxStock = {{ $product->stock }};
        if (quantityInput.value < maxStock) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }
    }

    // Add to cart functionality
    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        // Add your cart logic here
        alert(`Đã thêm ${quantity} sản phẩm "${@json($product->name)}" vào giỏ hàng!`);
    }

    // Buy now functionality
    function buyNow() {
        const quantity = document.getElementById('quantity').value;
        // Add your buy now logic here
        alert(`Chuyển đến trang thanh toán cho ${quantity} sản phẩm "${@json($product->name)}"`);
    }

    // Add to wishlist functionality
    function addToWishlist() {
        // Add your wishlist logic here
        alert('Đã thêm sản phẩm vào danh sách yêu thích!');
    }
</script>

<style>
    .thumbnail-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .thumbnail-img:hover {
        transform: scale(1.05);
    }
    
    .thumbnail-img.active {
        border: 2px solid #e91e63;
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        color: #e91e63;
        border-bottom: 2px solid #e91e63;
        background: none;
    }
    
    .product-description {
        line-height: 1.8;
    }
</style>
@endsection 