<div class="right_col" role="main">
  <br>&nbsp;
  <div class="row flex justify-content-center">
      <div class="col-xs-12  col-lg-8">
          <div class="card card-appraise" >
            <div class="card-body">
              <h5 class="card-title">BƯỚC 1: CHỌN TÀI SẢN BẠN MUỐN ĐỊNH GIÁ </h5>
              <ul class="selecttype step1">
                <li>
                  <input id="selecttype_1" type="radio" name="selecttype">
                  <label for="selecttype_1" class="unchecked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_bike.png" alt="">
                  </label>
                  <label for="selecttype_1" class="checked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_bike_checked.png" alt="">
                  </label>
                </li>
                <li>
                  <input id="selecttype_2" type="radio" name="selecttype">
                  <label for="selecttype_2" class="unchecked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_car.png" alt="">
                  </label>
                  <label for="selecttype_2" class="checked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_car_checked.png" alt="">
                  </label>
                </li>
                <li>
                  <input id="selecttype_3" type="radio" name="selecttype">
                  <label for="selecttype_3" class="unchecked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_laptop.png" alt="">
                  </label>
                  <label for="selecttype_3" class="checked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_laptop_checked.png" alt="">
                  </label>
                </li>
                <li>
                  <input id="selecttype_4" type="radio" name="selecttype">
                  <label for="selecttype_4" class="unchecked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_phone.png" alt="">
                  </label>
                  <label for="selecttype_4" class="checked">
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_phone_checked.png" alt="">
                  </label>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">BƯỚC 2: NHẬP THÔNG TIN TÀI SẢN </h5>
              <div class="form-group m-0 step2 d-none">
                <input type="text" class="form-control" placeholder="Hãng dòng, năm sản xuất. VD HonDa, 2018">
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">BƯỚC 3: CHỌN KHẤU HAO SẢN PHẨM</h5>
              <div class="step3 d-none">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" value="" id="formCheck1">
                  <label class="form-check-label" for="formCheck1">
                     Xe đã qua sửa chữa nhiều lần
                  </label>
                </div>
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" value="" id="formCheck2">
                  <label class="form-check-label" for="formCheck2">
                    Bổ máy
                  </label>
                </div>
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" value="" id="formCheck3">
                  <label class="form-check-label" for="formCheck3">
                    Đã hai năm không sử dụng
                  </label>
                </div>
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" value="" id="formCheck4">
                  <label class="form-check-label" for="formCheck4">
                    Xe bị tai nạn nhiều lần
                  </label>
                </div>
              </div>


            </div>
            <div class="card-body">
              <button class="btn btn-lg btn-success w-100 thesubmit" disabled>ĐỊNH GIÁ</button>
            </div>
            <div class="card-body result d-none">
              <h5 class="card-title text-pawn1">KẾT QUẢ ĐỊNH GIÁ:</h5>
              <div class="card-text">
                Xe bạn có trị giá 5.000 vnđ
              </div>
            </div>
          </div>

      </div>

    </div>
</div>

<script>
  $('.step1 input').change(function(event) {
    $('.step2').removeClass('d-none')
  });
  $('.step2 input').change(function(event) {
    $('.step3').removeClass('d-none')
  });
  $('.step3 input').change(function(event) {
    $('.thesubmit').removeAttr('disabled');
  });
  $('.thesubmit').click(function(event) {
    $('.result').removeClass('d-none')
  });
</script>
