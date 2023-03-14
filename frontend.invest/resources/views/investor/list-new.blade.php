@extends('layout.master')
@section('page_name','Danh sách xác nhận NĐT')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investor_new_list')}}"
                                                                   class="text-info">Danh sách xác nhận NĐT</a>
                </li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="d-inline-block text-success">Danh sách yêu cầu xác nhận trở thành NĐT <span
                                    class="text-red">({{$count}})</span></h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-left hide" id="btn-group">
                                <button type="button" class="btn btn-no-border btn-color-green" id="show-confirm-btn">
                                    <i class="ti ti-circle-check" style="font-size: 21px"></i> &nbsp;
                                    Xác nhận
                                </button>
                                <button type="button" class="btn btn-no-border btn-color-red" id="show-block-btn">
                                    <i class="ti ti-circle-x" style="font-size: 21px"></i> &nbsp;
                                    Block
                                </button>
                            </div>
                            <div class="float-right d-inline-block" id="filter-data">
                                <a class="btn" href="{{ route('investor_new_list') }}">
                                    Xóa filter
                                </a>
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('investor_new_list')}}">
                                                {{--                                                <input type="hidden" name="per_page">--}}
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày bắt đầu</label>
                                                    <div>
                                                        <input type="date" name="start_date" class="form-control"
                                                               value="{{ request()->get('start_date') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày kết thúc</label>
                                                    <div>
                                                        <input type="date" name="end_date" class="form-control"
                                                               value="{{ request()->get('end_date') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên khách hàng</label>
                                                    <div>
                                                        <input type="text" name="name" class="form-control"
                                                               placeholder="Tên khách hàng"
                                                               value="{{ request()->get('name') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Email</label>
                                                    <div>
                                                        <input type="text" name="email" class="form-control"
                                                               placeholder="Email" value="{{ request()->get('email') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Số điện thoại</label>
                                                    <div>
                                                        <input type="text" name="phone" class="form-control"
                                                               placeholder="Số điện thoại"
                                                               value="{{ request()->get('phone') }}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Trạng thái call</label>
                                                    <div>
                                                        <select type="text" name="status_call"
                                                                class="form-control status_call">
                                                            <option value="">- Chọn trạng thái -</option>
                                                            <option value="100">Mới</option>
                                                            @foreach(lead_status() as $l => $s)
                                                                @continue($l== 14)
                                                                <option value="{{$l}}">{{$s}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 note_delete" style="display: none">
                                                    <label class="form-label">Lý do hủy</label>
                                                    <div>
                                                        <select type="text" name="note_delete" class="form-control">
                                                            <option value="">- Chọn lý do -</option>
                                                            @foreach(note_delete() as $n => $d)
                                                                <option value="{{$n}}">{{$d}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if(in_array(\App\Service\ActionInterface::CHANGE_CALL, $action_global) || $is_admin == 1)
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Nhân viên</label>
                                                        <div>
                                                            <select type="text" name="find_call_assign"
                                                                    class="form-control">
                                                                <option value="">- Chọn nhân viên -</option>
                                                                @foreach($user_tls as $user)
                                                                    <option
                                                                        value="{{$user['id']}}">{{$user['email']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
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
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">
                                            <input class="form-check-input" type="checkbox" id="check-all">
                                        </th>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Nhân viên</th>
                                        @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR, $action_global) || $is_admin == 1)
                                            <th style="text-align: center">TLS</th>
                                        @endif
                                        <th style="text-align: center">Nhà đầu tư</th>
                                        <th style="text-align: center">Số điện thoại</th>
                                        <th style="text-align: center">Tài khoản liên kết</th>
                                        {{--                                        <th style="text-align: center">Số dư ví</th>--}}
                                        <th style="text-align: center">Tình trạng Call</th>
                                        <th style="text-align: center">Ghi chú</th>
                                        <th style="text-align: center">Ngày đăng kí</th>
                                        @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR, $action_global) || $is_admin == 1)
                                            <th style="text-align: center">Ngày gán TLS</th>
                                        @endif
                                        <th style="text-align: center">Nguồn</th>
                                        <th style="text-align: center">SDT giới thiệu</th>
                                        <th style="text-align: center">Tác động lần cuối</th>
                                        <th style="text-align: center">Lịch sử</th>
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td><input class="form-check-input" type="checkbox"
                                                           data-id="{{ $item['id'] }}"></td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(in_array(\App\Service\ActionInterface::CHANGE_CALL, $action_global) || $is_admin == 1)
                                                        <select class="form-control change-call"
                                                                name="user_call_{{$item['id']}}"
                                                                data-id="{{$item['id']}}" data-type="investor">
                                                            <option value="">-- Chọn telesales --</option>
                                                            @foreach($user_tls as $user)
                                                                <option
                                                                    value="{{$user['id']}}"
                                                                    {{isset($item['id_user_call']) && $item['id_user_call'] == $user['id'] ? 'selected' : ''}}>
                                                                    {{$user['email']}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        {{isset($item['user_call']) ? $item['user_call'] : ''}}
                                                    @endif
                                                </td>
                                                @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR, $action_global) || $is_admin == 1)
                                                    <td>
                                                        <a class="btn btn-success btn_call_investor"
                                                           style="border-style: none"
                                                           data-bs-toggle="modal" data-bs-target="#modal_call_ndt_new"
                                                           data-id="{{$item['id']}}">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ hide_phone($item['phone_number']) }}</td>
                                                <td>{{ hide_phone($item['phone_vimo']) }}</td>
                                                {{--                                                <td class="text-danger">{{ number_format($item['so_du_vi']) . ' VND' }}</td>--}}
                                                <td>
                                                    @if(isset($item['call']))
                                                        @if($item['call']['status'] == 13)
                                                            <span class="badge badge-block">
                                                        {{lead_status($item['call']['status'])}}
                                                        </span>
                                                            <br>
                                                            <span
                                                                class="text-danger">{{note_delete($item['call']['note'])}}</span>
                                                        @else
                                                            <span class="badge badge-active">
                                                        {{isset($item['call']['status']) ? lead_status($item['call']['status']) : 'Mới'}}
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-active">Mới</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! isset($item['call']['call_note']) ? wordwrap($item['call']['call_note'], 25, "<br>\n") : '' !!}
                                                </td>
                                                <td>{{ date('d/m/Y H:i:s', $item['created_at']) }}</td>
                                                @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR, $action_global) || $is_admin == 1)
                                                    <td> {{ !empty($item['time_assign_call']) ? date('d/m/Y H:i:s', strtotime($item['time_assign_call'])) : "" }} </td>
                                                @endif
                                                <td>{{ !empty($item['user']['source']) && $item['user']['source'] != "undefined" ? $item['user']['source'] : '' }}</td>
                                                <td>{{ !empty($item['user']['referral_code']) ? hide_phone($item['user']['referral_code']) : '' }}</td>
                                                <td>
                                                    {{!empty($item['log_call']) ? date('d/m/Y H:i:s', $item['log_call']['created_at']) : "Chưa có tác động"}}
                                                </td>
                                                <td><a class="btn btn-info history_call_ndt" data-bs-toggle="modal"
                                                       data-bs-target="#modal_history_call_ndt"
                                                       data-id="{{$item['id']}}"><i class="fas fa-history"></i></a>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false"
                                                           aria-haspopup="false">
                                                            <svg style="width: 28px; height: 28px; color: #828282;"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 class="icon icon-tabler icon-tabler-dots-vertical"
                                                                 width="24" height="24" viewBox="0 0 24 24"
                                                                 stroke-width="2"
                                                                 stroke="currentColor" fill="none"
                                                                 stroke-linecap="round"
                                                                 stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                      fill="none"></path>
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                            </svg>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                             data-bs-popper="none">
                                                            @if(in_array(\App\Service\ActionInterface::CAP_NHAT_NDT, $action_global) || $is_admin == 1)
                                                                <a class="dropdown-item"
                                                                   href="{{ route('investor_new_detail', $item['id']) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         class="icon dropdown-item-icon" width="24"
                                                                         height="24" viewBox="0 0 24 24"
                                                                         stroke-width="2"
                                                                         stroke="currentColor" fill="none"
                                                                         stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none"></path>
                                                                        <path
                                                                            d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                                                        <path
                                                                            d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                                                        <line x1="16" y1="5" x2="19" y2="8"></line>
                                                                    </svg>
                                                                    Chi tiết
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="20" class="text-danger" style="text-align: center">Không có dữ
                                                liệu
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Paginate --}}
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                @if($paginate)
                                    {{ $paginate->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
                </div>
            </div>
        </div>
    </div>
    @include("investor.modal_update_investor")
    @include("investor.modal_history_call")
    @include('investor.modal_confirm_new')
    @include('investor.modal_confirm_success')
    @include('investor.modal_block_new')
    <link rel="stylesheet" href="{{ asset('css/call/upload_image.css') }}">
    <script type="text/javascript">
        $('document').ready(function () {
            // Check all
            $('#check-all').on('click', function (e) {
                e.preventDefault();
                if ($('#check-all').hasClass('checked') == true) {
                    $(this).removeClass('checked');
                } else {
                    $(this).addClass('checked');
                }
                if ($('#check-all').hasClass('checked') == true) {
                    $('table tbody .form-check-input').each(function (key, item) {
                        if ($(this).prop('checked') != true) {
                            $(this).trigger('click');
                            $(this).attr('checked', true);
                        }
                    });
                } else {
                    console.log(1);
                    $('table tbody .form-check-input').each(function (key, item) {
                        if ($(this).prop('checked') == true) {
                            $(this).trigger('click');
                            $(this).attr('checked', false);
                        }
                    });
                }

                let count = $('table tbody .form-check-input[checked=checked]').size();
                if (count > 0) {
                    $('#btn-group').removeClass('hide');
                } else {
                    $('#btn-group').addClass('hide');
                }
            });
            // Check normal
            $('table tbody .form-check-input').on('click', function () {
                if ($(this).prop('checked') != true) {
                    $(this).attr('checked', false);
                } else {
                    $(this).attr('checked', true);
                }
                let count_all = $('table tbody .form-check-input').size();
                let count = $('table tbody .form-check-input[checked=checked]').size();
                if (count > 0) {
                    $('#btn-group').removeClass('hide');
                } else {
                    $('#btn-group').addClass('hide');
                }
                if (count_all == count) {
                    $('#check-all').addClass('checked');
                } else {
                    $('#check-all').removeClass('checked');
                }
            });
            // Per page change
            $('#per_page').on('change', function () {
                let data = $(this).val();
                $('input[name=per_page]').val(data);
                $('form').submit();
            });
            // Show Confirm button
            $('#show-confirm-btn').on('click', function () {
                $('#confirm-new-modal').modal('show');
            });
            // Confirm button
            $('#confirm-btn').on('click', function () {
                $('#confirm-new-modal').modal('hide');
                let investor_list = [];
                $('table tbody .form-check-input[checked=checked]').each(function () {
                    investor_list.push($(this).data('id'));
                });
                investor_list = investor_list.join();
                let data = new FormData();
                data.append('investor_list', investor_list);
                $.ajax({
                    url: '{{ route('investor_new_confirm') }}',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: data,
                }).done(function (result) {
                    if (result.status == 200) {
                        $('#success-confirm-modal').modal('show')
                    }
                    if (result.status == 400) {
                        alert('Xác nhận không thành công');
                    }
                }).error(function (result) {
                    alert("Lỗi hệ thống");
                });
            });
            // Show Block button
            $('#show-block-btn').on('click', function () {
                $('#modal-block-new').modal('show');
            });
            // Click Block button
            $('#block-btn').on('click', function () {
                let investor_list = [];
                $('table tbody .form-check-input[checked=checked]').each(function () {
                    investor_list.push($(this).data('id'));
                });
                investor_list = investor_list.join();
                let data = new FormData();
                data.append('investor_list', investor_list);
                $.ajax({
                    url: '{{ route('investor_new_block') }}',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: data,
                }).done(function (result) {
                    if (result.status == 200) {
                        // $('#success-confirm-modal').modal('show')
                        alert('Block thành công');
                    }
                    if (result.status == 400) {
                        alert('Block không thành công');
                    }
                }).error(function (result) {
                    alert("Lỗi hệ thống");
                });
            });
        });
    </script>
    <script src="{{asset('project_js/investor/call.js')}}"></script>
@endsection
