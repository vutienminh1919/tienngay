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
          <h3>Báo cáo Lead hủy
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Lead</a> / <a href="#">Báo cáo Lead hủy</a>
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
                <form action="<?php echo base_url('lead_custom/lead_cancel_daily')?>" method="get" style="width: 100%;">
                  <div class="row">
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
                      <input type="datetime-local" name="fdate" class="form-control" value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-01\TH:i')?>" >
                    </div>
                  </div>
					  <div class="col-lg-3">
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
							  <input type="datetime-local" name="tdate" class="form-control" value="<?= isset($_GET['tdate']) ?  $_GET['tdate'] : date("Y-m-d\TH:i")?>" >

						  </div>
					  </div>
                
                  <div class="col-lg-2 text-right">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
                  </div>
                </div>
                </form>

           <div class="table-responsive" style="width: 100%">
   <table id="datatable-buttons" class="table table-striped ">
            <thead>
              <tr>
                 <th rowspan=2 >#</th>
                <th rowspan=2 >Lý do hủy</th>
                <th colspan=3 class="center">Tổng nguồn </th>
               
                
            </tr>
            <tr>
                
                <th>Số lượng</th>
                <th></th>
                <th>Tỷ lệ</th>
               
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
