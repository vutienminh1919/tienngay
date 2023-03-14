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
					<h3>Báo cáo tổng quát Lead hàng ngày
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Lead</a> / <a href="#">Báo cáo tổng quát Lead hàng ngày</a>
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
                           
                <form action="<?php echo base_url('lead_custom/lead_daily')?>" method="get" style="width: 100%;">
                  <div class="row">
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"></span>
                      <input type="date" name="fdate" class="form-control" value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-d', strtotime(' -1 day'))?>" >
                    </div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
                  </div>
                </div>
                </form>

           <div class="table-responsive">
      <table id="datatable-buttons" class="table table-striped ">
            <thead>
              <tr>
                <th rowspan=2 border-spacing=2>Thời gian</th>
                <th colspan=2 class="center">Lead tồn ngày hôm trước </th>
                <th colspan=5 class="center">Tổng Lead về trong ngày</th>
                 <th rowspan=2 >Số Lead về PGD / Lead xử lý</th>
                <th rowspan=2>Tổng Lead Digital</th>
                <th rowspan=2>Tổng Lead tổng đài + Lead ngoài</th>
              <!--   <th colspan=2 class="center">Thực hiện cuộc gọi</th> -->
                
            </tr>
            <tr>
                <th>Lead chăm sóc tiếp</th>
                <th>Lead chưa nghe máy</th>
                <th>Lead chuyển về PGD</th>
                <th>Lead chăm sóc tiếp</th>
                <th>Lead chưa nghe máy</th>
                <th>Lead Hủy</th>
                <th>Tổng Lead tồn</th>

                <th>Tổng cuộc gọi</th>
                <th>Trung bình/TTS/Ngày</th>
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
