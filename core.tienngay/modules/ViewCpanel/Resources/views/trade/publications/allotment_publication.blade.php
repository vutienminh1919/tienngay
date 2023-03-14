@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết phiếu mua ấn phẩm')
@section('css')
    <style>
    body {
      font-family: Roboto;
      background: #f7f7f7;
      margin: 0 20px;
    }

    .content-body {
      padding: 22px 0px;
    }

    .content-body1 {
      background: #ffffff;
      margin-top: 34px;
    }

    /* content */
    .content {
      display: flex;
      justify-content: space-between;
    }

    .title-h1 {
      margin: 0;
      font-size: 20px;
      font-weight: 700;
    }

    .report {
      color: #676767;
      font-size: 12px;
      margin-bottom: 34px;
    }
    .btnn-prev {
      background-color: #d8d8d8;
      border: 1px solid #d2eadc;
      outline: none;
      color: #676767;
      border-radius: 5px;
      padding: 8px 16px;
      font-size: 14px;
      font-weight: 600;
    }
    .btnn-prev:hover {
      background-color: #c5c5c5;
    }

    @media screen and (max-width: 48rem) {
      .content-title {
        text-align: center;
      }

      .row {
        margin: 20px 0;
      }

      .content-btn {
        margin-top: 10px;
      }
    }
    /*  */
    /* content1 */
    .content1 {
      margin: 34px 0 24px 0;
      padding: 24px 16px 24px 16px;
      background-color: #f0f0f0;
    }
    .titleH2 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 0;
    }
    .content1-h4 {
      font-size: 14px;
      font-weight: 400;
      margin: 16px 0 8px 0;
    }
    .content1-h4-1 {
      font-size: 14px;
      font-weight: 400;
      margin: 24px 0 8px 0;
    }
    .content1-input {
      background-color: #d8d8d8;
      padding: 5px 16px 8px 16px;
      border-radius: 5px;
      font-size: 14px;
      width: 100%;
      border: none;
      padding-top: 8px;
    }
    .content1-input1 {
      background-color: #fff;
      padding: 5px 16px 8px 16px;
      border: 1px solid #d8d8d8;
      border-radius: 5px;
      font-size: 14px;
      width: 100%;
      padding-top: 8px;
      outline: none;
    }
    /*  */
    .form-select {
      height: 37px;
      min-width: 100%;
      border: 1px solid #d8d8d8;
      border-radius: 5px;
      outline: none;
    }
    .span-color {
      color: red;
    }
    .btn-danger {
      background-color: #f4cdcd;
      color: #c70404;
      border: none;
      padding: 7px 30px;
    }
    .content1-btn {
      display: flex;
      justify-content: end;
      margin-top: 20px;
    }

    .btn {
      font-size: 14px;
      font-weight: 600;
    }
    .btnnn {
      padding: 8px 40px;
      color: #1d9752;
      font-weight: 600;
    }
    .button-end {
      display: flex;
      justify-content: space-between;
    }
    .button-end1 {
      width: 190px;
      padding: 8px 0;
    }
    .button-end2 {
      width: 190px;
      margin-left: 10px;
      padding: 8px 0;
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
  </style>
@endsection
@section('content')
    <body style="margin-top: 20px">
    <div class="content-title">
      <div class="content flex-column flex-sm-row">
        <div>
          <h1 class="title-h1">Phân bổ ấn phẩm</h1>
          <span class="report"
            ><a href="{{route('viewcpanel::trade.publication.list')}}">Khác<i class="fa fa-angle-right" aria-hidden="true"></i></a> /<a href="">Báo cáo</a>
          </span>
        </div>
        <div class="content-btn text-center">
            <a href="{{url('cpanel/trade/publication/detail_publics/'.$id)}}">
          <button type="button" class="btnn-prev">
            Trở về
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
          </a>
        </div>
      </div>
    </div>
    <div class="content1 shadow mb-4 bg-white rounded">
      <h2 class="titleH2">Thông tin ấn phẩm</h2>
      <div class="row">
        <div class="col-md-8 col-xs-12 pr-0">
          <div class="content1-div-1">
            <h4 class="content1-h4">Tên ấn phẩm/loại ấn phẩm/quy cách ấn phẩm</h4>
            <input
              class="content1-input name_publications"
              type="text"
              placeholder="Poster"
              disabled
              value="{{$name_publications}}/{{$type}}/{{$specification}}" id="name_publications" name="name_publications"
            />
              <input
                  class="content1-input item_id"
                  type="text"
                  disabled
                  value="{{$id}}" hidden id="id" name="id"
              />
              <input
                  class="content1-input item_id"
                  type="text"
                  disabled
                  value="{{$item_id}}" hidden id="item_id" name="item_id"
              />
              <input
                  class="content1-input key_id"
                  type="text"
                  disabled
                  value="{{$key_id}}" hidden id="key_id" name="key_id"
              />
          </div>
        </div>
        <div class="col-md-4 col-xs-12">
          <div class="content1-div-1">
            <h4 class="content1-h4">Số lượng có thể phân bổ</h4>
            <input
              class="content1-input total_quantity_tested"
              type="text"
              disabled value="{{$result_total_quantity_tested}}" id="total_quantity_tested" name="total_quantity_tested"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="content1 shadow mb-4 bg-white rounded">
      <h2 class="titleH2">Danh sách phòng giao dịch</h2>
        <div id="publiation_item" class="publiation_item">
            <!-- 1 -->
            <div class="row rounded block " id="box-public" data="0">
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <h4 class="content1-h4-1">
                        Phòng giao dịch <span class="span-color">*</span>
                    </h4>
                    <select
                        class="form-select col-md-4 col-xs-12 col-sm-6 store_id"
                        aria-label="Default select example" name="store_id" id="store_id"
                    >
                        <option value="">-- chọn phòng giao dịch --</option>
                        @foreach($getAllData as $key => $value)
                        @if($value['total_remaining'] > 0)
                            <option data-quantity="{{$value['item_quantity']}}" data-store="{{$value['_id']}}" data-storeId="{{$value['store_id'][0]}}"
                            data-received="{{$value['received_amount']}}"
                                    value="{{$value['_id']}}">{{$value['store_name'][0]}} - {{$value['plan_name'][0]}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="content1-div-1">
                        <h4 class="content1-h4-1">Số lượng cần giao</h4>
                        <input
                            class="content1-input totalAll"
                            type="text"
                            value="" id="totalALl" name="totalAll"
                            disabled
                        />
                    </div>
                    <div class="content1-div-1">
                        <h4 class="content1-h4" hidden>Số đã giao</h4>
                        <input
                            class="content1-input received_amount"
                            type="text"
                            disabled hidden
                            id="received_amount" name="received_amount"
                        />
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="content1-div-1">
                        <h4 class="content1-h4-1">
                            Số lượng phân bổ <span class="span-color">*</span>
                        </h4>
                        <input class="content1-input1 total_allotment" type="text" id="total_allotment" name="total_allotment" placeholder="Nhập"/>
                        <div class="d-flex" style="display: flex; justify-content: right;margin-top: 10px">
                            <button type="button" class="btn btn-danger ml-3 removeButton" id="removeButton" hidden>Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 2 -->
            <div class="row rounded hidden" id="appendEl">
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <h4 class="content1-h4">
                        Phòng giao dịch <span class="span-color">*</span>
                    </h4>
                    <select
                        class="form-select col-md-4 col-xs-12 col-sm-6 store_id"
                        aria-label="Default select example" name="store_id" id="store_id"
                    >
                        <option value="">-- chọn phòng giao dịch --</option>
                        @foreach($getAllData as $key => $value)
                            @if($value['total_remaining'] > 0)
                            <option data-quantity="{{$value['item_quantity']}}"
                            data-received="{{$value['received_amount']}}" data-storeId="{{$value['store_id'][0]}}"
                                    value="{{$value['_id']}}">{{$value['store_name'][0]}}- {{$value['plan_name'][0]}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="content1-div-1">
                        <h4 class="content1-h4">Số lượng cần giao</h4>
                        <input
                            class="content1-input totalALl"
                            type="text"
                            disabled
                            id="totalALl" name="totalALl"
                        />
                    </div>
                    <div class="content1-div-1">
                        <h4 class="content1-h4" hidden>Số đã giao</h4>
                        <input
                            class="content1-input received_amount"
                            type="text"
                            disabled hidden
                            id="received_amount" name="received_amount"
                        />
                    </div>

                </div>
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="content1-div-1">
                        <h4 class="content1-h4">
                            Số lượng phân bổ <span class="span-color">*</span>
                        </h4>
                         <input class="content1-input1 total_allotment" type="text" id="total_allotment" name="total_allotment" placeholder="Nhập"/>
                        <div class="d-flex" style="display: flex; justify-content: right;margin-top: 10px">
                            <button  type="button" class="btn btn-danger ml-3 removeButton" id="removeButton">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="content1-btn">
        <button type="button" class="btn btn-outline-success btnnn" id="moreButton">
          Thêm phòng giao dịch
        </button>
      </div>
    </div>
    <div class="button-end">
        <a href="{{url('cpanel/trade/publication/detail_publics/'.$id)}}"><button type="button" class="btn btn-danger button-end1">Hủy</button></a>
      <button type="button" data-key="{{$key_id}}" id="saveButton" data-url="{{route('viewcpanel::trade.publication.allotment_publication',['id' =>$id ,'key_id'=>$key_id])}}" class="btn btn-success button-end2">
        Xác nhận
      </button>
    </div>
  </body>
<!-- modal success -->
<div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
@endsection
@section('script')
    <script>
        const csrf = "{{ csrf_token() }}";
        $(document).ready(function () {

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

            var usedItems = [];
            var option = '<option value="">-- Chọn phòng giao dịch --</option>';

            $('#publiation_item').on('change', ".store_id", function (e) {
                var _el = $(e.target).closest(".block");
                var quantity = $(_el).find(":selected").data('quantity')
                var received_amount = $(_el).find(":selected").data('received')
                var sumQuantityReceivedAmount = quantity - received_amount
                $(_el).find("#totalALl").val(sumQuantityReceivedAmount)
                $(_el).find("#received_amount").val(received_amount)
            })

            var getAllData = JSON.parse('{!! json_encode($getAllData) !!}');
            // $('#publiation_item').on('focus', ".store_id", function (e) {
            //     var _el = $(e.target).closest(".block");
            //     var store_id = $(_el).find("#store_id");
            //     var data = $(_el).attr('data');
            //     //console.log(store_id)
            //     $(".block").each(function (key, value) {
            //         //console.log(value)
            //         var store_id_code = $(value).find('select#store_id option:selected').val();
            //         //console.log(store_id_code)
            //         if (!store_id_code) {
            //             return;
            //         }
            //         usedItems.push(store_id_code);
            //         // console.log(usedItems)
            //     })
            //         var currentName = $(_el).find('[name="store_id"]').val();
            //           if (currentName) {
            //               usedItems.remove(currentName);
            //         }
            //        $.each(getAllData, function (key, value) {
            //            //console.log(value['store_name'][0])
            //                 // if (!usedItems.includes(value['_id'])) {
            //                 //     option += '<option value="' + value['_id'] + '">' + value['store_name'][0] - value['plan_name'][0] + '</option>';
            //                 //     $(store_id).html(option)
            //                 // }
            //         })
            //     })

                var countBlock = 1;
                $('#moreButton').on('click', function () {
                    let el = $("#appendEl").clone();
                    el.removeClass("hidden");
                    el.addClass("block");
                    el.attr("id", "block");
                    el.attr("data", countBlock++);
                    $("#appendEl").before(el);
                    var countRemo = $('.removeButton').length;
                    //console.log(countRemo)
                    if (countRemo >= 2) {
                        $('.removeButton').attr('hidden', false);
                    }
                })


                $("#publiation_item").on("click", ".removeButton", function (e) {
                    var countRemo = $('.removeButton').length;
                    if (countRemo <= 3) {
                        $('.removeButton').attr('hidden', true);
                    }
                    let _el = $(e.target).closest(".block");
                    $(_el).remove();
                });
                $('#saveButton').on('click', function (e) {
                    $('.invalid').remove();
                    $('.border-red').removeClass('border-red');
                    e.preventDefault();
                    var item_id = $("input[name='item_id']").val();
                    var id = $("input[name='id']").val();
                    var url = $(this).attr('data-url')
                    var key_id = $(this).attr('data-key')
                    var countBlock = 0;
                    var arrAllotment = [];
                    $(".block").each(function (key, value) {
                        var block = $(value)
                        block.attr('data', countBlock)
                        var id_request = block.find('#store_id').find(":selected").val();
                        var store_id = block.find('#store_id').find(":selected").attr('data-storeId');
                        var total_allotment = block.find("[name='total_allotment']").val()
                        var data = {
                            id_request: id_request,
                            store_id: store_id,
                            total_allotment: total_allotment
                        }
                        arrAllotment.push(data);
                        countBlock++
                    })
                    if (confirm('Bạn chắc chắn muốn phân bổ ấn phẩm này cho phòng giao dịch này không?')) {
                        $.ajax({
                            url: url,
                            headers: {
                                "Content-Type": "application/json",
                                Accept: "application/json",
                                'x-csrf-token': csrf
                            },
                            type: "POST",
                            data: JSON.stringify({
                                "data": arrAllotment,
                                "code_item": item_id,
                                "_id": id,
                                "key_id": key_id
                            }),
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $(".theloading").show();
                            },
                            success: function (data) {
                                $(".theloading").hide();
                                $(".modal_missed_call").hide();
                                if (data.status == 200) {
                                    $('#successModal').modal('show');
                                    $('.msg_success').text(data.message);
                                    window.scrollTo(0, 0);
                                    setTimeout(function () {
                                        window.location.href = '{{url('cpanel/trade/publication/detail_publics/'.$id)}}';
                                    }, 500);
                                } else {
                                    $('#errorModal').modal('show');
                                    $('.msg_error').text(data.message);
                                    if (data.errors) {
                                        $.each(data.errors, function (key, value) {
                                            let splitKey = key.split(".");
                                            let el = $("[name='" + splitKey[0] + "']");
                                            if (splitKey.length > 2) {
                                                let block = $('[data="' + splitKey[1] + '"]');
                                                el = block.find("[name='" + splitKey[2] + "']");
                                            }
                                            if (el.attr('name') == 'store_id' || el.attr('name') == 'total_allotment') {
                                                el.addClass('border-red');
                                                el.after('<span class="invalid">' + value[0] + '</span>');
                                            } else {
                                                el.addClass('border-red');
                                                el.after('<span class="invalid">' + value[0] + '</span>');
                                            }
                                        })
                                    }
                                }
                            },
                            error: function (data) {
                                console.log(data);
                                $(".theloading").hide();
                            }
                        })
                    }
                });

            });
        // })
    </script>

@endsection
