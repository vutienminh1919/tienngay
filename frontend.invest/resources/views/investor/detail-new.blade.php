@extends('layout.master')
@section('page_name','Chi tiết NDT')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC appove</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Chi tiết xác nhận NĐT</a></li>
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
                            <h1 class="d-inline-block mb-3">Chi tiết xác nhận NĐT: {{ $data['name'] ?? '' }}</h1>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <form class="row mb-3" method="POST" action="{{ route("investor_new_detail_post", $id) }}"
                          id="form">
                        @csrf
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Mã NĐT: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ substr($data['code'], 0, 4) . "****" . substr($data['code'], 7, 4) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Tên
                                    NĐT: </label>
                                <div class="col-6">
                                    <input class="form-control" name="name" value="{{ $data['name'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">SĐT: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ hide_phone($data['phone_number']) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Email: </label>
                                <div class="col-6">
                                    {{--<div class="form-control-plaintext show-info-text">{{ $data['email'] }}</div>--}}
                                    <input class="form-control" name="email" value="{{ $data['email'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Trạng
                                    thái: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">
                                        @if($data['status'] == "new")
                                            <span class="badge badge-success">Chờ kích hoạt</span>
                                        @else
                                            <span class="badge badge-secondary">Đã hủy</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">SĐT liên kết
                                    VIMO: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ substr($data['phone_vimo'], 0, 4) . "****" . substr($data['phone_vimo'], 7, 4) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Hạng người
                                    dùng: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ $data['investor_reviews'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Số
                                    CMND/CCCD: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ $data['identity'] ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Mặt trước
                                    CMND/CCCD: </label>
                                <div class="col-6">
                                    <div class="form-control-plaintext show-info-text">
                                        <img src="{{ $data['front_facing_card'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Mặt sau
                                    CMND/CCCD: </label>
                                <div class="col-6">
                                    <div class="form-control-plaintext show-info-text">
                                        <img src="{{ $data['card_back'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Form --}}
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label text-center"></label>
                        <div class="col-6 text-center">
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
                            <a href="javascript:void(0);" id="show-confirm-btn" class="btn btn-primary">
                                Kích hoạt
                            </a>
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
                </div>
            </div>
        </div>
    </div>

    @include('investor.modal_confirm_new')
    @include('investor.modal_confirm_success')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn-submit').on('click', function () {
                $('#form').submit();
            });

            // Show Confirm button
            $('#show-confirm-btn').on('click', function () {
                $('#confirm-new-modal').modal('show');
            });
            // Confirm button
            $('#confirm-btn').on('click', function () {
                $('#confirm-new-modal').modal('hide');
                investor_list = '{{$id}}';
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
        });
    </script>
@endsection
