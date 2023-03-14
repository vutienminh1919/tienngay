@extends('viewcpanel::layouts.master')

@section('title', 'Thêm mới yêu cầu ấn phẩm')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>
    body {
        font-family: Roboto;
        background-color: #EDEDED;
        margin: 0px 20px;
    }

    .row-content3 {
        border: 1px solid #F0F0F0;
        border-radius: 10px;
        margin: 0 0 16px 0;
        padding-top: 10px;
    }

    .content {
        display: flex;
        justify-content: space-between;
    }

    .TitleH1 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .report {
        color: #676767;
        font-size: 12px;
        margin-bottom: 34px;
    }

    /* content1 */
    .content1 {
        margin-top: 24px;
    }

    .titleH2 {
        font-size: 16px;
        font-weight: 600;
    }

    .label-text {
        font-size: 14px;
        color: #3B3B3B;
        margin: 8px 0;
    }

    .span-color {
        color: #C70404;
    }

    .content1-input {
        padding: 5px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: 1px solid #D8D8D8;
        padding-top: 8px;
        color: #676767;
    }

    .content1-input1 {
        background-color: #D8D8D8;
        padding: 5px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: none;
        padding-top: 8px;
        color: #676767;
    }

    .text-link {
        color: #4299E1
    }

    .text-color::placeholder {
        color: #1D9752;
        font-weight: bold;
    }

    .outline {
        outline: none;
    }

    /* content3 */
    .content3 {
        margin-top: 24px;
    }

    .content1,
    .content3 {
        background: #FFFFFF;
        padding: 24px 16px;
        border-radius: 10px;
    }

    .content3-title {
        display: flex;
        justify-content: space-between;
    }

    .titleH3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .content3-div {
        color: #676767;
    }

    .content2-div-1 {
        width: 100%;
    }

    .content2-h4 {
        font-size: 14px;
        margin: 8px 0;
        color: #3B3B3B
    }

    .image img {
        width: 100%;
        height: 320px;
    }

    .content2-input {
        background-color: #D8D8D8;
        padding: 5px 16px 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: none;
        padding-top: 8px
    }

    .height {
        min-height: 100px;
    }

    .input-height{
        height:40px;
        border: 1px solid #D8D8D8;
    }

    .input-text {
        width: 100%;
        border: none;
        outline: none;
    }

    .btn-width {
        height: 10%;
        /* max-width: 200px; */
        white-space: nowrap;
        padding: 0 30px;
    }

    .tea::placeholder {
        font-size: 14px;
    }

    .tea {
        width: 100%;
        padding: 5px 16px;
        outline: none;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        color: #676767;
    }

    .content3-btn {
        display: flex;
        justify-content: end;
    }

    .content5 {
        display: flex;
        justify-content: space-between;
    }

    .btnnn {
        padding: 8px 50px;
        font-size: 14px;
        height:40px
    }

    .btn-outline-success{
        border: 1px solid #1D9752;
        color: #1D9752;
        font-weight: 600;
    }

    .btn-success{
        border: 1px solid #1D9752;
        color: #FFFFFF;
        font-weight: 600;
    }

    .btn-danger{
        border: 1px solid #F4CDCD;
        background: #F4CDCD;
        color: #C70404;
        margin-left: 20px;
        font-weight: 600;
    }

    .bgr {
        background-color: #F4CDCD;
        color: #C70404;
        
    }

    .bgr:hover {
        background-color: #F4CDCD;
        color: #C70404;
    }

    .modal-header {
        border-bottom: none;
        margin: 0 auto;
        padding-bottom: 6px;
        font-weight: bold;
    }

    .modal-body {
        padding-top: 0px;
        text-align: center;
    }

    .modal-footer {
        border-top: none;
    }

    .modal-title {
        font-weight: bold;
    }

    .btn-cancel {
        background-color: #D8D8D8;
        outline: none;
        border: none;
        width: 49%;
        padding: 12px 0;
        font-size: 14px;
        border-radius: 5px;
    }

    .btn-submit {
        background-color: #1D9752;
        outline: none;
        border: none;
        width: 49%;
        padding: 12px 0;
        color: #FFFFFF;
        font-size: 14px;
        border-radius: 5px;
    }

    @media screen and (max-width:48em) {
        .btnnn {
            padding: 4px 12px
        }
    }

    .hidden {
        display: none !important;
    }
    .theloading {
        position: fixed;
        z-index: 999;
        display: block;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        top: 0;
        right: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center
    }
    .invalid {
        font-size: 13px;
        color: red;
        font-weight: 500;
    }
    .border-red {
        border-color: red;
    }
    .image {
        position: relative;
    }
    .xt{
        color: black;
        position: absolute;
        top: 50%;
        left: 50%;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .form-select{
        color: #676767;
        font-size: 14px;
        height: 40px;
    }

    .delete{
        font-size: 14px;
        color:#C70404;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
</style>
@endsection

@section('content')
<div id="loading" class="theloading hidden">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div class="content flex-column flex-sm-row">
    <div class="content-title">
        <h1 class="TitleH1">Thêm mới yêu cầu ấn phẩm</h1>
        
    </div>
</div>
<div class="content1">
    <h2 class="titleH2">Thông tin chung </h2>
    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Tên kế hoạch <span class="span-color">*</span> </label>
                <input id="plan-name" class="content1-input outline input-height" type="text"
                    placeholder="Nhập" name="plan_name">
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Chi Tiết kế hoạch Trade MKT <span class="span-color">*</span> </label>
                <div class="content1-input d-flex justify-content-between align-items-center input-height">
                    <input id="uploadPlan" class="icon text-link" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <i class="fa fa-upload icon" aria-hidden="true"></i>
                    <input class="icon text-link" type="hidden" name="plan_file">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Mục tiêu thúc đẩy <span class="span-color">*</span></label>
                <select id="motivating-goals" class="form-select" name="motivating_goal">
                    <option value="">Chọn</option>
                    @foreach($motivatingGoals as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Phòng giao dịch <span class="span-color">*</span></label>
                <select id="stores" class="form-select input-height" name="store_id">
                    <option value="">-- Chọn phòng giao dịch --</option>
                    @foreach($stores as $key => $value)
                        <option value="{{$value['_id']}}">{{$value['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="content3">
    <div class="content3-title">
        <h2 class="titleH3">Danh sách ấn phẩm yêu cầu </h2>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div id="trade-items" class="content3-div">
        <div class="row row-content3 shadow-sm mb-4 bg-white rounded block" data-id="0">
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục <span class="span-color">*</span></h4>
                        <select id="category" class="form-select category input-height" name="category">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach($categories as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu triển khai <span class="span-color">*</span></h4>
                        <select id="implementationGoals" class="form-select implementationGoals input-height" name="implementation_goal">
                            <option value="">-- Chọn mục tiêu triển khai --</option>
                            @foreach($implementationGoals as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Tên ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-item-name" class="form-select trade-item-name input-height" name="item_id">
                            <option value="">Chọn</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Loại ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-type" class="form-select trade-type input-height" name="item_type">
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Quy cách <span class="span-color">*</span></h4>
                        <select id="trade-spec" class="form-select trade-spec input-height" name="item_specifications">
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline input-height" placeholder="Nhập" name="item_quantity">
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline input-height" placeholder="Nhập" name="item_target_customers">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Khu vực triển khai <span class="span-color">*</span></h4>
                        <textarea class="tea" name="item_area" id="" cols="" rows="4" placeholder="Nhập"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="">
                    <h4 class="content2-h4">Ảnh mô tả</h4>
                </div>
                <div class="d-flex image">
                    <img src="" alt="">
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock" ><span class="delete btn btn-danger btnnn" aria-hidden="true">Xóa ấn phẩm</span></button>
            </div>
        </div>
        <div id="appendEl" class="row row-content3 shadow-sm p-3 mb-4 bg-white rounded hidden">
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục <span class="span-color">*</span></h4>
                        <select id="category" class="form-select category input-height" name="category">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach($categories as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu triển khai <span class="span-color">*</span></h4>
                        <select id="implementationGoals" class="form-select implementationGoals input-height" name="implementation_goal">
                            <option value="">-- Chọn mục tiêu triển khai --</option>
                            @foreach($implementationGoals as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Tên ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-item-name" class="form-select trade-item-name input-height" name="item_id">
                            <option value="">Chọn</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Loại ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-type" class="form-select trade-type input-height" name="item_type">
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Quy cách <span class="span-color">*</span></h4>
                        <select id="trade-spec" class="form-select trade-spec input-height" name="item_specifications">
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline input-height" placeholder="Nhập" name="item_quantity">
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline input-height" placeholder="Nhập" name="item_target_customers">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Khu vực triển khai <span class="span-color">*</span></h4>
                        <textarea class="tea" name="item_area" id="" cols="" rows="4" placeholder="Nhập"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="">
                    <h4 class="content2-h4">Ảnh mô tả</h4>
                </div>
                <div class="d-flex image">
                    <img src="" alt="">
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock" style="background: #F4CDCD"><span class="delete" aria-hidden="true">Xóa ấn phẩm</span></button>
            </div>
        </div>
    </div>
    <div class="content3-btn">
        <button id="appendBlock" type="button" class="btn btn-outline-success btnnn">Thêm ấn phẩm</button>
    </div>
</div>
<div class="content5 mt-4 mb-5">
    <div>
        <button id="saveRequest" type="button" class="btn btn-success btnnn mr-4">Lưu</button>
        <button id="cancelRequest" type="button" class="btn btn-danger btnnn">Hủy</button>
    </div>
    <button id="approveRequest" type="button" class="btn btn-success btnnn" data-toggle="modal" data-target="#exampleModal">
        Gửi duyệt</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gửi đề xuất</h5>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn gửi đề xuất danh sách ấn phẩm này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-submit">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="msg_error"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
        </div>
        <div class="modal-body">
          <p class="msg_success"></p>
        </div>
        <div class="modal-footer">
          <!-- <a id="redirect-url" class="btn btn-primary">Xem</a> -->
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
    const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
    console.log(iframeMode)
    const Redirect = (_url, _timeout) => {
        if (parseInt(iframeMode) != 1) {
            if (!_timeout) {
                window.location.href = _url;
                // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                setTimeout(function(){window.location.href = _url}, _timeout);
                // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        } else {
            _url = _url.replace(window.location.origin + '/', "");
            if (!_timeout) {
                // window.location.href = _url;
                window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                // setTimeout(function(){window.location.href = _url}, _timeout);
                setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js" integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/autocomplete.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script type="text/javascript">
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
</script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    $(document).ready(function() {
        // $('#motivating-goals').multiselect({
        //     templates: {
        //         button: '<button style="background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
        //     },
        //     // enableFiltering: true,
        // });
        var items = [];


        // Fetch trade item from api
        const getTradeItems = async (data) => {
            const response = await fetch('{{$getItemsByStoreId}}', {
                method: 'POST',
                body: JSON.stringify(data), // string or object
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    'x-csrf-token': csrf
                }
            });
            const responseJson = await response.json(); //extract JSON from the http response
            if (responseJson['status'] == 200) {
                let tradeItems = responseJson['data'];
                items = tradeItems;
                console.log(items);
            }
        }
        $("#stores").on('change', function(){
            const storeId = $(this).val();
            const formData = {store_id: storeId};
            console.log(formData);
            getTradeItems(formData);
            $(".trade-item-name").html('<option value=""></option>');
            $(".category").val("");
            $(".implementationGoals").val("");
        });

        const OptionItemNameHandle = (e) => {
            let _el = $(e.target).closest(".block");
            let categoryEl = $(_el).find("#category");
            let implementationGoalsEl = $(_el).find("#implementationGoals");
            let _category = $(categoryEl).val();
            let _implementationGoal = $(implementationGoalsEl).val();
            let _motivatingGoals = $("#motivating-goals").val();
            let targetEl = $(_el).find("#trade-item-name");
            let option = '<option value=""></option>';
            let usedItems = [];
            $(".block").each(function(index, value){
                let usedItem = $(value).find('#trade-item-name').find(":selected").val();
                if (!usedItem) {
                    return;
                }
                usedItems.push(usedItem);
            });
            let currentName = $(_el).find('#trade-item-name').find(":selected").val();
            if (currentName && usedItems.length > 0) {
                usedItems.remove(currentName);
            }
            for (let i = 0; i < items.length; i++) {
                let existsCategory = _category == items[i]['category'];
                let existsImplementationGoal = _implementationGoal == items[i]['target_goal'];
                let existsMotivatingGoals = items[i]['motivating_goal'].includes(_motivatingGoals);
                if ( existsCategory && existsImplementationGoal && !usedItems.includes(items[i]['_id']) && existsMotivatingGoals) {
                    let _tradeId = items[i]['_id'];
                    let _tradeType = items[i]['detail']['type'];
                    let _tradeName = items[i]['detail']['name'];
                    let _tradePath = JSON.stringify(items[i]['path']);
                    let _tradeSpec = items[i]['detail']['specification'];
                    option += '<option data-type="'+_tradeType+'" data-spec="'+_tradeSpec+'" data-path='+_tradePath+' value="' + _tradeId + '">' + _tradeName + ' - ' + _tradeType + ' - ' + _tradeSpec + '</option>';
                }

            }
            $(_el).find("#trade-type").html('<option value="">-- Chọn loại ấn phẩm --</option>');
            $(_el).find("#trade-spec").html('<option value="">-- Chọn quy cách --</option>');
            $(targetEl).html(option)
        }
        $("#trade-items").on("change", ".implementationGoals, .category", function(e){
            OptionItemNameHandle(e);
        });
        $("#trade-items").on("focus", ".trade-item-name", function(e){
            OptionItemNameHandle(e);
        });
        $("#motivating-goals").on("change", function(e){
            $(".implementationGoals").trigger('change');
        });

        $("#trade-items").on("change", ".trade-item-name", function(e) {
            let _el = $(e.target).closest(".block");
            let tradeTypeEl = $(_el).find("#trade-type");
            let tradeSpecEl = $(_el).find("#trade-spec");
            let tradePathEl = $(_el).find(".image");

            let _tradeType = $(e.target).find(":selected").attr("data-type");
            let _tradeSpec = $(e.target).find(":selected").attr("data-spec");
            let _tradePath = JSON.parse($(e.target).find(":selected").attr("data-path"));
            let optionType = '<option value="'+_tradeType+'" selected>'+_tradeType+'</option>';
            let optionSpec = '<option value="'+_tradeSpec+'" selected>'+_tradeSpec+'</option>';
            let dataId = $(_el).attr('data-id');
            let optionPath = '<img src="'+_tradePath[0]+'" alt="" data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer">';
            optionPath+= '<div style="display:none">';
            for(let i = 0; i < _tradePath.length; i++) {
                optionPath += '<a data-fancybox="gallery-'+dataId+'" href="'+_tradePath[i]+'"><img class="rounded" src="'+_tradePath[i]+'"/></a>';
            }
            optionPath+= '</div><h5 data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer xt">+'+_tradePath.length+'</h5>';
            $(tradePathEl).html(optionPath);
            if (_tradeType == undefined || _tradeType == '') {
                $(tradeTypeEl).html('<option value="">-- Chọn loại ấn phẩm --</option>');
            } else {
                $(tradeTypeEl).html(optionType);
            }
            if (_tradeSpec == undefined || _tradeSpec == '') {
                $(tradeSpecEl).html('<option value="">-- Chọn quy cách --</option>');
            } else {
                $(tradeSpecEl).html(optionSpec)
            }
        });
        var countBlock = 1;
        $("#appendBlock").on("click", function(){
            let el = $("#appendEl").clone();
            el.removeClass("hidden");
            el.addClass("block");
            el.attr("id", "block");
            el.attr("data-id", countBlock++);
            $("#appendEl").before(el);
        });

        $("#trade-items").on("click", ".removeBlock", function(e){
            let _el = $(e.target).closest(".block");
            $(_el).remove();
        })

    });
</script>
<script type="text/javascript">
    $("#uploadPlan").on('change', function () {
        var file = $(this)[0].files[0];
        let extension = file.name.split('.').pop();
        if (extension !== 'xlsx' && extension !== 'xls') {
            $("#errorModal").find(".msg_error").text("File không đúng định dạng xlsx, xls. Vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        } else {
            let callback = (path) => {
                $('input[name="plan_file"]').val(path);
            }
            uploadPlan(file, callback);
        }
    });
    /**
     * Service upload file
     * */
    const uploadPlan = async function (file, callback) {
        let formData = new FormData();
        formData.append("file", file);
        const response = await fetch('{{$urlUpload}}', {
            method: 'POST',
            body: formData,
            headers: {
                'x-csrf-token': csrf
            }
        });
        const responseJson = await response.json(); //extract JSON from the http response
        console.log(responseJson);
        if (responseJson && responseJson.status == 200) {
            callback(responseJson.path)
        } else {
            $("#errorModal").find(".msg_error").text("Upload file thất bại, vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        }

    }
</script>
<script type="text/javascript">
    const validateCallback = function(response) {
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        if (response.status == 200) {
            // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
            $("#successModal").find(".msg_success").text(response.message);
            $("#successModal").modal('show');
            // setTimeout(function(){window.location.href = response.targetUrl;}, 2000);
            Redirect(response.targetUrl, 2000);
        } else {
            if (response.errors) {
                $.each(response.errors, function(key, value){
                    let splitKey = key.split(".");
                    let el = $("[name='"+splitKey[0]+"']");
                    if (splitKey.length > 2) {
                        let block = $('[data-id="' + splitKey[1] + '"]');
                        el = block.find("[name='"+splitKey[2]+"']");
                    }
                    if (el.attr('name') == 'motivating_goal' || el.attr('name') == 'plan_file') {
                        el.closest('div').addClass('border-red');
                        el.closest('div').after('<span class="invalid">'+value[0]+'</span>');
                    } else {
                        el.addClass('border-red');
                        el.after('<span class="invalid">'+value[0]+'</span>');
                    }
                });
                let itemType = $('.block [name="item_type"]');
                $.each(itemType, function(key, value) {
                    let el = $(itemType[key]);
                    if (el.val() == '' || el.val() == undefined) {
                        el.addClass('border-red');
                        el.after('<span class="invalid">Loại ấn phẩm không được để trống</span>');
                    }
                });
                let itemSpec = $('.block [name="item_specifications"]');
                $.each(itemSpec, function(key, value) {
                    let el = $(itemSpec[key]);
                    if (el.val() == '' || el.val() == undefined) {
                        el.addClass('border-red');
                        el.after('<span class="invalid">Quy cách ấn phẩm không được để trống</span>');
                    }
                });
            }
        }
    }
    const SaveData = async function (data, url, callback) {
        $("#loading").removeClass('hidden');
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'x-csrf-token': csrf,
                "Content-Type": "application/json",
                Accept: "application/json",
            }
        });
        const result = await response.json();
        callback(result);
        $("#loading").addClass('hidden');
    }
    const CollectData = function() {
        let data = {
            store_id : $("#stores").val(),
            plan_name: $("#plan-name").val(),
            motivating_goal: $("#motivating-goals").val() ? [$("#motivating-goals").val()] : [],
            plan_file : $("[name='plan_file']").val(),
            items : []
        }
        let countBlock = 0;
        $(".block").each(function(index, value){
            let block = $(value);
            block.attr('data-id', countBlock);
            let category = block.find("[name='category']").val();
            let implementation_goal = block.find("[name='implementation_goal']").val();
            let item_id = block.find("[name='item_id']").val();
            let item_quantity = block.find("[name='item_quantity']").val();
            let item_area = block.find("[name='item_area']").val();
            let item_target_customers = block.find("[name='item_target_customers']").val();
            let item = {
                data_id: countBlock,
                category : category,
                implementation_goal : implementation_goal,
                item_id : item_id,
                item_quantity : item_quantity,
                item_area : item_area,
                item_target_customers : item_target_customers
            }
            data.items[countBlock] = item;
            countBlock++;
        });
        return data;
    }

    $("#saveRequest").on("click", function(e){
        e.preventDefault();
        $("#saveRequest").attr("disabled", "disabled");
        let data = CollectData();
        SaveData(data, '{{$orderUrl}}', validateCallback);
        $("#saveRequest").removeAttr("disabled");

    });
    $("#approveRequest").on("click", function(e){
        e.preventDefault();
        $("#approveRequest").attr("disabled", "disabled");
        if (confirm("Hệ thống sẽ gửi yêu cầu đến quản lý trực tiếp để phê duyệt, bạn có muốn tiếp tục gửi duyệt ?")) {
            let data = CollectData();
            SaveData(data, '{{$sentFirstApproveUrl}}', validateCallback);
        }
        $("#approveRequest").removeAttr("disabled");
    });
    $("#cancelRequest").on('click', function(e) {
        e.preventDefault();
        Redirect("{{$indexUrl}}", false);
    })
</script>
@endsection
