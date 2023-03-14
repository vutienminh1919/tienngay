@extends('layout.master')
@section('page_name','Nhà đầu tư uỷ quyền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}" class="text-info">Nhà
                        đầu tư uỷ quyền</a></li>
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
                            <h1 class="d-inline-block">Chi tiết hợp đồng</h1>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped">
                                    <thead align="center">
                                    <tr>
                                        <th>Số kỳ</th>
                                        <th>Ngày đến hạn</th>
                                        <th>Tiền gốc trả hàng kỳ</th>
                                        <th>Tiền lãi khách hàng trả</th>
                                        <th>Tiền lãi NĐT</th>
                                        <th>Trạng thái</th>
                                        <th>Số tiền thanh toán</th>
                                        <th>Hình thức thanh toán</th>
                                    </tr>
                                    </thead>
                                    <tbody align="center">
                                    <tr>
                                        <th>1</th>
                                        <th>01/01/2021</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>...</th>
                                        <th>...</th>
                                        <th>Giải ngân</th>
                                        <th>...</th>
                                        <th>...</th>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>01/01/2021</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>Đã thanh toán</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>Gạch nợ tự động</th>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>01/01/2021</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>20.000.000 VNĐ</th>
                                        <th>Chưa thanh toán</th>
                                        <th>20.000.000 VNĐ</th>
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
@endsection

<style>

    .markdown > table > :not(caption) > * > *, .table > :not(caption) > * > * {
        padding: 15px 10px;
        font-weight: normal;
        font-size: 14px;
    }
    input[type="radio"]
    {
        filter: invert(1%) hue-rotate(
            290deg
        ) brightness(1);
    }
    #filter-data .btn-filter
    {
        height: 36px;
        width: 36px;
    }
</style>
