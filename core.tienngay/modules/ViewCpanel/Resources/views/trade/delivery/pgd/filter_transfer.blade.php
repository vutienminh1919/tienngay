<div class="btn_list_filter-transfer text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button> -->
        <button id="fillter-button-transfer" class="btn btn-outline-success" type="button" aria-expanded="false" style="!important; background-color:#D2EADC; color:#1D9752;">Tìm kiếm <img src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png" alt=""></button>
        <div style="margin-right: -170px; margin-top: 10px; width:auto;" id="fillter-content-transfer" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form-transfer" method="GET" action="{{route('viewcpanel::warehouse.pgdIndex')}}">
                    @csrf
                    <div class="row">
                        <dir class="col-12">
                            <div class="text-large" style="font-family:Roboto; line-height: 20px; color: #3B3B3B;font-weight: 600;justify-content: center; text-align:center">Tìm kiếm</div>
                        </dir>
                    </div>
                    <input hidden name="tab" type="text" value="{{$tab}}"/>

                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Ngày tạo</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('start_date')}}" id="date9" type="text" name="start_date" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('end_date')}}" id="date10" type="text" name="end_date" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Ngày yêu cầu</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('start_request_date')}}" id="date3" type="text" name="start_request_date" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('end_request_date')}}" id="date4" type="text" name="end_request_date" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Ngày xuất</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('start_date_export')}}" id="date5" type="text" name="start_date_export" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('end_date_export')}}" id="date6" type="text" name="end_date_export" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Ngày nhận</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('start_date_import')}}" id="date7" type="text" name="start_date_import" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('end_date_import')}}" id="date8" type="text" name="end_date_import" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng giao dịch xuất</strong></label>
                        <select class="form-select" name="stores_export" id="stores_export" >
                            <option value="" >Chọn PGD</option>
                                @foreach($stores as $store)
                                <option value="{{$store['_id']}}" {{request()->get('stores_export') == $store['_id'] ? 'selected' : ''}}>{{$store['name']}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng giao dịch nhận</strong></label>
                        <select class="form-select" name="stores_import" id="stores_import" >
                            <option value="" >Chọn PGD</option>
                                @foreach($stores as $store)
                                <option value="{{$store['_id']}}" {{request()->get('stores_import') == $store['_id'] ? 'selected' : ''}}>{{$store['name']}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Trạng thái</strong></label>
                        <select class="form-select" name="status" id="status" >
                            <option value="" >Tất cả</option>
                                @foreach($status_transfer as $k => $i)
                                <option value="{{$k}}" {{request()->get('status') == $k ? 'selected' : ''}}>{{$i}}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button style="background-color:#1D9752; color:#FFFFFF;width:100%" id="submit-data" type="submit" class="btn btn_search-transfer">
                                Tìm kiếm
                            </button>
                        </div>
                        <div class="col-6">
                            <button style="background-color:#D8D8D8;float: right;width:100%" id="clear-search-form-transfer" type="submit" class="btn btn_search-transfer">
                                Hủy
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="button_functions btn-fitler-transfer">
        <div class="button_functions">
            <div class="dropdown">
            </div>
        </div>
    </div>
</div>
