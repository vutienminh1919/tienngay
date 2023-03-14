<section id="thebreadcrumb">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
      </ol>
    </nav>
  </div>
</section>


<section id="PawnNow">
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-xs-12 ">
        <h2 class="sectiontitle">Chọn tài sản bạn muốn cầm</h2>
      </div>
      <!-- PC -->
      <div id="PawnNowPC" class="col-xs-12  col-xl-10 d-none d-lg-block">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowbike.png" alt="">
              XE MÁY
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowcar.png" alt="">
              Ô TÔ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowbikelicense.png" alt="">
              ĐĂNG KÝ XE MÁY
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowcarlicense.png" alt="">
              ĐĂNG KÝ Ô TÔ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowlaptop.png" alt="">
              LAPTOP
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type1" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowmb.png" alt="">
              ĐIỆN THOẠI
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowPC_Type2" role="tab" data-toggle="tab">
              <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowothers.png" alt="" >
              KHÁC
            </a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade active show" id="PawnNowPC_Type1">
            <div class="card" >
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-xs-12  col-xl-8">

                    <h5 class="card-title">Nhập số điện thoại đăng ký vay</h5>
                    <form>
                      <div class="form-group">
                        <span class="noticemark">*</span>
                        <input type="text" class="form-control"  placeholder="Số di động liên hệ">
                        <span class="d-block mt-3" style="color:#777777"> <span class="text-danger">*</span> Thông tin bắt buộc</span>
                      </div>

                      <button type="submit" class="btn btn-teacup flat">XÁC NHẬN</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div role="tabpanel" class="tab-pane fade" id="PawnNowPC_Type2">
            <div class="card" >
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-xs-12  col-xl-8">

                    <h5 class="card-title">Nhập số điện thoại đăng ký vay</h5>
                    <form>
                      <div class="form-group">
                        <input type="text" class="form-control"  placeholder="Mô tả tài sản bạn muốn cầm cố">
                      </div>
                      <div class="form-group">
                        <span class="noticemark">*</span>
                        <input type="text" class="form-control"  placeholder="Số di động liên hệ">
                        <span class="d-block mt-3" style="color:#777777"> <span class="text-danger">*</span> Thông tin bắt buộc</span>
                      </div>

                      <button type="submit" class="btn btn-teacup flat">XÁC NHẬN</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MB -->
      <div id="PawnNowMB" class="col-xs-12  col-xl-10 d-lg-none">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvbike.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowbike.png" alt="">
              </div>

              XE MÁY
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvcar.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowcar.png" alt="">
              </div>

              Ô TÔ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvcar.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowcar.png" alt="">
              </div>

              ĐĂNG KÝ XE MÁY
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvcar.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowcar.png" alt="">
              </div>

              ĐĂNG KÝ Ô TÔ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvlaptop.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowlaptop.png" alt="">
              </div>

              LAPTOP
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type1" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/psvphone.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/pawnnowphone.png" alt="">
              </div>

              ĐIỆN THOẠI
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#PawnNowMB_Type2" role="tab" data-toggle="tab">
              <div class="theimg">
                <img class="inactive" src="<?php echo base_url();?>assets/home/images/icon/menuicon.png" alt="">
                <img class="active" src="<?php echo base_url();?>assets/home/images/icon/menuicon.png" alt="">
              </div>

              KHÁC
            </a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade active show" id="PawnNowMB_Type1">
            <div class="card" >
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-xs-12  col-xl-8">

                    <h5 class="card-title">Nhập số điện thoại đăng ký vay</h5>
                    <form>
                      <div class="form-group">
                        <span class="noticemark small">*</span>
                        <input type="text" class="form-control form-sm"  placeholder="Số di động liên hệ">
                        <span class="d-block mt-3" style="color:#777777"> <span class="text-danger">*</span> Thông tin bắt buộc</span>
                      </div>

                      <button type="submit" class="btn btn-teacup">XÁC NHẬN</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div role="tabpanel" class="tab-pane fade" id="PawnNowMB_Type2">
            <div class="card" >
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-xs-12  col-xl-8">

                    <h5 class="card-title">Nhập số điện thoại đăng ký vay</h5>
                    <form>
                      <div class="form-group">
                        <input type="text" class="form-control form-sm"  placeholder="Mô tả tài sản bạn muốn cầm cố">
                      </div>
                      <div class="form-group">
                        <span class="noticemark small">*</span>
                        <input type="text" class="form-control form-sm"  placeholder="Số di động liên hệ">
                        <span class="d-block mt-3" style="color:#777777"> <span class="text-danger">*</span> Thông tin bắt buộc</span>
                      </div>

                      <button type="submit" class="btn btn-teacup">XÁC NHẬN</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
