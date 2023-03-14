<div class="btn_list_filter2 text-right mt-0">
    <div class="button_functions btn-fitler2">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button style="height:35px; display:inline;" type="button" class="btn btn-outline-success" id="button_export_excel" onclick="export_history('xlsx', 'Lịch_sử_xuất_nhập_tồn')">Xuất Excel <i
                                    class="fa fa-file-excel-o search" aria-hidden="true"></i></button>
        <button id="fillter-button2" class="btn btn-outline-success" type="button" aria-haspopup="true"
                aria-expanded="false">
            Tìm kiếm <i class="fa fa-search"
                        aria-hidden="true"></i>
        </button>
        <div id="fillter-content2" class="dropdown-menu drop_select dropdown-customer"
             aria-labelledby="dropdownMenuButton" style="margin-right: -160px;">
            <div class="card-body">
                <form id="search-form2" method="GET" action="{{route('viewcpanel::trade.inventory.index')}}">
                    @csrf
                    <input type="text" class="form-control" name="tab" id="tab" hidden value="<?= $tab ?>">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="text-large"
                                 style="color: #333;font-weight: 600;text-transform: uppercase;text-align: center">Tìm
                                kiếm
                            </div>
                        </div>
                        <dir class="col-4">
                            <button type="button" id="close-search-form2" class="btn-close" aria-label="Close"
                                    style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <hr style="margin: 5px 0;">
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian</label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" id="date" type="text" name="start_date" placeholder="Từ ngày"
                                    value="{{request()->get('start_date')}}"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" id="date2" type="text" name="end_date" placeholder="Đến ngày"
                                    value="{{request()->get('end_date')}}"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mã ấn phẩm</label>
                        <input type="text" class="form-control" name="code_item" id="code_item" placeholder="Nhập" value="{{request()->get('code_item')}}">

                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Tên ấn phẩm</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập" value="{{request()->get('name')}}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Loại giao dịch</label>
                        <select class="form-control" name="transaction" id="transaction">
                            <option value="">--Chọn--</option>
                            @foreach($transactionType as $key => $trans)
                                <option value="{{$key}}" {{request()->get('transaction') == $key ? 'selected' : ''}}>{{$trans}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Phòng giao dịch</label>
                        <select class="form-control" name="store_id" id="store_id">
                            <option value="">--Chọn PGD--</option>
                            @foreach ($listStore as $st)
                                <option value="{{$st['_id']}}" {{request()->get('store_id') == $st['_id'] ? 'selected' : ''}}>{{$st['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <div class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search"
                                        style="width: 100%;padding: 6px 16px">
                                    Tìm kiếm
                                </button>

                            </div>
                            <div class="col-6">
                                <button id="clear-search-form2" type="submit" class="btn btn-secondary btn_search"
                                        style="width: 100%;padding: 6px 26px">
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





