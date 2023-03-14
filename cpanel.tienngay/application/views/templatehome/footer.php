</div>
<footer id="thefooter" class="footer">
  <div class="container">
    <div class="row footer-top">

      <div class="col-xs-12  col-md-4 col-xl-3 order-1">
        <div class="d-flex justify-content-between align-items-center">
          <img src="<?php echo base_url();?>assets/home/images/logo.png" alt="logo" class="d-block mb-4 footerlogo"/>

          <div class="mb-4 d-md-none">
            <a class="d-inline-block" href="#"><i class="fa fa-lg fa-facebook-square" aria-hidden="true"></i></a>
            <a class="d-inline-block" href="#"><i class="fa fa-lg fa-youtube-square" aria-hidden="true"></i></a>
          </div>
        </div>


        <ul class="footercontact">
          <li>
            <a href="mailto:contact@next68.vn">
              <i class="icofont icofont-envelope-open"></i> contact@next68.vn
            </a>
          </li>
          <li>
            <a href="tel:0989686868">
              <i class="icofont icofont-phone"></i> 0989686868
            </a>
          </li>
          <li>
            <a href="https://goo.gl/maps/svu3JLu9GUgtTPPG6">
              <i class="icofont icofont-location-pin"></i> Toà nhà VTC Online, Số 18 Tam Trinh, Quận Hai Bà Trưng, Hà Nội.
            </a>
          </li>
        </ul>

      </div>
      <div class="d-none d-xl-block col-xl-1 order-md-3">

      </div>
      <div class="col-xs-12  col-md-4 col-xl-4 order-3">
        <hr class="d-md-none">
        <h3 class="footertitle">HỆ THỐNG PHÒNG GIAO DỊCH TIỆN NGAY</h3>
        <hr class="d-none d-md-block">
        <ul class="footerinfo ">
          <li> <a href="#"> Tienngay Hà Nội</a></li>
          <li> <a href="#"> Tienngay Vĩnh Yên</a></li>
          <li>  <a href="#">Tienngay Băc Giang</a></li>
          <li> <a href="#"> Tienngay Hồ Chí Minh</a></li>
          <li> <a href="#"> Tienngay Hải Phòng</a></li>
          <li><a href="#">  Tienngay Bắc Ninh</a></li>
          <li> <a href="#"> Tienngay Thanh Hóa</a></li>
          <li><a href="#">  Tienngay Thái Bình</a></li>
        </ul>
      </div>
      <div class="d-none d-xl-block col-xl-1 order-md-4">

      </div>
      <div class="col-xs-12  col-md-4 col-xl-3 order-2 order-md-4">
        <hr class="d-md-none">
        <h3 class="footertitle">THÔNG TIN CHUNG</h3>
        <hr class="d-none d-md-block">
        <ul class="footerinfo mb3col">
          <li> <a href="#"> Giới thiệu</a></li>
          <li> <a href="#"> Mạng lưới</a></li>
          <li><a href="#">  Liên Hệ</a></li>
          <li> <a href="#"> Dịch vụ</a></li>
          <li> <a href="#"> Tin tức</a></li>
        </ul>
      </div>
    </div>
    <div class="row footer-top">
      <div class="col-xs-12  col-md-4 col-xs-12  d-none d-md-block">
        <hr class="d-none d-md-block">
      </div>
      <div class="col-xs-12  col-md-8 col-xs-12  d-none d-md-block">

      </div>
      <div class="col-xs-12  d-none d-md-block">


        <div class="row align-items-center">


          <div class="col-6 ">
            <div class="footerhotline">
              <p>HOTLINE</p>
              <a href="tel:1800 6868">1800 6868</a>
            </div>
          </div>
          <div class="col-6 text-right">
            <a class="d-inline-block" href="#"><i class="fa fa-lg fa-facebook-square" aria-hidden="true"></i></a>
            <a class="d-inline-block" href="#"><i class="fa fa-lg fa-youtube-square" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom ">
    <div class="container">
      <div class="row text-center">
        <div class="col-xs-12 ">
          Copyright 2019 © tienngay.vn
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Float C2A : MB  -->
<div id="FloatC2A_MB">
  <a href="#">
  <img src="<?php echo base_url();?>assets/home/images/banner/bannerfloat_mb.png" alt="">
  </a>
</div>
<!-- Float C2A : PC -->
<div id="FloatC2A_PC">
  <div class="card takeloannow ">
    <div class="card-body">
      <h5 class="card-title">ĐĂNG KÝ VAY NGAY</h5>
      <p class="card-text">Chỉ cần có hộ khẩu/KT2/KT3/ tạm trú tại nơi bạn sinh sống</p>
      <form>
        <div class="form-group">
          <input type="text" class="form-control form-sm" placeholder="Số điện thoại" >

        </div>
        <div class="form-group">
          <select class="form-control form-sm">
            <option disabled selected>Tỉnh thành bạn sống</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
        <div class="w-100 text-center">
          <button type="submit" class="btn btn-teacup btn-lg round" style="min-width:150px">GỬI</button>
        </div>
      </form>
    </div>
  </div>

  <button class="btn thec2a" onclick="$('#FloatC2A_PC .card').toggleClass('active')">
    <img src="<?php echo base_url();?>assets/home/images/banner/bannerfloat_pc.png" alt="">
  </button>
</div>

<!-- FLoat Banner -->
<div id="FloatBanner">
  <button class="btn btn-link" onclick="$('#FloatBanner').hide()">
    <i class="fa fa-close"></i>
  </button>
  <a href="#">
    <img src="<?php echo base_url();?>assets/home/images/banner/floatbanner.png" alt="">
  </a>
</div>


<!-- The Menu Modal -->
<div class="modal left fade" id="MenuMB_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <ul>
          <li>
            <a href="#">Giới thiệu</a>
          </li>
          <li>
            <a href="#">Hướng dẫn</a>
          </li>
          <li>
            <a href="#">Phòng giao dịch</a>
          </li>
          <li>
            <a href="#">Hàng thanh lý</a>
          </li>
          <li>
            <a href="#">Tin tức</a>
          </li>
          <li>
            <a href="#">Hỏi đáp</a>
          </li>

        </ul>
      </div>


    </div>
  </div>
</div>
