<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="row top_tiles">
    <div class="col-xs-9">
      <div class="page-title">
        <div class="title_left" style="width: 100%">
          <h3>Thống kê cuộc gọi
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Lead</a> / <a href="#">Thống kê cuộc gọi</a>
                    </small>
                    </h3>
          <div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
        </div>
      </div>
    </div>
    <div class="col-xs-3">
      
    </div>

<div class="col-xs-12">
        <div class="row">
                           
                <form action="<?php echo base_url('lead_custom/lead_call_statistics_daily')?>" method="get" style="width: 100%;">
                  <div class="row">
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
                      <input type="date" name="fdate" class="form-control" value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : date("Y-m-d")?>" >
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
                      <input type="date" name="tdate" class="form-control" value="<?= isset($_GET['tdate']) ?  $_GET['tdate'] : date("Y-m-d")?>" >

                    </div>
                  </div>
                  

                  <div class="col-lg-2 text-right">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
                  </div>
                </div>
                </form>

           <div class="table-responsive" style="width: 100%">
     <table  class="table table-striped thedatatable">
            <thead>
              
            <tr>
                
               
                <th>Thời gian</th>
                <th>Cuộc gọi</th>
                <th>Gọi vào</th>
                <th>Gọi ra</th>
                <th>Gọi nội bộ</th>
                <th>Gọi thành công</th>
                <th>Thời lượng gọi</th>
                <th>Thời lượng gọi vào</th>
                <th>Thời lượng gọi ra</th>
                <th>Thời lượng gọi nội bộ</th>
            </tr>
            </thead>
            <tbody name="list_lead">
            <?php 
    
            if(!empty($mktData)){
        
               echo $mktData;
             ?>
          
            <?php } ?>
            </tbody>
        </table>

    

    </div>
</div>


  </div>
</div>

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
 <script src="<?php echo base_url();?>assets/js/lead/index.js"></script> 
<script type="text/javascript">
    detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
  

</script>
