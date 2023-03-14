@extends('viewcpanel::layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

@section('title', 'Cập nhật phiếu đặt mua ấn phẩm')

@section('css')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .block_list_order {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .block-contract-info,
    .block_list_order {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 24px 16px;
    }

    .contract-input {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .contract-input label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .contract-input label span {
        color: #C70404;
    }

    .contract-input input {
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 5px;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .contract-info-box2 .contract-input input {
        background: #E6E6E6;
    }

    .list_order_title {
        display: flex;
        justify-content: space-between;
    }

    .list_order_title h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .block-fancyapp {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .block-fancyapp img {
        width: 285px;
        height: 188px;
    }

    .block-fancyapp label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .btn-fancyapp {
        display: flex;
        align-items: flex-end;
    }

    .btn-fancyapp button {
        width: 179px;
        height: 40px;
        background: #F4CDCD;
        border: none;
        outline: none;
        color: #C70404;
        border-radius: 8px;
    }

    .list-order-box1 {
        width: calc(100%-32px);
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 8px;
        margin: 0px 8px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
    }

    .btn-block-oder {
        display: flex;
        justify-content: flex-end;
    }

    .btn-block-oder button {
        width: 190px;
        height: 40px;
        border: 1px solid #1D9752;
        border-radius: 5px;
        color: #1D9752;
        background-color: #FFFFFF;
        outline: none;
    }

    .img-block-order {
        display: flex;
        justify-content: space-around;
    }

    .btn-footer {
        display: flex;
        gap: 10px;
    }

    .btn-footer button {
        width: 190px;
        height: 40px;
        border: none;
        outline: none;
        border-radius: 5px;
        color: #1D9752;
    }

    .img-fancyapp {
        position: relative;
    }

    .img-fancyapp h5 {
        position: absolute;
        top: 48%;
        left: 50%;
        z-index: 2;
        color: #FFFFFF;
    }

    .modal-dialog {
        bottom: 35%;
    }

    #successModal .modal-dialog{
        bottom: -20%;
    }

    #errorModal .modal-dialog{
        bottom: -20%;
    }

    @media screen and (min-width: 600px) and (max-width:900px) {
        .img-block-order {
            display: flex;
            flex-direction: column;
        }

        .img-fancyapp img {
            width: 100%;
        }
    }

    @media screen and (min-width: 1020px) and (max-width:1444px) {
        .block-fancyapp img {
            width: 250px;
            height: 188px;
        }

        .btn-fancyapp button {
            width: 145px;
            height: 40px;
        }




    }

    @media screen and (max-width:48em) {
        .img-block-order {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .block-contract-info,
        .block_list_order {
            padding: 10px 5px;
        }

    }

    .hidden {
        display: none !important;
    }

    .invalid {
        font-size: 13px;
        color: red;
        font-weight: 500;
    }

    .border-red {
        border-color: red !important;
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
        align-items: center;
    }

    .xt {
        position: absolute;
        top: 50%;
        left: 50%;
        color: #ffffff;
    }
</style>
@endsection
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
@section('content')
<section id="hcns_oder_details">
    <div class="wrapper">
        <div class="header">
            <div class="header-title">
                <h3>Chỉnh sửa đơn đặt hàng</h3>
                <small>
                    <a href="https://lms.tienngay.vn/"><i class="fa fa-home"></i> Khác</a> / <a href="https://lms.tienngay.vn/pawn/contract">yêu cầu</a>
                </small>
            </div>
        </div>
        <div class="block-contract-info">
            <h5>Thông tin chung </h5>
            <div class="contract-info-box1 row">
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Nhà cung cấp <span>*</span></label>
                    <input type="text"  value="{{$detail['supplier']}}" placeholder="Nhập" name="supplier" class="supplier" id="supplier" />
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Chi phí khác <span>*</span></label>
                    <input type="text" value="{{number_format($detail['other_costs'])}}" placeholder="Nhập" name="other_costs" class="other_costs" id="other_costs"/>
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày đặt hàng <span>*</span></label>
                    <input placeholder="Chọn" value="{{date('Y-m-d',$detail['date_order'])}}" class="form-control date_order" type="text" id="date_order" name="date_order" />
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày nghiệm thu dự kiến <span>*</span></label>
                    <input placeholder="Chọn" value="{{date('Y-m-d',$detail['date_acceptance'])}}" class="form-control date_acceptance" type="text" id="date_acceptance" name="date_acceptance" />
                </div>
            </div>
            <div class="contract-info-box2 row">
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng số loại ấn phẩm </label>
                    <input type="text" disabled value="{{$detail['sum_item_id']}}" name="sum_item_id" id="sum_item_id" class="sum_item_id"/>
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng số lượng ấn phẩm </label>
                    <input type="text" disabled value="{{$detail['sum_total']}}" name="sum_total" id="sum_total" class="sum_total"/>
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng chi phí thực tế </label>
                    <input type="text" disabled value="{{number_format($detail['sum_money_publications'])}}" name="sum_money_publications" id="sum_money_publications" class="sum_money_publications" />
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Người tạo</label>
                    <input type="text" disabled  value="{{$detail['created_by']}}"/>
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày tạo </label>
                    <input type="text" value="{{date('d/m/Y',$detail['created_at'])}}" disabled />
                </div>
                <div class="contract-input col-lg-4 col-md-4 col-xs-12">
                    <label>Trạng thái </label>
                    <input type="text" style="color: #1D9752;" disabled
                           @switch($detail['status'])
                               @case(1)
                               value="Mới"
                                   @break
                               @case(2)
                               value="Đã đặt hàng"
                                   @break
                               @case(3)
                               value="Chờ maketing nghiệm thu"
                                   @break
                               @case(4)
                               value="Đang nghiệm thu"
                                    @break
                               @case(5)
                               value="Nghiệm thu hoàn thành"
                                    @break
                               @default
                               Không xác định
                           @endswitch
                    />
                </div>
            </div>
        </div>
        <div class="block_list_order">
            <div class="list_order_title">
                <h5>Danh sách ấn phẩm đặt hàng </h5>
                <div>
                    <i class="fa fa-angle-up" aria-hidden="true"></i>
                </div>
            </div>
            <div id="public_item" class="content3-div">
                 <input type="text" value="{{$detail['_id']}}" class="idAccep form-input" id="idAccep" name="idAccep" hidden>
                @foreach($detail['lead_publications'] as $key => $value)
                    <div class="list-order-box1 row bg-white rounded block " data-id="{{$value['key_id']}}">
                        <div class="col-lg-8 col-md-8 col-xs-12">
                            <div class="row">
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Mã ấn phẩm <span>*</span></label>
                                    <select name="item_id" id="item_id" class="form-select item_id">
                                        <option value="">-- Chọn mã ấn phẩm --</option>
                                        @foreach($result_trade as $k => $v)
                                            @if($value['item_id'] == $v['item_id'])
                                                <option value="{{$v['item_id']}}" selected>{{$v['item_id']}}</option>
                                            @else
                                                <option value="{{$v['item_id']}}">{{$v['item_id']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Số lượng <span>*</span></label>
                                    <input type="text" placeholder="Nhập" class="total" name="total" id="total"
                                           value="{{$value['total']}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Đơn giá thực tế <span>*</span></label>
                                    <input type="text" placeholder="Nhập" class="money_publications"
                                           id="money_publications" name="money_publications"
                                           value="{{number_format($value['money_publications'])}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Chi phí thực tế </label>
                                    <input type="text" style="background: #E6E6E6;" disabled class="money_total"
                                           name="money_total" id="money_total" value="{{number_format($value['money_total'])}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Tên ấn phẩm </label>
                                    <input type="text" style="background: #E6E6E6;" disabled name="name_publications"
                                           class="name_publications" id="name_publications"
                                           value="{{$value['name_publications']}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Loại ấn phẩm</label>
                                    <input type="text" style="background: #E6E6E6;" disabled class="type" name="type"
                                           id="type" value="{{$value['type']}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label>Quy cách </label>
                                    <input type="text" style="background: #E6E6E6;" disabled name="specification"
                                           id="specification" class="specification"
                                           value="{{$value['specification']}}"/>
                                </div>
                                <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                    <label hidden>Đơn giá dự kiến <span>*</span></label>
                                    <input type="text" style="background: #E6E6E6;" disabled name="price" id="price"
                                           class="price" value="{{$value['price']}}" hidden/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12 img-block-order">
                            <div class="block-fancyapp">
                                <label>Ảnh mô tả</label>
                                <div class="d-flex image image_detail" style="position: relative">
                                    @if(count($value['image_detail']) > 0)
                                        <img src="{{$value['image_detail'][0]}}" alt=""
                                             data-fancybox-trigger="gallery-{{$value['key_id']}}"
                                             class="underline cursor-pointer">
                                        <div style="display:none">
                                            @foreach($value['image_detail'] as $path)
                                                <a data-fancybox="gallery-{{$value['key_id']}}" href="{{$path}}">
                                                    <img class="rounded" src="{{$path}}"/>
                                                </a>
                                            @endforeach
                                        </div>
                                        <h5 data-fancybox-trigger="gallery-{{$value['key_id']}}"
                                        class="underline cursor-pointer xt">  +{{count($value['image_detail'])}}</h5>

                                    @endif
                                </div>
                            </div>
                            <div class="btn-fancyapp">
                                <button type="button" class="btn removeBlock" id="removeBlock" >Xóa ấn phẩm</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div id="appendEl" class="list-order-box1 row bg-white rounded  hidden">
                    <div class="col-lg-8 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Mã ấn phẩm <span>*</span></label>
                                <select id="item_id" class="form-select" name="item_id">
                                    <option value="">-- Chọn mã ấn phẩm --</option>
                                    @foreach($result_trade as $key => $value)
                                        <option value="{{$value['item_id']}}">{{$value['item_id']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Số lượng <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="total" id="total" class="total"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Đơn giá thực tế <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="money_publications"
                                       id="money_publications" class="money_publications"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Chi phí thực tế </label>
                                <input type="text" style="background: #E6E6E6;" disabled name="money_total"
                                       id="money_total" class="money_total"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Tên ấn phẩm </label>
                                <input type="text" style="background: #E6E6E6;" disabled name="name_publications"
                                       id="name_publications" class="name_publications"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Loại ấn phẩm</label>
                                <input type="text" style="background: #E6E6E6;" disabled name="type" id="type"
                                       class="type"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label>Quy cách </label>
                                <input type="text" style="background: #E6E6E6;" disabled name="specification"
                                       class="specification" id="specification"/>
                            </div>
                            <div class="contract-input col-lg-6 col-md-6 col-xs-12">
                                <label hidden>Đơn giá dự kiến <span>*</span></label>
                                <input type="text" style="background: #E6E6E6;" disabled name="price" id="price"
                                       class="price" hidden/>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12 img-block-order">
                        <div class="block-fancyapp">
                            <div class="col-lg-8 col-md-8 col-xs-12" style="padding-top: 12px;">
                                <div class="label-img">
                                    <label>Ảnh mô tả </label>
                                    <div class="fancy-img image_detail" id="image_detail" style="position: relative">
                                          <img
                                        style="margin-top:12px; filter: brightness(50%);-webkit-filter: brightness(50%);"
                                        src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg"
                                        alt="" onerror="this.style.display='none'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-fancyapp">
                            <button type="button" class="btn removeBlock" id="removeBlock">Xóa ấn phẩm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="btn-block-oder">
                <button id="appendBlock" type="button">Thêm ấn phẩm </button>
            </div>
        </div>
        <div class="btn-footer">
            <button class="save_publications" id="save_publications" style="background: #1D9752;color: #FFFFFF;" data-url="{{route('viewcpanel::trade.publication.detail_publication' , ['id' => $id])}}">Lưu</button>
            <a href="{{route('viewcpanel::trade.publication.list')}}"><button style="background: #F4CDCD;color: #C70404;">Hủy</button></a>
        </div>
    </div>
</section>
@endsection
<!-- modal success -->
<div class="modal fade" id="successModal"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success" id="staticBackdropLabel">Thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-primary"></p>
          </div>
          <div class="modal-footer">
{{--            <a id="redirect-url" class="btn btn-success">Xem</a>--}}
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal error -->
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary" id="staticBackdropLabel">Có lỗi xảy ra</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="msg_error"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
const csrf = "{{ csrf_token() }}";
    $(document).ready(function () {
        function countBlock () {
            var countRemo = $('.removeBlock').length;
            if(countRemo <= 2){
                 $('.removeBlock').attr('hidden', true);
            }
            console.log(countRemo);
        }
        countBlock();

        $("#appendBlock").on("click", function(){
            let el = $("#appendEl").clone();
            el.removeClass("hidden");
            el.addClass("block");
            el.attr("id", "block");
            $("#appendEl").before(el);
            var countRemo = $('.removeBlock').length;
            console.log(countRemo)
            if (countRemo >= 2) {
                $('.removeBlock').attr('hidden', false);
            }
        });

        $("#public_item").on("click", ".removeBlock", function (e) {
            var countRemo = $('.removeBlock').length;
            if (countRemo <= 3) {
                $('.removeBlock').attr('hidden', true);
            }
            let _el = $(e.target).closest(".block");
            $(_el).remove();
        })

        $('#public_item').on('change','#item_id', function (e) {
        var _el = $(e.target).closest(".block");
        var item_id = $(_el).find("#item_id").val()
        var formData = new FormData();
        formData.append('item_id', item_id)
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.find_one_trade')}}',
            type: "POST",
            data: formData,
            dataType: 'json',
            headers: {
                'x-csrf-token': csrf
            },
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                        $(_el).find("#specification").val(data.data.detail.specification)
                        $(_el).find("#name_publications").val(data.data.detail.name)
                        $(_el).find("#type").val(data.data.detail.type)
                        $(_el).find("#price").val(data.data.detail.price)
                    if (data.data.path){
                        let imgs = $(_el).find(".image_detail");
                        let img = "";
                        let dataId = $(_el).attr('data-id');
                        let img_public = '<img src="'+data.data.path[0]+'" alt="" data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer">';
                        img_public+= '<div class="images" style="display:none">';
                        $.each(data.data.path,function (key,value) {
                            img_public += '<a data-fancybox="gallery-'+dataId+'" href="'+value+'">' +
                                          '<img class="rounded" src="'+value+'"/></a>';
                        });
                        img_public += '</div><h5 data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer xt">' +  '+' + data.data.path.length + '</h5>';
                        $(imgs).html(img_public);
                    }
                } else {
                    $('#errorModal').modal('show');
                    $('.msg_error').text(data.msg);
                }
            },
            error: function (data) {
                $(".theloading").hide();
            }
        })
    });

        $("#save_publications").click(function (event) {
            event.preventDefault();
            $('.invalid').remove();
            $('.border-red').removeClass('border-red');
            var url = $(this).attr('data-url');
            var id = $("input[name='idAccep']").val();
            var data = {
                supplier: $(" input[name='supplier']").val(),
                other_costs: $("input[name='other_costs']").val(),
                date_acceptance: $("input[name='date_acceptance']").val(),
                date_order: $("input[name='date_order']").val(),
                sum_item_id: $("input[name='sum_item_id']").val(),
                sum_money_publications: $("input[name='sum_money_publications']").val(),
                sum_total: $("input[name='sum_total']").val(),
                lead_publications: {},
                _id: id
            }
            var countBlock = 0;
            $(".block").each(function (index, value) {
                // console.log(value)
                var currentTime = Math.round(+new Date() / 1000);
                var block = $(value);
                var blockId = block.attr('data-id');
                if (blockId == undefined) {
                    block.attr('data-id', (currentTime + '' + countBlock));
                    blockId = (currentTime + '' + countBlock);
                }
                var item_id = block.find("[name='item_id']").val()
                var money_publications = block.find("[name='money_publications']").val()
                var name_publications = block.find("[name='name_publications']").val()
                var specification = block.find("[name='specification']").val()
                var total = block.find("[name='total']").val()
                var type = block.find("[name='type']").val();
                var price = block.find("[name='price']").val();
                var money_total = block.find("[name='money_total']").val();
                var path = [];
                image = $(value).find('.images > a > img');
                $.each(image, function (k, v) {
                    // console.log(v);
                    var url = $(v).attr('src');
                    // console.log(url);
                    path.push(url);
                });
                var lead_publications = {
                    key_id: blockId,
                    item_id: item_id,
                    money_publications: money_publications,
                    name_publications: name_publications,
                    specification: specification,
                    total: total,
                    type: type,
                    price: price,
                    money_total: money_total,
                    image_detail: path
                }
                data.lead_publications[blockId] = lead_publications;
                countBlock++;
            });
            // console.log(data)
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.update')}}',
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    'x-csrf-token': csrf
                },
                type: "POST",
                data: JSON.stringify(data),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        window.scrollTo(0, 0);
                        setTimeout(function () {
                            //window.location.reload();
                            window.location.href=url;
                        }, 1000);
                    } else {
                        $('#errorModal').modal('show');
                        $('.msg_error').text(data.message);
                        if (data.errors) {
                            $.each(data.errors, function (key, value) {
                                let splitKey = key.split(".");
                                let el = $("[name='" + splitKey[0] + "']");
                                if (splitKey.length > 2) {
                                    let block = $('[data-id="' + splitKey[1] + '"]');
                                    el = block.find("[name='" + splitKey[2] + "']");
                                }
                                if (el.attr('name') == 'supplier' || el.attr('name') == 'other_costs' || el.attr('name') == 'date_acceptance' || el.attr('name') == 'date_order') {
                                    el.addClass('border-red');
                                    el.after('<span class="invalid">' + value[0] + '</span>');
                                } else {
                                    el.addClass('border-red');
                                    el.after('<span class="invalid">' + value[0] + '</span>');
                                }
                            });
                        }
                    }
                },
                error: function (data) {
                    $(".theloading").hide();
                }
            })
        });

        $('#public_item').on('keyup', '.total , .money_publications', function (e) {
            var _el = $(e.target).closest(".block");
            var total = $(_el).find("#total").val()
            var money_publications = $(_el).find("#money_publications").val()
             money_publications = Number(money_publications.replace(/[^0-9.-]+/g,""));
            var moneyTotal = _el.find('#money_total');
            var sum_money_publications = $("input[name='sum_money_publications']").val()
            var sum_money_public_and_total = total * parseInt(money_publications)
            $(moneyTotal).val(addCommas(sum_money_public_and_total.toString()));
            var sum = 0;
            $("[name='money_total']").each(function (index, value) {
                let money = $(value).val();
                if (money != 0)
                    sum += parseInt(money.replace(/,/g, ""));
            });
            $("#sum_money_publications").val(addCommas(sum.toString()))
        });

        $("#public_item").on('keyup', '.total , .money_publications,#item_id', function (e) {
            var _el = $(e.target).closest(".block");
            var total = $(_el).find("#total").val()
            var money_publications = $(_el).find("#money_publications").val()
            var totals = $("input[name='sum_total']").val()
            var sum_money_publications = $("input[name='sum_money_publications']").val()
            var sum_item_id = $("input[name='sum_item_id']").val()
            var sum = 0
            var sum1 = 0
            if ($("[name='total']").empty()) {
                $("[name='total']").each(function (index, value) {
                    if ($(value).val() != "")
                        sum += parseInt($(value).val());
                });
                $("#sum_total").val((sum))
            }
            var sumItemId = $("[name='item_id']").length - 1
            $("#sum_item_id").val(sumItemId)
        })

        $("#public_item").on("click", ".removeBlock", function (e) {
            let _el = $(e.target).closest(".block");
            $(_el).remove();
            var sum = 0
            var sum1 = 0
            if ($("[name='total']").empty()) {
                $("[name='total']").each(function (index, value) {
                    if ($(value).val() != "")
                        sum += parseInt($(value).val());
                });
                $("#sum_total").val(sum)
            }
            if ($("[name='money_total']").empty()) {
                $("[name='money_total']").each(function (index, value) {
                    var sumMoney = $(value).val();
                    if (sumMoney != 0)
                        sum1 += parseInt(sumMoney.replace(/,/g, ""));
                });
                $("#sum_money_publications").val(addCommas(sum1.toString()))
            }
            if ($("[name = 'item_id']")) {
                var sumItemId = $("[name='item_id']").length - 1
                $("#sum_item_id").val(sumItemId)
            }
        });

        function addCommas(str) {
			return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

        $('#other_costs').on('keyup', function (event) {
            var other_costs = $("input[name='other_costs']").val()
            $('#other_costs').val(addCommas(other_costs))
        })

        $('#public_item').on('keyup', function (event) {
            var _el = $(event.target).closest(".block");
            var money_publications = $(_el).find("#money_publications").val();
            $(_el).find("#money_publications").val(addCommas(money_publications))
        })

        var result_trade = JSON.parse('{!! json_encode($result_trade) !!}');
        $.each(result_trade['item_id'], function (key, value) {
            $.each($('.block'), function (k, v) {
                var used = $(v).find("#item_id").val();
                if (value['item_id'] == used) {
                    usedItems.push(value['item_id']);
                }
            })
        })

        Array.prototype.remove = function () {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };

        $('#public_item').on('focus','#item_id', function (e) {
             var usedItems = [];
             var _el = $(e.target).closest(".block");
             var item_id = $(_el).find("#item_id");
             let dataId = $(_el).attr('data-id');
             let option = '<option value="">Chọn</option>';
             $(".block").each(function(index, value){
                 let usedItem = $(value).find('[name="item_id"]').val();
                 if (!usedItem) {
                     return;
                 }
                 usedItems.push(usedItem);
             });
                let currentName = item_id.val();
                if (currentName) {
                    usedItems.remove(currentName);
                }
            $.each(result_trade, function (key, value) {
                if (!usedItems.includes(value['item_id'])) {
                    option += '<option value="' + value['item_id'] + '">' + value['item_id'] + '</option>';
                    $(item_id).html(option)
                } else {
                    $(item_id).html(option)
                }
            });
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
<script>
    var dp = $("#date_acceptance, #date_order").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
</script>
@endsection

