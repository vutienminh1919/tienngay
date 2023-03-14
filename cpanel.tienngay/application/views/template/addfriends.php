<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">

        <h3>Add Friends</h3>

      </div>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-7">
          <div class="x_panel">
            <div class="x_title">
              <div class="row">


                <div class="col-lg-9">
                  <input type="text" class="form-control" placeholder="Nhập tên tài khoản người bạn cần tìm...">
                </div>
                <div class="col-lg-3 text-right">
                  <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

                </div>
              </div>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <ul class="list-unstyled top_profiles scroll-view">
                <?php for ($i=0; $i < 12; $i++) { ?>


                <li class="media event">
                  <a class="pull-left border-aero profile_thumb">
                    <i class="fa fa-user aero"></i>
                  </a>
                  <div class="media-body">
                    <a class="title" href="#">Ms. Mary Jane</a>
                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                    <p> <small>12 Sales Today</small>
                    </p>
                    <button class="btn btn-primary btn-action btn-xs ">
                      <i class="fa fa-plus"></i> Thêm bạn
                    </button>
                  </div>
                </li>
                <?php } ?>
              </ul>

            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-5">
          <div class="x_panel">
            <div class="x_title">
              <h2>Danh sách lời mời đã gửi <a class="small" href="#">Xem danh sách bạn bè</a></h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <ul class="list-unstyled top_profiles scroll-view">
                <?php for ($i=0; $i < 12; $i++) { ?>


                <li class="media event">
                  <a class="pull-left border-aero profile_thumb">
                    <i class="fa fa-user aero"></i>
                  </a>
                  <div class="media-body">
                    <a class="title" href="#">Ms. Mary Jane</a>
                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                    <p> <small>12 Sales Today</small>
                    </p>
                    <button class="btn btn-xs btn-action" disabled>
                      <i class="fa fa-user-plus"></i> Đã gửi lời mời
                    </button>
                  </div>
                </li>
                <?php } ?>
              </ul>


            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
<!-- /page content -->
