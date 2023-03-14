@extends('viewcpanel::layouts.master')
@section('title', 'Thông Tin Tài San Giả Mạo')
@section('css')
    <style type="text/css">
        /* Style the Image Used to Trigger the Modal */
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
        .box {
            display: inline-block;
            width: 55px;
            height: 55px;
            background-color: white;
            border: 3px dashed #B5B5B5;
            color: #B5B5B5;
            font-size: 30px;
            text-align: center;
        }
        .block {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 75px;
            height: 75px;
            padding: 9px;
            margin-right: 15px;
            margin-bottom: 35px;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-right: 10px;
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
      .block img, video{
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
      }

      label {
        font-weight: 500;
      }
      .row div {
        margin-bottom: 25px;
      }
      .main-content {
        width: 90%;
        margin: 0 auto;
      }
      @media (min-width:768px) {
          #mainForm {
            padding-left:50px;
          }
      }

      legend {
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 50px;
        margin-top: 30px;
        color: #009535;
        font-weight: 500;
        text-shadow: rgba(17, 17, 26, 0.3) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
      }
    </style>
@endsection
@section('content')

    <section class="main-content">
        <div class="create_record">
            <div id="loading" class="theloading" style="display: none;">
                <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            </div>
        </div>
        <legend class="col-md-6">
            Thông Tin DKX/CVX Giả Mạo
        </legend>
        <div class="new_report">
        </div>
        <form id="mainForm" action='' method="post" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
            <div class="row col-md-12 col-lg-8">
                <div class="col-md-6 col-sm-6">
                    <label for="user_name" class="form-label">Họ và tên(cá nhân/pháp nhân)&nbsp;<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="user_name" name="user_name"
                           value="{{$property['customer_infor']['name']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['car_owner'])) ? "" : "display:none"}}>
                    <label for="user_name" class="form-label">Họ và tên(không chính chủ)&nbsp;</label>
                    <input type="text" class="form-control" id="user_name" name="user_name"
                           value="{{!empty($property['customer_infor']['car_owner']) ? $property['customer_infor']['car_owner'] : "" }}" disabled>
                </div>

                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['identify'])) ? "" : "display:none"}}>
                    <label for="user_identify" class="form-label">Số CCCD/CMND&nbsp;</label>
                    <input type="text" class="form-control" id="user_identify" name="user_identify"
                           value="{{!empty($property['customer_infor']['identify']) ? $property['customer_infor']['identify'] : "" }}"
                           disabled>
                </div>

                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['passport'])) ? "" : "display:none"}}>
                    <label for="user_identify" class="form-label">Hộ Chiếu&nbsp;<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="user_identify" name="user_identify"
                           value="{{!empty($property['customer_infor']['passport']) ? $property['customer_infor']['passport'] : "" }}"
                           disabled>
                </div>

                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['date_range'])) ? "" : "display:none"}}>
                    <label for="date_range" class="form-label">Ngày cấp&nbsp;</label>
                    <input type="text" class="form-control" id="date_range" name="date_range"
                           value="{{!empty($property['customer_infor']['date_range']) ? $property['customer_infor']['date_range'] : ""}}" disabled>
                </div>

                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['issued_by'])) ? "" : "display:none"}}>
                    <label for="issued_by" class="form-label">Nơi cấp&nbsp;</label>
                    <input type="text" class="form-control" id="issued_by" name="issued_by"
                           value="{{!empty($property['customer_infor']['issued_by']) ? $property['customer_infor']['issued_by'] : "" }}" disabled>
                </div>

                <div class="col-md-6 col-sm-6" style={{(!empty($property['customer_infor']['phone'])) ? "" : "display:none"}}>
                    <label for="user_phone" class="form-label">Số điện thoại&nbsp;</label>
                    <input type="text" class="form-control" id="user_phone" name="user_phone"
                           value="{{!empty($property['customer_infor']['phone']) ? $property['customer_infor']['phone'] : ""}}" disabled>
                </div>

                <div class="col-md-6 col-sm-6">
                    <label for="user_phone" class="form-label">Tài sản&nbsp;</label>
                    <input type="text" class="form-control" id="user_phone" name="user_phone"
                           value="{{$type . " " .  $property['brand_name']}}" disabled>
                </div>

                <div class="col-md-6 col-sm-6">
                    <label for="work_place" class="form-label">Số khung&nbsp;</label>
                    <input type="text" class="form-control" id="work_place" name="work_place"
                           value="{{$property['chassis_number']}}" disabled>
                </div>

                <div class="col-md-6 col-sm-6">
                    <label for="room" class="form-label">Số máy&nbsp;</label>
                    <input type="text" class="form-control" id="room" name="room" value="{{$property['engine_number']}}"
                           disabled>
                </div>

                <div class="col-md-6 col-sm-6">
                    <label for="position" class="form-label">Biển số xe&nbsp;</label>
                    <input type="text" class="form-control" id="position" name="position"
                           value="{{$property['vehicle_number']}}" disabled>
                </div>

                <div class="col-md-6 col-sm-6">
                    <label for="reason_for_leave" class="form-label">Số đăng ký&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['registration']['number']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6">
                    <label for="reason_for_leave" class="form-label">Ngày cấp đăng ký&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['registration']['date_range']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6">
                    <label for="reason_for_leave" class="form-label">Nơi cấp đăng ký&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['registration']['issued_by']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6" style={{ ($property['code'] == "OTO") ? '' : "display:none" }}>
                    <label for="reason_for_leave" class="form-label">Số đăng kiểm&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['inspection']['number']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6" style={{ ($property['code'] == "OTO") ? '' : "display:none" }}>
                    <label for="reason_for_leave" class="form-label">Ngày cấp đăng kiểm&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['inspection']['date_range']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6" style={{ ($property['code'] == "OTO") ? '' : "display:none" }}>
                    <label for="reason_for_leave" class="form-label">Nơi cấp đăng kiểm&nbsp;</label>
                    <input type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"
                           value="{{$property['inspection']['issued_by']}}" disabled>
                </div>
                <div class="col-md-6 col-sm-6">
                    <label for="reason_for_leave" class="form-label">Mô tả&nbsp;</label>
                    <textarea class="form-control" id="reason_for_leave" name="reason_for_leave"
                              disabled>{{$property['description']}}</textarea>
                </div>

                <div class="row">
                    <div class="col-4" id="url">
                        <label class="form-label" style="font-style: 18px">Ảnh đăng ký</label>
                        <div class="img" id="img">
                            <div id="imgInput"></div>
                        </div>
                    </div>
                    <div class="col-4" id="url2">
                        <label class="form-label" style="font-style: 18px">Ảnh đăng kiểm</label>
                        <div class="img" id="img">
                            <div id="imgInput2"></div>
                        </div>
                    </div>
                    <div class="col-4" id="url3">
                        <label class="form-label" style="font-style: 18px">Ảnh khác</label>
                        <div class="img" id="img">
                            <div id="imgInput3"></div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="modal-footer" style="border-top: 2px solid #dee2e6">
            <div style="margin-top:10px;">
            </div>
        </div>

    </section>
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
@endsection

