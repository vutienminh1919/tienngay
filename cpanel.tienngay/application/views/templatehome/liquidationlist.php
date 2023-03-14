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


<section>
  <div class="container pt-5 pb-3">
    <div class="row no-gutters">
      <div class="col-xs-12 ">
        <h2 class="sectiontitle">Sản phẩm thanh lý của TIỆN NGAY</h2>

      </div>
      <div class="col-xs-12  text-center">
        <p>Tất cả các sản phẩm bao gồm ô tô, xe máy, điện thoại, laptop, đồng hồ, trang sức...</p>

      </div>
      <div class="col-xs-12  bg-secondary thecontroller">
        <div class="row justify-content-center">
          <div class="col-xs-12  col-xl-10">
            <div class="row  justify-content-center pl-3 pr-3">

              <div class="form-group mt-4 mb-4 d-flex align-items-center col-4">

                <button class="btn btn-teacup mr-3 h-100">
                  Tất cả
                </button>

                <select class="form-control form-sm" name="">
                  <option disabled selected>Sản phẩm </option>
                  <option>Demo</option>
                </select>


              </div>
              <div class="form-group mt-4 mb-4 d-flex align-items-center col">
                <label class="mb-0 mr-3 nowrapspace">
                  Giá từ
                </label>
                <input type="number" class="form-control form-sm havecurrencty">
                <span class="thecurrency">vnđ</span>

              </div>
              <div class="form-group mt-4 mb-4 d-flex align-items-center col">
                <label class="mb-0 mr-3">
                  Đến
                </label>
                <input type="number" class="form-control form-sm havecurrencty">
                <span class="thecurrency">vnđ</span>

              </div>
              <div class="input-group  mt-4 mb-4 col">
                <input type="text" class="form-control  form-sm" placeholder="Địa chỉ..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-teacup">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xs-12  mt-3">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="text-pawn1">Tìm thấy 12 kết quả phù hợp với:</strong>

          <div class="form-group m-0">
    <select class="form-control form-sm" >
      <option>Giá từ thấp đến cao</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
        </div>
      </div>
    </div>


  </div>
</section>

<section>
  <div class="container mb-5">
    <div class="row">
      <div class="col-xs-12 ">
        <ul class="applygoods bg-transparent mb-4">
          <li class="smaller">
            <img src="<?php echo base_url();?>assets/home/images/icon/pawnnowbike.png" alt="">
            ĐIỆN THOẠI
          </li>

        </ul>
      </div>
    </div>


    <div class="row">
      <?php for ($i=0; $i < 24; $i++) { ?>
        <div class="col-6 col-md-3">
          <div class="card productlistitem shadows">
            <a href="#" class="thesquareimg">
                <img src="https://cdn.chotot.com/RNzfyY0sESur_mil4BFJDXn6tMT6LS26xXAE2U-NYVs/preset:listing/plain/1dfe7396d781822a804eac3d5f5be919-2631112971606956485.jpg"  alt="">
            </a>
            <div class="card-body">
              <div class="row">
                <div class="col-xs-12 ">
                  <a href="#" class="card-title text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit adipisicing elit adipisicing elit </a>
                </div>

                <div class="col-6">
                  <span>Giá mới</span>
                  <strong class="theprice">10.000.000 vnđ</strong>
                </div>
                <div class="col-6">
                  <span>Giá thanh lý</span>
                  <strong class="theprice liquidation">3.000.000 vnđ</strong>
                </div>
              </div>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>


    <ul class="pagination teacup-pagi  justify-content-center">

      <li class="page-item disabled"><a href="#">1</a></li>
      <li class="page-item"><a href="#">2</a></li>
      <li class="page-item"><a href="#">3</a></li>
    </ul>
  </div>
</section>
