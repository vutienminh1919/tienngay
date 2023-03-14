
@extends('viewcpanel::layouts.master')
@section('title', 'Nhập liệu chi phí truyền thông')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" rel="stylesheet"/>
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
      width: 200px;
      height: 50px;
      padding: 9px;
      margin-right: 15px;
      margin-bottom: 35px;
      background-color: #fff;
      border: 1px solid #ccc;
      margin-top: 15px;
      margin-right: 10px;
      border:none;
    }
  .block img, video {
    position: absolute;
    left: 0;
    top: 50%;
    width: 150px;
    height: 40px;
    transform: translateY(-50%);
  }
  .box {
    justify-content: center;
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
    width: 75px;
    height: 75px;
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
      .form-sum {
        display: flex;
        flex-direction: column;
        gap: 5px;

      }
      .form-sum span {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
      }
      .form-ips {
        display: flex;
        padding: 20px 20px;
        border: 1px solid #D8D8D8;
border-radius: 5px;
padding: 16px;
      }
      .form-ip button {
        padding: 30px 20px;
      }
      #file {
        opacity: 0;
        position: absolute;
        z-index: -1;
      }

      .btn-xy > label {
        cursor: pointer;
        padding: 10px 20px;
        width: 100%;
      }
      .btn-xy {
        height:50px;
        padding: 10px 0px;
        background-color: #ffffff;
        border: 1px solid #1d9752;
        border-radius: 4px;
        color: #1d9752;
        display: flex;
    align-items: center;
      }
      .form-iten {
        display: flex;
        align-items: center;
      }
      /* .box {
            display: inline-block;
            width: 55px;
            height: 55px;
            background-color: white;
            border: 3px dashed #B5B5B5;
            color: #B5B5B5;
            font-size: 30px;
            text-align: center;
        } */
      .swal2-container.swal2-center>.swal2-popup {
        margin-top: -600px;
      }
</style>
@endsection

