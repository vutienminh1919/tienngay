@extends('viewcpanel::layouts.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet"/>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
        background-color: #E5E5E5;
    }

    .header {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
        padding: 10px 40px 0px;
    }

    .header h2 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
        margin: 0px;
    }

    .table-of-contents {
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .table-of-contents > a {
        color: #676767;
        text-decoration: none;
    }

    .style-container {
        background: #fff;
        padding: 24px 16px;
        border-radius: 8px;
        margin: 24px 40px;
    }

    .style-container h3 {
        color: #3B3B3B;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;

    }

    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 8px;
    }

    .form-ip input {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-ip select {
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
        padding: 5px 16px;
    }

    .form-ip input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #B8B8B8;
    }

    .form-ip p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
        margin: 0px;
    }

    .style-star {
        color: #C70404;
        font-size: 20px !important;
    }

    .list-tranfer {
        width: 100%;
        padding: 16px;
        gap: 16px;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
    }

    .botton-input input {
        padding: 16px;
        width: 100%;
        height: 82px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        margin-top: 8px;
    }

    .botton-input p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
        margin: 0px;
        padding-top: 8px
    }

    .botton-input input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #B8B8B8;
    }

    .block-img {
        display: flex;
        gap: 16px;
        padding-right: 8px;
        justify-content: space-between;
    }

    .img-box {
        width: 285px;
        height: 205px;
    }

    .img-box img {
        width: 100%;
        height: 100%;
    }

    .btn-del {
        display: flex;
        align-items: flex-end;
    }

    .img-box p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
        margin-bottom: 4px;
    }

    .btn-create {
        display: flex;
        justify-content: flex-end;
        padding-top: 24px;
    }

    .btn-success {
        color: #1D9752;
        background-color: #fff;
        display: flex;
        flex-wrap: wrap;
        align-content: space-around;
        justify-content: space-around;
        width: 190px;
        height: 40px;
        border: 1px solid #1D9752;
        border-radius: 8px;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
    }

    .footer {
        display: flex;
        padding: 24px 40px 80px;
        justify-content: space-between;
    }

    .footer button{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 190px;
        height: 40px;
        border-radius: 8px;
        border: none;
    }

    .footer a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 190px;
        height: 40px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
    }
    .btn-left {
        display: flex;
    }

    .btn-green {
        background: #1D9752;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
    }

    .btn-cancel {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        margin-left: 24px;
        color: #C70404;
        padding: 8px 16px;
        background: #F4CDCD;
    }

    .btn-del {
        display: flex;

        gap: 16px;
        width: 179px;
        height: 100%;
        border-radius: 8px;
        flex-direction: column-reverse;
    }

    .style-btn-cancel {
        width: 179px;
        height: 40px;
        background: #F4CDCD;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #C70404;
        border: none;
        border-radius: 8px;
    }

    .btn-modal {
        display: flex;
        justify-content: space-between;
    }

    .btn-accept {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 192.5px;
        height: 40px;
        background: #1D9752;
        color: #fff;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        border: none;
        border-radius: 8px;
    }

    .btn-delete {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 192.5px;
        height: 40px;
        background: #D8D8D8;
        color: #676767;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        border: none;
        border-radius: 8px;
    }
    .invalid {
        font-size: 13px;
        color: red;
        font-weight: 500;
    }
    .countImg {
        color: white;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 46%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }
    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
        height: 205px;
    }
    .is-animated {
        width:100%;
        height:1000px;
    }
