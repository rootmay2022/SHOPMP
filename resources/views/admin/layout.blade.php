<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .admin-sidebar {
            background: #fff;
            border-right: 1px solid #e5e7eb;
            min-height: 100vh;
            box-shadow: 2px 0 8px rgba(0,0,0,0.03);
        }
        .admin-sidebar .nav-link {
            color: #374151;
            border-radius: 8px;
            margin-bottom: 6px;
        }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover {
            background: #e0e7ff;
            color: #1d4ed8;
        }
        .admin-content {
            padding: 32px 24px;
        }
        .admin-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 32px;
        }
        .pagination {
            justify-content: center;
            margin-top: 16px;
        }
        .pagination .page-item .page-link {
            padding: 4px 12px;
            font-size: 14px;
            border-radius: 6px;
        }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            display: none !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fa fa-cogs me-2"></i>Admin Panel
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 admin-sidebar pt-4">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fa fa-shopping-cart me-2"></i> Đơn hàng
                        </a>
                    </li>
                    <!-- Thêm các menu khác nếu cần -->
                </ul>
            </div>
            <div class="col-md-10 admin-content">
                <div class="admin-card">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>