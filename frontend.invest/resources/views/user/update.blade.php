@extends('layout.master')
@section('page_name','Cập nhật thông tin tài khoản')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Cập nhật thông tin người dùng</a>
                </li>
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
                            <h1 class="d-inline-block mb-3">Cập nhật thông tin người dùng</h1>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="post" action="{{ route('user_update_post', $id) }}">
                                @csrf
                                <input type="hidden" name="menu_list">
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <input type="email"
                                               class="form-control {{ isset($error['email']) ? 'is-invalid' : '' }}"
                                               placeholder="Nhập email" name="email" value="{{ $data['email'] }}"
                                               autocomplete="off" readonly>
                                        @if( isset($error['email']) )
                                            <div class="invalid-feedback">{{ $error['email'][0] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Tên đầy đủ <span
                                            class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <input type="text"
                                               class="form-control {{ isset($error['full_name']) ? 'is-invalid' : '' }}"
                                               placeholder="Tên đầy đủ" name="full_name"
                                               value="{{ $data['full_name'] }}" autocomplete="off" readonly>
                                        @if( isset($error['full_name']) )
                                            <div class="invalid-feedback">{{ $error['full_name'][0] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <input type="number"
                                               class="form-control {{ isset($error['phone']) ? 'is-invalid' : '' }}"
                                               placeholder="Số điện thoại" name="phone" value="{{ $data['phone'] }}"
                                               autocomplete="off" readonly>
                                        @if( isset($error['phone']) )
                                            <div class="invalid-feedback">{{ $error['phone'][0] }}</div>
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
                                {{-- Menu --}}
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4 d-inline-block float-left">
                                                    <input type="text" class="form-control" placeholder="Tìm menu"
                                                           id="filter-menu">
                                                </div>
                                                <div class="col-8 d-inline-block float-right">
                                                    <a href="#" class="btn btn-primary float-right d-inline-block"
                                                       data-bs-toggle="modal" data-bs-target="#add-menu">
                                                        <i class="fas fa-plus"></i>&nbsp;
                                                        Thêm menu
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="max-height: 400px">
                                            <table class="table table-vcenter table-nowrap table-striped"
                                                   id="table-menu">
                                                <thead>
                                                <tr>
                                                    <th>Menu</th>
                                                    <th>Action</th>
                                                    <th>Hành động</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if ( isset($data['menu']) )
                                                    @foreach($data['menu'] as $menu_detail)
                                                        @if ( !$menu_detail['parent'] )
                                                            <tr>
                                                                <td data-id="{{ $menu_detail['id'] }}">{{ $menu_detail['name'] }}</td>
                                                                <td>
                                                                    <span data-action='0'>Xem</span><br>
                                                                    @foreach($action as $action_item)
                                                                        @if ( in_array($action_item['id'], explode(',', $menu_detail['pivot']['action'])) )
                                                                            <span
                                                                                data-action="{{$action_item['id']}}">{{$action_item['name']}}</span>
                                                                            <br>
                                                                        @endif
                                                                    @endforeach
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
                                                                            <line x1="10" y1="11" x2="10"
                                                                                  y2="17"></line>
                                                                            <line x1="14" y1="11" x2="14"
                                                                                  y2="17"></line>
                                                                            <path
                                                                                d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                            <path
                                                                                d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                                        </svg>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @foreach($data['menu'] as $menu_child)
                                                                @if ( $menu_child['parent'] == $menu_detail['id'] )
                                                                    <tr>
                                                                        <td data-id="{{ $menu_child['id'] }}">
                                                                            |--&nbsp;{{ $menu_child['name'] }}</td>
                                                                        <td>
                                                                            <span data-action='0'>Xem</span><br>
                                                                            @foreach($action as $action_item)
                                                                                @if ( in_array($action_item['id'], explode(',', $menu_child['pivot']['action'])) )
                                                                                    <span
                                                                                        data-action="{{$action_item['id']}}">{{$action_item['name']}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            <a href="javascript:void(0);"
                                                                               class="text-danger">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                     class="icon icon-tabler icon-tabler-trash"
                                                                                     width="24" height="24"
                                                                                     viewBox="0 0 24 24"
                                                                                     stroke-width="2"
                                                                                     stroke="currentColor" fill="none"
                                                                                     stroke-linecap="round"
                                                                                     stroke-linejoin="round">
                                                                                    <path stroke="none"
                                                                                          d="M0 0h24v24H0z"
                                                                                          fill="none"></path>
                                                                                    <line x1="4" y1="7" x2="20"
                                                                                          y2="7"></line>
                                                                                    <line x1="10" y1="11" x2="10"
                                                                                          y2="17"></line>
                                                                                    <line x1="14" y1="11" x2="14"
                                                                                          y2="17"></line>
                                                                                    <path
                                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                                    <path
                                                                                        d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                                                </svg>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- Menu --}}
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    <div class="col-6">
                                        @if(in_array(\App\Service\ActionInterface::CAP_NHAT_USER, $action_global) || $is_admin == 1)
                                            <a href="javascript:void(0);" id="btn-submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                     height="24" viewBox="0 0 24 24" stroke-width="2"
                                                     stroke="currentColor"
                                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M6 4h10l4 4v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2"></path>
                                                    <circle cx="12" cy="14" r="2"></circle>
                                                    <polyline points="14 4 14 8 8 8 8 4"></polyline>
                                                </svg>
                                                Lưu lại
                                            </a>
                                        @endif
                                        <a class="btn" href="{{ route('user_list') }}">
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

    <div class="modal" tabindex="-1" role="dialog" id="add-menu">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control mb-3" placeholder="Tìm menu" id="filter-menu-select">
                            <div class="table-responsive" style="max-height: 400px">
                                <table class="table table-vcenter table-nowrap table-striped" id="table-menu-select">
                                    <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ( isset($menu) )
                                        @foreach($menu as $menu_detail)
                                            @if ( !$menu_detail['parent'] )
                                                <tr>
                                                    <td>{{ $menu_detail['name'] }}</td>
                                                    <td>
                                                        {{-- Check Render --}}
                                                        @php
                                                            $menu_list_arr = \Illuminate\Support\Arr::pluck($data['menu'], 'id')
                                                        @endphp
                                                        @if( in_array($menu_detail['id'], $menu_list_arr) )
                                                            @foreach($data['menu'] as $data_menu_item)
                                                                @if ($data_menu_item['id'] == $menu_detail['id'])
                                                                    <label class="form-check mb-2">
                                                                        <input class="form-check-input"
                                                                               data-id="{{ $menu_detail['id'] }}"
                                                                               data-action="0" type="checkbox"
                                                                               checked="checked">
                                                                        <span class="form-check-label">Xem</span>
                                                                    </label>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <label class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                       data-id="{{ $menu_detail['id'] }}"
                                                                       data-action="0" type="checkbox">
                                                                <span class="form-check-label">Xem</span>
                                                            </label>
                                                        @endif
                                                        {{-- End Check Render --}}
                                                        @php
                                                            $menu_child_arr_two = [];
                                                            foreach ($data['menu'] as $data_menu_item) {
                                                                if ($data_menu_item['id'] == $menu_detail['id']) {
                                                                    $menu_child_arr_two = explode(',', $data_menu_item['pivot']['action']);
                                                                }
                                                            }
                                                        @endphp
                                                        @foreach($action as $action_item)
                                                            @if($action_item['menu_id'] == $menu_detail['id'])
                                                                @if( in_array($action_item['id'], $menu_child_arr_two) )
                                                                    <label class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               data-id="{{ $menu_detail['id'] }}"
                                                                               data-action="{{$action_item['id']}}"
                                                                               checked="checked">
                                                                        <span
                                                                            class="form-check-label">{{ $action_item['name'] }}</span>
                                                                    </label>
                                                                @else
                                                                    <label class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               data-id="{{ $menu_detail['id'] }}"
                                                                               data-action="{{$action_item['id']}}">
                                                                        <span
                                                                            class="form-check-label">{{ $action_item['name'] }}</span>
                                                                    </label>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @foreach($menu as $menu_child)
                                                    @if ( $menu_child['parent'] == $menu_detail['id'] )
                                                        <tr>
                                                            <td>|--&nbsp;{{ $menu_child['name'] }}</td>
                                                            <td>
                                                                {{-- Check Render --}}
                                                                @php
                                                                    $menu_list_arr = \Illuminate\Support\Arr::pluck($data['menu'], 'id')
                                                                @endphp
                                                                @if ( in_array($menu_child['id'], $menu_list_arr) )
                                                                    @foreach($data['menu'] as $data_menu_item)
                                                                        @if ($data_menu_item['id'] == $menu_child['id'])
                                                                            <label class="form-check mb-2">
                                                                                <input class="form-check-input"
                                                                                       data-id="{{ $menu_child['id'] }}"
                                                                                       data-action="0" type="checkbox"
                                                                                       checked="checked">
                                                                                <span
                                                                                    class="form-check-label">Xem</span>
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <label class="form-check mb-2">
                                                                        <input class="form-check-input"
                                                                               data-id="{{ $menu_child['id'] }}"
                                                                               data-action="0" type="checkbox">
                                                                        <span class="form-check-label">Xem</span>
                                                                    </label>
                                                                @endif
                                                                {{-- Check Render --}}
                                                                @php
                                                                    $menu_child_arr = [];
                                                                    foreach ($data['menu'] as $data_menu_item) {
                                                                        if ($data_menu_item['id'] == $menu_child['id']) {
                                                                            $menu_child_arr = explode(',', $data_menu_item['pivot']['action']);
                                                                        }
                                                                    }
                                                                @endphp
                                                                @foreach($action as $action_item)
                                                                    @if($action_item['menu_id'] == $menu_child['id'])
                                                                        @if( in_array($action_item['id'], $menu_child_arr) )
                                                                            <label class="form-check mb-2">
                                                                                <input class="form-check-input"
                                                                                       type="checkbox"
                                                                                       data-id="{{ $menu_child['id'] }}"
                                                                                       data-action="{{$action_item['id']}}"
                                                                                       checked="checked">
                                                                                <span
                                                                                    class="form-check-label">{{ $action_item['name'] }}</span>
                                                                            </label>
                                                                        @else
                                                                            <label class="form-check mb-2">
                                                                                <input class="form-check-input"
                                                                                       type="checkbox"
                                                                                       data-id="{{ $menu_child['id'] }}"
                                                                                       data-action="{{$action_item['id']}}">
                                                                                <span
                                                                                    class="form-check-label">{{ $action_item['name'] }}</span>
                                                                            </label>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
        var menu_data = '{!!
		$menu->map(function($menu_item){
			return collect($menu_item)->only('id', 'name');
		})->toJson()
	!!}';
        var action_data = '{!!
		$action->map(function($action_item){
			return collect($action_item)->only('id', 'name');
		})->toJson()
	!!}';
        let menu_list = JSON.parse(menu_data);
        let action_list = JSON.parse(action_data);

        $(document).ready(function () {
            // Delete user
            $(document).on('click', '.text-danger', function () {
                $(this).parents('tr').remove();
            });
            // Chọn Menu
            $('.form-check-input').on('click', function () {
                if ($(this).prop('checked') != true) {
                    $(this).attr('checked', false);
                } else {
                    $(this).attr('checked', true);
                }
            });
            // Btn Submit
            $('#btn-submit').on('click', function () {
                // List Menu
                let arr_menu = [];
                $("#table-menu tbody").find("tr").each(function () {
                    let data = [];
                    let data_id = $(this).find("td:eq(0)").data('id');
                    $(this).find("td:eq(1) span").each(function () {
                        let data_action = $(this).data('action');
                        data.push(data_action);
                    })
                    arr_menu.push({
                        menu: data_id,
                        action: data
                    });
                });
                $('input[name=menu_list]').val(JSON.stringify(arr_menu));
                // Submit
                $('form').submit();
            });
            // Filter menu
            $("#filter-menu").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#table-menu tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // Filter menu select
            $("#filter-menu-select").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#table-menu-select tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // Add menu
            $('#add-menu-btn').on('click', function () {
                $('#table-menu tbody').html('');
                let temp_list = [];
                $('[checked=checked]').each(function () {
                    let menu_check = $(this).data('id');
                    let action_check = $(this).data('action');
                    if (typeof action_check === 'undefined') {
                        temp_list.push({
                            menu: menu_check,
                        });
                    } else {
                        temp_list.push({
                            menu: menu_check,
                            action: action_check
                        });
                    }
                });
                let data_list = [];
                menu_list.map((menu_list) => {
                    let test_2 = []
                    temp_list.map((item) => {
                        if (menu_list.id === item.menu) {
                            if (typeof item.action !== 'undefined') {
                                test_2.push(item.action);
                            }
                        }
                    });
                    if (test_2.length > 0) {
                        data_list.push({
                            menu: menu_list.id,
                            action: test_2
                        })
                    }
                });
                console.log(data_list);
                menu_list.map((menu_list) => {
                    data_list.map((data_item) => {
                        if (menu_list.id === data_item.menu) {
                            let str_action = "<span data-action='0'>Xem</span><br>";
                            action_list.map((action_item) => {
                                data_item.action.map((data_action_item) => {
                                    if (action_item.id === data_action_item) {
                                        str_action += "<span data-action='" + data_action_item + "'>" + action_item.name + '</span><br>';
                                    }
                                })
                            });
                            let html = `
							<tr>
								<td data-id="${menu_list.id}">${menu_list.name}</td>
								<td>${str_action}</td>
								<td>
									<a href="javascript:void(0);" class="text-danger">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
									</a>
								</td>
							</tr>
						`;
                            $('#table-menu tbody').append(html);
                        }
                    })
                });
                // Done
                $('#add-menu').modal('hide');
            });
        });
    </script>
@endsection
