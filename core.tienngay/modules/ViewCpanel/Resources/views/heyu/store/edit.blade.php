
@extends('viewcpanel::layouts.master')
@section('title', 'Chỉnh sửa số lượng đồng phục vào kho Tienngay')

@section('css')
<style type="text/css">
  .main-content {
    font-family: 'Roboto';
    font-style: normal;
    color: #3B3B3B;
  }
  .tilte_top {
    margin-top: 50px;
    font-size: 16px;
    font-weight: 600;
  }
  label, input, select, textarea, .time-value {
    color: #676767 !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    display: block;
  }
  .inline-block {
    display: inline-block;
  }
  .invalid {
    color: red;
  }
  .invalid-input {
    border-color: red !important;
  }
  .upload-hidden {
    display: none;
  }
  #call-to-action {
    width: 150px;
    border: solid 1px #1D9752;
    font-size: 14px;
    color: #1D9752;
    border-radius: 5px;
    font-weight: 400;
    padding: 5px 0;
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
  .block {
    position: relative;
    display: inline-block;
    vertical-align: top;
    width: 150px;
    height: 150px;
    padding: 9px;
    margin-right: 15px;
    margin-bottom: 15px;
    background-color: #fff;
    border: 1px solid #ccc;
    margin-right: 10px;
    border-radius: 5px;
  }
  .block img, video {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    max-height: 100%;
  }
  .cancelButton {
    -moz-appearance: none;
    -webkit-appearance: none;
    position: absolute;
    top: -3px;
    right: 3px;
    color: #F00;
    text-align: center;
    font-weight: 700;
    background-color: transparent;
    padding: 0;
    margin: 0;
    border: 0;
    font-size: 25px;
    right: -8px;
    top: -8px;
    line-height: 15px;
    border-radius: 100%;
    background-color: #fff
  }
  .img {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .modal-backdrop {
      display: none !important;
  }

  .img:hover {opacity: 0.7;}

  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  /* Modal Content (Image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  /* Caption of Modal Image (Image Text) - Same Width as the Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation - Zoom in the Modal */
  .modal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
  }

  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }

  .img-area {
    border: solid 1px #D8D8D8;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    position: relative;
  }

  .submit {
    width: 150px;
    font-weight: 400;
    font-size: 14px;
  }
  .form-group {
    margin-top: 10px;
  }
  #delivery_time {
    border-radius: 5px;
    background-color: #377dff;
  }
</style>
@endsection

