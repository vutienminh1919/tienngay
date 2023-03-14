<div class="btn_list_filter text-right mt-0" style="position: absolute; bottom: 0; right: 0;">

    <div class="button_functions btn-fitler" style="width: 100px;">
        <input type="text" class="form-control" name="select-time" id="select-time" value="{{$currentTime}}" placeholder="Tháng"/>
    </div>
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="post" action="{{$searchTransactionsUrl}}">
                    @csrf
                    <div class="mb-3">
                        <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc dữ liệu</div>
                        <hr style="margin: 5px 0;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã hợp đồng</strong>
                        </label>
                        <div>
                            <input type="text" name="contract_code_disbursement" class="form-control" value="" autocomplete="off" placeholder="Mã hợp đồng">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Loại GD</strong></label>
                        <select class="form-control" name="payment_option">
                            <option value>Tất cả</option>
                            <option value="1">Thanh toán kỳ</option>
                            <option value="2">Tất toán</option>
                            <option value="3">NĐT</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái gạch nợ</strong></label>
                        <select class="form-control" name="contract_status">
                            <option value>Tất cả</option>
                            <option value="1">Đang xử lý</option>
                            <option value="2">Đã trừ tiền kỳ</option>
                            <option value="3">Thất bại</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái thanh toán</strong></label>
                        <select class="form-control" name="status">
                            <option value>Tất cả</option>
                            <option value="1">Chưa thanh toán</option>
                            <option value="2">Đã thanh toán</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái đối soát</strong></label>
                        <select class="form-control" name="confirmed">
                            <option value>Tất cả</option>
                            <option value="1">Chưa đối soát</option>
                            <option value="2">Đã đối soát</option>
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
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã giao dịch</strong>
                        </label>
                        <div>
                            <input type="text" name="transactionId" class="form-control" value="" autocomplete="off" placeholder="Mã giao dịch">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã phiếu ghi</strong>
                        </label>
                        <div>
                            <input type="text" name="contract_code" class="form-control" value="" autocomplete="off" placeholder="Mã phiếu ghi">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button id="submit-data" type="submit" class="btn btn-success btn_search">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="button_functions">
        <div class="dropdown">
            <button class="btn btn-secondary btn-success dropdown-toggle btn-func" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Chức năng &nbsp<i class="fa fa-caret-down "></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a id="export-excel" class="dropdown-item" href="javascriptvoid:0">Xuất danh sách giao dịch</a>
                <a id="print-data" class="dropdown-item" href="javascriptvoid:0">In danh sách giao dịch</a>
                <a id="reconciliation-confirm" class="dropdown-item" href="javascriptvoid:0">Xác nhận đối soát</a>
                <a id="reconciliation-data" class="dropdown-item" href="javascriptvoid:0">Tạo đối soát bổ sung</a>
            </div>
        </div>
    </div>
</div>
