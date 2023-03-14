<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
           Tìm kiếm <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="POST" action="{{$filterUrl}}">
                    @csrf
                    <div class="row">
                        <dir class="col-6">
                            <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc dữ liệu</div>
                        </dir>
                        <dir class="col-6">
                            <button type="button" id="close-search-form" class="btn-close" aria-label="Close" style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <hr style="margin: 5px 0;">
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Từ ngày</strong></label>
                        <input type="date" name="from_date" class="form-control" value="{{request()->get('from_date')}}" autocomplete="off" placeholder="Từ ngày">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Đến ngày</strong></label>
                        <input type="date" name="to_date" class="form-control" value="{{request()->get('to_date')}}" autocomplete="off" placeholder="Đến ngày">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Họ và tên</strong></label>
                        <input type="text" name="user_name" class="form-control" value="" autocomplete="off" placeholder="Họ và tên">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số điện thoại</strong></label>
                        <input type="text" name="user_phone" class="form-control" value="" autocomplete="off" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số cmnd/cccd</strong></label>
                        <input type="text" name="user_identify" class="form-control" value="" autocomplete="off" placeholder="Số cmnd/cccd">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số hộ chiếu</strong></label>
                        <input type="text" name="user_passport" class="form-control" value="" autocomplete="off" placeholder="Số hộ chiếu">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Loại Blacklist</strong></label>
                        <select name="id_blacklist" id="id_blacklist" class="form-control">
                            <option value="" selected>Chọn loại blacklist</option>
                            <option value="1">Giấy tờ giả</option>
                            <option value="2">Nhân sự nghỉ việc</option>
                            <option value="3">Nợ xấu/Miễn giảm</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <div class="col-6">
                                <button id="clear-search-form" type="submit" class="btn btn-warning btn_search" style="padding: 6px 26px">
                                    Clear
                                </button>
                            </div>
                            <div class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search" style="padding: 6px 16px">
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="button_functions btn-fitler">
        <a id="export-excel" class="btn btn-info" file-name="blackList" clone-table="export-object" href="javascriptvoid:0" style="color: white; font-size: 14px;">
            Xuất Excel <i class="fa fa-file-excel-o"></i>
        </a>
    </div>
</div>

