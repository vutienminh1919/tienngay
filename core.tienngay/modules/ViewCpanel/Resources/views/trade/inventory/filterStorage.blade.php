<div class="btn_list_filter1 text-right mt-0">
    <div class="button_functions btn-fitler1">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button id="fillter-button1" class="btn btn-outline-success" type="button" aria-haspopup="true" aria-expanded="false" style="!important; background-color:#D2EADC; color:#1D9752;">
           Tìm kiếm <i class="fa fa-search"
                       aria-hidden="true"></i>
        </button>
        <div id="fillter-content1" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton" style="margin-right: -160px;">
            <div class="card-body">
                <form id="search-form1" method="GET" action="{{route('viewcpanel::trade.inventory.index')}}">
                    @csrf
                    <input type="text" class="form-control" name="tab" id="tab" hidden value="<?= $tab ?>">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;text-align: center">Tìm kiếm</div>
                        </div>
                        <dir class="col-4">
                            <button type="button" id="close-search-form1" class="btn-close" aria-label="Close" style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <hr style="margin: 5px 0;">
                   <div class="form-group mb-3">
                        <label class="form-label">Vùng</label>
                        <select class="form-control" name="domain" id="domain">
                            <option value="">--Chọn vùng--</option>
                            @foreach($domain as $key => $d)
                                <option <?= ($domain_search == $key) ? "selected" : "" ?> value="{{$key}}">{{$d}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Khu vực</label>
                        <select class="form-control" name="area" id="area" <?= $domain_search ? "" : "disabled" ?>>
                            @if(isset($areaSearch))
                                @foreach($areaSearch as $key => $a)
                                    <option <?= ($area_search == $a['code']) ? "selected" : "" ?> value="{{$a['code']}}">{{$a['title']}}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Phòng giao dịch</label>
                        <select name="store" id="store" class="form-control">
                            @if(isset($storeSearch))
                                <option value="">--Chọn PGD--</option>
                                @foreach($storeSearch as $key => $s)
                                    <option <?= ($store_search == $s['_id']) ? "selected" : "" ?> value="{{$s['_id']}}">{{$s['name']}}</option>
                                @endforeach
                            @else
                                @foreach($listStore as $st)
                                    <option value="{{$st['_id']}}">{{$st['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <div class="row">
                            <div class="col-6">
                                <button id="submit-data" type="submit" class="btn btn-success btn_search" style="width: 100%;padding: 6px 16px">
                                    Tìm kiếm
                                </button>

                            </div>
                            <div class="col-6">
                                <button id="clear-search-form1" type="submit" class="btn btn-secondary btn_search" style="width: 100%;padding: 6px 26px">
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




