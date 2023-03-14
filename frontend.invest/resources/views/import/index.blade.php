@extends('layout.master')
@section('page_name','Import danh sách')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Import</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="#"
                                                                   class="text-info">Import</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        @if($is_admin == 1)
            <div class="col-12 col-md-6 pb-2">
                <div class="card">
                    <div class="card-header d-inline-block bg-success text-white">
                        <i class="fa fa-upload"></i> &nbsp;Import NDT Uỷ Quyền
                    </div>
                    <div class="card-body">
                        <div class="form-group pb-2">
                            <input type="file" name="import_ndt_uy_quyen" class="form-control"
                                   placeholder="sothing">
                        </div>
                        <a class="btn btn-success float-right d-inline-block" id="import_ndt_uy_quyen">Upload</a>
                        <div class="list_user_fail" style="display: none">
                            <h4 class="text-danger">Ds các dòng không hợp lệ</h4>
                            <ol>
                                <li class="">Dòng chưa hợp lệ:</li>
                                <ul>
                                    <li class="text_list_user_fail"></li>
                                </ul>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
                <div class="card">
                    <div class="card-header d-inline-block bg-success text-white">
                        <i class="fa fa-upload"></i> &nbsp;Block user call lead
                    </div>
                    <div class="card-body">
                        <div class="form-group pb-2">
                            <input type="file" name="block_user_call" class="form-control"
                                   placeholder="sothing">
                        </div>
                        <a class="btn btn-success float-right d-inline-block" id="block_user_call">Upload</a>
{{--                        <div class="list_user_fail" style="display: none">--}}
{{--                            <h4 class="text-danger">Ds các dòng không hợp lệ</h4>--}}
{{--                            <ol>--}}
{{--                                <li class="">Dòng chưa hợp lệ:</li>--}}
{{--                                <ul>--}}
{{--                                    <li class="text_list_user_fail"></li>--}}
{{--                                </ul>--}}
{{--                            </ol>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
            @if(in_array(\App\Service\ActionInterface::IMPORT_CONTRACT_AUTHORITY, $action_global) || $is_admin == 1)
                <div class="col-12 col-md-6 pb-2">
                    <div class="card">
                        <div class="card-header d-inline-block bg-info text-white">
                            <i class="fa fa-upload"></i> &nbsp;Import DS HD Uỷ Quyền
                        </div>
                        <div class="card-body">
                            <div class="form-group pb-2">
                                <input type="file" name="import_hd_uy_quyen" class="form-control"
                                       placeholder="sothing">
                            </div>
                            <a class="btn btn-info float-right d-inline-block" id="import_hd_uy_quyen">Upload</a>
                            <div class="list_contract_fail" style="display: none">
                                <h4 class="text-danger">Ds các dòng HD không hợp lệ</h4>
                                <ol>
                                    <li class="">Dòng chưa hợp lệ:</li>
                                    <ul>
                                        <li class="text_list_contract_fail"></li>
                                    </ul>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12 col-md-6 pb-2">
                <div class="card">
                    <div class="card-header d-inline-block bg-primary text-white">
                        <i class="fa fa-upload"></i> &nbsp;Import DS thanh toán NDT Uỷ Quyền
                    </div>
                    <div class="card-body">
                        <div class="form-group pb-2">
                            <input type="file" name="import_transaction_uy_quyen" class="form-control"
                                   placeholder="sothing">
                        </div>
                        <a class="btn bg-primary float-right d-inline-block text-white"
                           id="import_transaction_uy_quyen">Upload</a>
                        <div class="list_transaction_fail" style="display: none">
                            <h4 class="text-danger">Ds các dòng Transaction không hợp lệ</h4>
                            <ol>
                                <li class="">Dòng chưa hợp lệ:</li>
                                <ul>
                                    <li class="text_list_transaction_fail"></li>
                                </ul>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
                <div class="card">
                    <div class="card-header d-inline-block bg-primary text-white">
                        <i class="fa fa-upload"></i> &nbsp;Import DS NDT giới thiệu NDT
                    </div>
                    <div class="card-body">
                        <div class="form-group pb-2">
                            <input type="file" name="import_commission" class="form-control"
                                   placeholder="sothing">
                        </div>
                        <a class="btn bg-primary float-right d-inline-block text-white"
                           id="import_commission">Upload</a>
                        <div class="list_commission_fail" style="display: none">
                            <h4 class="text-danger">Ds các dòng không hợp lệ</h4>
                            <ol>
                                <li class="">Dòng chưa hợp lệ:</li>
                                <ul>
                                    <li class="text_list_commission_fail"></li>
                                </ul>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(in_array(\App\Service\ActionInterface::IMPORT_LEAD_INVESTOR, $action_global) || $is_admin == 1)
            <div class="col-12 col-md-6 pb-2">
                <div class="card">
                    <div class="card-header d-inline-block bg-warning text-white">
                        <i class="fa fa-upload"></i> &nbsp;Import DS Lead Nhà đầu tư
                    </div>
                    <div class="card-body">
                        <div class="form-group pb-2">
                            <input type="file" name="import_lead_investor" class="form-control"
                                   placeholder="sothing">
                        </div>
                        <a class="btn bg-warning float-right d-inline-block text-white"
                           id="import_lead_investor" style="margin-left: 10px">Upload</a>
                        <a class="btn bg-primary float-right d-inline-block text-white"
                           href="{{route('investor.lead')}}">Về danh sách Lead</a>
                        <div class="list_lead_fail" style="display: none">
                            <h4 class="text-danger">Ds các dòng không hợp lệ</h4>
                            <ol>
                                <li class="">Dòng chưa hợp lệ:</li>
                                <ul>
                                    <li class="text_list_lead_fail"></li>
                                </ul>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script src="{{asset('project_js/import/index.js')}}"></script>
@endsection
