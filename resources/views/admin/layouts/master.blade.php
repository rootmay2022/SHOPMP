<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .admin-topbar { background:#1f2937; }
        .admin-brand { color:#fff; font-weight:600; }
        .sidebar {
            position: fixed; top: 56px; bottom: 0; left: 0; width: 240px;
            background: #111827; color: #cbd5e1; overflow-y: auto;
        }
        .sidebar a { color:#cbd5e1; text-decoration:none; display:block; padding:10px 16px; border-radius:8px; }
        .sidebar a:hover, .sidebar a.active { background:#374151; color:#fff; }
        .content-wrapper { margin-left: 240px; padding: 24px; }
    </style>
    @stack('styles')
    @yield('styles')
    @stack('head')
    @yield('head')
    @vite([])
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark admin-topbar shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand admin-brand" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high me-2"></i>Admin Panel
            </a>
            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-gear me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.home') }}"><i class="fa-solid fa-house me-2"></i>Trang admin</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="sidebar p-3">
        <div class="mb-3 small text-uppercase text-secondary">Quản trị</div>
        <a href="{{ route('admin.dashboard') }}" class="mb-1 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="mb-1 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fa-solid fa-box-open me-2"></i>Sản phẩm</a>
        <a href="{{ route('admin.banners.index') }}" class="mb-1 {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i class="fa-solid fa-image me-2"></i>Banner</a>
        <a href="{{ route('admin.categories.index') }}" class="mb-1 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group me-2"></i>Danh mục</a>
      
        <a href="{{ route('admin.menus.index') }}" class="mb-1 {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}"><i class="fa-solid fa-bars me-2"></i>Menu</a>
        <a href="{{ route('admin.posts.index') }}" class="mb-1 {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"><i class="fa-solid fa-newspaper me-2"></i>Bài viết</a>
        <a href="{{ route('admin.users.index') }}" class="mb-1 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users me-2"></i>Người dùng</a>
        <a href="{{ route('admin.orders.index') }}" class="mb-1 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fa-solid fa-shopping-cart me-2"></i>Đơn hàng
        </a>
    </div>

    <main class="content-wrapper">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
