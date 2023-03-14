<div class="btn_list_filter text-right mt-0">
    <div class="button_functions btn-fitler">
        <!-- <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter">Export Excel</i>
        </button> -->
        <button id="fillter-button" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i>
        </button>
        <div id="fillter-content" class="dropdown-menu drop_select dropdown-customer" aria-labelledby="dropdownMenuButton">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{$searchUrl}}">
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
                        <label class="form-label"><strong>Họ và tên</strong></label>
                        <input type="text" name="user_name" class="form-control" value="" autocomplete="off" placeholder="Tên nhân sự nghỉ việc">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số điện thoại</strong></label>
                        <input type="text" name="user_phone" class="form-control" value="" autocomplete="off" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số cmnd/cccd</strong></label>
                        <input type="text" name="user_identify" class="form-control" value="" autocomplete="off" placeholder="Số cmnd/cccd">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Số hộ chiếu</strong></label>
                        <input type="text" name="user_passport" class="form-control" value="" autocomplete="off" placeholder="Số hộ chiếu">
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
              <button class="btn btn-secondary btn-success" type="button" aria-expanded="false" id="import_record" style="font-size:unset"><i class="fa fa-upload"></i>
                Import Excel
              </button>
              <button class="btn btn-secondary btn-success" type="button" aria-expanded="false" id="export_record" style="font-size:unset"><i class="fa fa-download"></i>
                Export Excel
              </button>
              <ul class="dropdown-menu dropdown-customer" aria-labelledby="dropdownMenu">
                    <li><a id="create-report" target = "_blank" class="dropdown-item" href='{{$cpanelURL.route("viewcpanel::hcns.createRecord")}}'>Tạo mới</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
