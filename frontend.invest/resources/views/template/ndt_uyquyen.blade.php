@extends('layout.master')
@section('page_name','Nhà đầu tư uỷ quyền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}" class="text-info">Yêu cầu vay và chênh lệch thực tế</a></li>
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
                        <div class="col-12 mb-4">
                            <h1 class="d-inline-block">Yêu cầu vay và chênh lệch thực tế</h1>
                            <div class="clearfix"></div>
                        </div>
                        <div class="list_total_money mb-4">
                            <div class="row">
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng tiền cho vay</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng tiền được uỷ quyền</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng tiền cho vay - app</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng lãi suất phải thu KH</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng lãi suất phải trả NĐT</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center border_right">
                                    <div class="item">
                                        <label>Tổng tiền chênh lệch thu về</label>
                                        <div class="money">
                                            <strong>400.000.000</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav_link_category mb-3 pb-3">
                        <div class="row">
                            <div class="col-sm-8">
                                <ul class="nav">
                                    <li class="nav_items">
                                        <a class="nav_links " href="ndt_app" title="">Nhà đầu tư app</a>
                                    </li>
                                    <li class="nav_items">
                                        <a class="nav_links active" href="ndt_uyquyen" title="">Nhà đầu tư uỷ quyền</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4 hr-text-right">
                                <div class="float-right d-inline-block" id="filter-data">
                                    <a class="btn btn-primary" style="padding-left: 10px;padding-right: 10px;" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-filter"></i>
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
                            </div>
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
                                        <th>Mã nhà đầu tư</th>
                                        <th>Tên nhà đầu tư</th>
                                        <th>Ngày đáo hạn</th>
                                        <th>Số tiền uỷ quyền</th>
                                        <th>Hình thức trả lãi</th>
                                        <th>Số tiền giải ngân</th>
                                        <th>Số HĐ đang đầu tư</th>
                                        <th>Tổng số tiền trả NĐT</th>
                                        <th>Lãi suất trả NĐT</th>
                                        <th>Lãi suất KH</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody align="center">
                                    <tr>
                                        <th>1</th>
                                        <th>0987777897</th>
                                        <th>Nguyễn Văn B</th>
                                        <th>01/01/2021</th>
                                        <th>250.000.000</th>
                                        <th>Dư nợ giảm dần</th>
                                        <th>1.000.000.000 NVĐ</th>
                                        <th>10</th>
                                        <th>1.000.000 VNĐ</th>
                                        <th>1,2%(3) <br />
                                            1,5%(2)</th>
                                        <th>1,2%(3)</th>
                                        <th><a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="details_uyquyen.blade">Xem chi tiết</a>
                                            </div></th>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>0987777897</th>
                                        <th>Nguyễn Văn B</th>
                                        <th>01/01/2021</th>
                                        <th>250.000.000</th>
                                        <th>Dư nợ giảm dần</th>
                                        <th>1.000.000.000 NVĐ</th>
                                        <th>10</th>
                                        <th>1.000.000 VNĐ</th>
                                        <th>1,2%(3) <br />
                                            1,5%(2)</th>
                                        <th>1,2%(3)</th>
                                        <th><a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a></th>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <th>0987777897</th>
                                        <th>Nguyễn Văn B</th>
                                        <th>01/01/2021</th>
                                        <th>250.000.000</th>
                                        <th>Dư nợ giảm dần</th>
                                        <th>1.000.000.000 NVĐ</th>
                                        <th>10</th>
                                        <th>1.000.000 VNĐ</th>
                                        <th>1,2%(3) <br />
                                            1,5%(2)</th>
                                        <th>1,2%(3)</th>
                                        <th><a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a></th>
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
    .list_total_money .border_right
    {
        border-right: 1px solid #000;
        padding: 5px 0;
    }
    .list_total_money .border_right:last-child
    {
        border-right: none;
    }
    .list_total_money .item label
    {
        color: #828282;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .list_total_money .item .money strong
    {
        color: #0E9549;
        font-size: 24px;
    }
    .nav_link_category
    {
        border-bottom: 1px solid #ddd;
    }
    .nav_link_category .nav_items .nav_links
    {
        padding: 20px 75px 0 0;
        font-size: 18px;
        color: #b1b4b9;
        text-decoration: none;
        text-transform: uppercase;
    }
    .nav_link_category .nav_items .nav_links.active{
        color: #154001;
        font-weight: 600;
    }
</style>
