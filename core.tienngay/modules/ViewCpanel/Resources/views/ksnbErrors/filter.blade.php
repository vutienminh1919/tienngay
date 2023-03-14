<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false" style="margin-right: 10px;">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton" style="">
            <div class="card-body" style="">
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
                        <label class="form-label"><strong>Mã Lỗi</strong></label>
                        <input  class="form-control" name="code_error" placeholder="Mã lỗi">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Nhóm lỗi vi phạm</strong></label>
                        <select class="form-control" name="type" placeholder="Nhóm lỗi vi phạm">
                            <option value="">Tất cả</option>
                            <option value="1">Vi phạm nội quy công ty</option>
                            <option value="2">Vi phạm liên quan đến khách hàng</option>
                            <option value="3">Vi phạm liên quan đến hoạt động phòng giao dịch</option>
                            <option value="4">Các vi phạm khác</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Hình thức kỷ luật</strong></label>
                        <select class="form-control" name="discipline" placeholder="Hình thức kỷ luật">
                            <option value="">Tất cả</option>
                            <option value="1">Khiển trách</option>
                            <option value="2">Kéo dài thời hạn tăng lương hoặc Cách chức</option>
                            <option value="3">Kéo dài thời hạn tăng lương hoặc Sa thải</option>
                            <option value="4">Sa thải</option>
                            <option value="5">Từng sự vụ</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Chế tài phạt</strong></label>
                        <select class="form-control" name="punishment" placeholder="Chế tài phạt">
                            <option value="">Tất cả</option>
                            <option value="1">10%</option>
                            <option value="2">20%</option>
                            <option value="3">30%</option>
                            <option value="4">Sa thải</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái</strong></label>
                        <select class="form-control" name="status" placeholder="Trạng thái">
                            <option value>Tất cả</option>
                            <option value="active">Active</option>
                            <option value="block">Block</option>
                        </select>
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
    <div class="button_functions btn-fitler">
        <div class="button_functions">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle btn-func btn-success" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Chức năng &nbsp
              </button>
              <ul class="dropdown-menu dropdown-customer" aria-labelledby="dropdownMenu">
                    <li><a id="create-report" class="dropdown-item" href='{{url("/cpanel/ksnb_erors/create")}}'>Tạo mới mã lỗi</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
