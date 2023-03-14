<div class="btn_list_filter text-right mt-0" style="position: absolute; bottom: 0; right: 0;">
    @csrf
    <div class="button_functions btn-fitler" style="width: 100px;">
        <input type="text" class="form-control" name="select-time" id="select-time" value="{{$currentTime}}" placeholder="Tháng"/>
    </div>
    <div class="button_functions">
        <div class="dropdown">
            <button class="btn btn-secondary btn-success dropdown-toggle btn-func" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Chức năng &nbsp<i class="fa fa-caret-down "></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a id="export-excel" class="dropdown-item" href="javascriptvoid:0">Xuất danh sách giao dịch</a>
                <a id="print-data" class="dropdown-item" href="javascriptvoid:0">In danh sách giao dịch</a>
            </div>
        </div>
    </div>
</div>