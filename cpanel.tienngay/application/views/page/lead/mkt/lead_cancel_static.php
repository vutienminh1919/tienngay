  <?php
  $code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
  ?>
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
					<h3>Phân tích lý do lead hủy
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">MKT</a> / <a href="#">Phân tích lý do lead hủy</a>
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
                           
                <form action="<?php echo base_url('lead_custom/mkt_lead_cancel_static')?>" method="get" style="width: 100%;">
                  <div class="row">
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
                      <input type="date" name="fdate" class="form-control" value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : date("Y-m-d") ?>" >
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
                      <input type="date" name="tdate" class="form-control" value="<?= isset($_GET['tdate']) ?  $_GET['tdate'] : date("Y-m-d") ?>" >

                    </div>
                  </div>
                  <div class="col-lg-2">
                    <select class="form-control" name="source">
                      <option value="">Chọn nguồn</option>
                    <?php  $source=isset($_GET['source']) ? $_GET['source'] : '-';
                    $source=($source=="") ? "-" : $source;
                    foreach ( lead_nguon() as $key => $item) { ?>
                    <option <?php echo $source == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
                  <?php } ?>
                    </select>
                  </div>
                  
                </div> 
                 <div class="row">
                     <div class="col-lg-2">
                  <?php  $utm_source=isset($_GET['utm_source']) ? $_GET['utm_source'] : ''; ?>
                <input name="utm_source" placeholder="Nhập utm_source" value="<?= $utm_source?>" class="form-control" type="text">
                  </div> 
                    <div class="col-lg-2">
                  <?php  $utm_campaign=isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ''; ?>
                <input name="utm_campaign" placeholder="Nhập utm_campaign" value="<?= $utm_campaign?>" class="form-control" type="text">
                  </div> 
                  <div class="col-lg-3">
                    <select class="form-control" name="area" id="selectize_area">
                      <option value="">Chọn khu vực</option>
                    <?php $area=isset($_GET['area']) ? $_GET['area'] : '';
                    foreach ($provinces as $key => $item) { ?>
                    <option <?php echo $area == $item->code ? 'selected' : ''?> value="<?= $item->code ?>"><?= $item->name ?></option>
                  <?php } ?>
                    </select>
                  </div>
                <div class="col-lg-2">
         
            <select id="selectize_store" class="form-control" name="code_store[]"  multiple="multiple">
          <option value="">Chọn phòng giao dịch</option>
              <?php foreach ($storeData as $p) {?>
                <option <?php  if(is_array($code_store)){ echo in_array($p->id,$code_store) ? 'selected' : ''; } ?> value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
              <?php }?>
            </select>
          </div>

                  <div class="col-lg-2 text-right">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
                  </div>
                </div>
                </form>
          
            <div class="group-tabs" style="width: 100%;">
               <br>     
  <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab" data-toggle="tab">Lead</a></li>
            <li role="presentation"><a href="#en" aria-controls="profile" role="tab" data-toggle="tab">Lead Qualified</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="vi">
                 <br/>
           <div class="table-responsive">
     <table  id="datatable-buttons" class="table table-striped ">
            <thead>
            <tr>
                <th>#</th>
                <th>UTM SOURCE</th>
                <th>UTM CAMPAIGN</th>
                <th>Lý do hủy</th>
                <th>Số lượng</th>
                <th>Lead hủy/ Tổng Lead </th>
                <th>Lead hủy/ Tổng Lead Hủy</th>
               
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
<div role="tabpanel" class="tab-pane " id="en">
              <br/>
                 <div class="table-responsive" >
     <table class="table table-striped thedatatable" style="width: 100%;">
            <thead>
            <tr>
                <th>#</th>
                 <th>UTM SOURCE</th>
                <th>UTM CAMPAIGN</th>
                <th>Lý do hủy</th>
                <th>Số lượng</th>
                <th>Tỷ trọng/ Tổng Lead (Qualified)</th>
                <th>Tỷ trọng/ Tổng Lead Hủy (Qualified)</th>
               
            </tr>
            </thead>
            <tbody name="list_lead">
            <?php 
    
           if(!empty($mktData_q)){
               echo $mktData_q;
             ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
            </div>
          </div>
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
