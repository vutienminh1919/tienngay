
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
  .block img {
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

      ul.timeline-3 {
  list-style-type: none;
  position: relative;
}
ul.timeline-3:before {
  content: " ";
  background: #d4d9df;
  display: inline-block;
  position: absolute;
  left: 29px;
  width: 2px;
  height: 100%;
  z-index: 400;
}
ul.timeline-3 > li {
  margin: 20px 0;
  padding-left: 20px;
}
ul.timeline-3 > li:before {
  content: " ";
  background: white;
  display: inline-block;
  position: absolute;
  border-radius: 50%;
  border: 3px solid #1D9752;
  left: 20px;
  width: 20px;
  height: 20px;
  z-index: 400;
}
.locked {
  background-color: #e9ecef;
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
            Chi Tiết Nhập Liệu
        </legend>
        <div class="new_report">
            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
        </div>
        <div class="row" style="margin-left: 10px">
            <div class="col-md-6 col-sm-12">
                <label for="campaign_name" class="col-form-label">TÊN CHIẾN DỊCH<span class="text-danger">*</span></label>
                <input disabled type="text" name="campaign_name" id="campaign_name" class="form-control" value="{{$detail->campaign_name}}">
            </div>
        </div>
        <div class="row" style="margin-left: 10px">
            <div class="col-md-2 col-sm-12">
                <label for="code_area" class="col-form-label">TÊN VÙNG&nbsp;<span class="text-danger">*</span></label>
                <select  disabled class="form-control" name="code_area" id="code_area">
                    <option value="">{{$detail->area_name}}</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="store_id" class="col-form-label">PHÒNG GIAO DỊCH&nbsp;<span class="text-danger">*</span></label>
                <select readonly class="form-control store" name="store_id[]" id="store_id" multiple="multiple">
                  @foreach ($detail['stores'] as $i)
                    <option value="{{$i['id']}}" selected >{{$i['store']}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="hits" class="col-form-label">SỐ LƯỢNG TIẾP CẬN&nbsp;<span class="text-danger">*</span></label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="hits" name="hits" value="{{number_format($detail['hits'])}}">
            </div>
        </div>
        <div class="row" style="margin-left: 10px">
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="social" class="form-label">SOCIAL MEDIA&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="social_media" name="social_media" value="{{number_format($detail['social_media'])}}" >
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="pr" class="form-label">PR, BÁO CHÍ, TV&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="pr_tv" name="pr_tv" value="{{number_format($detail['pr_tv'])}}" >
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="kol" class="form-label">KOL/KOC&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="kol_koc" name="kol_koc" value="{{number_format($detail['kol_koc'])}}" >
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="ooh" class="form-label">OOH&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="ooh" name="ooh" value="{{number_format($detail['ooh'])}}">
            </div>
            <div class="col-md-2 col-sm-12" style="padding-top: 5px">
                <label for="other" class="form-label">KHÁC&nbsp;</label>
                <input disabled style="width:100%" type="text" min="0" class="form-control" id="other" name="other" value="{{number_format($detail['other'])}}">
            </div>
            <div class="col-md-12 col-sm-12" style="margin-top:30px;">
                <div class="form-sum">
                    <span>UPLOAD CHỨNG TỪ</span>
                    <div class="form-ips">
                      <input disabled id="imgInput" class="block btn btn-outline-success">
                    </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="row" style="margin-left: 10px; padding-top: 20px;">
            <div class="col-md-3 col-sm-12" style="padding-top: 5px; padding-left: 20px;">
                <label for="other" class="form-label">Người nhập&nbsp;</label>
                <input disabled style="width: fit-content;" type="text" class="form-control" id="created_by" name="created_by" value="{{$detail->created_by}}">
            </div>
            <div class="col-md-3 col-sm-12" style="padding-top: 5px;">
                <label for="other" class="form-label">Thời gian&nbsp;</label>
                <input disabled style="width: fit-content;" type="text" class="form-control" id="created_at" name="created_at" value="{{date('H:i:s d/m/Y', $detail->created_at)}}">
            </div>
        </div>

      
        <div style="display:block;margin-top:30px;margin-left: 30px ;display: flex; " >
            <div style=" text-align:center; position:inherit;">
                <a href='' style="width:200px" class="btn btn-secondary back">Quay lại</a>
            </div>
        </div>
		</div>

  <div class="container my-5"></div>
  <div class="row" style="">
    <div class="col-md-6 card-body" >
      <h4 style="margin-left: 1.6rem;">Lịch sử cập nhật</h4>
      @if (isset($logs))
        <?php $history = isset($logs->logs) ? $logs->logs:[]; ?>
        <ul class="timeline-3 view">
        @for($i = count($history) - 1; $i >= 0; $i--)
        <li>
          <a href="#!" style="text-decoration: none">{{$history[$i]['action']}}</a><br>
          <a href="#!" style="text-decoration: none" class="text-secondary">{{date('H:i:s d/m/Y', $history[$i]['created_at'])}}</a>
          <p class="text-success">{{$history[$i]['created_by']}}</p>
          <p class="">
            @if (isset($history[$i]['data_old']))
            <span class="text-danger">Dữ liệu cũ trước khi chỉnh sửa</span>
              <table class="table table-bordered">
                <thead style="background: #E8F4ED; text-align:center;" class="table-oder">
                  <tr>
                    <th scope="col" style="width:250px;">Social Media</th>
                    <th scope="col" style="width:350px;">Pr, Báo Chí, Tv</th>
                    <th scope="col" style="width:250px;">Kol/Koc</th>
                    <th scope="col" style="width:250px;">Ooh</th>
                    <th scope="col" style="width:250px;">Khác</th>
                    <th scope="col" style="width:250px;">Lượt tiếp cận</th>
                    <th scope="col" style="width:250px;">Phòng giao dịch</th>
                  </tr>
                </thead>
                <tbody style="text-align:center">
                  <tr>
                    <td>{{number_format($history[$i]['data_old']['social_media'])}}</td>
                    <td>{{number_format($history[$i]['data_old']['pr_tv'])}}</td>
                    <td>{{number_format($history[$i]['data_old']['kol_koc'])}}</td>
                    <td>{{number_format($history[$i]['data_old']['ooh'])}}</td>
                    <td>{{number_format($history[$i]['data_old']['other'])}}</td>
                    <td>{{number_format($history[$i]['data_old']['hits'])}}</td>
                    <td>
                      @if (count($history[$i]['data_old']['stores']) > 0)
                        @foreach ($history[$i]['data_old']['stores'] as $st)
                          {{$st['store']. ","}}
                        @endforeach
                      @endif 
                    </td>
                  </tr>
                </tbody>
              </table>
              <span class="text-danger">Chứng từ cũ trước chỉnh sửa</span>
              <table class="table table-bordered">
                <thead style="background: #E8F4ED; text-align:center;" class="table-oder">
                  <tr>
                    <th scope="col" style="width:250px;">Tên chứng từ</th>
                    <th scope="col" style="width:350px;">Đường dẫn</th>
                  </tr>
                </thead>
                <tbody style="text-align:center">
                  @foreach($history[$i]['data_old']['url'] as $item)
                  <tr>
                    <td>{{$item['file_name']}}</td>
                    @if ($item['file_type'] == 'image/jpeg' || $item['file_type'] == 'image/png' || $item['file_type'] == 'image/jpg')
                    <td><img style="width: 80px;height: 30px;" onclick="clickImg(this)" src="{{$item['path']}}"></td>
                    @else
                    <td><a style="font-size:13px; " href="{{$item['path']}}"> {{$item['file_name']}}</a></td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </p>
        </li>
        @endfor
      </ul>
      @endif
    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $("#store_id").selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 100,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });
    $('#store_id')[0].selectize.lock();
    $("#store_id").style.background = "#e9ecef";
  });
