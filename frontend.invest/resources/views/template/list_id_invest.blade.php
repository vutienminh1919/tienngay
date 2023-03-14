@extends('layout.master')
@section('page_name','Nhà đầu tư uỷ quyền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" ><a href="test">NĐT uỷ quyền</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}" class="text-info">Danh sách phụ lục hợp đồng</a></li>
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
                            <h1 class="d-inline-block">Danh sách phụ lục hợp đồng - Nguyễn Văn A</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown">
                                    Chức năng
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                       data-bs-target="#add_new_ndt">Thêm mới NĐT uỷ quyền</a>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                       data-bs-target="#add_appendix">Thêm phụ lục</a>
                                </div>
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 400px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('contract.list')}}">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Mã nhà đầu tư</strong></label>
                                                    <div>
                                                        <input type="text" name="key" class="form-control"
                                                               value=""
                                                               autocomplete="off" placeholder="Mã nhà đầu tư">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Tên nhà đầu tư</strong></label>
                                                    <div>
                                                        <input type="text" name="name" class="form-control"
                                                               value=""
                                                               autocomplete="off" placeholder="Tên nhà đầu tư">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Thời gian</strong></label>
                                                    <div>
                                                        <input type="date" name="fdate" class="form-control"
                                                               value="{{ request()->get('fdate') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Lãi suất</strong></label>
                                                    <div>
                                                        <select class="sellect form-control" id="sl_ls"
                                                                style="appearance: auto;">
                                                            <option value="">1</option>
                                                            <option value="">1</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="button" class="btn btn-light">
                                                        Huỷ
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        Tìm kiếm
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped">
                                    <thead align="center">
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã phụ lục</th>
                                        <th>Ngày đầu tư</th>
                                        <th>Số tiền đầu tư</th>
                                        <th>Ngày trả lãi</th>
                                        <th>Số ngày trong năm</th>
                                        <th>Lãi suất</th>
                                        <th>Hình thức thanh toán</th>
                                    </tr>
                                    </thead>
                                    <tbody align="center">
                                    <tr>
                                        <th>1</th>
                                        <th>HĐNT/NHB/06</th>
                                        <th>01/01/2021</th>
                                        <th>1.000.000.000</th>
                                        <th>15</th>
                                        <th>365</th>
                                        <th>1.5%</th>
                                        <th>Gạch nợ tự động</th>

                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>HĐNT/NHB/06</th>
                                        <th>01/01/2021</th>
                                        <th>1.000.000.000</th>
                                        <th>15</th>
                                        <th>365</th>
                                        <th>1.5%</th>
                                        <th>Gạch nợ tự động</th>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Paginate --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-inline-block float-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="add_appendix" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm phụ lục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Nhà đầu tư</strong><span class="text-danger">*</span></label>
                        <select id="sl_invest_uyquyen" class="form-control">
                            <option value="-1">- chọn nhà đầu tư -</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Mã phụ lục</strong><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" >
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label"><strong>Ngày đầu tư</strong><span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label"><strong>Ngày đáo hạn</strong><span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Số tiền đầu tư</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Nhập số tiền đầu tư">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <strong>Hình thức thanh toán</strong>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="handmade" class="radio_check" value="Thủ công" checked="checked" name="radio" /> Thủ công
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="auto" class="radio_check" value="Tự động" name="radio" /> Tự động
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <strong>Số ngày trong năm</strong>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="360_date" class="radio_date_check" value="360 ngày" checked name="radio1" /> 360 ngày
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="365_date" class="radio_date_check" value="365 ngày" name="radio1" /> 365 ngày
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="another_date" class="radio_date_check" value="Khác" name="radio1" /> Khác
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <strong>Chọn ngày trả lãi</strong>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="radio" id="30_date" class="radio_date_sellect_check" checked value="30 ngày" name="radio2" /> 30 ngày
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="radio" id="init_date" class="radio_date_sellect_check" value="Tự định nghĩa" name="radio2" /> Tự định nghĩa
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="mb-3">
                                                        <label class="form-label"><strong>Chọn ngày trả lãi</strong><span class="text-danger">*</span></label>
                                                        <select id="sl_invest_uyquyen" class="form-control">
                                                            <option value="-1">- Chọn ngày trả lãi -</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><strong>Chọn số trả lãi tháng/lần</strong><span class="text-danger">*</span></label>
                                                        <select id="sl_invest_uyquyen" class="form-control">
                                                            <option value="-1">- Chọn số trả lãi tháng/lần -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-primary">Tạo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="add_new_ndt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới nhà đầu tư uỷ quyền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong> Nhà đầu tư</strong><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="example-text-input"
                               placeholder="Your report name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong> Ngày đầu tư</strong><span class="text-danger">*</span></label>
                        <input type="date" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong> Số tiền đầu tư</strong><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập số tiền đầu tư">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong> Ghi chú</strong></label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="modal-footer" style="padding-left: 0;padding-right: 0">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Huỷ</button>
                        <a href="javascript:void(0)" class="btn btn-primary ms-auto" >
                            Tạo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .markdown > table > :not(caption) > * > *, .table > :not(caption) > * > * {
        padding: 15px 10px;
        font-weight: normal;
        font-size: 14px;
    }
</style>