@section('content')
    <section class="main-content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="create_record">
            <div id="loading" class="theloading" style="display: none;">
                <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            </div>
        </div>
        <legend class="col-md-6" style="margin-left: 20px">
            Chỉnh sửa kho PGD - {{$detail['store']['name'] ?? ""}}
        </legend>
        <div class="new_report">
            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
        </div>
        <div class="row" style="margin-left: 10px">
            <div class="col-md-4 col-sm-12">
                <label for="store_id" class="form-label"><strong>Phòng giao dịch</strong>&nbsp;<span class="text-danger">*</span></label>
                <select class="form-control" name="" id="store_id">
                        <option value="{{$detail['store']['id'] . ',' . $detail['store']['name']}}">{{$detail['store']['name']}}</option>
                </select>
            </div>
            <div class="col-md-8 col-sm-12">

            </div>
            <div class="col-md-6 col-sm-6" style="display:none">
                <label for="helmet" class="form-label">Số lượng mũ&nbsp;</label>
                <input style="width:150px" type="number" class="form-control" id="helmet" name="helmet" onkeydown="return event.keyCode !== 69" min="0">
                        </div>
            <div class="row" style="margin-bottom: 20px;margin-top: 20px">
                <input type="text" id="editId" value="{{$detail['_id']}}" hidden>
                <label for="coat" class="form-label"><strong>Áo khoác</strong>&nbsp; (Tổng: <span class="text-danger totalCoat">{{$detail['total_coat']}}</span>)</label>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_s" class="form-label">Cỡ S&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['s']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_s" name="coat_s" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_m" class="form-label">Cỡ M&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['m']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_m" name="coat_m" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_l" class="form-label">Cỡ L&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['l']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_l" name="coat_l" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_xl" class="form-label">Cỡ XL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['xl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_xl" name="coat_xl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_xxl" class="form-label">Cỡ XXL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['xxl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_xxl" name="coat_xxl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="coat_xxxl" class="form-label">Cỡ XXXL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['coat']['xxxl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control coatTotal" id="coat_xxxl" name="coat_xxxl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
            </div>

            <div class="row">
                <label for="shirt" class="form-label"><strong>Áo phông</strong>&nbsp;(Tổng: <span class="text-danger totalShirt">{{$detail['total_shirt']}}</span>)</label>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_s" class="form-label">Cỡ S&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['s']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_s" name="shirt_s" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_m" class="form-label">Cỡ M&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['m']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_m" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69"
                           name="shirt_m">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_l" class="form-label">Cỡ L&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['l']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_l" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69"
                           name="shirt_l">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_xl" class="form-label">Cỡ XL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['xl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_xl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69"
                           name="shirt_xl">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_xxl" class="form-label">Cỡ XXL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['xxl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_xxl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69"
                           name="shirt_xxl">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="shirt_xxxl" class="form-label">Cỡ XXXL&nbsp;</label>
                    <input style="width:100%" type="number" value="{{$detail['detail']['shirt']['xxxl']}}" min="0" onkeypress="return event.charCode != 45" class="form-control shirtTotal" id="shirt_xxxl" placeholder="Nhập số lượng" onkeydown="return event.keyCode !== 69"
                           name="shirt_xxxl">
                </div>
            </div>

        </div>
        <div style="margin-top: 30px;margin-left: 10px">
            <div style="margin-top:10px;">
                <button style="margin-left: 10px" id="typeEdit" type="submit" class="btn btn-success">Xác nhận</button>
            </div>
        </div>
        <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Có Lỗi Xảy Ra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="msg_error"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thông báo</h5>
                    </div>
                    <div class="modal-body">
                        <p class="msg_success text-success"></p>
                    </div>
                    <div class="modal-footer">
                        <a id="redirect-url" class="btn btn-success" data-bs-dismiss="modal">Đóng</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div id="imgModal" class="modal">
            <!-- The Close Button -->
            <span class="close" onclick="closeModal(this)">&times;</span>
            <!-- Modal Content (The Image) -->
            <img class="modal-content" id="img01">
            <!-- Modal Caption (Image Text) -->
        </div>
        <div id="videoModal" class="modal">
            <!-- The Close Button -->
            <span class="close" onclick="closeModal(this)">&times;</span>
            <!-- Modal Content (The Image) -->
            <iframe id="srcVideo" width="100%" height="100%" frameborder="0" allowfullscreen src=""></iframe>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        var data = JSON.parse('{!! json_encode($detail) !!}');
        console.log(data)
        $(document).on("keyup change", ".coatTotal", function () {
            var sum = 0;
            $(".coatTotal").each(function () {
                sum += +$(this).val();
            });
            $(".totalCoat").html(sum);
        });
        $(document).on("keyup change", ".shirtTotal", function () {
            var sum = 0;
            $(".shirtTotal").each(function () {
                sum += +$(this).val();
            });
            $(".totalShirt").html(sum);
        });

        $(document).ready(function () {
            $('#typeEdit').click(function (event) {
                event.preventDefault();
                let id = $('#editId').val();
                let store_id = $('#store_id').val();
                let helmet = $('#helmet').val();
                let coat_s = $('#coat_s').val();
                let coat_m = $('#coat_m').val();
                let coat_l = $('#coat_l').val();
                let coat_xl = $('#coat_xl').val();
                let coat_xxl = $('#coat_xxl').val();
                let coat_xxxl = $('#coat_xxxl').val();
                let shirt_s = $('#shirt_s').val();
                let shirt_m = $('#shirt_m').val();
                let shirt_l = $('#shirt_l').val();
                let shirt_xl = $('#shirt_xl').val();
                let shirt_xxl = $('#shirt_xxl').val();
                let shirt_xxxl = $('#shirt_xxxl').val();
                let total_coat = $('.totalCoat').text();
                let total_shirt = $('.totalShirt').html();
                let formData = new FormData();
                formData.append('id', id);
                formData.append('store_id', store_id);
                formData.append('helmet', helmet);
                formData.append('coat_s', coat_s);
                formData.append('coat_m', coat_m);
                formData.append('coat_l', coat_l);
                formData.append('coat_xl', coat_xl);
                formData.append('coat_xxl', coat_xxl);
                formData.append('coat_xxxl', coat_xxxl);
                formData.append('shirt_s', shirt_s);
                formData.append('shirt_m', shirt_m);
                formData.append('shirt_l', shirt_l);
                formData.append('shirt_xl', shirt_xl);
                formData.append('shirt_xxl', shirt_xxl);
                formData.append('shirt_xxxl', shirt_xxxl);
                formData.append('total_coat', total_coat);
                formData.append('total_shirt', total_shirt);
                if (coat_s == "" && coat_m == "" && coat_l == "" && coat_xl == "" && coat_xxl == "" && coat_xxxl == "" && shirt_s == "" && shirt_m == "" && shirt_l == "" && shirt_xl == "" && shirt_xxl == "" && shirt_xxxl == "") {
                    alert("Hãy nhập ít nhất 1 số lượng đồng phục !")
                }else if(coat_s == data.detail.coat.s && coat_m == data.detail.coat.m && coat_l == data.detail.coat.l && coat_xl == data.detail.coat.xl && coat_xxl == data.detail.coat.xxl && coat_xxxl == data.detail.coat.xxxl && shirt_s == data.detail.shirt.s && shirt_m == data.detail.shirt.m && shirt_l == data.detail.shirt.l && shirt_xl == data.detail.shirt.xl && shirt_xxl == data.detail.shirt.xxl && shirt_xxxl == data.detail.shirt.xxxl ){
                    alert("Dữ liệu chỉnh sửa trùng với dữ liệu cũ !")
                }
                else {
                    $.ajax({
                        url: '{{$editUrl}}',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $(".theloading").show();
                        },
                        success: function (data) {
                            $(".theloading").hide();
                            console.log(data);
                            if (data.status == 200) {
                                $('#successModal').modal('show')
                                $('.msg_success').text("Chỉnh sửa thành công")
                                setTimeout(function () {
                                   window.parent.postMessage({targetLink: "{{$storagePath}}"}, "{{$cpanelPath}}");
                                }, 500);
                            } else {
                                $('#errorModal').modal('show')
                                $('.msg_error').text(data.message)
                            }
                        },
                        error: function () {
                            $(".theloading").hide();
                            $('#modal-danger').modal('show')
                            $('.msg_error').text("error")
                        }
                    });
                }

            })

        });
    </script>
@endsection