</style>
@endsection
@section('content')
    <div class="wrapper">
        <div class="header">
            <h2>Chỉnh sửa điều chuyển ấn phẩm
                <br>
                <small class="table-of-contents">
                    <a class="redirect" style="text-decoration: none;" href="{{route('viewcpanel::warehouse.pgdIndex')}}"><i class="fa fa-home"></i>Home</a> / 
                    <a class="redirect" style="text-decoration: none;" href='{{route("viewcpanel::transfer.edit" ,["id" => $detail["_id"]])}}'>Cập nhật phiếu điều chuyển</a>
                </small>
            </h2>
        </div>

        <div class="style-container">
            <h3>Thông tin chung</h3>
            <div class="style-col-ip">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch xuất</p>
                            <select class="stores_export form-control" style="background: #E6E6E6;" name="stores_export" id="stores_export" class="" readonly>
                                <option value="{{$detail['stores_export']['id']}}">{{$detail['stores_export']['name']}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch nhận <span class="style-star">*</span></p>
                            <select class="stores_import" name="stores_import" id="stores_import" class="form-select">
                                <option value="">Chọn</option>
                                @foreach($stores as $store)
                                    <option value="{{$store['_id']}}" @if($store['_id'] == $detail['stores_import']['id']) ? selected @endif>{{$store['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Tổng số sản phẩm</p>
                            <input type="text" class="total_items" id="total_items" name="total_items" style="background: #E6E6E6;" readonly value="{{$detail['total_items']}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">   
                            <p>Tổng số lượng ấn phẩm</p>
                            <input type="text" class="total_amount" id="total_amount" name="total_amount" style="background: #E6E6E6;" readonly value="{{$detail['total_amount']}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="style-container" id="publications">
            <h3>Danh sách ấn phẩm</h3>
            @foreach($detail['list'] as $item)
            <div class="list-tranfer box1 items" style="margin-top: 20px;" data-id="0">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Mã ấn phẩm <span class="style-star">*</span></p>
                                    <select name="code_item" id="code_item" class="code_item form-select">
                                        <option value="">Chọn</option>
                                        @foreach($storages['items'] as $key => $storage)
                                            <option data-value="{{$storage['code_item']}}" value="{{$storage['code_item']}}" @if($item['code_item'] == $storage['code_item']) selected @endif>{{$storage['code_item']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Số lượng <span class="style-star">*</span>
                                        @foreach($storages['items'] as $sto)
                                            @if ($sto['code_item'] == $item['code_item'])
                                                <span class="text-danger quantity" id="quantity">{{$sto['quantity_stock']}}</span>
                                            @else
                                                @continue;
                                            @endif
                                        @endforeach
                                    </p>
                                    <input  class="amount" id="amount" name="amount" type="number" placeholder="Nhập" value="{{$item['amount']}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Tên ấn phẩm<span class="style-star">*</span></p>
                                    <input  class="name" id="name" name="name" type="text" style="background: #E6E6E6;" value="{{$item['name']}}" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Loại ấn phẩm<span class="style-star">*</span></p>
                                    <input  class="type" id="type" name="type" type="text" style="background: #E6E6E6;" value="{{$item['type']}}" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Quy cách<span class="style-star">*</span></p>
                                    <input class="specification" id="specification" name="specification" type="text" style="background: #E6E6E6;" value="{{$item['specification']}}" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 block-img">
                        <div class="img-box imgs">
                            <p>Ảnh mô tả</p>
                            @if (count($item['path']) > 0)
                            <div class="img-area">
                                <img src="{{$item['path'][0]}}" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-{{$item['data_id']}}">
                                <div style="display:none" class="images">
                                    @foreach($item['path'] as $i)
                                        <a data-fancybox="gallery-{{$item['data_id']}}" href="{{$i}}"><img class="rounded" src="{{$i}}"></a>
                                    @endforeach
                                </div>
                                <h5 data-fancybox-trigger="gallery-{{$item['data_id']}}" class="underline cursor-pointer xt countImg">+{{count($item['path'])}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="btn-del">
                            <button name="remove_block" type="button" onclick="myFunction(this)" id="remove_block" class="btn btn remove_block" hidden style="background-color:#F4CDCD; color:#C70404">Xóa ấn phẩm</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="btn-create">
                <button onclick="addBlock(this)" id="add_block" class="btn btn-success" >Thêm ấn phẩm</button>
            </div>
        </div>

        <div class="footer">
            <div class="btn-left">
                <button id="confirm" class="btn-green">Lưu</button>
                <a href="{{$cancelTransfer}}" class="btn-cancel cancelTransfer">Huỷ</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
    var total_box1 = $('.box1');
    if (total_box1.length > 1) {
        $('.remove_block').attr('hidden', false);
    }
    var total_items = parseInt($("#total_items").val());
    // $('#total_items').val(total_items);
    var countBlock = 1;
//
    var storage = JSON.parse('{!! json_encode($storages) !!}');
    // console.log(storage);
    var usedItems = [];
    // let used = $('.items').find('[name="code_item"]').val();
    $.each(storage['items'], function(key, value) {
        $.each($('.items'), function(k, v) {
            let used = $(v).find("#code_item").val();
            if(value['code_item'] == used) {
                usedItems.push(value['code_item']);
            }
        })
    })
    function addBlock(e) {
        let el = $('.box1:first').clone().insertAfter('.box1:last');
        $(el).find("#code_item").val("");
        $(el).find("#specification").val("");
        $(el).find("#name").val("");
        $(el).find("#type").val("");
        $(el).find("#amount").val("");
        $(el).attr("data-id", countBlock++);
        $(el).find(".imgs > .img-area > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
        $(el).find(".imgs > .img-area > img").attr('data-fancybox-trigger', 'gallery-b'+ countBlock);
        $(el).find(".imgs > .img-area .xt").html('');
        $(el).find(".images").html('');
        $(el).find(".imgs > button").attr('hidden', false);
        $(el).find('#remove_block').attr('hidden', false);
        $('#remove_block').attr('hidden', false);
        $(el).find('.invalid').remove();
        $(el).find('#border-red').remove();
        $(el).find('#code_item, #specification, #name, #type, #specification, #amount').css('border','1px solid #D8D8D8');
        total_items += 1;
        $('#total_items').val(total_items);
        let option = '<option value="">'+"Chọn"+'</option>';
        var storage = JSON.parse('{!! json_encode($storages) !!}');
        $.each(storage, function(key, value) {
            option+='<option data-value="'+value['code_item']+'" value="'+ value['code_item'] +'">'+value['code_item']+'</option>';
            $(el).find('#code_item').html(option)
        })
        $(el).find(".quantity").html("");
    }
    function myFunction(el) {
        let parent = $(el).parent().closest('.box1');
        let item= $(parent).find('select[name=code_item] option').filter(':selected').val()
        console.log(item)
        usedItems.remove(item);
        console.log(usedItems)
        $(el).parent().closest('.box1').remove();
        if ($(".box1").length <= 1) {
            $('#remove_block').attr('hidden', true);
        }
        //
        var sum = 0;
        $(".amount").each(function () {
            sum += +$(this).val();
        });
        console.log(sum);
        $("#total_amount").val(sum);
        //
        total_items = $('#total_items').val() - 1;
        $('#total_items').val(total_items);
    }
    let amount = $('.amount');
    console.log(amount);
    $('#publications').on('keyup change', amount, function (e) {
        var sum = 0;
        $(".amount").each(function () {
            sum += +$(this).val();
        });
        // console.log(sum);
        $("#total_amount").val(sum);
    });

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

    const csrf = "{{ csrf_token() }}";

    const UpdateData = async function (data, url) {
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
                title: 'Sửa phiếu điều chuyển thành công',
                showConfirmButton: false,
                timer: 2000
            });
            setTimeout(function(){
                window.location.assign("{{route('viewcpanel::transfer.detail', ['id' => $detail['_id']])}}");
            }, 2000);
            return ;
        }
        callback(result);
        $("#loading").addClass('hidden');
    }
    const CollectDataUpdate = function() {
        let data = {
            stores_export : $("#stores_export").val(),
            stores_import : $("#stores_import").val(),
            total_items : parseInt($("#total_items").val()),
            total_amount : parseInt($("#total_amount").val()),
            button : "save",
            items : []
        }
        console.log(data);
        let countBlock = 0;
        $(".items").each(function(index, value){
            let block = $(value);
            block.attr('data-id', countBlock);
            let name = $(value).find("#name").val();
            let code_item = $(value).find("#code_item").val();
            let type = $(value).find("#type").val();
            let specification= $(value).find("#specification").val();
            let amount = $(value).find("#amount").val();
            let path = [];
            image = $(value).find('.images > a > img');
            $.each(image, function (k, v) {
                console.log(v);
                let url = $(v).attr('src');
                console.log(url);
                path.push(url);
            })
            let item = {
                data_id: countBlock,
                code_item: code_item,
                name : name,
                type : type,
                specification : specification,
                amount : parseInt(amount),
                path : path,
            }
            data.items[countBlock] = item;
            countBlock++;
        });
        return data;
    }


    $("#confirm").on("click", function(e){
        e.preventDefault();
        $('#exampleModal').modal('hide');
        let data = CollectDataUpdate();
        let stores_export = $('select[name="stores_export"]');
        let stores_import = $('select[name="stores_import"]');
        let total_items = $('input[name="total_items"]');
        let total_amount = $('input[name="total_amount"]');
        var sendData = false;
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        if (stores_export.val() == '' || stores_export.val() == undefined) {
            stores_export.css('border','1px solid red');
            stores_export.after('<span class="invalid">Phòng giao dịch xuất không được để trống</span>');
            sendData = true;
            return;
        }
        if (stores_import.val() == '' || stores_import.val() == undefined) {
            stores_import.css('border','1px solid red');
            stores_import.after('<span class="invalid">Phòng giao dịch nhập không được để trống</span>');
            sendData = true;
            return;
        }
        if (total_items.val() == '' || total_items.val() == undefined) {
            total_items.css('border','1px solid red');
            total_items.after('<span class="invalid">Tổng số sản phẩm không được để trống</span>');
            sendData = true;
            return;
        }
        if (total_amount.val() == '' || total_amount.val() == undefined || total_amount.val() == 0) {
            total_amount.css('border','1px solid red');
            total_amount.after('<span class="invalid">Tổng số lượng ấn phẩm không được để trống</span>');
            sendData = true;
            return;
        } 
        $(".items").each(function(key, value) {
            let itemSpec = $(value).find('#specification');
            let itemCode = $(value).find('#code_item');
            let itemName = $(value).find('#name');
            let itemAmount = $(value).find('#amount');
            console.log(itemAmount.val());
            let itemType = $(value).find('#type');
            let quantity = $(value).find('#quantity').text();
            console.log(quantity);
            if (itemSpec.val() == '' || itemSpec.val() == undefined) {
                itemSpec.css('border','1px solid red');
                itemSpec.after('<span class="invalid">Quy cách ấn phẩm không được để trống</span>');
                sendData = true;
                return;
            }
            if (itemCode.val() == '' || itemCode.val() == undefined) {
                itemCode.css('border','1px solid red');
                itemCode.after('<span class="invalid">Mã ấn không được để trống</span>');
                sendData = true;
                return;
            }
            if (itemName.val() == '' || itemName.val() == undefined) {
                itemName.css('border','1px solid red');
                itemName.after('<span class="invalid">Tên ấn phẩm không được để trống</span>');
                sendData = true;
                return;
            }
            if (itemAmount.val() == '' || itemAmount.val() == undefined) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng không được để trống</span>');
                sendData = true;
                return;
            }
            if (itemAmount.val() > parseInt(quantity)) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng điều chuyển không được lớn hơn số lượng tồn vật phẩm</span>');
                sendData = true;
                return;
            }
            if (itemType.val() == '' || itemType.val() == undefined) {
                itemType.css('border','1px solid red');
                itemType.after('<span class="invalid">Loại ấn phẩm không được để trống</span>');
                sendData = true;
                return;
            }
        })
        console.log(sendData);
        if (sendData == false) {
            UpdateData(data, '{{route("viewcpanel::transfer.update",["id" => $detail["_id"]])}}');
        }
    });

        $("#publications").on("focus", ".code_item", function(e){
            showNameUsed(e);
        });

        $("#publications").on("change", ".code_item", function(e){
            showName(e);
        });

        const showNameUsed = (e) => {
            let _el = $(e.target).closest(".items");
            let code_item = $(_el).find("#code_item");
            let targetName = $(_el).find("#name");
            let targetType = $(_el).find("#type");
            let targetSpec = $(_el).find("#specification");
            let tradePathEl = $(_el).find(".imgs");
            let dataId = $(_el).attr('data-id');
            let option = '<option value="">Chọn</option>';      
            $(".items").each(function(index, value){
                let usedItem = $(value).find('[name="code_item"]').val();
                console.log(usedItem)
                if (!usedItem) {
                    return;
                }
                usedItems.push(usedItem);
            });
            let currentName = code_item.val();
            if (currentName) {
                usedItems.remove(currentName);
            }
            console.log(usedItems)
            $.each(storage['items'], function(key, value) {       
                if (!usedItems.includes(value['code_item'])) {
                    option+='<option value="'+ value['code_item'] +'">'+value['code_item']+'</option>';
                    $(code_item).html(option)
                } else {
                    $(code_item).html(option)
                }
            });
        }

        
        const showName = (e) => {
            let _el = $(e.target).closest(".items");
            let code_item = $(_el).find("#code_item");
            let targetName = $(_el).find("#name");
            let targetType = $(_el).find("#type");
            let targetSpec = $(_el).find("#specification");
            let tradePathEl = $(_el).find(".img-area");
            let dataId = $(_el).attr('data-id');    
            let option = '<option value="">Chọn</option>';      
            console.log(dataId);
            console.log(storage['items']);
            $.each(storage['items'], function(key, value) {
                console.log(value)
                if (!usedItems.includes(value['code_item']) && code_item.val() == value['code_item']) {
                    // console.log(value['code_item'], usedItems.includes(value['code_item']))
                    console.log(value['key'])
                    let optionPath = '<img src="'+ value['path'][0]+'" alt="" data-fancybox-trigger="gallery-'+value['key']+'" class="underline cursor-pointer">';
                    optionPath+= '<div class="images" style="display:none">';
                    for(let i = 0; i < value['path'].length; i++) {
                        optionPath += '<a data-fancybox="gallery-'+value['key']+'" href="'+value['path'][i]+'"><img class="rounded" src="'+value['path'][i]+'"/></a>';
                    }
                    optionPath+= '</div><h5 data-fancybox-trigger="gallery-'+value['key']+'" class="underline cursor-pointer xt countImg">+'+value['path'].length+'</h5>';
                    targetName.val(value['name']);
                    targetType.val(value['type']);
                    targetSpec.val(value['specification']);
                    $(tradePathEl).html(optionPath);
                    let span_quantity = value['quantity_stock'];
                    let label_quantity = $(_el).find(".quantity");
                    label_quantity.text(span_quantity);
                }
            });
        }
  
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
    $('a.redirect').on('click', (e) => {
        e.preventDefault();
        let url = $(e.target).attr('href');
        Redirect(url, false);
    })
</script>
@endsection