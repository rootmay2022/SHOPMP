@extends('admin.layouts.master')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.banners.index') }}">Quản lý Banner</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Quản lý Người dùng</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.menus.index') }}">Quản lý Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.posts.index') }}">Quản lý Bài viết</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Quản lý Sản phẩm</a></li>
                </ul>
            </div>
        </nav>
        <!-- Main dashboard content -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <h4 class="mt-4 mb-4">Dashboard</h4>
            <div class="alert alert-info">Chào mừng bạn đến trang quản trị!</div>
        </main>
    </div>
</div>
@endsection
