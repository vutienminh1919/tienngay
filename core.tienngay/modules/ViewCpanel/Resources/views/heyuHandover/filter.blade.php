<div class="btn_list_filter text-right mt-0 inline-block">
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{$searchUrl}}">
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
                        <label class="form-label"><strong>PGD</strong></label>
                        <select class="form-control" name="store" id="store">
                            <option id="default" value="">--Chọn PGD--</option>
                            @foreach($pgd as $item)
                                @if(!in_array($item['_id'], $pgd_active))
                                    @continue;
                                    @endif
                                <option <?= (!empty($_GET['store']) && $_GET['store'] == $item['_id']) ? 'selected' : ""  ?> value="{{$item['_id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã tài xế</strong></label>
                        <input type="text" name="driver_code" class="form-control" value="" autocomplete="off" placeholder="Mã tài xế">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Tên tài xế</strong></label>
                        <input type="text" name="driver_name" class="form-control" value="" autocomplete="off" placeholder="Tên tài xế">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái</strong></label>
                        <select name="status" id="" class="form-control">
                            <option value="">--Chọn trạng thái</option>
                            <option value="2">Đã duyệt</option>
                            <option value="1">Chờ duyệt</option>
                            <option value="3">Đã hủy</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khoảng thời gian giao</strong>
                        </label>
                        <div style="padding-left: 20px;">
                            <label class="form-label"><strong>Từ ngày:</strong></label>
                                <input type="text" class="form-control" name="start_date" id="start-date"
                                       placeholder="yyyy-mm-dd">
                                <label class="form-label"><strong>Đến ngày:</strong></label>
                                    <input type="text" class="form-control" name="end_date" id="end-date"
                                           placeholder="yyyy-mm-dd">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <dir class="col-6">
                                <button id="clear-search-form" type="submit" class="btn btn-warning btn_search" style="padding: 6px 26px">
                                    Clear
                                </button>
                            </dir>
                            <dir class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search" style="padding: 6px 16px">
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
