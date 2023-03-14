<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button> -->
        <button id="fillter-button" class="btn btn-outline-success" type="button" aria-expanded="false" style="!important; background-color:#D2EADC; color:#1D9752;">Tìm kiếm <img src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png" alt=""></button>
        <div style="margin-right: -170px; margin-top: 10px; width:auto;" id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{route('viewcpanel::macom.cost.history')}}">
                    @csrf
                    <div class="row">
                        <dir class="col-12">
                            <div class="text-large" style="font-family:Roboto; line-height: 20px; color: #3B3B3B;font-weight: 600;justify-content: center; text-align:center">Tìm kiếm</div>
                        </dir>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Tên chiến dịch</strong></label>
                        <input type="text" name="campaign_name" class="form-control" value="" autocomplete="off" placeholder="Nhập tên chiến dịch">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Thời gian</strong></label>
                        <div class="row">
                            <div class="col-6" style="">
                                <div class="date-container">
                                    <input style="color:black; border-radius: 5px;" id="date" type="text" name="start_date" placeholder="Từ ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6" style="">
                                <div class="date-container2">
                                    <input style="color:black; border-radius: 5px;" id="date2" type="text" name="end_date" placeholder="Đến ngày"/>
                                    <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khu Vực</strong></label>
                        <select class="form-select" name="code_area" id="code_area">
                            <option value="" >--Chọn Khu Vực-</option>
                            @foreach($code_area as $i)
                                <option value="{{$i['code']}}">{{$i['title']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng giao dịch</strong></label>
                        <select class="form-select store" name="store_id" id="store_id" >
                            <option value="" >--Chọn PGD--</option>
                            @foreach($stores as $i)
                                <option value="{{$i['_id']}}">{{$i['name']}}</option>
                            @endforeach
                        </select>
                    </div>
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
