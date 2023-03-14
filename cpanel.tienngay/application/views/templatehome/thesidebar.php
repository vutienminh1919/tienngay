<!-- Banner -->
<div class="card thewidget">
  <a href="#">
  <img class="w-100" src="<?php echo base_url();?>assets/home/images/banner/bannerwidget.png" alt="">
  </a>
</div>

<div class="card thewidget">
  <div class="card-header">
    HỎI ĐÁP
  </div>
  <div class="card-body bg-secondary">

    <ul class="faqs">
      <li>
        <a href="#">Sản phẩm/ Dịch vụ</a>
      </li>
      <li>
        <a href="#">Về khoản vay</a>
      </li>
      <li>
        <a href="#">Thanh toán khoản vay</a>
      </li>
    </ul>
  </div>
</div>

<div class="card thewidget">
  <div class="card-header">
    Báo chí nói về chúng tôi
  </div>
  <ul class="list-group list-group-flush">
    <?php for ($i=0; $i < 5; $i++) { ?>
      <li class="list-group-item">
        <ul class="thenews">
          <a href="#" class="theimg" style="background-image:url('https://via.placeholder.com/350x150')">
          </a>
          <li>Vietnamnet.vn</li>
          <li> <i class="fa fa-calendar"></i> 6-10-2019</li>
          <li class="thetitle">
            <a href="#">
              TIEN NGAY dự kiến huy động 100 tỷ đồng trái phiếu
            </a>
          </li>
        </ul>

      </li>
    <?php } ?>

  </ul>
</div>


<div class="card thewidget">
  <div class="card-header">
    Kết nối với chúng tôi
  </div>
  <div class="card-body">
    <ul class="social">
      <li>
        <a href="#">
          <img src="<?php echo base_url();?>assets/home/images/icon/widget_fb.png" alt="">
        </a>
      </li>
      <li>
        <a href="#">
          <img src="<?php echo base_url();?>assets/home/images/icon/widget_youtube.png" alt="">
        </a>
      </li>
      <li>
        <a href="#">
          <img src="<?php echo base_url();?>assets/home/images/icon/widget_tw.png" alt="">
        </a>
      </li>
      <li>
        <a href="#">
          <img src="<?php echo base_url();?>assets/home/images/icon/widget_skype.png" alt="">
        </a>
      </li>
      <li>
        <a href="#">
          <img src="<?php echo base_url();?>assets/home/images/icon/widget_linkedin.png" alt="">
        </a>
      </li>
    </ul>
  </div>
</div>
