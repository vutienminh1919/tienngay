@extends('layout.master')
@section('page_name','Cài đặt call center')
@section('content')
    @include('layout.alert_success')
    @include('investor.modal_confirm_new')
    @include('investor.modal_confirm_success')
    @include('investor.modal_block_new')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('config.call')}}"
                                                                   class="text-info">Cài đặt Call Center</a>
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
                            <h1 class="d-inline-block mb-3">Cài đặt</h1>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="post" action="{{route('config')}}">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Ngày hiện tại :</label>
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="Tên nhóm" name="name"
                                               value="{{date('d-m-Y') }}" autocomplete="off" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Chọn CSKH :</label>
                                    <div class="col-6">
                                        @foreach($user_tls as $value)
                                            <label class="form-check">
                                                <input type="checkbox" name="telesales[]" value="{{$value['id']}}"
                                                       class="form-check-input" {{$value['checked'] == true ? 'checked' : ''}}>
                                                <span class="form-check-label">{{$value['email']}}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    @if(in_array(\App\Service\ActionInterface::CONFIG_CALL, $action_global) || $is_admin == 1)
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary">
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
                                                Cập nhật
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

