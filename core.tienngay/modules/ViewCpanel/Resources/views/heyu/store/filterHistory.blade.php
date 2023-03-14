<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <button class="btn inline-block export" style="
                                    border: solid 1px #146c43;
                                    color: #146c43;
                                    font-size: 12px;
                                    font-weight: 600;
                                    margin-right: 10px;
                                " type="button">
            Xuất excel&nbsp;&nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i>
        </button>
    </div>
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer"
             aria-labelledby="dropdownMenuButton" style="right: 100px !important;">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{$searchUrl}}">
                    @csrf
                    <div class="row">
                        <dir class="col-6">
                            <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc
                                dữ liệu
                            </div>
                        </dir>
                        <dir class="col-6">
                            <button type="button" id="close-search-form" class="btn-close" aria-label="Close"
                                    style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <hr style="margin: 5px 0;">
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khoảng thời gian nhập</strong>
                        </label>
                        <div style="padding-left: 20px;">
                            <label class="form-label"><strong>Từ ngày:</strong></label>
                            <input type="text" class="form-control" name="start_date" id="start-date"
                                   placeholder="yyyy-mm-dd">
                            <label class="form-label"><strong>Đến ngày:</strong>
                                <input type="text" class="form-control" name="end_date" id="end-date"
                                       placeholder="yyyy-mm-dd"></label>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <dir class="col-6">
                                <button id="clear-search-form" type="submit" class="btn btn-warning"
                                        style="padding: 6px 26px">
                                    Clear
                                </button>
                            </dir>
                            <dir class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search"
                                        style="padding: 6px 16px">
                                    Tìm kiếm
                                </button>
                            </dir>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

