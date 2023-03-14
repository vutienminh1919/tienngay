@extends('viewcpanel::layouts.master')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
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

    .box1 {
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

    .footer button {
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
    .border-red {
        border-color: red;
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
        transform: translate(-50%, -50%);
        z-index: 2;
        padding: 20px;
        text-align: center;
        top: 55%;
        left: 45%;
    }
    .imgs {
        position: relative;
    }
    .is-animated {
        width:100%;
        height:1000px;
    }
    .swal2-popup {
        bottom: 50%;
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
</style>
@endsection
@section('content')
    <div class="wrapper">
        <div class="header">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>
            <h2>Điều chuyển ấn phẩm
                <br>
                <small class="table-of-contents">
                    <a class="redirect" style="text-decoration: none;" href="{{route('viewcpanel::warehouse.pgdIndex').'&tab=transfer'}}"><i class="fa fa-home"></i>Home</a> /
                    <a class="redirect" style="text-decoration: none;" href='{{route("viewcpanel::transfer.create")}}'>Thêm mới</a>
                </small>
            </h2>
        </div>
        <div class="style-container">
            <h3>Thông tin chung</h3>
            <div class="style-col-ip" id="transfer">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch xuất <span class="style-star">*</span></p>
                            <select name="stores_export" id="stores_export" class="form-select">
                                <option value="">Chọn</option>
                                @foreach($stores as $store)
                                    <option value="{{$store['_id']}}">{{$store['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch nhận <span class="style-star">*</span></p>
                            <select name="stores_import" id="stores_import" class="form-select">
                                <option value="">Chọn</option>
                                @foreach($stores as $store)
                                    <option value="{{$store['_id']}}">{{$store['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Tổng số sản phẩm</p>
                            <input class="form-control" name="total_items" id="total_items" type="text" style="background: #E6E6E6;" placeholder="Tổng số sản phẩm" readonly />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Tổng số lượng ấn phẩm</p>
                            <input class="form-control" name="total_amount" id="total_amount" type="text" style="background: #E6E6E6;" placeholder="Tổng số lượng ấn phẩm" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="style-container" id="publications">
            <h3>Danh sách ấn phẩm</h3>
            <div class="box1 items" style="margin-top: 20px;" data-id="0">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Mã ấn phẩm <span class="style-star">*</span></p>
                                    <select class="form-select code_item" name="code_item" id="code_item">
                                        <option value="">Chọn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p class="quantity_stock" id="quantity_stock">Số lượng <span class="style-star">*</span></p>
                                    <input class="amount" name="amount" id="amount" type="number" min="1" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69" placeholder="Nhập" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Tên ấn phẩm</p>
                                    <input class="name" name="name" id="name" type="text" style="background: #E6E6E6;" placeholder="Tên ấn phẩm" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Loại ấn phẩm</p>
                                    <input class="type" name="type" id="type" type="text" style="background: #E6E6E6;" placeholder="Loại ấn phẩm" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-ip">
                                    <p>Quy cách</p>
                                    <input class="specification" name="specification" id="specification" type="text" style="background: #E6E6E6;" placeholder="Quy cách" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 block-img">
                        <div class="img-box imgs">
                            <p>Ảnh mô tả</p>
                            <img style="margin-top:12px;" src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg" alt="" onerror="this.style.display='none'">
                        </div>
                        <div class="btn-del">
                            <button name="remove_block" type="button" onclick="myFunction(this)" id="remove_block" class="btn btn" hidden style="background-color:#F4CDCD; color:#C70404">Xóa ấn phẩm</button>
                        </div>
                    </div>
                    <input name="key" id="key" class="form-control key" type="text" hidden value="">
                    <input name="category" id="category" class="form-control category" type="text" hidden value="">
                    <input name="taget_goal" id="taget_goal" class="form-control taget_goal" type="text" hidden value="">
                    <input name="item_id" id="item_id" class="form-control item_id" type="text" hidden value="">
                    <input name="quantityCheck" id="quantityCheck" class="form-control quantityCheck" type="text" hidden value="">
                </div>
            </div>

            <div class="btn-create">
                <button type="button" onclick="addBlock(this)" id="add_block" class="btn btn-outline-success">Thêm mới ấn phẩm</button>
            </div>
        </div>

        <div class="footer">
            <div class="btn-left">
                <button id="save" type="save" class="btn-green">Lưu</button>
                <a href="{{route('viewcpanel::warehouse.pgdIndex')}}" class="btn-cancel redirect">Huỷ</a>
            </div>
            <div class="btn-right">
                <a type="button" style="background: #1D9752; color: #FFFFFF;" class="btn btn-success create-transfer-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">Tạo phiếu</a>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="bottom: 45%;">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h5 style="text-align: center">Tạo phiếu</h5>
                                <p style="text-align: center">Bạn có chắc chắn tạo phiếu điều chuyển danh sách ấn phẩm này?
                                </p>
                                <div class="btn-modal">
                                    <button type="button" id="confirm" class="btn-accept">Đồng ý</button>
                                    <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    var total_items = 1;
    $('#total_items').val(total_items);
    var countBlock = 1;
    function addBlock(e) {
        let el = $('.box1:first').clone().insertAfter('.box1:last');
        $(el).find("#code_item").val("");
        $(el).find("#specification").val("");
        $(el).find("#name").val("");
        $(el).find("#type").val("");
        $(el).find("#amount").val("");
        $(el).attr("data-id", countBlock++);
        $(el).find(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
        $(el).find(".imgs > img").attr('data-fancybox-trigger', 'gallery-a'+ countBlock );
        $(el).find(".imgs > .xt").remove();
        $(el).find(".imgs > button").attr('hidden', false);
        $(el).find('#remove_block').attr('hidden', false);
        $(el).find('.images').html('');
        $('#remove_block').attr('hidden', false);
        $(el).find('.invalid').remove();
        $(el).find('#border-red').remove();
        $(el).find('#code_item, #specification, #name, #type, #amount').css('border','1px solid #D8D8D8');
        total_items += 1;
        $('#total_items').val(total_items);
        $(el).find('.quantity').remove();
        $(el).find('#key').val("");
        $(el).find('#category').val("");
        $(el).find('#taget_goal').val("");
        $(el).find('#item_id').val("");
    }
    function myFunction(el) {
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

</script>
<script>
    $(document).ready(function() {

        $('.create-transfer-modal').click(function (event) {
            event.preventDefault();
            document.body.scrollIntoView();
        })

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
        //
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
                // let targetEl = $("#code_item");
                $('.items').each(function(key, value) {
                    console.log(value);
                    let taget = $(value).find('.code_item');
                    let option = '<option value="">-- Chọn tên ấn phẩm --</option>';
                    $.each(items['items'], function(k, v) {
                        let path = JSON.stringify(v['path']);
                        let type = v['type'];
                        let name = v['name'];
                        let spec = v['specification'];
                        console.log(v)
                        option += '<option data-type="'+type+'" data-spec="'+spec+' "data-name="'+ name +'" data-path='+ path +' value="' + v['code_item'] + '">' + v['code_item']+ '</option>';
                    });
                    $(taget).html(option);
                });
            } else {
                items = [];
                let taget = $('.items').find('.code_item');
                let option1 = '<option value="">Chọn</option>';
                $(taget).html(option1);
            }
        }
        $("#transfer").on('change', "#publications, #stores_export", function(){
            const storeId = $(this).val();
            const formData = {id: storeId};
            console.log(formData);
            getTradeItems(formData);
            $(".name").val("");
            $("#total_amount").val("");
            $(".type").val("");
            $(".specification").val("");
            $(".amount").val("");
            $(".code_item").val("");
            $('.quantity').html('');
            $('.key').val("");
            $('.category').val("");
            $('.taget_goal').val("");
            $('.item_id').val("");
            $(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
            $(".images").html('');
            $(".imgs > .xt").remove();
        });

        $("#publications").on("change", ".code_item", function(e){
            showName(e);
        });

        $("#publications").on("focus", ".code_item", function(e){
            showNameUsed(e);
        });
        var usedItems = [];
        const showNameUsed = (e) => {
            let _el = $(e.target).closest(".items");
            let code_item = $(_el).find("#code_item");
            // let _code_item = $(_el).val();
            let targetName = $(_el).find("#name");
            let targetType = $(_el).find("#type");
            let targetSpec = $(_el).find("#specification");
            let tradePathEl = $(_el).find(".imgs");
            let dataId = $(_el).attr('data-id');
            console.log(dataId);
            let option = '<option value="">Chọn</option>';
            $(".items").each(function(index, value){
                let usedItem = $(value).find('[name="code_item"]').val();
                console.log(usedItem)
                if (!usedItem) {
                    return;
                }
                usedItems.push(usedItem);
            });
            let currentName = $(_el).find('[name="code_item"]').val();
            if (currentName) {
                usedItems.remove(currentName);
            }
            console.log(usedItems)
            $.each(items['items'], function(key, value) {
                if (value['quantity_stock'] > 0) {
                    if (!usedItems.includes(value['code_item'])) {
                        option+='<option value="'+ value['code_item'] +'">'+value['code_item']+'</option>';
                        $(code_item).html(option)
                    }
                }

            });
        }

        const showName = (e) => {
            let _el = $(e.target).closest(".items");
            let code_item = $(_el).find("#code_item");
            let targetName = $(_el).find("#name");
            let targetType = $(_el).find("#type");
            let targetSpec = $(_el).find("#specification");
            let tradePathEl = $(_el).find(".imgs");
            let dataId = $(_el).attr('data-id');
            $(_el).find(".amount").val("");
            console.log(dataId)
            let key_image = $(_el).find("#key");
            let category = $(_el).find('#category')
            let taget_goal = $(_el).find('#taget_goal')
            let item_id = $(_el).find('#item_id')
            let quantityCheck = $(_el).find('#quantityCheck')
            let option = '<option value="">Chọn</option>';

            $.each(items['items'], function(key, value) {
                console.log(usedItems)
                if (!usedItems.includes(value['code_item']) && code_item.val() == value['code_item']) {
                    // console.log(value['code_item'], usedItems.includes(value['code_item']))
                    let optionPath = '<img src="'+ value['path'][0]+'" alt="" data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer">';
                    optionPath+= '<div class="images" style="display:none">';
                    for(let i = 0; i < value['path'].length; i++) {
                        optionPath += '<a data-fancybox="gallery-'+dataId+'" href="'+value['path'][i]+'"><img class="rounded" src="'+value['path'][i]+'"/></a>';
                    }
                    optionPath+= '</div><h5 data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer xt countImg">+'+value['path'].length+'</h5>';
                    targetName.val(value['name']);
                    targetType.val(value['type']);
                    targetSpec.val(value['specification']);
                    $(tradePathEl).html(optionPath);
                    $(key_image).val(value['key']);
                    $(category).val(value['category']);
                    $(taget_goal).val(value['taget_goal']);
                    $(item_id).val(value['item_id']);
                    $(quantityCheck).val(value['quantity_stock']);
                    $(_el).find('.quantity').remove();
                    let span_quantity = '<span class="quantity text-danger">'+ value['quantity_stock'] +'</span>'
                    let label_quantity = $(_el).find("#quantity_stock");
                    label_quantity.append(span_quantity);
                }
            });
        }

    });
</script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    const SaveData = async function (data, url) {
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
                position: 'top',
                icon: 'success',
                title: 'Tạo phiếu điều chuyển thành công',
                showConfirmButton: false,
                timer: 2000
            });
            setTimeout(function(){
                window.location.assign(result['data']['redirectURL']);
            }, 2000);
            return ;
        }
        // callback(result);
        $("#loading").addClass('hidden');
    }
    const CollectDataCreate = function() {
        let data = {
            stores_export : $("#stores_export").val(),
            stores_import : $("#stores_import").val(),
            total_items : parseInt($("#total_items").val()),
            total_amount : parseInt($("#total_amount").val()),
            button : "create",
            items : []
        }
        console.log(data);
        let countBlock = 0;
        $(".items").each(function(index, value){
            let block = $(value);
            block.attr('data-id', countBlock);
            let key = $(value).find("#key").val();
            let category = $(value).find("#category").val();
            let taget_goal = $(value).find("#taget_goal").val();
            let item_id = $(value).find("#item_id").val();
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
                key: key,
                item_id: item_id,
                category: category,
                taget_goal: taget_goal,
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

    const CollectDataSave = function() {
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
            let key = $(value).find("#key").val();
            let category = $(value).find("#category").val();
            let taget_goal = $(value).find("#taget_goal").val();
            let item_id = $(value).find("#item_id").val();
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
                key: key,
                item_id: item_id,
                category: category,
                taget_goal: taget_goal,
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
        let data = CollectDataCreate();
        let stores_export = $('select[name="stores_export"]');
        let stores_import = $('select[name="stores_import"]');
        let total_items = $('input[name="total_items"]');
        let total_amount = $('input[name="total_amount"]');
        var sendData = false;
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        if (stores_export.val() == stores_import.val()) {
            Swal.fire({
                position: 'top',
                icon: 'error',
                title: 'Phòng giao dịch nhận không được trùng phòng giao dịch xuất',
                showConfirmButton: true,
                // timer: 2000
            });
            sendData = true;
            return;
        }
        if (stores_export.val() == '' || stores_export.val() == undefined) {
            stores_export.css('border','1px solid red');
            stores_export.after('<span class="invalid">Phòng giao dịch xuất không được để trống</span>');
            sendData = true;
        }
        if (stores_import.val() == '' || stores_import.val() == undefined) {
            stores_import.css('border','1px solid red');
            stores_import.after('<span class="invalid">Phòng giao dịch nhập không được để trống</span>');
            sendData = true;
        }
        // if (total_items.val() == '' || total_items.val() == undefined) {
        //     total_items.css('border','1px solid red');
        //     total_items.after('<span class="invalid">Tổng số sản phẩm không được để trống</span>');
        //     sendData = true;
        // }
        // if (total_amount.val() == '' || total_amount.val() == undefined || total_amount.val() == 0) {
        //     total_amount.css('border','1px solid red');
        //     total_amount.after('<span class="invalid">Tổng số lượng ấn phẩm không được để trống</span>');
        //     sendData = true;
        // }
        $(".items").each(function(key, value) {
            let itemSpec = $(value).find('input[name="specification"]');
            let itemCode = $(value).find('select[name="code_item"]');
            let itemName = $(value).find('input[name="name"]');
            let itemAmount = $(value).find('input[name="amount"]');
            let itemType = $(value).find('input[name="type"]');
            let quantity = $(value).find('input[name="quantityCheck"]');
            if (itemSpec.val() == '' || itemSpec.val() == undefined) {
                itemSpec.css('border','1px solid red');
                itemSpec.after('<span class="invalid">Quy cách ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemCode.val() == '' || itemCode.val() == undefined) {
                itemCode.css('border','1px solid red');
                itemCode.after('<span class="invalid">Mã ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemName.val() == '' || itemName.val() == undefined) {
                itemName.css('border','1px solid red');
                itemName.after('<span class="invalid">Tên ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemAmount.val() == '' || itemAmount.val() == undefined) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng không được để trống</span>');
                sendData = true;
            }
            if (itemAmount.val() > parseInt(quantity.val())) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng điều chuyển không được lớn hơn số lượng tồn kho vật phẩm</span>');
                sendData = true;
            }
            if (itemType.val() == '' || itemType.val() == undefined) {
                itemType.css('border','1px solid red');
                itemType.after('<span class="invalid">Loại ấn phẩm không được để trống</span>');
                sendData = true;
            }
        })
        if (sendData == false) {
            SaveData(data, '{{route("viewcpanel::transfer.save")}}');
        }
    });

    $("#save").on("click", function(e){
        e.preventDefault();
        $('#exampleModal').modal('hide');
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        var sendData = false;
        let data = CollectDataSave();
        let stores_export = $('select[name="stores_export"]');
        let stores_import = $('select[name="stores_import"]');
        let total_items = $('input[name="total_items"]');
        let total_amount = $('input[name="total_amount"]');
        if (stores_export.val() == stores_import.val()) {
            Swal.fire({
                // position: 'top',
                icon: 'error',
                title: 'Phòng giao dịch nhận không được trùng phòng giao dịch xuất',
                showConfirmButton: true,
                // timer: 2000
            });
            sendData = true;
            return;
        }
        if (stores_export.val() == '' || stores_export.val() == undefined) {
            stores_export.css('border','1px solid red');
            stores_export.after('<span class="invalid">Phòng giao dịch xuất không được để trống</span>');
            sendData = true;
        }

        if (stores_import.val() == '' || stores_import.val() == undefined) {
            stores_import.css('border','1px solid red');
            stores_import.after('<span class="invalid">Phòng giao dịch nhập không được để trống</span>');
            sendData = true;
        }
        // if (total_items.val() == '' || total_items.val() == undefined) {
        //     total_items.css('border','1px solid red');
        //     total_items.after('<span class="invalid">Tổng số sản phẩm không được để trống</span>');
        //     sendData = true;
        // }
        $(".items").each(function(key, value) {
            let itemSpec = $(value).find('input[name="specification"]');
            let itemCode = $(value).find('select[name="code_item"]');
            let itemName = $(value).find('input[name="name"]');
            let itemAmount = $(value).find('input[name="amount"]');
            let itemType = $(value).find('input[name="type"]');
            let quantity = $(value).find('input[name="quantityCheck"]');
            if (itemSpec.val() == '' || itemSpec.val() == undefined) {
                itemSpec.css('border','1px solid red');
                itemSpec.after('<span class="invalid">Quy cách ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemCode.val() == '' || itemCode.val() == undefined) {
                itemCode.css('border','1px solid red');
                itemCode.after('<span class="invalid">Mã ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemName.val() == '' || itemName.val() == undefined) {
                itemName.css('border','1px solid red');
                itemName.after('<span class="invalid">Tên ấn phẩm không được để trống</span>');
                sendData = true;
            }
            if (itemAmount.val() == '' || itemAmount.val() == undefined) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng không được để trống</span>');
                sendData = true;
            }
            if (itemAmount.val() > parseInt(quantity.val())) {
                itemAmount.css('border','1px solid red');
                itemAmount.after('<span class="invalid">Số lượng điều chuyển không được lớn hơn số lượng tồn kho vật phẩm</span>');
                sendData = true;
            }
            if (itemType.val() == '' || itemType.val() == undefined) {
                itemType.css('border','1px solid red');
                itemType.after('<span class="invalid">Loại ấn phẩm không được để trống</span>');
                sendData = true;
            }
        })
        if (sendData == false) {
            SaveData(data, '{{route("viewcpanel::transfer.save")}}');
        }
    });


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
</script>
<script type="text/javascript">
  $(document).ajaxStart(function() {
  $("#loading").show();
  var loadingHeight = window.screen.height;
  $("#loading, .right-col iframe").css('height', loadingHeight);
  }).ajaxStop(function() {
    $("#loading").hide();
  });
</script>
@endsection
