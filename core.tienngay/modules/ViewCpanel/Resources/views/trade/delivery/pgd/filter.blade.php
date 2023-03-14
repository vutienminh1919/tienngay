<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button> -->
        <button id="fillter-button" class="btn btn-outline-success" type="button" aria-expanded="false" style="!important; background-color:#D2EADC; color:#1D9752;">Tìm kiếm <img src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png" alt=""></button>
        <div style="margin-right: -170px; margin-top: 10px; width:auto;" id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{route('viewcpanel::warehouse.pgdIndex')}}">
                    @csrf
                    <div class="row">
                        <dir class="col-12">
                            <div class="text-large" style="font-family:Roboto; line-height: 20px; color: #3B3B3B;font-weight: 600;justify-content: center; text-align:center">Tìm kiếm</div>
                        </dir>
                    </div>
                    <input hidden name="tab" type="text" value="{{$tab}}"/>

                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Thời gian</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('start_date')}}" id="date" type="text" name="start_date" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input class="form-control" style="color:black; height:30px; border-radius: 5px;" value="{{request()->get('end_date')}}" id="date2" type="text" name="end_date" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($domainSelect)
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Vùng</strong></label>
                        <select class="form-select" name="domain" id="domain">
                            <option value="" >--Chọn Vùng--</option>
                            <option value="MB" {{request()->get('domain') == 'MB' ? 'selected' : ''}}>Miền Bắc</option>
                            <option value="MN" {{request()->get('domain') == 'MN' ? 'selected' : ''}}>Miền Nam</option>
                        </select>
                    </div>
                    @endif

                    @if ($areaSelect)
                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Khu vực</strong></label>
                            <select class="form-select" name="code_area" id="code_area">
                                <option value="" >--Chọn Khu Vực--</option>
                                    @if (isset($user['codeArea']))
                                        @foreach($user['codeArea'] as $code_area)
                                            <option value="{{$code_area['code']}}" {{request()->get('code_area') == $code_area['code'] ? 'selected' : ''}}>{{$code_area['name']}}</option>
                                        @endforeach
                                    @endif
                            </select>
                        </div>
                    @endif

                    @if($pgdSelect)
                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Phòng giao dịch</strong></label>
                            <select class="form-select" name="stores" id="stores">
                                <option value="" >--Chọn phòng giao dịch--</option>
                                @if (!empty($user['pgds']))
                                    @foreach($user['pgds'] as $pgd)
                                        <option value="{{$pgd['_id']}}" {{request()->get('stores') == $pgd['_id'] ? 'selected' : ''}}>{{$pgd['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-6">
                            <button style="background-color:#1D9752; color:#FFFFFF;width:100%" id="submit-data" type="submit" class="btn btn_search">
                                Tìm kiếm
                            </button>
                        </div>
                        <div class="col-6">
                            <button style="background-color:#D8D8D8;float: right;width:100%" id="clear-search-form" type="submit" class="btn btn_search">
                                Hủy
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="button_functions btn-fitler">
        <div class="button_functions">
            <div class="dropdown">
            </div>
        </div>
    </div>
</div>
