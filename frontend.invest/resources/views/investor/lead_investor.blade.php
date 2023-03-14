@extends('layout.master')
@section('page_name','Danh sách Lead Investor')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investor.lead')}}"
                                                                   class="text-info">Danh sách Lead Investor</a>
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
                            <h1 class="d-inline-block text-success">Danh sách Lead Investor</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-right d-inline-block" id="filter-data">
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('investor.lead')}}">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên nhà đầu tư</label>
                                                    <div>
                                                        <input type="text" name="name_investor" class="form-control"
                                                               placeholder="Nhà đầu tư"
                                                               value="{{ request()->get('name_investor') }}"
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
                                                            <option value="1">Chờ gọi lại</option>
                                                            <option value="10">Đang suy nghĩ</option>
                                                            <option value="11">Kích hoạt thành công</option>
                                                            <option value="12">Chờ bổ sung</option>
                                                            <option value="14">Đồng ý tải App</option>
                                                            <option value="13">Huỷ</option>
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
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Nguồn Lead</label>
                                                    <div>
                                                        <select type="text" name="source" class="form-control">
                                                            <option value="">- Chọn nguồn -</option>
                                                            @foreach(source_lead() as $k => $v)
                                                                <option value="{{$k}}">{{$v}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Độ ưu tiên</label>
                                                    <div>
                                                        <select type="text" name="priority" class="form-control">
                                                            <option value="">- Chọn độ ưu tiên -</option>
                                                            @foreach(priority_lead() as $k => $v)
                                                                <option value="{{$k}}">{{$v}}</option>
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
                                <table
                                    class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Nhân viên</th>
                                        @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_LEAD_INVESTOR, $action_global) || $is_admin == 1)
                                            <th style="text-align: center">Sale</th>
                                        @endif
                                        <th style="text-align: center">Nhà đầu tư</th>
                                        <th style="text-align: center">Số điện thoại</th>
                                        <th style="text-align: center">Tài khoản liên kết</th>
                                        <th style="text-align: center">Trạng thái Lead</th>
                                        <th style="text-align: center">Tình trạng Call</th>
                                        <th style="text-align: center">Ghi chú</th>
                                        <th style="text-align: center">Nguồn</th>
                                        <th style="text-align: center">Độ ưu tiên</th>
                                        <th style="text-align: center">UTM Source</th>
                                        <th style="text-align: center">UTM Campaign</th>
                                        <th style="text-align: center">Ngày tạo</th>
                                        <th style="text-align: center">Lịch sử</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(in_array(\App\Service\ActionInterface::CHANGE_CALL, $action_global) || $is_admin == 1)
                                                        <select class="form-control change-call"
                                                                name="user_call_{{$item['id']}}"
                                                                data-id="{{$item['id']}}" data-type="lead">
                                                            <option>-- Chọn telesales --</option>
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
                                                @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_LEAD_INVESTOR, $action_global) || $is_admin == 1)
                                                    <td>
                                                        <a class="btn btn-success btn_call_lead"
                                                           style="border-style: none"
                                                           data-bs-toggle="modal" data-bs-target="#modal_call_lead_ndt"
                                                           data-id="{{$item['id']}}">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ hide_phone($item['phone']) }}</td>
                                                <td>{{ hide_phone($item['phone_link']) }}</td>
                                                <td>
                                                    @if(isset($item['status']))
                                                        @if($item['status'] == 1)
                                                            <span class="badge badge-new">Mới</span>
                                                        @else
                                                            <span class="badge badge-active">Chờ kích hoạt</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-new">Mới</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['call']))
                                                        @if($item['call']['status'] == 13)
                                                            <span class="badge badge-block">
                                                        {{lead_status($item['call']['status'])}}
                                                        </span>
                                                            <br>
                                                            <span
                                                                class="text-danger">{{note_delete($item['call']['note'])}}</span>
                                                        @elseif($item['call']['status'] == 14)
                                                            <span class="badge badge-success">
                                                        {{lead_status($item['call']['status'])}}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-active">
                                                        {{isset($item['call']['status']) ? lead_status($item['call']['status']) : 'Mới'}}
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-active">Mới</span>
                                                    @endif
                                                </td>
                                                <td>{!! isset($item['call']['call_note']) ? wordwrap($item['call']['call_note'], 15, "<br>\n") : '' !!}</td>
                                                <td><span
                                                        class="badge bg-lime">{{!empty($item['source']) ? source_lead($item['source']) : "VFC"}}</span>
                                                </td>
                                                <td><span
                                                        class="badge {{!empty($item['priority']) ? color_priority_lead($item['priority']) : ''}}">{{!empty($item['priority']) ? priority_lead($item['priority']) : ''}}</span>
                                                </td>
                                                <td>{{!empty($item['utm_source']) ? $item['utm_source'] : ''}}</td>
                                                <td>{{!empty($item['utm_campaign']) ? wordwrap($item['utm_campaign'], 25, "<br>\n") : ''}}</td>
                                                <td>{{ date('d/m/Y H:i:s', $item['created_at']) }}</td>
                                                <td><a class="btn btn-info history_lead_call" data-bs-toggle="modal"
                                                       data-bs-target="#modal_history_lead_ndt"
                                                       data-id="{{$item['id']}}"><i class="fas fa-history"></i></a>
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
    <div class="modal modal-blur fade" id="modal_call_lead_ndt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CẬP NHẬT NHÀ ĐẦU TƯ</h5>
                    @if(in_array(\App\Service\ActionInterface::CALL_LEAD_INVESTOR, $action_global) || $is_admin == 1)
                        <div class="float-right d-inline-block text-right mt-2 mb-2">
                            <button id="call" class="btn btn-success" style="margin-right: 15px;"><i
                                    class="fas fa-phone-alt"></i>&nbsp;
                            </button>
                            <button id="end" class="btn btn-danger"><i class="fas fa-phone-slash"></i>&nbsp;
                            </button>
                            <input id="number" name="phone_number" type="hidden" value=""/>
                            <p id="status" style="margin: 5px 0;"></p>
                            <div class="alert alert-danger alert-dismissible text-center" style="display:none"
                                 id="div_error1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class='div_error'></span>
                            </div>
                            <div class="alert alert-success alert-dismissible text-center" style="display:none"
                                 id="div_success1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class='div_success'></span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <input type="hidden" class="form-control"
                                   autocomplete="off" name="id">
                            <label class="form-label">Số điện thoại</label>
                            <div class="input-group input-group-flat">
                                <input type="text" class="form-control text-danger" id="phone_investor"
                                       autocomplete="off" disabled name="phone_investor">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Số điện thoại liên kết</label>
                            <div class="input-group input-group-flat">

                                <input type="text" class="form-control text-danger" id="phone_vimo"
                                       autocomplete="off"
                                       disabled name="phone_vimo">
                            </div>
                        </div>
                    </div>
                    <div class="row paddding">
                        <div class="col-md-12 mb-3">
                            <label class="title">THÔNG TIN NHÀ ĐẦU TƯ
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="group">
                                        <label class="form-label">Họ và tên<span class="text-danger">*</span></label>
                                        <input type="text" name="fullname" id="fullname" class="form-control"
                                               placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group">
                                        <label class="form-label">Email<span class="text-danger">*</span></label>

                                        <input type="email" name="email_investor" id="fullEmail" class="form-control"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group">
                                        <label class="form-label">Ngày tháng năm sinh</label>

                                        <input type="date" name="birthday" id="fulldate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group">
                                        <label class="form-label">Số CMT/CCCD</label>

                                        <input type="number" name="cmt" id="fullCMT" class="form-control"
                                               placeholder="Số CMT/CCCD từ 9 đến 12 kí tự">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group">
                                        <label class="form-label">Khu vực</label>
                                        <select id="" class="form-control city" name="city">
                                            <option value="">- Chọn khu vực -</option>
                                            @foreach(get_province_name_by_code() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group">
                                        <label class="form-label">Trạng thái Call</label>
                                        <select id="status_call" class="form-control status" name="status">
                                            <option value="">- Chọn trạng thái -</option>
                                            @foreach(lead_status() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 ly_do_huy" style="display: none">
                                    <div class="group">
                                        <label class="form-label">Lý do hủy<span class="text-danger">*</span></label>
                                        <select id="" class="form-control note" name="note">
                                            <option value="">- Chọn lý do hủy -</option>
                                            @foreach(note_delete() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group">
                                        <label class="form-label">Ghi chú</label>
                                        <textarea class="form-control call_note" name="call_note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_LEAD_INVESTOR, $action_global) || $is_admin == 1)
                            <a href="#" class="btn btn-primary btn_call_update_lead" data-bs-dismiss="modal">
                                Lưu thông tin
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal_history_lead_ndt" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="">Lịch sử tác động khách hàng <span class="title_ten_nha_dau_tu text-danger"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="text-align: center">#</th>
                            <th style="text-align: center">Trạng thái</th>
                            <th style="text-align: center">Lý do hủy</th>
                            <th style="text-align: center">Ghi chú</th>
                            <th style="text-align: center">Thời gian</th>
                            <th style="text-align: center">Nhân viên</th>
                        </tr>
                        </thead>
                        <tbody id="lich_su_cap_nhat">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('investor.modal_confirm_new')
    @include('investor.modal_confirm_success')
    @include('investor.modal_block_new')
    <style>
        .img_anh_chan_dung {
            position: relative;
        }

        .img_anh_chan_dung .loading_img_anh_chan_dung {
            position: absolute;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }

        .img_anh_chan_dung .loading_img_anh_chan_dung i.fa {
            width: 38px;
            height: 38px;
            text-align: center;
        }

        .img_cmt_mat_truoc {
            position: relative;
        }

        .img_cmt_mat_truoc .loading_img_cmt_mat_truoc {
            position: absolute;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }

        .img_cmt_mat_truoc .loading_img_cmt_mat_truoc i.fa {
            width: 38px;
            height: 38px;
            text-align: center;
        }

        .img_cmt_mat_sau {
            position: relative;
        }

        .img_cmt_mat_sau .loading_img_cmt_mat_sau {
            position: absolute;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }

        .img_cmt_mat_sau .loading_img_cmt_mat_sau i.fa {
            width: 38px;
            height: 38px;
            text-align: center;
        }
    </style>
    <script src="{{asset('project_js/investor/call.js')}}"></script>
@endsection
