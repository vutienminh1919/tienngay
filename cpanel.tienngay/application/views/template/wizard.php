<!-- PC -->
<div class="pcversion">
  <?php $this->load->view('template/wizard_pc');?>
</div>


<!-- MB -->
<div class="mbversion">
  <?php $this->load->view('template/wizard_mb');?>
</div>

<!-- Upload & confirm image Modal -->
<div class="modal fade" id="UploadConfirmIMG_1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload & xác thực giấy tờ</h4>
      </div>
      <div class="modal-body">
        <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu, Bằng lái xe. Hình ảnh biển số xe. Văn bản scan.</p>

        <p>
          <button class="btn btn-primary" >
            Giấy tờ tuỳ thân
          </button>
          <button class="btn btn-secondary" >
            Bằng lái xe
          </button>
          <button class="btn btn-secondary" >
            Biển số xe
          </button>
          <button class="btn btn-secondary" >
            Văn bản scan
          </button>
          <button class="btn btn-secondary" >
            A4
          </button>
        </p>
        <p>
          <input type='file' class="imgInp" data-preview="imgInp001"  />
        </p>
        <img id="imgInp001" class="w-100" src="https://via.placeholder.com/350x150" alt="">

        <p>
          <small>Lưu ý: Bằng cách tải lên các ảnh, tệp ở đây, bạn đồng ý để chúng được lưu trữ tạm thời trong tập dữ liệu đào tạo của chúng tôi cho mục đích duy nhất là cải thiện công nghệ của Computer Vision Việt Nam.</small>
        </p>
        <p class="text-center">
          <button type="button" class="btn btn-default">Chọn lại</button>
          <button type="button" class="btn btn-primary">Nhận dạng</button>
        </p>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <th scope="row">Mark</th>
              <td>Otto</td>
            </tr>
            <tr>
              <th scope="row">Jacob</th>
              <td>Thornton</td>
            </tr>
          </tbody>
        </table>
        <p class="text-center">
          <button type="button" class="btn btn-primary btn-lg">Áp dụng</button>
        </p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="UploadConfirmIMG_2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload & xác thực giấy tờ</h4>
      </div>
      <div class="modal-body">
        <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu, Bằng lái xe. Hình ảnh biển số xe. Văn bản scan.</p>

        <div class="row">
          <div class="col-xs-12 col-md-6 text-center">
            <p>

              <input type='file' class="imgInp" data-preview="imgInp002"  />
            </p>
            <img id="imgInp002" class="w-100" src="https://via.placeholder.com/350x150" alt="">
            Ảnh giấy tờ tuỳ thân
          </div>
          <div class="col-xs-12 col-md-6 text-center">
            <p>
              <input type='file' class="imgInp" data-preview="imgInp003"  />
            </p>
            <img id="imgInp003" class="w-100" src="https://via.placeholder.com/350x150" alt="">
            Ảnh chân dung
          </div>
        </div>
        <p>
          <small>Lưu ý: Bằng cách tải lên các ảnh, tệp ở đây, bạn đồng ý để chúng được lưu trữ tạm thời trong tập dữ liệu đào tạo của chúng tôi cho mục đích duy nhất là cải thiện công nghệ của Computer Vision Việt Nam.</small>  </p>
          <strong>Ảnh giấy tờ tuỳ thân:</strong>
          <ul>
            <li>Mặt trước rõ, đủ 4 góc.</li>

            <li>Không chụp giấy tờ tuỳ thân photo, chụp thông qua màn hình thiết bị điện tử.</li>
          </ul>
          <strong>  Ảnh chân dung chụp:</strong>
          <ul>
            <li>hụp cận mặt, rõ, thẳng góc, không bị che, không chụp quá xa.</li>

            <li>Không chụp chân dung từ ảnh, chụp thông qua màn hình thiết bị điện tử.</li>
          </ul>


          <p class="text-center">
            <button type="button" class="btn btn-default">Chọn lại</button>
            <button type="button" class="btn btn-primary">Nhận dạng</button>
          </p>
<h1 class="text-center text-primary">  This is a alert—check it out!</h1>

        </div>

      </div>
    </div>
  </div>
  <script>
  if ($(window).width() < 767) {
    $('.pcversion').remove()
  }
  else {
    $('.mbversion').remove()
  }

  $(window).on('load',function(){
    $('#UploadConfirmIMG_2').modal('show');
  });

  function readURL(input,preview) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#'+preview).attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".imgInp").change(function() {
    var thetarget = $(this).data('preview');
    readURL(this,thetarget);
  });
</script>
