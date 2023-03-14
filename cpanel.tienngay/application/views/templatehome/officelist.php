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

<section id="thesubmenu" >
  <div class="container">
    <ul>
      <li>
        <a href="#">Tài chính</a>
      </li>
      <li>
        <a href="#">Bản tin TIENNGAY</a>
      </li>
      <li>
        <a  class="active" href="#">Tuyển dụng</a>
      </li>
    </ul>
  </div>
</section>

<section class="d-none d-md-block">
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-xs-12 ">
        <h2 class="sectiontitle">Danh sách phòng giao dịch của TIỆN NGAY</h2>

      </div>
      <div class="col-xs-12  text-center">
        <p>Vui lòng chọn một thành phố / tỉnh thành, hoặc chỉ cần gõ địa điểm của bạn để tìm ra chi nhánh gần bạn nhất</p>
        <div class="row  justify-content-center">
          <div class="form-group mb-3 d-flex align-items-center col-3">
            <button class="btn btn-link">
              <img src="<?php echo base_url();?>assets/home/images/icon/iconlocation.png" alt="">
            </button>
            <select class="form-control form-sm" name="">
              <option disabled selected>Chọn tỉnh thành </option>
              <option>Demo</option>
            </select>


          </div>

          <div class="input-group mb-3  col-3">
            <input type="text" class="form-control  form-sm" placeholder="Địa chỉ..." aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-teacup">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12  table-responsive">
        <table class="table table-borderless table-teacup type2 table-striped table-lg table-fixed">

          <tbody class="bg-light">
            <tr>

            </tr>
            <?php for ($i=1; $i < 15; $i++) { ?>
              <tr>
                <td colspan="2">TIEN NGAY 25 Khương Hạ (Gần cầu Khương Đình)</td>
                <td colspan="3">
                  <img src="<?php echo base_url();?>assets/home/images/icon/iconlocation.png" alt=""/>
                  Số 25 hương Hạ - Q. Thanh Xuân - Hà Nội.</td>
                  <td colspan="2">
                    <img src="<?php echo base_url();?>assets/home/images/icon/iconphone.png" alt=""/>
                    024.7323.488</td>
                    <td colspan="2">
                      <img src="<?php echo base_url();?>assets/home/images/icon/iconclock.png" alt=""/>
                      8:30 AM - 21:00 PM</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>


              <ul class="pagination teacup-pagi  justify-content-center mt-3">

                <li class="page-item disabled"><a href="#">1</a></li>
                <li class="page-item"><a href="#">2</a></li>
                <li class="page-item"><a href="#">3</a></li>
              </ul>
            </div>

          </div>


        </div>
      </section>


<section class="d-md-none">
  <div class="containerpt-5 pb-5">
    <div class="col-xs-12 ">
      <h2 class="sectiontitle">Danh sách phòng giao dịch</h2>

    </div>
    <div class="col-xs-12  text-center">
      <p>Vui lòng chọn một thành phố / tỉnh thành, hoặc chỉ cần gõ địa điểm của bạn để tìm ra chi nhánh gần bạn nhất</p>
      <div class="row  justify-content-center">
        <div class="form-group mb-3 d-flex align-items-center col-3">
          <button class="btn btn-link">
            <img src="<?php echo base_url();?>assets/home/images/icon/iconlocation.png" alt="">
          </button>
          <select class="form-control form-sm" name="">
            <option disabled selected>Chọn tỉnh thành </option>
            <option>Demo</option>
          </select>


        </div>

        <div class="input-group mb-3  col-3">
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
</section>
