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
                        <label class="form-label"><strong>Họ tên</strong></label>
                        <input type="text" name="name_note" class="form-control" value="" autocomplete="off" placeholder="Tên nhân viên ghi nhận">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Email</strong></label>
                        <input type="text" name="email_note" class="form-control" value="" autocomplete="off" placeholder="Email nhân viên ghi nhận">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Họ tên nhân viên vi phạm</strong></label>
                        <input type="text" name="user_name" class="form-control" value="" autocomplete="off" placeholder="Tên nhân viên vi phạm liên quan">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Email nhân viên vi phạm</strong></label>
                        <input type="text" name="user_email" class="form-control" value="" autocomplete="off" placeholder="Email nhân viên vi phạm liên quan">
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
                            <option value="10">Chờ TBP Kết Luận</option>
                            <option value="11">Đã gửi CEO</option>
                            <option value="12">CEO đồng ý</option>
                            <option value="12">CEO chưa đồng ý</option>
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
                    <li><a id="create-note" class="dropdown-item" href='{{url("/cpanel/reportsKsnb/createNote")}}'>Tạo mới</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
