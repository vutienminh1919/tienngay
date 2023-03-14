@extends('viewcpanel::layouts.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet" />
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: rgb(237, 237, 237);
    }

    .form-body {
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 24px 16px;
        margin-top: 34px;
    }

    .header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .form-container {
        width: 100%;
        padding: 24px 16px;
        gap: 24px;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
    }

    .header a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
    }

    .box1 {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 16px;
    }

    .box2 {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 16px;
    }

    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }

    .form-ip label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;

    }

    .form-ip select {
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-ip input {
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    input::placeholder {
        font-size: 14px;
    }

    .img-right img {
        width: 300px;
        height: 190px;
    }

    .img-right {
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }

    .form-img {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-img label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .box-btn {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        padding-top: 16px;
    }

    .form-footer {
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        width: 100%;
        margin: 24px 0px;
        padding: 15px;
    }

    .form-footer h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .form-footer textarea {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        padding: 16px;
    }

    .box-btn-footer {
        display: flex;
        justify-content: space-between;
        margin: 24px 16px;
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

    .imgs {
        position: relative;
    }

    .imgs img {
        max-width: 100%;
    }

    .remove_block {
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }

    label {
        font-size: 14px;
        color: #3B3B3B;
        font-weight: 400;
    }

    .form-select {
        height: 40px;
        font-size: 14px;
        font-weight: 400;
        color: #676767;
    }

    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
        height: 40px;
    }

    #call-to-action {
        /* width: 120px; */
        /*border: solid 1px #1D9752;*/
        font-size: 14px;
        color: #4299E1;
        border-radius: 5px;
        font-weight: 400;
        padding: 5px 0;
    }

    .upload-hidden {
        display: none;
    }

    .cancelButton {
        -moz-appearance: none;
        -webkit-appearance: none;
        position: absolute;
        top: -3px;
        right: 3px;
        color: #000;
        text-align: center;
        font-weight: 700;
        background-color: transparent;
        padding: 0;
        margin: 0;
        border: 0;
        font-size: 16px;
        right: -8px;
        top: -8px;
        line-height: 15px;
        border-radius: 100%;
        background-color: #fff
    }

    .block {
        position: relative;
        display: inline-block;
        vertical-align: top;
        width: 70px;
        height: 0px;
        padding: 9px;
        margin-right: 15px;
        margin-bottom: 35px;
        border: 1px solid #ccc;
        margin-top: 15px;
        margin-right: 10px;
        border: none;
    }

    .box-btn-footer a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 190px;
        height: 40px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
    }

    .cancelButton {
        -moz-appearance: none;
        -webkit-appearance: none;
        top: -3px;
        right: 3px;
        color: #000;
        text-align: center;
        font-weight: 700;
        background-color: transparent;
        padding: 0;
        margin: 0;
        border: 0;
        font-size: 16px;
        right: -8px;
        top: -8px;
        line-height: 15px;
        border-radius: 100%;
        background-color: #fff;
        position: inherit;
    }

    .block img,
    video {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
    }

    .countImg {
        color: white;
        font-weight: bold;
        position: absolute;
        top: 55%;
        left: 23%;
        transform: translate(-50%, -50%);
        z-index: 2;
        padding: 20px;
        text-align: center;
    }

    .is-animated {
        width: 100%;
        height: 1000px;
    }

    .swal2-popup {
        bottom: 55%;
    }
</style>
@endsection
@section('content')
<section id="xk_create">
    <div class="wrapper">
        <meta hidden name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>
        <div class="header" style="padding-bottom: 20px">
            <h3>Xuất kho ấn phẩm</h3>
            <small>
                <a style="text-decoration:none;" href="{{$homeDelivery}}" class="homeDelivery"><i class="fa fa-home"></i> Home</a> / <a class="createDelivery" style="text-decoration:none;" href='{{route("viewcpanel::warehouse.pgdCreate")}}'>Thêm
                    mới</a>
            </small>
        </div>
        <div class="container-fluid">
            <div class="form-container">
                <div class="box1-title">
                    <h5 style="font-size: 16px; font-weight: 600;">Thông tin chung</h5>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="box1-form-ip">
                            <label>Phòng giao dịch <span style="color:#C70404;">*</span></label>
                            <select name="stores" id="stores" class="form-select stores">
                                <option value="">--Chọn phòng giao dịch--</option>
                                @foreach ($pgds as $pgd)
                                <option value="{{$pgd['_id']}}">{{$pgd['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="box1-form-ip">
                            <label>Chứng từ <span style="color:#C70404;">*</span></label>
                            <div class="img-area">
                                <div id="imgInput"></div>
                                <a type="button" style="color:#B8B8B8; width:100%; text-align: left;" class="upload btn btn-default btn-lg" id="call-to-action"> Tải ảnh lên</a>
                                <i style="position: absolute;right: 10px;top: 26%;" class="fa fa-upload upload" aria-hidden="true"></i>
                                <div id="drop">
                                    <input type="file" name="imgs" multiple mlutiple class="upload-hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="publications" class="form-body" style="display: flex; flex-direction: column;gap: 24px">
                <h3 style="font-size: 16px; font-weight: 600;">Danh sách ấn phẩm</h3>
                <div class="box1 items" data-id="0">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-ip">
                                        <label style="color:#3B3B3B;">Hạng mục <span style="color:#C70404;">*</span></label>
                                        <select class="form-select category" name="category" style='color:gray' id="category" oninput='style.color="black"'>
                                            <option value="">--Chọn hạng mục--</option>
                                            @foreach ($category as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('category'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('category') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-ip">
                                        <label style="color:#3B3B3B;">Mục tiêu triển khai <span style="color:#C70404;">*</span> </label>
                                        <select class="form-select taget_goal" name="taget_goal" style='color:gray' id="taget_goal" oninput='style.color="black"'>
                                            <option value="">--Chọn mục tiêu triển khai--</option>
                                            @foreach ($tagets as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('taget_goal'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('taget_goal') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-ip">
                                        <label style="color:#3B3B3B;">Tên ấn phẩm <span style="color:#C70404;">*</span>
                                        </label>
                                        <select class="form-select name" name="name" style='color:gray' id="name" oninput='style.color="black"'>
                                            <option value="">--Chọn tên ấn phẩm--</option>
                                        </select>
                                        @if($errors->has('name'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-ip">
                                        <label style="color:#3B3B3B;" class="quantity_stock" id="quantity_stock">Số
                                            lượng <span style="color:#C70404;">*</span> </label>
                                        <input class="form-control amount" placeholder="Nhập số lượng" name="amount" id="amount" style='color:gray;' type="number" min="1" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
                                        @if($errors->has('amount'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('amount') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-ip" hidden>
                                        <label style="color:#3B3B3B;">Loại ấn phẩm <span style="color:#C70404;">*</span>
                                        </label>
                                        <select class="form-select type" name="type" style='color:gray' id="type" oninput='style.color="black"'>
                                            <option value="">--Chọn loại ấn phẩm--</option>
                                        </select>
                                        @if($errors->has('type'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('type') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-ip" hidden>
                                        <label style="color:#3B3B3B;">Quy cách <span style="color:#C70404;">*</span>
                                        </label>
                                        <select class="form-select specification" name="specification" id="specification" style='color:gray' oninput='style.color="black"'>
                                            <option value="">--Chọn quy cách ấn phẩm--</option>
                                        </select>
                                        @if($errors->has('specification'))
                                        <p style="text-align: center" class="text-danger">{{ $errors->first('specification') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="img-box">
                                <label style="font-weight:400; font-size:14px;">Ảnh mô tả</label>
                                <div class="img-right imgs" id="imgs">
                                    <img style="margin-top:12px; filter: brightness(50%);-webkit-filter: brightness(50%);" src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg" alt="" onerror="this.style.display='none'">
                                    <button name="remove_block" type="button" onclick="myFunction(this)" id="remove_block" class="btn btn" hidden style="background-color:#F4CDCD; color:#C70404">Xóa ấn phẩm
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input name="item_id" id="item_id" class="form-control item_id" type="text" hidden value="">
                        <input name="name_item" id="name_item" class="form-control name_item" type="text" hidden value="">
                    </div>
                </div>
                <div class="box-btn">
                    <button type="button" onclick="addBlock(this)" id="add_block" class="btn btn-outline-success" style="margin-right: 16px; font-size: 14px; font-weight: 400;">Thêm ấn phẩm
                    </button>
                </div>
            </div>
        </div>`
        <div class="container-fluid">
            <div class="form-footer">
                <h5>Ghi chú</h5>
                <textarea style="font-size: 14px; font-weight: 400;" name="note" id="note" class="form-control" placeholder="Ghi chú tuyến đường"></textarea>
                @if($errors->has('note'))
                <p style="text-align: center" class="text-danger">{{ $errors->first('note') }}</p>
                @endif
            </div>

        </div>

        <div class="box-btn-footer">
            <a href="{{route('viewcpanel::warehouse.pgdIndex')}}" type="button" class="btn btn redirect" style="background-color:#F4CDCD;color: #C70404; font-size: 14px; font-weight: 600;">Hủy</a>
            <button style="font-size: 14px; font-weight: 600; background-color: #1D9752 !important; color: #FFFFFF;" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Tạo
                phiếu xuất kho
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo phiếu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn tạo phiếu xuất danh sách ấn phẩm này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button id="confirm" type="button" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

<script type="text/javascript">
    Array.prototype.remove = function() {
        var what, a = arguments,
            L = a.length,
            ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };
    $(document).ajaxStart(function() {
        $("#loading").show();
        var loadingHeight = window.screen.height;
        $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<script type="text/javascript">
    var countBlock = 1;

    function addBlock(e) {
        let el = $('.box1:first').clone().insertAfter('.box1:last');
        $(el).find("#category").val("");
        $(el).find("#taget_goal").val("");
        $(el).find("#name").val("");
        $(el).find("#type").val("");
        $(el).find("#specification").val("");
        $(el).find("#amount").val("");
        $(el).attr("data-id", countBlock++);
        $(el).find(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
        $(el).find(".imgs > img").attr('data-fancybox-trigger', 'gallery-' + countBlock);
        $(el).find(".imgs > .xt").remove();
        $(el).find(".imgs > button").attr('hidden', false);
        $(el).find('.images').html('');
        $('#remove_block').attr('hidden', false);
        $(el).find('.invalid').remove();
        $(el).find('#border-red').remove();
        $(el).find('#category, #taget_goal, #name, #type, #specification, #amount').css('border', '1px solid #D8D8D8');
        $(el).find('.quantity').remove();
        $(el).find('#item_id').val("");
        $(el).find('#name_item').val("");
    }

    function myFunction(el) {
        $(el).parent().closest('.box1').remove();
        if ($(".box1").length <= 1) {
            $('#remove_block').attr('hidden', true);
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {

        const csrf = "{{ csrf_token() }}";
        var items = [];


        // Fetch trade item from api
        const getTradeItems = async (data) => {
            const response = await fetch('{{route("viewcpanel::warehouse.getItemByStoreId")}}', {
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
        $("#stores").on('change', function() {
            const storeId = $(this).val();
            const formData = {
                id: storeId
            };
            console.log(formData);
            getTradeItems(formData);
            $(".name").html('<option value="">-- Chọn tên ấn phẩm --</option>');
            $(".category").val("");
            $(".taget_goal").val("");
            $(".type").val("");
            $(".specification").val("");
            $(".amount").val("");
            $(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
            $(".imgs > .xt").remove();
            $('.images').html('');
            $('.block').remove('');
            $('.quantity').html('');
            $('.item_id').val("");
            $('.name_item').val("");
        });

        const showNameOptions = (e) => {
            let _el = $(e.target).closest(".items");
            let category = $(_el).find("#category");
            let target_goal = $(_el).find("#taget_goal");
            let _category = $(category).val();
            let _target_goal = $(target_goal).val();
            let option = '<option value="">-- Chọn tên ấn phẩm --</option>';
            let targetEl = $(_el).find("#name");
            let inputID = $(_el).find("#item_id");
            let itemId = $(_el).find("#name_item");
            let usedItems = [];
            $(".items").each(function(index, value) {
                let usedItem = $(value).find('[name="name"]').val();
                if (!usedItem) {
                    return;
                }
                usedItems.push(usedItem);
            });
            let currentName = $(_el).find('[name="name"]').val();
            if (currentName) {
                usedItems.remove(currentName);
            }
            console.log(items['items']);
            $.each(items['items'], function(key, value) {
                console.log(value)
                // console.log(value['code_item'], usedItems.includes(value['code_item']))
                if (
                    value['category'] == _category &&
                    value['taget_goal'] == _target_goal &&
                    !usedItems.includes(value['code_item'])
                ) {
                    let Id = items['_id'];
                    let code_item = value['code_item'];
                    let Type = value['type'];
                    let Name = value['name'];
                    let Spec = value['specification'].split(',').join(', ');
                    // Spec = Spec.replaceAll(',' , '-')
                    let Path = JSON.stringify(value['path']);
                    let quantity = value['quantity_stock'];
                    option += '<option data-type="' + Type + '" data-spec="' + Spec + '" data-path=' + Path + ' data-amount="' + quantity + '" value="' + value['code_item'] + '">' + Name + " - " + Type + " - " + Spec + '</option>';
                    $(inputID).val(Id);
                    $(itemId).val(Name);
                }
            });
            $(_el).find("#type").html('<option value="">-- Chọn loại ấn phẩm --</option>');
            $(_el).find("#specification").html('<option value="">-- Chọn quy cách --</option>');
            $(targetEl).html(option);
        }

        $("#publications").on("change", ".category, .taget_goal", function(e) {
            let _el = $(e.target).closest(".items");
            $(_el).find(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
            $(_el).find(".imgs > .xt").remove();
            $(_el).find('.images').html('');
            $(_el).find('.quantity ').html('');
            $(_el).find(".type").val("");
            $(_el).find(".specification").val("");
            $(_el).find(".amount").val("");
            showNameOptions(e);
        });

        $("#publications").on("focus", ".name", function(e) {
            showNameOptions(e);
        });

        $("#publications").on('change', ".name", function(e) {
            let _el = $(e.target).closest(".items");
            let tradeTypeEl = $(_el).find("#type");
            let tradeSpecEl = $(_el).find("#specification");
            let tradePathEl = $(_el).find(".imgs");
            var hidden = "";
            let _tradeType = $(e.target).find(":selected").attr("data-type");
            let _tradeSpec = $(e.target).find(":selected").attr("data-spec");
            let _tradePath = JSON.parse($(e.target).find(":selected").attr("data-path"));
            let _tradeAmount = $(e.target).find(":selected").attr("data-amount");
            console.log(_tradePath);
            let optionType = '<option value="' + _tradeType + '" selected>' + _tradeType + '</option>';
            let optionSpec = '<option value="' + _tradeSpec + '" selected>' + _tradeSpec + '</option>';
            let dataId = $(_el).attr('data-id');
            console.log(dataId);
            let optionPath = '<img style="filter: brightness(50%);-webkit-filter: brightness(50%);" src="' + _tradePath[0] + '" alt="" data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer">';
            optionPath += '<div class="images" style="display:none">';
            for (let i = 0; i < _tradePath.length; i++) {
                optionPath += '<a data-fancybox="gallery-' + dataId + '" href="' + _tradePath[i] + '"><img class="rounded" src="' + _tradePath[i] + '"/></a>';
            }
            optionPath += '</div><h5 data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer xt countImg">+' + _tradePath.length + '</h5>';
            $(tradePathEl).html(optionPath);
            if ($(".box1").length <= 1) {
                hidden = "hidden"
            }
            $(tradePathEl).append(` <button name="remove_block" type="button" onclick="myFunction(this)" id="remove_block" class="btn btn" ` + hidden + ` style="background-color:#F4CDCD; color:#C70404">Xóa ấn phẩm</button>`)
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
            let span_quantity = '<span class="quantity text-danger">' + _tradeAmount + '</span>'
            let label_quantity = $(_el).find("#quantity_stock");
            $(_el).find('.quantity').remove();
            label_quantity.append(span_quantity);
        });
    });
</script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    const SaveData = async function(data, url) {
        console.log(data);
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
        if (result['status'] == 200) {
            $('#exampleModal').modal('hide');
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Tạo phiếu xuất kho thành công',
                showConfirmButton: false,
                timer: 2000,
            });
            setTimeout(function() {
                window.location.assign(result['data']['redirectURL']);
            }, 2000);
            return;
        }
        // callback(result);
        $("#loading").addClass('hidden');
    }
    const CollectData = function() {
        let image = [];
        $("input[name='url[]']").each(function(key, value) {
            let url = $(this).val();
            image.push(url);
        });
        let data = {
            stores: $("#stores").val(),
            note: $("#note").val(),
            url: image,
            items: []
        }
        let countBlock = 0;
        $(".items").each(function(index, value) {
            let block = $(value);
            block.attr('data-id', countBlock);
            let category = block.find("[name='category']").val();
            let taget_goal = block.find("[name='taget_goal']").val();
            let name = $(value).find("#name").val();
            let type = $(value).find("#type").val();
            let specification = $(value).find("#specification").val();
            let amount = $(value).find("#amount").val();
            let itemId = $(value).find("#item_id").val();
            let name_item = $(value).find("#name_item").val();
            let path = [];
            image = $(value).find('.images > a > img');
            $.each(image, function(k, v) {
                console.log(v);
                let url = $(v).attr('src');
                console.log(url);
                path.push(url);
            })
            let item = {
                data_id: countBlock,
                category: category,
                taget_goal: taget_goal,
                name: name,
                type: type,
                specification: specification,
                amount: amount,
                storage_id: itemId,
                name_item: name_item,
                path: path
            }
            data.items[countBlock] = item;
            countBlock++;
        });
        return data;
    }

    $("#confirm").on("click", function(e) {
        e.preventDefault();
        $('#exampleModal').modal('hide');
        let data = CollectData();
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        let stores = $('select[name="stores"]');
        let inputLicense = $('.img-area');
        let value_inputLicense = $('.img-area > .block > input[name="url[]"]');
        var sendData = false;
        if (stores.val() == '' || stores.val() == undefined) {
            stores.addClass('border-red');
            stores.after('<span class="invalid">Phòng giao dịch không được để trống</span>');
            sendData = true;
        }
        if (value_inputLicense.val() == '' || value_inputLicense.val() == undefined) {
            inputLicense.css('border', '1px solid red');
            inputLicense.after('<span class="invalid">Chứng từ không được để trống</span>');
            sendData = true;
        }
        $(".items").each(function(key, value) {
            let itemSpec = $(value).find('select[name="specification"]');
            let itemName = $(value).find('select[name="name"]');
            let itemAmount = $(value).find('input[name="amount"]');
            let itemTaget = $(value).find('select[name="taget_goal"]');
            let itemType = $(value).find('select[name="type"]');
            let itemCate = $(value).find('select[name="category"]');
            let quantity = $(value).find('.quantity').text();
            if (itemSpec.val() == '' || itemSpec.val() == undefined) {
                itemSpec.css('border', '1px solid red');
                itemSpec.after('<span class="invalid">Quy cách ấn phẩm không được để trống</span>');
                sendData = true;

            }
            if (itemName.val() == '' || itemName.val() == undefined) {
                itemName.css('border', '1px solid red');
                itemName.after('<span class="invalid">Tên ấn phẩm không được để trống</span>');
                sendData = true;

            }
            if (itemAmount.val() == '' || itemAmount.val() == undefined) {
                itemAmount.css('border', '1px solid red');
                itemAmount.after('<span class="invalid">Số lượng không được để trống</span>');
                sendData = true;

            }
            if (itemAmount.val() > parseInt(quantity)) {
                itemAmount.css('border', '1px solid red');
                itemAmount.after('<span class="invalid">Số lượng xuất kho không được lớn hơn số lượng tồn vật phẩm</span>');
                sendData = true;

            }
            if (itemType.val() == '' || itemType.val() == undefined) {
                itemType.css('border', '1px solid red');
                itemType.after('<span class="invalid">Loại ấn phẩm không được để trống</span>');
                sendData = true;

            }
            if (itemTaget.val() == '' || itemTaget.val() == undefined) {
                itemTaget.css('border', '1px solid red');
                itemTaget.after('<span class="invalid">Mục tiêu triển khai không được để trống</span>');
                sendData = true;

            }
            if (itemCate.val() == '' || itemCate.val() == undefined) {
                itemCate.css('border', '1px solid red');
                itemCate.after('<span class="invalid">Hạng mục ấn phẩm không được để trống</span>');
                sendData = true;

            }
        })

        if (sendData == false) {
            SaveData(data, '{{route("viewcpanel::warehouse.pgdSave")}}');
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.upload-hidden').on('change', function() {
            var files = $(this)[0].files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                uploadImgs(file);
            }
        });

        const uploadImgs = async function(file) {
            var formData = new FormData();
            formData.append('file', file);
            console.log(file.type);
            var mine = ['image/jpeg', 'image/png', 'image/jpg'];
            if (mine.includes(file.type)) {
                //
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra...',
                    text: 'File upload sai định dạng! ',
                })
                return;
            }
            await $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::warehouse.uploadLisence")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    console.log(data);
                    if (data && data.code == 200) {
                        $('.fa-upload').attr('hidden', true);
                        if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                            let block = `
                            <div class="block" style="width:auto; border:none; ">
                            <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                            <input data-fileType ="` + file.type + `" data-fileName = "` + data.raw_name + `" type="hidden" name="url[]" value="` + data.path + `">
                            <button style="top: -3px;" type="button" onclick="deleteImage(this)" class="cancelButton">
                                <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times-circle"></i>
                            </button>
                            </div>
                            `;
                            $('#imgInput').before(block);
                        }

                    } else if (typeof(data) == "string") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            confirmButtonColor: '#dc3545',
                            timer: 3000,
                            position: 'top',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: data.msg,
                            confirmButtonColor: '#dc3545',
                            timer: 3000,
                            position: 'top',
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thông báo',
                        text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                        confirmButtonColor: '#dc3545',
                        timer: 3000,
                        position: 'top',
                    })
                }
            });
        }
    })
    </script>
    <script type="text/javascript">
        $('a.redirect').on('click', (e) => {
            e.preventDefault();
            let url = $(e.target).attr('href');
            Redirect(url, false);
        })
    </script>

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
    
    <script>
        $('#amount').keyup(function (event) {
            var value = $(this).val();
            value = value.replace(/^(0*)/, "");
            $(this).val(value);
            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });

        const closeModal = function(el) {
            console.log("close");
            $(el).closest('.modal').hide();
        }


    function deleteImage(el) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")) {
            $(el).closest(".block").remove();
            $('#imgInput').find('[type="file"]').first().val('');
        }
    }
</script>

<script type="text/javascript">
    const Redirect = (_url, _timeout) => {
        _url = _url.replace(window.location.origin + '/', "");
        if (!_timeout) {
            // window.location.href = _url;
            window.parent.postMessage({
                targetLink: _url
            }, "{{$cpanelPath}}");
        } else {
            // setTimeout(function(){window.location.href = _url}, _timeout); 
            setTimeout(function() {
                window.parent.postMessage({
                    targetLink: _url
                }, "{{$cpanelPath}}");
            }, _timeout);
        }

    }
    $('a.redirect').on('click', (e) => {
        e.preventDefault();
        let url = $(e.target).attr('href');
        Redirect(url, false);
    })
</script>

<script>
    $('#amount').keyup(function(event) {
        var value = $(this).val();
        value = value.replace(/^(0*)/, "");
        $(this).val(value);
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;
        // format number
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    $('#call-to-action, .upload').click(function() {
        $('.upload-hidden').click();
    });
</script>
@endsection