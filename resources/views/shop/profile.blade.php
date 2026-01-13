@extends('layouts.app')

@section('title', 'Hồ sơ của tôi - Fashion Shop')

@section('styles')
<style>
	.profile-hero { background: linear-gradient(45deg, #f06292, #ff9ec4); color:#fff; border-radius: 16px; }
	.card-elev { border: none; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
	.form-control:focus { box-shadow: 0 0 0 .2rem rgba(240,98,146,.15); border-color: #f06292; }
	.btn-pink { background: linear-gradient(45deg, #f06292, #ff9ec4); border: none; color:#fff; }
	.btn-pink:hover { filter: brightness(.97); }
</style>
@endsection

@section('content')
<div class="container py-4">
	<div class="profile-hero p-4 mb-4 d-flex align-items-center justify-content-between">
		<div>
			<h2 class="mb-1">Xin chào, {{ $user->name }}</h2>
			<div>{{ $user->email }}</div>
		</div>
	</div>

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	@endif
	@if($errors->any())
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<ul class="mb-0">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	@endif

	<div class="row g-4">
		<div class="col-lg-6">
			<div class="card card-elev">
				<div class="card-header bg-white d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Thông tin tài khoản</h5>
					<button id="editProfileBtn" type="button" class="btn btn-sm btn-outline-secondary">Chỉnh sửa</button>
				</div>
				<div class="card-body">
					<form id="profileForm" method="POST" action="{{ route('profile.update') }}">
						@csrf
						<div class="mb-3">
							<label class="form-label">Họ và tên</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required disabled>
						</div>
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required disabled>
						</div>
						<div class="mb-3">
							<label class="form-label">Số điện thoại</label>
							<input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" disabled>
						</div>
						<div class="d-flex gap-2">
							<button id="saveProfileBtn" class="btn btn-pink d-none" type="submit">Lưu thay đổi</button>
							<button id="cancelEditBtn" class="btn btn-outline-secondary d-none" type="button">Hủy</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card card-elev">
				<div class="card-header bg-white d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Đổi mật khẩu</h5>
					<button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#passwordCollapse" aria-expanded="false">Mở</button>
				</div>
				<div id="passwordCollapse" class="collapse">
					<div class="card-body">
						<form method="POST" action="{{ route('profile.password') }}">
							@csrf
							<div class="mb-3">
								<label class="form-label">Mật khẩu hiện tại</label>
								<input type="password" class="form-control" name="current_password" autocomplete="current-password">
							</div>
							<div class="mb-3">
								<label class="form-label">Mật khẩu mới</label>
								<input type="password" class="form-control" name="password" autocomplete="new-password">
							</div>
							<div class="mb-3">
								<label class="form-label">Xác nhận mật khẩu mới</label>
								<input type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
							</div>
							<button class="btn btn-pink" type="submit">Cập nhật mật khẩu</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
(function(){
	const form = document.getElementById('profileForm');
	const inputs = form.querySelectorAll('input');
	const editBtn = document.getElementById('editProfileBtn');
	const saveBtn = document.getElementById('saveProfileBtn');
	const cancelBtn = document.getElementById('cancelEditBtn');
	let editing = false;

	function setEditing(state){
		editing = state;
		inputs.forEach(i => i.disabled = !state);
		saveBtn.classList.toggle('d-none', !state);
		cancelBtn.classList.toggle('d-none', !state);
		editBtn.textContent = state ? 'Đang chỉnh sửa' : 'Chỉnh sửa';
		editBtn.disabled = state;
	}

	editBtn.addEventListener('click', () => setEditing(true));
	cancelBtn.addEventListener('click', () => {
		// khôi phục giá trị gốc từ data attribute hoặc reload trang
		window.location.reload();
	});
})();
</script>
@endsection