@section('content')
    <section class="main-content">
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
        <div class="create_record">
            <div id="loading" class="theloading" style="display: none;">
                <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            </div>
        </div>
        <legend class="col-md-6" style="margin-left: 20px">
            Nhập Dữ Liệu
        </legend>
        <div class="new_report">
            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
        </div>

        <div class="row" style="margin-left: 10px">
        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-2 col-sm-12">
                <label for="campaign_name" class="col-form-label">TÊN CHIẾN DỊCH<span class="text-danger">*</span></label>
                <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Nhập tên chiến dịch">
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="code_area" class="col-form-label">TÊN VÙNG &nbsp;<span class="text-danger">*</span></label>
                <select class="form-control" name="code_area" id="code_area">
                    <option value="" >--Chọn Vùng--</option>
                      @foreach($code_area as $i)
                          <option value="{{$i['code']}}">{{$i['title']}}</option>
                      @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="store_id" class="col-form-label">PHÒNG GIAO DỊCH&nbsp;<span class="text-danger">*</span></label>
                <select class="form-control store" name="store_id" id="store_id" >
                    <option value="" >--Chọn PGD--</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="store_id" class="col-form-label">SỐ LƯỢNG TIẾP CẬN</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="hits" name="hits" placeholder="Nhập số lượng tiếp cận" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
            </div>
        </div>
        <div class="row" style="margin-left: 10px">
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="social" class="form-label">SOCIAL MEDIA&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="social_media" name="social_media" placeholder="Nhập chi phí" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="pr" class="form-label">PR, BÁO CHÍ, TV&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="pr_tv" name="pr_tv" placeholder="Nhập chi phí" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="kol" class="form-label">KOL/KOC&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="kol_koc" name="kol_koc" placeholder="Nhập chi phí" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69" >
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="ooh" class="form-label">OOH&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="ooh" name="ooh" placeholder="Nhập chi phí" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="other" class="form-label">KHÁC&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="other" name="other" placeholder="Nhập chi phí" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
            </div>
            <div class="col-md-12 col-sm-12" style="margin-top:30px;">
                <div class="form-sum">
                    <span>UPLOAD CHỨNG TỪ</span>
                    <div class="form-ips">
                      <div id="imgInput" class="block btn ">
                      <label for="file"><div class="box btn btn-outline-success"style="border:1px solid greend">Thêm chứng từ +</div></label>   
                      <input type="file" id="file" name="file[]" style="display: none;" multiple="multiple">
                    </div>
                    </div>
                </div>
            </div>
        </div>

      
        <div style="display:block;margin-top:30px;margin-left: 6px">
            <div style="margin-top:10px;">
                <button style="width:200px;margin-left:10px" id="typeCreate" type="submit" class="btn btn-success">Nhập thông tin</button>
                <a href="" style="width:200px" class="btn btn-secondary back">Hủy</a>
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
                        <a id="redirect-url" class="btn btn-success" data-dismiss="modal">Đóng</a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#typeCreate').click(function (event) {
                event.preventDefault();
                let campaign_name = $('#campaign_name').val();
                let code_area = $('#code_area').val();
                let store_id = $('#store_id').val();
                let social = $('#social_media').val();
                if (social.indexOf(',')) {
                  social = social.replace(/,/g, '');
                }
                let pr = $('#pr_tv').val();
                if (pr.indexOf(',')) {
                  pr = pr.replace(/,/g, '');
                }
                let kol = $('#kol_koc').val();
                if (kol.indexOf(',')) {
                  kol = kol.replace(/,/g, '');
                }
                let ooh = $('#ooh').val();
                if (ooh.indexOf(',')) {
                  ooh = ooh.replace(/,/g, '');
                }
                let other = $('#other').val();
                if (other.indexOf(',')) {
                  other = other.replace(/,/g, '');
                }
                let file = $('#file').val();
                let hits = $('#hits').val();
                if (hits.indexOf(',')) {
                  hits = hits.replace(/,/g, '');
                }
                let type = {};
                $("input[name='url[]']").each(function (key, value) {
                  let data = {};
                  let url = $(this).val();
                  let name = $(this).attr('data-fileName');
                  let file_type = $(this).attr('data-fileType');
                  data['path'] = url;
                  data['file_name'] = name;
                  data['file_type'] = file_type;
                  // type.push(data);
                  type[key] = data;
                });
                if (campaign_name == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Chưa nhập tên chiến dịch!',
                    })
                    return;
                } else if(code_area == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Chưa có vùng nào được chọn!',
                    })
                    return;
                } else if (store_id == "") {
                  Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Chưa có phòng giao dịch nào được chọn!',
                    })
                    return;
                } else if (social == "" && pr == "" && kol == "" && ooh == "" && other == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Hãy nhập ít nhất một chi phí!',
                    })
                    return;
                } else if (social < 0 || pr < 0 || kol < 0 || ooh < 0 || other < 0) {
                  Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Số tiền không được nhỏ hơn 0! Kiểm tra lại số tiền',
                    })
                    return;
                }else if (Object.keys(type).length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra...',
                        text: 'Chưa có chứng từ được upload!',
                    })
                    return;
                }
                let formData = new FormData();
                formData.append('campaign_name', campaign_name);
                formData.append('code_area', code_area);
                formData.append('store_id', store_id);
                formData.append('social_media', social);
                formData.append('pr_tv', pr);
                formData.append('kol_koc', kol);
                formData.append('ooh', ooh);
                formData.append('other', other);
                formData.append('url', JSON.stringify(type));
                formData.append('hits', hits);
                formData.append('_token', $('input[name="_token"]').val());
                console.log(formData);
                $.ajax({
                  dataType: 'json',
                  enctype: 'multipart/form-data',
                  url: '{{route("viewcpanel::macom.cost.save")}}',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                      console.log(data.data)
                      if (data['status'] == 200) {
                        Swal.fire({
                          title: 'Thông báo',
                          text: "Nhập dữ liệu thành công",
                          icon: 'success',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Tiếp tục tạo!',
                          cancelButtonText: 'Quay lại trang báo cáo!',
                          allowOutsideClick: false
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.assign("{{route('viewcpanel::macom.cost.create')}}");
                          } else if (result.dismiss === Swal.DismissReason.cancel){
                            window.location.assign("{{route('viewcpanel::macom.cost.index')}}");
                          }
                        })
                      } else {
                          Swal.fire({
                          icon: 'error',
                          title: 'Có lỗi xảy ra...',
                          text: data.message,
                        })
                      }
                  },
                });

            });
            $("#code_area").on('change', function() {
                let code_area = $(this).val();
                if (code_area != "") {
                    $("#social_media").prop('disabled', false);
                    $("#pr_tv").prop('disabled', false);
                    $("#kol_koc").prop('disabled', false);
                    $("#ooh").prop('disabled', false);
                    $("#other").prop('disabled', false);
                    $("#hits").prop('disabled', false);
                } else {
                    $("#social_media").prop('disabled', true);
                    $("#pr_tv").prop('disabled', true);
                    $("#kol_koc").prop('disabled', true);
                    $("#ooh").prop('disabled', true);
                    $("#other").prop('disabled', true);
                    $("#hits").prop('disabled', true);
                }
                let form = new FormData();
                form.append('code_area', code_area);
                form.append('_token', $('input[name="_token"]').val());
                $.ajax({
                  dataType: 'json',
                  enctype: 'multipart/form-data',
                  url: '{{route("viewcpanel::macom.cost.getStoreByCodeArea")}}',
                  type: 'POST',
                  data: form,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                      if (data['status'] == 200) {
                        var select = $("#store_id");
                        select.selectize()[0].selectize.destroy();
                        select.html('');
                        $('#store_id').append('<option value="">' + "--Chọn PGD--" + '</option>');
                        $.each(data.data, function(key, value){
                          $('#store_id').append('<option value="' + value['_id'] + '">' + value['name'] + '</option>');
                        });
                        select.selectize({
                          maxItems: 1000,
                          plugins: ["remove_button"],
                        });
                      } else if (typeof(data) == "string") {
                        $("#errorModal").find(".msg_error").text(data);
                        $("#errorModal").modal('show');
                      }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                    $("#errorModal").modal('show');
                  }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(".back").on('click', function(e) {
            e.preventDefault();
            window.parent.postMessage({targetLink: "{{$cpanelUrl}}"}, "{{$cpanelPath}}");
        });
        var numDocuments = 0;
        var numDocumentsProcessed = 0;
        function processFiles() {
        numDocuments = files.length;
        for (var i = 0, f; (f = files[i]); i++) {
            var fileReader = new FileReader();
            fileReader.onloadend = (function (file) {
            return function (evt) {
                doSomethingWithFile(evt, file);
            };
            })(f);
            fileReader.readAsDataURL(f);
        }
        }
        function onFilesSelected(event) {
        files = event.target.files; // FileList object
        processFiles();
        }
        function doSomethingWithFile(evt, file) {
        var key = file.name;
        var value = evt.target.result;
        var container = document.getElementById("image-container");
        var image = document.createElement("img");
        image.src = evt.target.result;
        container.appendChild(image);
        if (++numDocumentsProcessed === numDocuments) {
            //final steps after final image processed
        }
        }
        document
        .getElementById("files")
        .addEventListener("change", onFilesSelected, false);
    </script>
    <script type="text/javascript">

      function clickImg(el) {
        var modal = document.getElementById("imgModal");
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        modal.style.display = "block";
        modalImg.src = el.src;
      }

      function clickVideo(el) {
        var targetLink = $(el).find("source").first().attr('src');
        window.open(targetLink);
      }

      // Get the <span> element that closes the modal
      // When the user clicks on <span> (x), close the modal
      const closeModal = function(el) {
        console.log("close");
        $(el).closest('.modal').hide();
      }

      function deleteImage(el) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")){
          $(el).closest(".block").remove();
          $('#imgInput').find('[type="file"]').first().val('');
        }
      }

      const uploadImgs = async function (file) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', $('input[name="_token"]').val());
        var mine = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 
        'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 
        'application/xls', 'application/x-xls', 'application/excel', 'application/download', 
        'application/vnd.ms-office', 'application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip', 
        'image/jpeg', 'image/png', 'image/jpg', 'application/octet-stream',
        'application/vnd.ms-office','application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 
        'application/msword', 'application/x-zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'];
        if(mine.includes(file.type)) {

        } else {
            Swal.fire({
              icon: 'error',
              title: 'Có lỗi xảy ra...',
              text: 'File upload sai định dạng!',
            })
          return;
        }

        await $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{route("viewcpanel::macom.cost.uploadLicense")}}',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
                if (data && data.code == 200) {
                  console.log(data)
                  if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                    let block = `
                    <div class="block" style="width:150px; border:none;">
                        <img onclick="clickImg(this)" src="` + data.path + `">
                        <input data-fileType ="` + file.type +`" data-fileName = "`+ data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                          <i class="fa fa-times-circle"></i>
                        </button>
                    </div>

                      `;
                    $('#imgInput').before(block);
                  } else {
                    let block = `
                    <div class="block" style="width:auto; border:none;">
                        <a style="font-size:13px; "href="` + data.path + `">` +data.raw_name+` </a>
                        <input data-fileType ="` + file.type +`" data-fileName = "`+ data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                          <i class="fa fa-times-circle"></i>
                        </button>
                    </div>

                      `;
                    $('#imgInput').before(block);
                  }
                if (typeof(data) == "string") {
                  $("#errorModal").find(".msg_error").text(data);
                  $("#errorModal").modal('show');
                }
            }
          }
        });
      }
    $(document).ready(function () {
      $('input[type=file]').on('change', function () {
        var files = $(this)[0].files;
        for(let i = 0; i < files.length; i++) {
            let file = files[i];
            uploadImgs(file);
        }
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
      $(document).ajaxStart(function() {
        $("#loading").show();
        var loadingHeight = window.screen.height;
        $("#loading, .right-col iframe").css('height', loadingHeight);
        }).ajaxStop(function() {
          $("#loading").hide();
      });
      $('#social_media').keyup(function (event) {
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
      $('#pr_tv').keyup(function (event) {
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
      $('#kol_koc').keyup(function (event) {
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
      $('#ooh').keyup(function (event) {
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
      $('#other').keyup(function (event) {
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
      $('#hits').keyup(function (event) {
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
  </script>
@endsection


