<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-outline-success" type="button" aria-haspopup="true"
                aria-expanded="false">
            Tìm kiếm <img
                src="https://service.tienngay.vn/uploads/avatar/1669364001-b4751897ac58481f87746e6674f72b19.png" alt="">
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer"
             aria-labelledby="dropdownMenuButton" style="display: none;width: 350px;margin-left: -240px;">
            <div class="card-body" style="font-size: 12px">
                <form id="search-form" method="GET" action="{{$urlSearch}}">
                    @csrf
                    <div class="row">
                        <dir class="col-6">
                            <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc
                                dữ liệu
                            </div>
                        </dir>
                        <dir class="col-6">
                            <button type="button" id="close-search-form" class="btn-close" aria-label="Close"
                                    style="position: absolute;right: 15px;top: 15px; padding: 3px 9px;"></button>
                        </dir>
                    </div>
                    <hr style="margin: 5px 0;">
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mã ấn phẩm</strong></label>
                        <input type="text" name="item_id" class="form-control" value="" autocomplete="off"
                               placeholder="Nhập mã ấn phẩm" style="font-size: 12px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Tên ấn phẩm</strong></label>
                        <select name="name" id="name" style="font-size: 12px;">
                            <option value="">--Tất cả--</option>
                            @foreach($name as $item)
                                <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Loại ấn phẩm</strong></label>
                        <select class="form-select" name="type" id="type"
                                style="font-size: 12px;" <?= !empty($nameSearch) ? "" : "disabled" ?> >
                            <option value="">--Tất cả--</option>
                            @if((count($typeSearch) > 0) && $name)
                                @foreach($typeSearch as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Hạng mục</strong></label>
                        <select class="form-select" name="category" style="font-size: 12px;">
                            <option value>--Tất cả--</option>
                            <option value="item">Vật phẩm</option>
                            <option value="publication">Ấn phẩm</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mục tiêu triển khai</strong></label>
                        <select class="form-select" name="target_goal" style="font-size: 12px;">
                            <option value>--Tất cả--</option>
                            <option value="direct">Trực tiếp</option>
                            <option value="indirect">Phủ nhận diện</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Mục tiêu thúc đẩy</strong></label>
                        <select class="form-select motivating_goal" name="motivating_goal[]" style="font-size: 12px;"
                                multiple>
                            @foreach($moti as $key => $mt)
                                <option value="{{$key}}">{{$mt}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng giao dịch</strong></label>
                        <select class="store" name="store" id="store" style="font-size: 12px;">
                            <option value="">--Tất cả--</option>
                            @if(!empty($store))
                                @foreach($store as $st)
                                    <option value="{{$st->_id}}">{{$st->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group text-right" style="font-size: 12px; ">
                        <div style="display: flex; justify-content: space-between">
                            <div>
                                <button id="submit-data" type="submit" class="btn btn-success btn_search"
                                        style="padding: 6px 16px;width: 150px">
                                    Tìm kiếm
                                </button>
                            </div>
                            <div>

                                <button id="clear-search-form" type="submit" class="btn btn-secondary btn_search"
                                        style="padding: 6px 26px;width: 150px">
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

