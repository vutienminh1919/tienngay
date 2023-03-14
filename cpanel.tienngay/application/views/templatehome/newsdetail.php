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
  <div class="container pt-5 pb-5">
    <div class="row">
      <div class="col-xs-12  col-lg-8">
        <h1 class="singleNews_title">TIEN NGAY cầm đồ lãi suất thấp tại Hà Nội</h1>
        <div class="singleNews_meta">
          <div class="meta_left">
            <ul class="newsmeta">
              <li> <i class="fa fa-calendar"></i> 22/33/4444 </li>
            </ul>
          </div>
          <div class="meta_right">
            <!-- - Code Twitter & Facebook like here - -->
          </div>
        </div>
        <hr>
        <div class="thecontent wysiwyg">
          <p>Donec sed odio dui. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Donec ullamcorper nulla non metus auctor fringilla. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam porta sem malesuada magna mollis euismod. Aenean eu leo quam.</p>
          <p>Donec sed odio dui. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Donec ullamcorper nulla non metus auctor fringilla. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam porta sem malesuada magna mollis euismod. Aenean eu leo quam.</p>
        </div>
        <hr class="d-none d-lg-block">

        <div class="relatedpost_pc d-none d-lg-block">
          <strong class="relatedpost_title">Bài viết liên quan</strong>
          <div class="row">
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
                    <a href="#" class="card-title">Bật mí cách kiểm tra độ chai pin đơn giả Bật mí cách kiểm tra độ chai pin đơn giả</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>


        <div class="row mb-3">
          <div class="col-xs-12  mb-3 mt-5">
            <strong style="font-size:18px;color:#2B2B2B">
              Bài viết liên quan
            </strong>
          </div>
          <div class="col-xs-12  ">
            <div class="card thewidget m-0">
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

      <div class="col-xs-12  col-lg-4 d-none d-lg-block">
        <?php $this->load->view('templatehome/thesidebar', (isset($data))?$data:NULL); ?>
      </div>

    </div>
  </div>
</section>
