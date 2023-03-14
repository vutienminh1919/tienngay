@extends('layout.master')
@section('page_name','Cập nhật nhóm quyền')

@section('content')
    @include('layout.alert_success')
    @include('investor.modal_confirm_new')
    @include('investor.modal_confirm_success')
    @include('investor.modal_block_new')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Cập nhật nhóm quyền</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block mb-3">Cập nhật nhóm quyền</h1>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="post" action="{{ route('role_update_post', $id) }}">
                                @csrf
                                <input type="hidden" name="user_list">
                                <input type="hidden" name="menu_list">
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Tên nhóm <span
                                            class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <input type="text"
                                               class="form-control {{ (isset($error['name']) || isset($error['slug'])) ? 'is-invalid' : '' }}"
                                               placeholder="Tên nhóm" name="name" value="{{ $data['name'] }}"
                                               autocomplete="off">
                                        @if( isset($error['name']) )
                                            <div class="invalid-feedback">{{ $error['name'][0] }}</div>
                                        @endif
                                        @if ( isset($error['slug']) )
                                            <div class="invalid-feedback">{{ $error['slug'][0] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Trạng thái</label>
                                    <div class="col-6">
                                        <select class="form-control" name="status">
                                            <option
                                                value="active" {{ ($data['status'] == 'active') ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option
                                                value="deactive" {{ ($data['status'] == 'deactive') ? 'selected' : '' }}>
                                                Deactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                {{-- User --}}
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4 d-inline-block float-left">
                                                    <input type="text" class="form-control" placeholder="Tìm người dùng"
                                                           id="filter-user">
                                                </div>
                                                <div class="col-8 d-inline-block float-right">
                                                    <a href="#" class="btn btn-primary float-right d-inline-block"
                                                       data-bs-toggle="modal" data-bs-target="#add-user">
                                                        <i class="fas fa-plus"></i>&nbsp;
                                                        Thêm người dùng
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="max-height: 400px">
                                            <table class="table table-vcenter table-nowrap table-striped"
                                                   id="table-user">
                                                <thead>
                                                <tr>
                                                    <th>Tên người dùng</th>
                                                    <th>Chức vụ</th>
                                                    <th class="w-1"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if ( isset($data['user']) )
                                                    @foreach($data['user'] as $user_detail)
                                                        <tr>
                                                            <td data-id="{{ $user_detail['id'] }}">{{ $user_detail['email'] }}</td>
                                                            <td>
                                                                <div>
                                                                    <label class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               value="3"
                                                                               {{$user_detail['pivot']['position']== '3'  ? 'checked' : ''}}
                                                                               name="position_{{$user_detail['id']}}">
                                                                        <span
                                                                            class="form-check-label">Trưởng bộ phận</span>
                                                                    </label>
                                                                    <label class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               value="2"
                                                                               {{$user_detail['pivot']['position']== '2'  ? 'checked' : ''}}
                                                                               name="position_{{$user_detail['id']}}">
                                                                        <span
                                                                            class="form-check-label">Trưởng nhóm</span>
                                                                    </label>
                                                                    <label class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                                value="1"
                                                                               {{$user_detail['pivot']['position']== '1'  ? 'checked' : ''}}
                                                                               name="position_{{$user_detail['id']}}">
                                                                        <span class="form-check-label">Nhân viên</span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="text-danger">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         class="icon icon-tabler icon-tabler-trash"
                                                                         width="24" height="24" viewBox="0 0 24 24"
                                                                         stroke-width="2" stroke="currentColor"
                                                                         fill="none" stroke-linecap="round"
                                                                         stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none"></path>
                                                                        <line x1="4" y1="7" x2="20" y2="7"></line>
                                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                        <path
                                                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                        <path
                                                                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" id="btn-submit" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                 height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M6 4h10l4 4v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2"></path>
                                                <circle cx="12" cy="14" r="2"></circle>
                                                <polyline points="14 4 14 8 8 8 8 4"></polyline>
                                            </svg>
                                            Lưu lại
                                        </a>
                                        <a class="btn" href="{{ route('role_list') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <line x1="5" y1="12" x2="11" y2="18"></line>
                                                <line x1="5" y1="12" x2="11" y2="6"></line>
                                            </svg>
                                            Quay lại
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="add-user">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <select type="text" name="user[]" class="form-select" placeholder="Chọn người dùng"
                                    id="select-user" multiple>
                                @foreach($user as $user_item)
                                    <option value="{{ $user_item['id'] }}">{{ $user_item['email'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="add-user-btn">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="add-menu">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <select type="text" name="menu[]" class="form-select" placeholder="Chọn Menu"
                                    id="select-menu" multiple>
                                @if ( isset($menu) )
                                    @foreach($menu as $menu_item)
                                        @if( !$menu_item['parent'] )
                                            <option value="{{ $menu_item['id'] }}">{{ $menu_item['name'] }}</option>
                                            @foreach($menu as $menu_item_child)
                                                @if( $menu_item['id'] == $menu_item_child['parent'] )
                                                    <option value="{{ $menu_item_child['id'] }}">
                                                        |--&nbsp;{{ $menu_item_child['name'] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="add-menu-btn">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var select = $('#select-user').selectize();
        var select_menu = $('#select-menu').selectize();
        var user_data = '{!!
		$user->map(function($user_item){
			return collect($user_item)->only('id', 'email');
		})->toJson()
	!!}';

        $(document).ready(function () {
            // Btn Submit
            $('#btn-submit').on('click', function () {
                // List User
                let arr_data = [];
                $("#table-user tbody").find("tr").each(function () {
                    let data = $(this).find("td:eq(0)").data('id');
                    let position = $(this).find("td:eq(1)").find("input[name='position_" + data + "']:checked").val();
                    arr_data.push(data + ':' + position);
                });
                $('input[name=user_list]').val(arr_data.join());
                // Submit
                $('form').submit();
            });
            // Filter user
            $("#filter-user").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#table-user tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // Add user
            $('#add-user-btn').on('click', function () {
                let data = select[0].selectize.getValue();
                let user_list = JSON.parse(user_data);
                user_list.map((user_item) => {
                    data.map((data_item) => {
                        if (user_item.id == data_item) {
                            let html = `
							<tr>
								<td data-id="${user_item.id}">${user_item.email}</td>
								<td>
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   value="3" name="position_${user_item.id}">
                                            <span
                                                class="form-check-label">Trưởng bộ phận</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   value="2" name="position_${user_item.id}">
                                            <span
                                                class="form-check-label">Trưởng nhóm</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   checked value="1" name="position_${user_item.id}">
                                            <span class="form-check-label">Nhân viên</span>
                                        </label>
                                    </div>
                                </td>
								<td>
									<a href="javascript:void(0);" class="text-danger">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
									</a>
								</td>
							</tr>
						`;
                            let check = false;
                            $("#table-user tbody").find("tr").each(function () {
                                let td1 = $(this).find("td:eq(0)").text();
                                if (td1 == user_item.email) {
                                    check = true;
                                }
                            });
                            if (!check) {
                                $('#table-user tbody').append(html);
                            }
                        }
                    })
                });
                // Done
                $('#add-user').modal('hide');
                select[0].selectize.clear();
            });
            // Delete user
            $(document).on('click', '.text-danger', function () {
                $(this).parents('tr').remove();
            });
            // Filter menu
            $("#filter-menu").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#table-menu tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // Add menu
            $('#add-menu-btn').on('click', function () {
                let data = select_menu[0].selectize.getValue();
                let menu_list = JSON.parse(menu_data);
                menu_list.map((menu_list) => {
                    data.map((data_item) => {
                        if (menu_list.id == data_item) {
                            let html = `
							<tr>
								<td data-id="${menu_list.id}">${menu_list.name}</td>
								<td>
									<a href="javascript:void(0);" class="text-danger">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
									</a>
								</td>
							</tr>
						`;
                            let check = false;
                            $("#table-menu tbody").find("tr").each(function () {
                                let td1 = $(this).find("td:eq(0)").text();
                                if (td1 == menu_list.name) {
                                    check = true;
                                }
                            });
                            if (!check) {
                                $('#table-menu tbody').append(html);
                            }
                        }
                    })
                });
                // Done
                $('#add-menu').modal('hide');
                select_menu[0].selectize.clear();
            });
        });
    </script>
@endsection
