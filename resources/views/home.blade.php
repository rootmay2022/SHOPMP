@extends('layouts.app')

@section('title', 'Trang chủ - Fashion Shop')

@section('content')
    <!-- Banner Slider Section -->
    <section class="banner-section">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($banners as $index => $banner)
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="banner-slide" style="background-image: url('{{ $banner->image }}');">
                        <div class="container">
                            <div class="row align-items-center min-vh-75">
                                <div class="col-lg-6">
                                    <div class="banner-content text-white">
                                        <h1 class="display-4 fw-bold mb-4">{{ $banner->title }}</h1>
                                        <p class="lead mb-4">{{ $banner->description }}</p>
                                        <div class="d-flex gap-3">
                                            <a href="{{ $banner->link }}" class="btn btn-light btn-lg px-4">
                                                <i class="fas fa-shopping-bag me-2"></i>Khám phá ngay
                                            </a>
                                            <a href="#about" class="btn btn-outline-light btn-lg px-4">
                                                <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Danh mục sản phẩm</h2>
                <p class="text-muted">Khám phá các danh mục thời trangđa dạng</p>
            </div>
            <div class="row g-4">
                @foreach($categories as $category)
                <div class="col-md-4 col-lg-2">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="{{ $category->icon ?? 'fas fa-spa' }} fa-2x text-primary"></i>
                            </div>
                            <h6 class="card-title">{{ $category->name }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
   <!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm được yêu thích nhất</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">

                    <!-- Hiển thị hình đã sửa -->
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">

                         

                    <div class="card-body d-flex flex-column">
                        <span class="category-badge mb-2">
                            {{ $product->category->name ?? 'Danh mục' }}
                        </span>

                        <h5 class="card-title">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h5>

                        <div class="mb-3">
                            <span class="price">{{ $product->getFormattedPrice() }}</span>
                            @if($product->hasDiscount())
                                <span class="old-price ms-2">{{ $product->getFormattedOldPrice() }}</span>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <div class="row g-2">
                                <div class="col-8">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products') }}" class="btn btn-outline-primary btn-lg">
                Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</section>


    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="https://png.pngtree.com/background/20230414/original/pngtree-cosmetic-set-static-scene-photography-advertising-background-picture-image_2424115.jpg" alt="About Us" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Về Fashion Shop</h2>
                    <p class="lead mb-4">Chúng tôi tự hào là địa chỉ tin cậy cung cấp các sản phẩm thời trangchất lượng cao, chính hãng với giá cả hợp lý.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <h6>Chính hãng 100%</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                                <h6>Giao hàng nhanh</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-headset fa-2x text-info mb-2"></i>
                                <h6>Hỗ trợ 24/7</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-undo fa-2x text-warning mb-2"></i>
                                <h6>Đổi trả dễ dàng</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Liên hệ với chúng tôi</h2>
                <p class="text-muted">Hãy để lại thông tin, chúng tôi sẽ liên hệ lại ngay</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone">
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Nội dung</label>
                                        <textarea class="form-control" id="message" rows="4" required></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add to cart functionality - removed as we now use real forms
</script>
@endsection