<style>
    .btn-outline-success {
        margin: 6px 16px;
        background-color: #D2EADC !important;
        height: 32px;
        font-style: normal;
        font-weight: 600 !important;
        color: #1D9752 !important;
        border-color: #D2EADC !important;
    }
    .form-label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .btn-success {
        background-color: #1D9752 !important;
        font-style: normal;
        font-weight: 600 !important;
        font-size: 14px !important;
        line-height: 16px !important;
        height: 40px;
    }

    .btn-secondary {
        background-color: #D8D8D8 !important;
        border-color: #D8D8D8 !important;
        color: #676767 !important;
        font-style: normal;
        font-weight: 600 !important;
        line-height: 16px !important;
        height: 40px;
    }
</style>
<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button id="fillter-button" class="btn btn-outline-success" type="button" aria-haspopup="true" aria-expanded="false">
           Tìm kiếm <i class="fa fa-search"
                       aria-hidden="true"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton" style="margin-right: -160px;">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{route('viewcpanel::trade.inventory.reportList')}}">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="text-large" style="padding-bottom:16px;color: #3B3B3B;font-weight: 600;font-size: 16px;line-height: 20px;text-align: center">Tìm kiếm</div>
                        </div>
                        <dir class="col-4">
                            <button type="button" id="close-search-form" class="btn-close" aria-label="Close" style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Ngày tạo</label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" id="date" type="text" name="start_date" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" id="date2" type="text" name="end_date" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Phòng giao dịch</label>
                        <select name="store" id="store" class="form-control">
                            @if(isset($pgds))
                                <option value="">--Tất cả--</option>
                                @foreach($pgds as $key => $s)
                                    <option value="{{$s['_id']}}">{{$s['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">--Tất cả--</option>
                            @if(isset($status))
                            @foreach($status as $key => $item)
                                <option value="{{$key}}">{{$item}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <div class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search" style="width: 100%;padding: 6px 16px">
                                    Tìm kiếm
                                </button>

                            </div>
                            <div class="col-6">
                                <button id="clear-search-form" type="submit" class="btn btn-secondary btn_search" style="width: 100%;padding: 6px 26px">
                                    Hủy
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


