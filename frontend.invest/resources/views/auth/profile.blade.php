@extends('layout.master')

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<ol class="breadcrumb" aria-label="breadcrumbs">
			<li class="breadcrumb-item active"><a href="#"><h1>Tài khoản cá nhân</h1></a></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-6 offset-3">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="avatar avatar-xl avatar-rounded" style="background-image: url({{asset('images/icon-logo.svg')}})">
                                </span>
							</div>
							<div class="col">
								<h4 class="card-title m-0">{{ $data['full_name'] }}</h4>
								<div class="text-muted mt-1">{{ $data['email'] }}</div>
								<div class="mt-1">
									<span class="badge bg-green"></span> Active
								</div>
							</div>
							<div class="col-auto dropdown">
								<a href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
									Chức năng
								</a>
								<div class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
									<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#change-password">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><rect x="5" y="11" width="14" height="10" rx="2"></rect><circle cx="12" cy="16" r="1"></circle><path d="M8 11v-4a4 4 0 0 1 8 0v4"></path></svg>&nbsp;
										Đổi mật khẩu
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6 offset-3 mt-3">
						<h3 class="mb-2">Thông tin cá nhân</h3>
						<div class="hr mt-0 mb-3"></div>
						<div class="clearfix"></div>
						<div class="mb-3">
							<label class="form-label profile-page">Họ tên</label>
							<div class="form-control-plaintext">{{ $data['full_name'] }}</div>
						</div>
						<div class="mb-3">
							<label class="form-label profile-page">Email</label>
							<div class="form-control-plaintext">{{ $data['email'] }}</div>
						</div>
						<div class="mb-3">
							<label class="form-label profile-page">Phone</label>
							<div class="form-control-plaintext">{{ $data['phone'] }}</div>
						</div>
						<div class="mb-3">
							<label class="form-label profile-page">Trạng thái</label>
							<div class="form-control-plaintext">{{ ($data['status'] == 'active') ? "Active" : 'Deactive' }}</div>
						</div>
						<div class="mb-3">
							<label class="form-label profile-page">Phòng ban</label>
							<div class="form-control-plaintext">
								@foreach($data['role'] as $role)
									{{ $role['name'] }}&nbsp;&nbsp;
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="change-password">
	<div class="modal-dialog modal-sm show">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Đổi mật khẩu</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="alert alert-danger alert-change-pass d-none" role="alert">
							<h4 class="alert-title" style="white-space: pre"></h4>
						</div>
						<div class="alert alert-success d-none" role="alert">
							<h4 class="alert-title" style="white-space: pre">Đổi mật khẩu thành công</h4>
						</div>
						<input type="password" class="form-control mb-3" name="password_old" placeholder="Mật khẩu cũ">
						<input type="password" class="form-control mb-3" name="password_new" placeholder="Mật khẩu mới">
						<input type="password" class="form-control" name="password_re" placeholder="Nhập lại mật khẩu">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-bs-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="change-password-btn">Đổi mật khẩu</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function() {
		$('#change-password-btn').on('click', function() {
			$('.alert-change-pass').addClass('d-none');
			$('.alert-success').addClass('d-none');
			let password_old = $('input[name=password_old]').val();
			let password_new = $('input[name=password_new]').val();
			let password_re = $('input[name=password_re]').val();
			let data = new FormData();
			data.append('password_old', password_old);
			data.append('password_new', password_new);
			data.append('password_re', password_re);
			$.ajax({
				url: '{{ route('change_pass') }}',
				type: 'POST',
				contentType: false,
				processData: false,
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: data,
			}).done(function(result) {
				if (result.status == 200) {
					$('.alert-success').removeClass('d-none');
					$('input[name=password_old]').val('');
					$('input[name=password_new]').val('');
					$('input[name=password_re]').val('');
				}
				if (result.status == 400) {
					let html = '';
					result.message.map(item => {
						console.log(item);
						html += item + '\n';
					});
					$('.alert-change-pass .alert-title').text(html);
					$('.alert-change-pass').removeClass('d-none');
				}
			}).error(function(result) {
				alert("Update thất bại");
			});
		});
	});
</script>
@endsection
