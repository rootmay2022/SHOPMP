@extends('admin.layouts.master')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <h2 class="mt-4 mb-4">Quản lý sản phẩm</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tổng sản phẩm</h5>
                    <h3>{{ $productCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Đang bán</h5>
                    <h3>{{ $activeCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Ngừng bán</h5>
                    <h3>{{ $inactiveCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm nổi bật</h5>
                    <h3>{{ $featuredCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="GET" action="">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm kiếm sản phẩm..." value="{{ request('keyword') }}">
            <button class="btn btn-outline-primary" type="submit">Tìm</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm mới</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Nổi bật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: 70px; object-fit: cover;" class="img-thumbnail">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 100px; height: 70px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price) }} VND</td>
                    <td>{{ $product->category ?? '' }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success">Đang bán</span>
                        @else
                            <span class="badge bg-danger">Ngừng bán</span>
                        @endif
                    </td>
                    <td>
                        @if($product->is_featured)
                            <span class="badge bg-warning">Nổi bật</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
