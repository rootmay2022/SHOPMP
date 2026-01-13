@extends('admin.layouts.master')

@section('title', 'Sửa Banner')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Sửa Banner</h1>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="bannerEditForm" action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" 
                                   id="link" name="link" value="{{ old('link', $banner->link) }}" placeholder="/products hoặc https://example.com">
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Có thể nhập link tương đối (ví dụ: /products) hoặc URL hoàn chỉnh</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh banner</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Để trống nếu không muốn thay đổi ảnh. Định dạng: JPG, PNG, GIF. Tối đa: 2MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="1">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Kích hoạt banner
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div id="imagePreview">
                                        @if($banner->image)
                                            <img id="previewImg" src="{{ asset($banner->image) }}" alt="Current Image" 
                                                 class="img-fluid rounded" style="max-height: 200px;">
                                            <p class="text-muted mt-2 mb-0">Ảnh hiện tại</p>
                                        @else
                                            <div id="imagePlaceholder">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Chưa có ảnh</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    console.log('Edit banner page loaded');
    
    // Find the specific banner edit form by ID
    const bannerForm = document.getElementById('bannerEditForm');
    
    if (bannerForm) {
        console.log('Banner edit form found:', bannerForm);
        console.log('Form action:', bannerForm.action);
        console.log('Form method:', bannerForm.method);
        console.log('CSRF token:', bannerForm.querySelector('input[name="_token"]')?.value);
        
        // Debug form submission for banner form only
        bannerForm.addEventListener('submit', function(e) {
            console.log('=== BANNER FORM SUBMISSION START ===');
            console.log('Banner form submitting...');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Log all form fields
            const formData = new FormData(this);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            console.log('=== BANNER FORM SUBMISSION END ===');
        });
    } else {
        console.error('Banner edit form not found!');
        // Fallback: try to find form by ID or class
        const forms = document.querySelectorAll('form');
        console.log('All forms found:', forms.length);
        forms.forEach((form, index) => {
            console.log(`Form ${index}:`, form.action, form.method);
        });
    }
    
    // Preview ảnh khi chọn file mới
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Image file selected:', file.name, file.size, file.type);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.getElementById('imagePreview');
                    if (previewDiv) {
                        previewDiv.innerHTML = `
                            <img id="previewImg" src="${e.target.result}" alt="New Image Preview" 
                                 class="img-fluid rounded" style="max-height: 200px;">
                            <p class="text-muted mt-2 mb-0">Ảnh mới (sẽ thay thế ảnh cũ)</p>
                        `;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection
