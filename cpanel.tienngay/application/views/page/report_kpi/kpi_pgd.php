<?php
$tong_chi_tieu=(!empty($data->tong_chi_tieu)) ? number_format($data->tong_chi_tieu) : 0;
$kpi_giai_ngan=(!empty($data->kpi_giai_ngan)) ? number_format($data->kpi_giai_ngan) : 0;
$kpi_kh_moi=(!empty($data->kpi_kh_moi)) ? number_format($data->kpi_kh_moi) : 0;
$kpi_bao_hiem=(!empty($data->kpi_bao_hiem)) ? number_format($data->kpi_bao_hiem) : 0;
$groupRoles=(!empty($data->groupRoles)) ? $data->groupRoles : array();

 ?>

<div class="col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>KPI phòng giao dịch</h2>
       <ul class="nav navbar-right panel_toolbox">
        <li>
          <a target="_blank" href="<?php echo base_url('kpi/listDetailKPI_pgd')?>">
            <i class="fa fa-pie-chart"></i>
            Chi tiết PGD
          </a>
        </li>
        <li>
          <a target="_blank" href="<?php echo base_url('kpi/listDetailKPI_user')?>">
            <i class="fa fa-pie-chart"></i>
            Chi tiết GDV
          </a>
        </li>

      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div id="char_vung">
         <?php 
        

        
         $this->load->view('page/report_kpi/char_pgd', isset($data) ? $data : NULL);
         ?>
        </div>


        </div>
      </div>

    </div>



