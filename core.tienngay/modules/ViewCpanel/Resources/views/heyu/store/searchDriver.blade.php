@extends('viewcpanel::layouts.master')

@section('title', 'Tra cứu thông tin đồng phục tài xê Heyu')

@section('css')
     <style type="text/css">
         <link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
        /* Style the Image Used to Trigger the Modal */
        .img {
          border-radius: 5px;
          cursor: pointer;
          transition: 0.3s;
        }

        .img:hover {opacity: 0.7;}
        .modal-backdrop {
            display: none !important;
        }

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
            margin-top: 15px;
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
      .block img, video {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
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
        #overlay{
          position: absolute;
          width: 30px;
          height: 30px;
          top: 2px;
          z-index: 3;
          left: 32px;
        }
    </style>
@endsection

 <div id="loading" class="theloading" style="display: none;">
      <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>

 <h3 class="tilte_top_tabs" style="margin-left: 20px">
    Tra cứu thông tin đồng phục tài xế HeyU
 </h3>
 <nav aria-label="breadcrumb" style="margin-left: 20px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{$storagePath}}">Quản lý kho</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tra cứu thông tin đồng phục</li>
  </ol>
</nav>
<input style="width: 300px;display: inline;margin-left: 20px" class="form-control" type="text" value="" id="code" name="code"
       placeholder="Nhập mã tài xế Heyu">
<meta name="csrf-token" content="{{ csrf_token() }}">
<button style="margin-bottom: 4px;" type="submit" class="btn btn-success test">Tìm kiếm</button>
<div class="row" style="padding-top: 20px;margin-left: 20px">
    <div class="col-md-6 col-sm-6 detail">

    </div>

</div>
<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
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

  <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
        </div>
        <div class="modal-body">
          <p class="msg_success text-success"></p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-danger" data-bs-dismiss="modal">Đóng</a>
        </div>
      </div>
    </div>
  </div>
 <div id="imgModal" class="modal">
    <!-- The Close Button -->
    <span class="close" onclick="closeModal(this)">&times;</span>
    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">
    <!-- Modal Caption (Image Text) -->
  </div>

@section('script')
    <script>
        function clickImg(el) {
            var modal = document.getElementById("imgModal");
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modal.style.display = "block";
            modalImg.src = el.src;
        }

        const closeModal = function (el) {
            console.log("close");
            $(el).closest('.modal').hide();
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.test').click(function (event) {
                event.preventDefault();
                let code = $('#code').val();
                let formData = new FormData();
                formData.append('code', code);
                $.ajax({
                    url: '{{$getStatusHeyu}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.detail').html("")
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $(".theloading").hide();
                        console.log(data);
                        if (data.status == 200) {
                            let time = '';
                            if(data.data.receivedUniformAt){
                                time = new Date(data.data.receivedUniformAt);
                                time = time.toLocaleString();
                            }else{
                                time = ""
                            }
                            console.log(time)
                            $('.detail').append('<label>Thông tin tài xế</label><table class="table caption-top"> <thead> <tr> <th style="text-align: center">Mã tài xế</th> <th style="text-align: center;min-width: 150px;">Tên tài xế</th> <th style="text-align: center;min-width: 200px">Size đồng phục tài xế</th> <th style="text-align: center;min-width: 200px">Ảnh tài xế</th><th style="text-align: center;min-width: 250px">Trạng thái</th><th style="text-align: center;min-width: 250px">Thời gian nhận</th> </tr> </thead> <tbody> <tr> <td style="text-align: center">' + data.data.code + '</td><td style="text-align: center">' + data.data.name + '</td><td style="text-align: center">' + (data.data.size ? data.data.size : "")  + '</td><td style="text-align: center"><img onclick="clickImg(this)" style="width:70px;height:" src="' + data.data.avatar + '"></img></td><td style="text-align: center">' + data.message + '</td><td style="text-align: center">' + time + '</td></tr></tbody></table>');
                        } else {
                            console.log(data)
                            $('#errorModal').modal('show')
                            $('.msg_error').text(data.message)
                        }
                    },
                    error: function () {
                        $(".theloading").hide();
                        $('#modal-danger').modal('show')
                        $('.msg_error').text("Có lỗi xảy ra! Vui lòng thử lại")
                    }
                });

            })

        });
        $(".breadcrumb-item").on('click', function(e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            if (targetLink == "" || targetLink == undefined) {
              return;
            }
            window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");
        });
    </script>
@endsection
