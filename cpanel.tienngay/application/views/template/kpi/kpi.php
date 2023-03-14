<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3 class="d-inline-block">Báo cáo KPI: Phan Thị Hoài (CSKH)</h3>
        </div>
        <div class="title_right text-right">

          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
             <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
             <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
           </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row top_tiles">
        <div class="col-xs-12 col-md-4">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text"></i></div>
            <br>
            <h3>Gốc còn lại quá hạn</h3>
            <div class="count">123.000.000 đ</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text-o"></i></div>
            <br>
            <h3>Gốc còn lại đang cho vay</h3>
            <div class="count">123.000.000 đ</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-o"></i></div>
            <br>
            <h3>Doanh số giải ngân</h3>
            <div class="count">123.000.000 đ</div>
          </div>
        </div>
      </div>

    </div>


    <div class="col-xs-12">
      <div class="row tile_count">
        <div class="col-md-4 col-xs-12 tile_stats_count">
          <div class="x_panel h-100">
            <div class="count" style="text-align: right">
              <span class="count_top" style="float:left"><i class="fa fa-user"></i> Gốc còn lại quá hạn</span>
              2500
            </div>
            <p class="count_bottom"><i class="green">T+ 4: </i> <span style="float:right">122 triệu - 10 HS</span>   </p>
            <p class="count_bottom"><i class="green">T+ 10: </i> <span style="float:right">122 triệu - 10 HS</span> </p>
          </div>

        </div>

        <div class="col-md-4 col-xs-12 tile_stats_count">
          <div class="x_panel h-100">
            <div class="count" style="text-align: right">
              <span class="count_top" style="float:left"><i class="fa fa-user"></i> Gốc còn lại đang cho vay</span>
              2500
            </div>

            <p class="count_bottom"><i class="green">Số hợp đồng: </i> <span style="float:right">30 HS</span>   </p>
          </div>
        </div>
        <div class="col-md-4 col-xs-12 tile_stats_count">
          <div class="x_panel h-100">
            <div class="count" style="text-align: right">
              <span class="count_top" style="float:left"><i class="fa fa-user"></i>Doanh số giải ngân</span>
              2500
            </div>

            <p class="count_bottom"><i class="green">Số hợp đồng: </i> <span style="float:right">40 HS</span>   </p>
            <p class="count_bottom"><i class="green">KH mới: </i> <span style="float:right">20 HS</span> </p>
          </div>
        </div>

      </div>
    </div>
    <?php $this->load->view('template/kpi/kpi_danhsachlead');?>

    <?php $this->load->view('template/kpi/kpi_hopdong');?>

    <?php $this->load->view('template/kpi/kpi_danhsachleadv2');?>

    <?php $this->load->view('template/kpi/kpi_danhsachleadv3');?>

    <?php $this->load->view('template/kpi/kpi_vung');?>

        <?php $this->load->view('template/kpi/kpi_vungv2');?>

    <?php $this->load->view('template/kpi/kpi_detailvung');?>

  </div>
</div>
<!-- /page content -->
