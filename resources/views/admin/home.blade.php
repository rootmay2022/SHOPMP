@extends('admin.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <h1>Chào mừng đến trang quản trị!</h1>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-primary w-100">Quản lý Banner</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">Quản lý Người dùng</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.menus.index') }}" class="btn btn-primary w-100">Quản lý Menu</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-primary w-100">Quản lý Bài viết</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-success w-100">Quản lý Đơn hàng</a>
        </div>
    </div>
</div>
@endsection
