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
        <a href="#">Bản tin TIENGNGAY</a>
      </li>
      <li>
        <a  class="active" href="#">Tuyển dụng</a>
      </li>
    </ul>
  </div>
</section>


<!-- PC version -->
<section class="d-none d-md-block">
  <div class="container pt-5 pb-5">
    <div class="row">
      <div class="col-xs-12  col-lg-8">
        <!-- Featured section -->
        <div class="row mb-3">
          <div class="col-xs-12  col-md-6">
            <div class="card newsitem bg-pawn1" >
              <a href="#">
                <img src="https://via.placeholder.com/409x239" class="featuredimg">
              </a>
              <div class="card-body " style="min-height:240px">

                <a href="#" class="card-title text-light m-0">TIEN NGAY cầm đồ lãi suất thấp tại Hà Nội</a>
                <hr>
                <p class="card-text text-light">Donec sed odio dui. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue....</p>
              </div>
              <div class="card-body bg-secondary p-3">
                <ul class="newsmeta">
                  <li class="text-pawn1"> <i class="fa fa-calendar"></i> 22/33/4444 </li>
                </ul>
              </div>

            </div>
          </div>
          <div class="col-xs-12  col-md-6">
            <?php for ($i=0; $i < 2; $i++) { ?>

            <div class="card newsitem mb-3" >
              <a href="#">
                <img src="https://via.placeholder.com/354x157" class="featuredimg">
              </a>
              <div class="card-body p-0">

                <a href="#" class="card-title m-0">Bật mí cách kiểm tra độ chai pin đơn giả Bật mí cách kiểm tra độ chai pin đơn giả</a>
                <ul class="newsmeta">
                  <li> <i class="fa fa-calendar"></i> 22/33/4444 </li>
                </ul>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>


        <!-- News -->
        <div class="row mb-3">
          <?php for ($i=0; $i < 3; $i++) { ?>
            <div class="col-4">
              <div class="card newsitem" >
                <a href="#">
                  <img src="https://via.placeholder.com/250x145" class="featuredimg">
                </a>
                <div class="card-body">
                  <ul class="newsmeta">
                    <li> <i class="fa fa-calendar"></i> 22/33/4444 </li>
                  </ul>
                  <a href="#" class="card-title line3">Bật mí cách kiểm tra độ chai pin đơn giả Bật mí cách kiểm tra độ chai pin đơn giả</a>
                  <p class="card-text">Donec sed odio dui. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. s. Nulla vitae elit libero, a pharetra augue....</p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mb-3">
          <div class="col-xs-12  ">
            <div class="card thewidget  bg-secondary">
              <ul class="list-group list-group-flush">
                <?php for ($i=0; $i < 5; $i++) { ?>
                  <li class="list-group-item">
                    <ul class="thenews inbody">
                      <a href="#" class="theimg" style="background-image:url('https://via.placeholder.com/350x150')">
                      </a>

                      <li class="thetitle">
                        <a href="#">
                          TIEN NGAY dự kiến huy động 100 tỷ đồng trái phiếu
                        </a>
                      </li>
                      <li> <i class="fa fa-calendar"></i> 6-10-2019</li>
                    </ul>

                  </li>
                <?php } ?>

              </ul>
            </div>
          </div>
        </div>

      </div>
      <div class="col-xs-12  col-lg-4">
        <?php $this->load->view('templatehome/thesidebar', (isset($data))?$data:NULL); ?>
      </div>

    </div>
  </div>
</section>

<!-- Mobile version -->
<section class="d-md-none">
  <div class="container pt-5 pb-5">
    <div class="row">
      <?php for ($i=0; $i < 15; $i++) { ?>
      <div class="col-xs-12 ">
        <div class="card newsitem" >
        <div class="card-body p-0">

          <a href="#" class="card-title noclamp m-0">Bật mí cách kiểm tra độ chai pin đơn giả Bật mí cách kiểm tra độ chai pin đơn giả</a>
          <ul class="newsmeta">
            <li> <i class="fa fa-calendar"></i> 22/33/4444 </li>
          </ul>
        </div>
        <div class="card newsitem mt-1 mb-3" >
          <a href="#">
            <img src="https://via.placeholder.com/359x210" class="featuredimg">
          </a>
          </div>
          <div class="card-body p-0">

            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a class="text-pawn2" href="#">Xem chi tiết >></a>
            <hr>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>

    <div class="row">
      <div class="col-xs-12  text-center">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw text-dark"></i>
      </div>
    </div>
  </div>
</section>
