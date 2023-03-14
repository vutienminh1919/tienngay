<div class="btn_list_filter text-right mt-0">
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
                        <label class="form-label"><strong>Email nhân viên vi phạm</strong></label>
                        <input type="text" name="user_email" class="form-control" value="" autocomplete="off" placeholder="Email nhân viên vi phạm">
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
                        <label class="form-label"><strong>Tiến trình</strong></label>
                        <select class="form-control" name="process" placeholder="Tiến trình">
                            <option value>Tất cả</option>
                            <option value="1">Chờ xác nhận</option>
                            <option value="2">Đã duyệt, chờ phản hồi</option>
                            <option value="3">Đã kết luận</option>
                            <option value="4">Kiểm tra lại</option>
                            <option value="5">Đã phản hồi/chờ kết luận</option>
                            <option value="6">Quá thời gian phản hồi</option>
                            <option value="7">Chờ duyệt lại</option>
                            <option value="8">Chờ gửi duyệt</option>
                            <option value="9">Chờ phản hồi</option>
                            <option value="10">Chờ TBP kết luận</option>
                            <option value="11">Gửi CEO xác nhận</option>
                            <option value="12">CEO đồng ý</option>
                            <option value="13">CEO chưa đồng ý</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái</strong></label>
                        <select class="form-control" name="status" placeholder="Trạng thái">
                            <option value>Tất cả</option>
                            <option value="1">Mới</option>
                            <option value="2">Còn hiệu lực</option>
                            <option value="3">Hết hiệu lực</option>
                            <option value="4">TBP chưa duyệt</option>
                            <option value="5">Hủy</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khoảng thời gian tạo</strong>
                        </label>
                        <div style="padding-left: 20px;">
                            <label class="form-label"><strong>Từ ngày:</strong>
                            <input type="text" class="form-control" name="start_date" id="start-date" placeholder="yyyy-mm-dd">
                            <label class="form-label"><strong>Đến ngày:</strong>
                            <input type="text" class="form-control" name="end_date" id="end-date" placeholder="yyyy-mm-dd">
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
    <div class="button_functions btn-fitler">
        <div class="button_functions">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle btn-func btn-success" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Chức năng &nbsp
              </button>
              <ul class="dropdown-menu dropdown-customer" aria-labelledby="dropdownMenu">
                    <li><a id="create-report" class="dropdown-item" href='{{url("/cpanel/reportsKsnb/createReport")}}'>Tạo mới</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
