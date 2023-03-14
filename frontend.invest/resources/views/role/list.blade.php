@extends('layout.master')
@section('page_name','Danh sách nhóm quyền')

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<ol class="breadcrumb" aria-label="breadcrumbs">
			<li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý nhóm quyền</a></li>
		</ol>
	</div>
</div>
@include('layout.alert_success')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				{{-- Head --}}
				<div class="row mb-3">
					<div class="col-12">
						<h1 class="d-inline-block">Danh sách nhóm quyền</h1>
						<a class="float-right btn btn-primary d-inline-block" href="{{ route('role_create') }}">
							<i class="fas fa-plus"></i>&nbsp;
							Thêm mới
						</a>
						<div class="clearfix"></div>
					</div>
				</div>
				{{-- Search --}}
				<div class="row mb-3">
					<div class="col-12">
						<div class="float-right d-inline-block" id="filter-data">
							<a class="btn" href="{{ route('role_list') }}">
								Xóa filter
							</a>
							<a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
								<i class="fas fa-filter"></i>&nbsp;
								Lọc dữ liệu
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
								<div class="card d-flex flex-column">
									<div class="card-body d-flex flex-column">
										<form method="get">
											<div class="mb-3">
												<div class="text-large">Thông tin tìm kiếm</div>
												<hr class="mt-2 mb-0">
											</div>
											<div class="form-group mb-3">
												<label class="form-label">Tên nhóm</label>
												<div>
													<input type="text" name="name" class="form-control" placeholder="Tên nhóm" value="{{ request()->get('name') }}" autocomplete="off">
												</div>
											</div>
											<div class="form-group text-right">
												<button type="submit" class="btn btn-primary">
													<i class="fas fa-search"></i>&nbsp; Tìm kiếm
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Table --}}
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-vcenter table-nowrap table-striped">
								<thead>
									<tr>
										<th>STT</th>
										<th>Tên nhóm</th>
										<th>Trạng thái</th>
										<th class="w-1"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $key => $item)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $item['name'] }}</td>
										<td>
											<label class="form-check form-switch d-inline-block mb-0 toggle-status" data-id="{{ $item['id'] }}">
												<input class="form-check-input" type="checkbox" {{ ($item['status'] == 'active') ? 'checked' : '' }}>
											</label>
										</td>
										</td>
										<td>
											<div class="dropdown">
												<a href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="false">
													<svg style="width: 28px; height: 28px; color: #828282;" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="19" r="1"></circle><circle cx="12" cy="5" r="1"></circle></svg>
												</a>
												<div class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
													<a class="dropdown-item" href="{{ route('role_update', $item['id']) }}">
														<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path><line x1="16" y1="5" x2="19" y2="8"></line></svg>
														Chi tiết
													</a>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				{{-- Paginate --}}
				<div class="row">
					<div class="col-12">
						@if($paginate)
							{{ $paginate->links() }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// Toggle Status
	$('.toggle-status').on('click', function(e) {
		if ( confirm('Bạn có chắc chắn muốn thay đổi') ) {
			let data = new FormData();
			data.append('id', $(this).data('id'));
			$.ajax({
				url: '{{ route('role_toggle_active') }}',
				type: 'POST',
				contentType: false,
				processData: false,
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: data,
			}).done(function(result) {

			}).error(function(result) {
				alert("Update thất bại");
			});
		} else {
			e.preventDefault();
		}
	});
</script>
@endsection
