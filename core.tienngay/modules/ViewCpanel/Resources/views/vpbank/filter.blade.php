<div class="btn_list_filter text-right mt-0">

    <div class="button_functions btn-fitler" style="width: 100px;">
        <input type="text" class="form-control" name="select-time" id="select-time" value="{{$currentTime}}" placeholder="Tháng"
        data-bs-toggle="tooltip" title="" data-bs-original-title="Lọc dữ liệu theo tháng"
        />
    </div>
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="post" action="{{$searchTransactionsUrl}}">
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
                        <label class="form-label"><strong>Mã Giao Dịch</strong>
                        </label>
                        <div>
                            <input type="text" name="transactionId" class="form-control" value="" autocomplete="off" placeholder="Mã giao dịch">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng Giao Dịch</strong>
                        </label>
                        <div>
                            <input type="text" name="storeValue" class="form-control" value="" autocomplete="off" placeholder="VPBank Code/Tên Phòng GD">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số TK Chuyên Thu</strong></label>
                        <input type="text" name="masterAccountNumber" class="form-control" value="" autocomplete="off" placeholder="Số tài khoản chuyên thu">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số TK VAN</strong></label>
                        <input type="text" name="virtualAccountNumber" class="form-control" value="" autocomplete="off" placeholder="Số tài khoản vitual">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Tên TK VAN</strong></label>
                        <input type="text" name="virtualName" class="form-control" value="" autocomplete="off" placeholder="Tên tài khoản vitual">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã Phiếu Ghi</strong></label>
                        <input type="text" name="contract_code" class="form-control" value="" autocomplete="off" placeholder="Mã phiếu ghi">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái thanh toán</strong></label>
                        <select class="form-control" name="status" placeholder="Trạng thái gạch nợ">
                            <option value>Tất cả</option>
                            <option value="1">Đang xử lý</option>
                            <option value="2">Đã trừ tiền kỳ</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>TT Đối Soát</strong></label>
                        <select class="form-control" name="daily_confirmed" placeholder="Trạng thái gạch nợ">
                            <option value>Tất cả</option>
                            <option value="1">Chưa đối soát</option>
                            <option value="2">Đã đối soát</option>
                            <option value="3">Đối soát bổ sung</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khoảng thời gian</strong>
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
                    <li><a id="export-excel" class="dropdown-item" file-name="vpbank-transactions" clone-table="export-object" href="javascriptvoid:0">Xuất danh sách giao dịch</a></li>
                    <li><a id="print-data" class="dropdown-item" clone-table="clone-object" href="javascriptvoid:0">In danh sách giao dịch</a></li>
              </ul>
            </div>
        </div>
    </div>
    <div class="button_functions btn-fitler" style="width: 200px;">
        <input style="font-size: 14px" type="text" class="form-control" name="search-input" id="search-input" placeholder="Search" data-bs-toggle="tooltip" title="" data-bs-original-title="Tìm kiếm toàn bộ dữ liệu hiện tại khớp với bất kỳ thông tin nào được nhập vào"/>
    </div>
</div>
