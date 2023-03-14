<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler" style="width: 200px;">
        <input style="font-size: 14px" type="text" class="form-control" name="search-input" id="search-input" placeholder="Search" data-bs-toggle="tooltip" title="" data-bs-original-title="Tìm kiếm toàn bộ dữ liệu hiện tại khớp với bất kỳ thông tin nào được nhập vào"/>
    </div>
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="post" action="{{$filterUrl}}">
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
                        <label class="form-label"><strong>Tên Khách Hàng</strong></label>
                        <input type="text" name="name" class="form-control" value="" autocomplete="off" placeholder="Tên khách hàng">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số CMT/CCCD</strong></label>
                        <input type="text" name="indentity" class="form-control" value="" autocomplete="off" placeholder="Số CMT/CCCD">
                    </div>
                    @if($bn)
                    <input type="hidden" name="isBanNgoai" class="form-control" value="1">
                    @elseif($hd)
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã Phiếu Ghi</strong></label>
                        <input type="text" name="contract_code" class="form-control" value="" autocomplete="off" placeholder="Mã phiếu ghi">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã Hợp Đồng</strong></label>
                        <input type="text" name="contract_disbursement" class="form-control" value="" autocomplete="off" placeholder="Mã hợp đồng">
                    </div>
                    <input type="hidden" name="isHopDong" class="form-control" value="1">
                    @else
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã Phiếu Ghi</strong></label>
                        <input type="text" name="contract_code" class="form-control" value="" autocomplete="off" placeholder="Mã phiếu ghi">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã Hợp Đồng</strong></label>
                        <input type="text" name="contract_disbursement" class="form-control" value="" autocomplete="off" placeholder="Mã hợp đồng">
                    </div>
                    @endif
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
                    @if ($bn)
                    <li><a href="{{$createLink}}" class="dropdown-item" target="_blank">Tạo đơn bảo hiểm</a></li>
                    @endif
                    @if ($export)
                    <li><a id="export-excel" class="dropdown-item" file-name="pti-bhtn" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
                    @endif
              </ul>
            </div>
        </div>
    </div>
</div>