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
          <h3 class="d-inline-block">Dashboard bảo hiểm</h3>
        </div>
        <div class="title_right text-right">

          <div class="form-inline">


             <form action="<?php echo base_url('dashboard/baohiem') ?>" method="get" >
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
        </div>
      </div>
    </div>

    <?php $this->load->view('page/dashboard/baohiem/so_luong/total', isset($data_total) ? $data_total : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/giai_ngan/total', isset($data_total) ? $data_total : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/phi/total', isset($data_total) ? $data_total : NULL);?>

  <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
         <div class="dashboarditem_line1 blue">
        <div class="thetitle">
          Bảo hiểm khoản vay
        </div>
      </div>
        </div>
        <div class="title_right text-right">

        
        </div>
      </div>
    </div>
      <?php $this->load->view('page/dashboard/baohiem/so_luong/kv', isset($data_kv) ? $data_kv : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/giai_ngan/kv', isset($data_kv) ? $data_kv : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/phi/kv', isset($data_kv) ? $data_kv : NULL);?>

   
     <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
         <div class="dashboarditem_line1 blue">
        <div class="thetitle">
          Bảo hiểm xe máy (EASY)
        </div>
      </div>
        </div>
        <div class="title_right text-right">

        
        </div>
      </div>
    </div>
      <?php $this->load->view('page/dashboard/baohiem/so_luong/easy', isset($data_easy) ? $data_easy : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/giai_ngan/easy', isset($data_easy) ? $data_easy : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/phi/easy', isset($data_easy) ? $data_easy : NULL);?>
   
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
         <div class="dashboarditem_line1 blue">
        <div class="thetitle">
          Bảo hiểm VBI
        </div>
      </div>
        </div>
        <div class="title_right text-right">

        
        </div>
      </div>
    </div>
  
     <?php $this->load->view('page/dashboard/baohiem/so_luong/vbi', isset($data_vbi) ? $data_vbi : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/giai_ngan/vbi', isset($data_vbi) ? $data_vbi : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/phi/vbi', isset($data_vbi) ? $data_vbi : NULL);?>
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
         <div class="dashboarditem_line1 blue">
        <div class="thetitle">
          Bảo hiểm Phúc Lộc Thọ
        </div>
      </div>
        </div>
        <div class="title_right text-right">

        
        </div>
      </div>
    </div>
  
     <?php $this->load->view('page/dashboard/baohiem/so_luong/plt', isset($data_plt) ? $data_plt : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/giai_ngan/plt', isset($data_plt) ? $data_plt : NULL);?>

    <?php $this->load->view('page/dashboard/baohiem/phi/plt', isset($data_plt) ? $data_plt : NULL);?>
   


  </div>
</div>
<!-- /page content -->
