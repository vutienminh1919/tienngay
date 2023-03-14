<div id="themenu" class="d-none d-xl-block" >
  <div class="container">
    <nav class="navbar navbar-expand-sm bg-transparent">
      <div class="row flex-grow">
        <div class="col-xs-12  d-lg-flex flex-row mx-auto">
          <a class="navbar-brand" href="#">
            <img src="<?php echo base_url();?>assets/home/images/logo.png" alt="logo" />
          </a>
          <button class="navbar-toggler collapsed float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon ti ti-menu text-white"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link btn btn-link active" href="#">Giới thiệu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-link" href="#">Hướng dẫn</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-link" href="#">Phòng giao dịch</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-link" href="#">Hàng thanh lý</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-link" href="#">Tin tức</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-link" href="#">Hỏi đáp</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <img src="<?php echo base_url();?>assets/home/images/headerhotline.png" alt="" />
                </a>
              </li>

              <li class="nav-item">
                <a class="btn btn-teacup-warning" href="#">
                  <img src="<?php echo base_url();?>assets/home/images/iconheaderpawn.png" alt="" />
                  cầm đồ ngay
                </a>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>
</div>

<div id="themenuMB" class="d-xl-none">
  <div class="container p-0">

    <div class="d-flex justify-content-between align-items-center">

      <div class="">
        <button class="btn btn-link btn-menu border-right" type="button"  data-toggle="modal" data-target="#MenuMB_Modal">
          <img src="<?php echo base_url();?>assets/home/images/icon/menuicon.png" alt="logo" />
        </button>
        <button class="btn btn-link btn-menu" type="button" name="button" onclick="$('#themenuMB .thesearchbox').toggleClass('active')">
          <img src="<?php echo base_url();?>assets/home/images/icon/searchicon.png" alt="logo" />
        </button>
      </div>

      <a  href="#">
        <img class="logo" src="<?php echo base_url();?>assets/home/images/logo.png" alt="logo" />
      </a>

      <a href="#" >
        <img class="hotline" src="<?php echo base_url();?>assets/home/images/headerhotline.png" alt="" />
      </a>
    </div>

  </div>

  <div class="thesearchbox input-group  ">
    <input type="text" class="form-control" placeholder="Search" >
    <div class="input-group-append">
      <button type="button" name="button" class="btn btn-teacup">
        <i class="icofont-search"></i>
      </button>
    </div>
  </div>
</div>

<div id="thecontent">
