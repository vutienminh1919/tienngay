@inject('noti','App\Service\Notification')
<header class="navbar navbar-expand-md">
    <div class="container-fluid">
        <div class="navbar-nav flex-row order-md-last">
            @if(in_array(\App\Service\ActionInterface::CALL_INVESTOR, $action_global) || $is_admin == 1)
                <div class="nav-item d-inline-block ml-5" style="display: block !important;">
                    <a href="#" class="nav-link px-0 phone" id="phone_header">
                        <i class="fas fa-phone-alt" style="font-size: 18px" id="icon_call"></i>
                        <span class="badge" id="span_call"></span>
                    </a>
                </div>
            @endif
            <style>
                #phone_header, #notifications
                {
                    margin-right: 15px;
                }
            </style>
            <div class="nav-item dropdown d-none d-md-flex mr-5" style="display: block !important;">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                   aria-label="Show notifications" id="notifications">
                    <i class="fas fa-bell " style="font-size: 18px"></i>
                    @if($noti->count_notification()>0)
                        <span class="badge bg-red">{{$noti->count_notification()}}</span>
                    @else
                        <span class="badge bg-red"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <ul style="list-style: none" class="list-style">
                        @foreach($noti->get_notification_user() as $item)
                            <a class="dropdown-item update_read_noti"
                               href="{{$item['link'] ? url($item['link']) : ''}}"
                               target="_blank" data-id="{{$item['id']}}"
                               @if($item['status'] == 1) style="background-color: #00e5ff !important;" @endif>
                                <div class="text-center">
                                    <div class="small text-gray-500">{{date('d/m/Y H:i:s',$item['created_at'])}}</div>
                                    <span class="font-weight-bold">{{$item['note'] ? $item['note'] : ''}}</span>
                                </div>

                            </a>
                            <hr class="mt-1 mb-1">
                        @endforeach
                        <a class="dropdown-item text-center small text-gray-500" href="{{route('notification.list')}}">Xem
                            tất cả thông báo >></a>
                    </ul>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                    <span
                        class="avatar avatar-sm avatar-rounded"><img
                            src="{{ asset('images/icon-logo.svg') }}"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ session()->get('user')['full_name'] }}</div>
                        <div class="mt-1 small text-muted">{{ session()->get('user')['email'] }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('auth_profile') }}" class="dropdown-item">Tài khoản</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('auth_logout') }}" class="dropdown-item">Đăng xuất</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu"></div>
    </div>
</header>