</script>

<script type="text/javascript">
    $(".back").on('click', function(e) {
        e.preventDefault();
        window.parent.postMessage({targetLink: "{{$cpanelHistory}}"}, "{{$cpanelPath}}");
    });
      function clickImg(el) {
      var modal = document.getElementById("imgModal");
      // Get the image and insert it inside the modal - use its "alt" text as a caption
      var modalImg = document.getElementById("img01");
      var captionText = document.getElementById("caption");
      modal.style.display = "block";
      modalImg.src = el.src;
      $('.view').attr('hidden', true);
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
      $('.view').attr('hidden', false);
    }
</script>
<script type="text/javascript">
  var imgs = JSON.parse('{!! json_encode($detail->url) !!}');
  console.log(imgs);
  let mine = ['image/jpeg' ,'image/png', 'image/jpg'];
  $.each(imgs, function (key, value) {
    if (mine.includes(value.file_type)) {
      let block = `
        <div class="block" style="width:150px; border:none;">
          <img onclick="clickImg(this)" src="` + value.path + `">
          <input data-fileType ="` + value.file_type +`" data-fileName = "`+ value.file_name + `" multiple type="hidden" name="url[]" id="url" value="` + value.path + `">
        </div>`;
        $('#imgInput').before(block);
    } else {
      let block = `
        <div class="block" style="width:auto; border:none;">
            <a style="font-size:13px; "href="` + value.path + `">` + value.file_name +` </a>
            <input data-fileType ="` + value.file_type +`" data-fileName = "`+ value.file_name + `" multiple type="hidden" name="url[]" id="url" value="` + value.path + `">
        </div>`;
        $('#imgInput').before(block);
    }
  });
</script>
@endsection


