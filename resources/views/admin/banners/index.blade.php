@extends('admin.layouts.master')

@section('title', 'Quản lý Banner')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý Banner</h1>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Thêm Banner
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($banners->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="120">Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Link</th>
                                <th width="80">Thứ tự</th>
                                <th width="100">Trạng thái</th>
                               
                                <th width="150">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                            <tr>
                                <td>
                                    @if($banner->image)
                                        <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" 
                                             class="img-thumbnail" style="width: 100px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 100px; height: 70px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $banner->title }}</strong>
                                </td>
                                <td>
                                    {{ Str::limit($banner->description, 50) }}
                                </td>
                                <td>
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>Link
                                        </a>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $banner->sort_order }}</span>
                                </td>
                                                                <td>
                                    @if($banner->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" 
                                           class="btn btn-sm btn-primary" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.banners.toggle-status', $banner->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning" title="Đổi trạng thái">
                                                <i class="fas fa-toggle-{{ $banner->is_active ? 'on' : 'off' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc muốn xóa banner này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5>Chưa có banner nào</h5>
                    <p class="text-muted">Hãy thêm banner đầu tiên để bắt đầu</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Banner
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
