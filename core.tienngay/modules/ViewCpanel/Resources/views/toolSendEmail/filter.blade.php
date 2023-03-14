<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="GET" action='{{url("/cpanel/toolSendEmail/indexTempale")}}'>
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
                        <label class="form-label"><strong>Tiêu đề email</strong></label>
                        <input type="text" name="subject" class="form-control" value="" autocomplete="off" placeholder="Tiêu đề email">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Phòng ban</strong></label>
                        <select class="form-control" name="store" placeholder="Phòng ban">
                            <option value="">Tất cả</option>
                                 @if(isset($stores))
                                  @foreach($stores as $key => $store)
                                      <option value="{{$store['id']}}">{{$store['name']}}</option>
                                  @endforeach
                                @endif  
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Khoảng thời gian tạo</strong>
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
                    <li><a id="send_email" target='_blank' class="dropdown-item" href='{{$cpanelURL.route("viewcpanel::toolSendEmail.sendEmail")}}'>Gửi email</a></li>
                    <li><a id="create_template" target='_blank' class="dropdown-item" href='{{$cpanelURL.route("viewcpanel::toolSendEmail.createTemplate")}}'>Tạo mới template</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
