<!-- page content -->
<div class="right_col" role="main">
	<?php
		$id_lead = !empty($_GET['id_lead']) ? $_GET['id_lead'] : '';
		$id_contract = !empty($_GET['id_contract']) ? $_GET['id_contract'] : '';
	?>
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Xác thực ảnh và cmnd</h3>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
            <a href="#step-1" class="btn igniter">Xác thực Ảnh</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn disabled" disabled>So khớp CMTND và chân dung</a>
          </div>

        </div>
      </div>


      <form role="form" class="form-horizontal form-label-left">
        <div class="x_panel setup-content" id="step-1">

          <div class="x_content">
            <div class="modal-body">
              <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu, Bằng lái xe. Hình ảnh biển số xe. Văn bản scan.</p>

              <p class="text-center">
                <img id="imgImg_mattruoc" style="width: 200px" src="https://via.placeholder.com/350x350" alt="">
				  <input type="file" id="input_cmt_search" data-preview="imgInp001" style="visibility: hidden;">
              </p>
              <p>
                <small>Lưu ý: Bằng cách tải lên các ảnh, tệp ở đây, bạn đồng ý để chúng được lưu trữ tạm thời trong tập dữ liệu đào tạo của chúng tôi cho mục đích duy nhất là cải thiện công nghệ của Computer Vision Việt Nam.</small>
              </p>
              <p class="text-center">
                <button type="button" class="btn btn-default return_Face_search">Chọn lại</button>
                <button type="button" class="btn btn-primary identification_Face_search">Kiểm tra blacklist</button>
              </p>
                <div class="alert alert-success alert-dismissible text-center" style="display: none">
                </div>
              <div class="alert alert-danger alert-dismissible text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Danger!</strong> Indicates a successful or positive action.
              </div>
              <table class="table table-bordered" style="white-space: normal">
                <tbody id='list_info_Face_search'>
				
                </tbody>
              </table>

            </div>

            <button id="nextBtn_Face_search" class="btn btn-primary nextBtn pull-right" style="display: none" type="button">Tiếp tục</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-2">

          <div class="x_content">
            <div class="modal-body">
              <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu, Bằng lái xe. Hình ảnh biển số xe. Văn bản scan.</p>

              <div class="row">
                <div class="col-xs-12 col-md-6 text-center">
					<img id="imgImg_giayto" style="height: 350px; width: 350px" src="https://via.placeholder.com/350x150" alt="">
                  Ảnh giấy tờ tuỳ thân
                </div>
                <div class="col-xs-12 col-md-6 text-center">
					<img id="imgImg_chandung" style="height: 350px; width: 350px" src="https://via.placeholder.com/350x150" alt="">
                  Ảnh chân dung
                </div>
				  <input type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;"
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


                <div class="row text-center">
                  <button type="button" class="btn btn-default return_Face_Identify">Chọn lại</button>
                  <button type="button" class="btn btn-primary identification_Face_Identify">Nhận dạng</button>
                </div>
				<div class="row">
					<h1 class="text-center text-primary face_identify_results" >  </h1>
				</div>
                <div class="alert alert-danger alert-dismissible text-center">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Danger!</strong> Indicates a successful or positive action.
                </div>

				<button class="btn btn-danger backBtn pull-right" type="button">Back</button>
                <button id="nextBtn_Face_Identify" class="btn btn-primary nextBtn pull-right" style="display: none" type="button">Tiếp tục</button>
				<input type="text" hidden id="idLead_Identify" value="<?php echo $id_lead ?>">
				<input type="text" hidden id="idContract_Identify" value="<?php echo $id_contract ?>">
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>
    </div>
    </div>
    <style>
      .x_content {
        display: inline-block;
        float: none
      }
    </style>
    <script>


    $(document).ready(function () {

      var navListItems = $('div.setup-panel div a'),
      allWells = $('.setup-content'),
      allNextBtn = $('.nextBtn');
      allBackBtn = $('.backBtn');

      allWells.hide();

      navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
        $item = $(this);

        if (!$item.hasClass('disabled')) {
          navListItems.removeClass('active');
          $item.addClass('active');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
        }
      });

      allNextBtn.click(function () {

        var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[required]"),
        isValid = true;
        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
          if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
      });

      allBackBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
        prevStepWizard.click();

      });

      $('div.setup-panel div .btn.igniter').trigger('click');
    });
  </script>
<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script>
