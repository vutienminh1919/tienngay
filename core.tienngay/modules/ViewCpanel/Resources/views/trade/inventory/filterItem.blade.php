<style>
    .form-label {
        font-style: normal;
        font-weight: 400;
        line-height: 16px;
        color: #3B3B3B;
    }
    .btn-success {
        background-color: #1D9752 !important;
        font-style: normal;
        font-weight: 600 !important;
        line-height: 21px !important;
    }
    .btn-secondary {
        background-color: #D8D8D8!important;
        border-color: #D8D8D8 !important;
        color: #676767!important;
        font-style: normal;
        font-weight: 600!important;
        line-height: 21px!important;
    }
</style>
<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
       <button style="height: 35px;display: inline;padding: 5px;width: 110px;font-size: 15px;" type="button" onclick="export_item('xlsx', 'danh_sach_ton_kho_an_pham_trade')" class="btn btn-outline-success excel-item">Xuất Excel <i class="fa fa-file-excel-o search" aria-hidden="true"></i></button>
        <button id="fillter-button" class="btn btn-outline-success" type="button" aria-haspopup="true" style=" background-color:#D2EADC; color:#1D9752; border-color:#D2EADC; margin-left: 16px;"
                aria-expanded="false">
            Tìm kiếm <i class="fa fa-search"
                        aria-hidden="true"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer"
             aria-labelledby="dropdownMenuButton" style="margin-right: -160px;">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{route('viewcpanel::trade.inventory.index')}}">
                    @csrf
                    <input type="text" class="form-control" name="tab" id="tab" hidden value="<?= $tab ?>">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="text-large"
                                 style="color: #3B3B3B;font-weight: 600;font-size: 16px;text-align: center; padding-bottom: 16px;">Tìm
                                kiếm
                            </div>
                        </div>
                        <dir class="col-4">
                            <button type="button" id="close-search-form" class="btn-close" aria-label="Close"
                                    style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Mã ấn phẩm</label>
                        <input type="text" class="form-control" name="code_item" id="code_item" placeholder="Nhập">
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Tên ấn phẩm</label>
                        <select class="form-control name" name="name" id="name">
                            <option value="">--Chọn--</option>
                            @if($name)
                                @foreach($name as $nm)
                                    <option value="{{$nm['_id']}}">{{$nm['_id']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Loại ấn phẩm</label>
                        <select class="form-control type" name="type" id="type">
                            <option value="">--Chọn--</option>
                            @if($name && $type_search)
                                @foreach($name as $nm)
                                    @if($nm['_id'] == $name_search)
                                        @foreach($nm['type'] as $type)
                                            <option <?= $type_search == $type ? "selected" : "" ?> value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @elseif(!$type_search)
                                @foreach($name as $nm)
                                    @if($nm['_id'] == $name_search)
                                        @foreach($nm['type'] as $type)
                                            <option <?= $type_search == $type ? "selected" : "" ?> value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
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
                                <button id="clear-search-form" type="submit" class="btn btn-secondary btn_search"
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



