{{-- Table --}}
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-vcenter table-nowrap table-striped table-bordered">
                <thead>
                <tr>
                    <th style="text-align: center">STT</th>
                    <th style="text-align: center">Nhân viên</th>
                    <th style="text-align: center">Nhà đầu tư</th>
                    <th style="text-align: center">Số điện thoại</th>
                    <th style="text-align: center">Ngày kích hoạt</th>
                    <th style="text-align: center">Số dư ví</th>
                    <th style="text-align: center">Trạng thái</th>
                    <th style="text-align: center">Tình trạng Call</th>
                    <th style="text-align: center">Ghi chú</th>
                    {{--                                        <th style="text-align: center">Xếp hạng</th>--}}
                    <th style="text-align: center">Nguồn</th>
                    <th style="text-align: center">SDT giới thiệu</th>
                    <th style="text-align: center">Lịch sử</th>
                    <th class="w-1" style="text-align: center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $item)
                    <tr style="text-align: center">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if(in_array(\App\Service\ActionInterface::CHANGE_CALL, $action_global) || $is_admin == 1)
                                <select class="form-control change-call"
                                        name="user_call_{{$item['id']}}" data-id="{{$item['id']}}"
                                        data-type="investor">
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
                        <td>{{ $item['name'] }}</td>
                        <td>
                            @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR_ACTIVE, $action_global) || $is_admin == 1)

                                <a class="btn btn-success btn_call_investor"
                                   style="border-style: none"
                                   data-bs-toggle="modal" data-bs-target="#modal_call_ndt_new"
                                   data-id="{{$item['id']}}">
                                    <i class="fas fa-phone-alt"></i>
                                </a>
                            @endif
                            <br>
                            {{ hide_phone($item['phone_number']) }}
                        </td>
                        <td>{{ isset($item['active_at']) ? date('d/m/Y H:i:s', strtotime($item['active_at']))  : ''}}</td>
                        <td class="text-danger">0</td>
                        <td>
                            @if(!empty($item['investment_status']) && $item['investment_status'] == 1)
                                <span class="badge badge-success">Đang đầu tư</span>
                            @else
                                <span class="badge badge-active">Chưa đầu tư</span>
                            @endif
                        </td>
                        <td>
                            <span
                                class="badge {{!empty($item['call_status']) ? color_lead_status($item['call_status']) : 'badge-active'}}">{{!empty($item['call_status']) ? lead_status($item['call_status']) : 'Mới'}}</span>
                            @if($item['call_status'] == 13)
                                <br>
                                <span
                                    class="text-danger">{{!empty($item['note_cancel']) ? note_delete($item['note_cancel']) : ""}}</span>
                            @endif
                        </td>
                        <td>
                            {!! isset($item['call_note']) ? wordwrap($item['call_note'], 25, "<br>\n") : '' !!}
                        </td>
                        <td>{{ !empty($item['user_source']) ? $item['user_source'] : '' }}</td>
                        <td>{{ !empty($item['referral_code']) ? hide_phone($item['referral_code']) : '' }}</td>
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
                                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                         stroke="currentColor" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
                                    @if(in_array(\App\Service\ActionInterface::CHI_TIET_NDT, $action_global) || $is_admin == 1)
                                        <a class="dropdown-item"
                                           href="{{ route('investor_detail', $item['id']) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon dropdown-item-icon" width="24"
                                                 height="24" viewBox="0 0 24 24" stroke-width="2"
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
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Table --}}