@section('script')
<script type="text/javascript">
    // Get the modal

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
</script>
<script type="text/javascript">
  var imgs = JSON.parse('{!! json_encode($img_dang_ky['path']) !!}');
  var imgs2 = JSON.parse('{!! json_encode($img_dang_kiem['path']) !!}');
  var imgs3 = JSON.parse('{!! json_encode($img_tai_san['path']) !!}');
  const isImg = function (url) {
      return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
  }
  if (imgs.length == 0) {
    $('#imgInput').text("Không có");
  } else {
    for (let i = 0; i < imgs.length; i++) {
      if (isImg(imgs[i].toLowerCase())) {
        let block = `
          <div class="block">
            <img onclick="clickImg(this)" src="` + imgs[i] + `">
            <input type="hidden" name="url[]" value="` + imgs[i] + `">
          </div>`;
          $('#imgInput').before(block);
      } else {
        let block = `
          <div class="block">
              <video onclick="clickVideo(this)">
                  <source src="` + imgs[i] + `">
              </video>
              <input type="hidden" name="url[]" value="` + imgs[i] + `">
          </div>`;
          $('#imgInput').before(block);
      }
    }
  }
  if (imgs2.length == 0) {
    $('#imgInput2').text("Không có");
  } else {
    for (let i = 0; i < imgs2.length; i++) {
      if (isImg(imgs2[i].toLowerCase())) {
        let block = `
          <div class="block">
            <img onclick="clickImg(this)" src="` + imgs2[i] + `">
            <input type="hidden" name="url[]" value="` + imgs2[i] + `">
          </div>`;
          $('#imgInput2').before(block);
      } else {
        let block = `
          <div class="block">
              <video onclick="clickVideo(this)">
                  <source src="` + imgs2[i] + `">
              </video>
              <input type="hidden" name="url[]" value="` + imgs2[i] + `">
          </div>`;
          $('#imgInput2').before(block);
      }
    }
  }
  if (imgs3.length == 0) {
    $('#imgInput3').text("Không có");
  } else {
    for (let i = 0; i < imgs3.length; i++) {
      if (isImg(imgs3[i].toLowerCase())) {
        let block = `
          <div class="block">
            <img onclick="clickImg(this)" src="` + imgs3[i] + `">
            <input type="hidden" name="url[]" value="` + imgs3[i] + `">
          </div>`;
          $('#imgInput3').before(block);
      } else {
        let block = `
          <div class="block">
              <video onclick="clickVideo(this)">
                  <source src="` + imgs3[i] + `">
              </video>
              <input type="hidden" name="url[]" value="` + imgs3[i] + `">
          </div>`;
          $('#imgInput3').before(block);
      }
    }
  }

</script>
@endsection
