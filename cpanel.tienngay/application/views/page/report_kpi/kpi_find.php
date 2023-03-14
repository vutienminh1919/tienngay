<?php
  $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
  $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">


    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3 class="d-inline-block">Dashboard</h3>
        </div>
      
      </div>
    </div>
<div class="col-xs-12">
       <div class="row top_tiles">
        <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text"></i></div>
            <br>
            <h3>Doanh số giải ngân</h3>
            <div class="count"><?=(!empty($data->total_so_tien_vay_old->{'$numberLong'})) ? number_format($data->total_so_tien_vay_old->{'$numberLong'}) :  number_format($data->total_so_tien_vay_old) ?> đ</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text-o"></i></div>
            <br>
            <h3>Gốc còn lại đang cho vay</h3>
           <!--  <div class="count"><?=(!empty($data->total_du_no_dang_cho_vay_old)) ? number_format($data->total_du_no_dang_cho_vay_old) : 0 ?> đ</div> -->
            <div class="count"><?=(!empty($data->total_du_no_dang_cho_vay_old->{'$numberLong'})) ? number_format($data->total_du_no_dang_cho_vay_old->{'$numberLong'}) :  number_format($data->total_du_no_dang_cho_vay_old) ?> đ</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-o"></i></div>
            <br>
            <h3>Gốc còn lại quá hạn T+4</h3>
            <div class="count"><?=(!empty($data->total_du_no_qua_han_t4_old)) ? number_format($data->total_du_no_qua_han_t4_old) : 0 ?> đ</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-o"></i></div>
            <br>
            <h3>Gốc còn lại quá hạn T+10</h3>
            <div class="count"><?=(!empty($data->total_du_no_qua_han_t10_old)) ? number_format($data->total_du_no_qua_han_t10_old) : 0 ?> đ</div>
          </div>
        </div>
      </div>

    

    </div>

        <div class="col-xs-12 col-md-6">

          <h3 class="d-inline-block"></h3>
 
          </div>
    <div class="col-xs-12 col-md-6">

        <div class="title_right text-right">


          <form action="<?php echo base_url('report_kpi/kpi_domain') ?>" method="get" >
          <div class="form-inline">
            <div class="form-group">
              <input type="date" class="form-control" name="fdate"  title="From" value="<?= !empty($fdate) ?  $fdate :  date('Y-m-01')?>" >
            </div>
            -
            <div class="form-group">
              <input type="date" class="form-control" name="tdate" title="To" value="<?= !empty($tdate) ?  $tdate : date('Y-m-d')?>" >
            </div>
             <button type="submit" class="btn btn-info m-0" title="Tìm kiếm">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
          </div>
        </form>
        </div>
        <br/>
        </div>
                    <div class="col-xs-12 ">
      <div class="row top_tiles">

        <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
           <!--  <div class="icon"><i class="fa fa-file-o"></i></div> -->
            <br>
            <h3>Giải ngân mới</h3>
            <!-- <div class="count"><?=(!empty($data->total_so_tien_vay)) ? number_format($data->total_so_tien_vay) : 0 ?> đ</div> -->
            <div class="count"><?=(!empty($data->total_so_tien_vay->{'$numberLong'})) ? number_format($data->total_so_tien_vay->{'$numberLong'}) :  number_format($data->total_so_tien_vay) ?> đ</div>
          
          </div>
        </div>
         <div class="col-xs-12 col-md-3">
          <div class="tile-stats">
           <!--  <div class="icon"><i class="fa fa-file-text-o"></i></div> -->
            <br>
            <h3>Đang cho vay </h3>
            <div class="count"><?=(!empty($data->total_du_no_dang_cho_vay)) ? number_format($data->total_du_no_dang_cho_vay) : 0 ?> đ</div>
           
          </div>
        </div>
       


      </div>

    </div>

    <?php $this->load->view('page/report_kpi/kpi_danhsachlead', isset($data) ? $data : NULL);?>

    <?php $this->load->view('page/report_kpi/kpi_hopdong', isset($data) ? $data : NULL);?>
    <?php if((!in_array('giao-dich-vien', $data->groupRoles) && !in_array('cua-hang-truong', $data->groupRoles)) || (in_array('phat-trien-san-pham', $data->groupRoles) || in_array('quan-ly-khu-vuc', $data->groupRoles)) ) { ?>
     <?php $this->load->view('page/report_kpi/kpi_vung', isset($data) ? $data : NULL);?>
     <?php } ?>
<?php if(!in_array('giao-dich-vien', $data->groupRoles)){ ?>
     <?php $this->load->view('page/report_kpi/kpi_pgd', isset($data) ? $data : NULL);?>
     <?php } ?>
<?php if(in_array('giao-dich-vien', $data->groupRoles)){ ?>
   <?php $this->load->view('page/report_kpi/kpi_detailvung', isset($data) ? $data : NULL);?> 
<?php } ?>
  </div>
</div>






<!-- /page content -->
<style type="text/css">
  .tile-stats .icon {
    opacity: 0.1;
}
</style>
