@extends('admin.layouts.master')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid">
    <h2 class="mt-4 mb-4">Quản lý Danh mục</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <div></div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Thêm mới</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug ?? '-' }}</td>
                    <td>{{ Str::limit($category->description, 50) ?? '-' }}</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">Đang hoạt động</span>
                        @else
                            <span class="badge bg-danger">Vô hiệu hóa</span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                            
                            <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ $category->is_active ? 'Vô hiệu' : 'Kích hoạt' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Chưa có danh mục nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
