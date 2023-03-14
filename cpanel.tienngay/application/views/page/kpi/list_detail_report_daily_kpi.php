
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
  </div>

<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
	$code_domain = !empty($_GET['code_domain']) ? $_GET['code_domain'] : "";
	$code_region = !empty($_GET['code_region']) ? $_GET['code_region'] : "";
	$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";
	$customer_email = !empty($_GET['customer_email']) ? $_GET['customer_email'] : "";
	

 ?> 
  <div class="row top_tiles">
	  <div class="col-xs-12">
		  <?php if ($this->session->flashdata('error')) { ?>
			  <div class="alert alert-danger alert-result">
				  <?= $this->session->flashdata('error') ?>
			  </div>
		  <?php } ?>
		  <?php if ($this->session->flashdata('success')) { ?>
			  <div class="alert alert-success alert-result">
				  <?= $this->session->flashdata('success') ?>
			  </div>
		  <?php } ?>
	  </div>
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Chi tiết số liệu Dashboard phòng giao dịch
          <br>
			<small>
			<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Chi tiết số liệu Dashboard phòng giao dịch</a>
			</small>
          </h3>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-12">
        
				  <form action="<?php echo base_url('kpi/listDetail_daily_pgd')?>" method="get" style="width: 100%;">
				  	      <div class="row">
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
							  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
						  </div>
					  </div>
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
							  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

						  </div>
					  </div>
					
                              	
							  
				</div>
				  <div class="row">
					  
					<div class="col-lg-2">
										<select id="selectize_domain" class="form-control" name="code_domain[]" multiple="multiple">
											<option value="">Chọn miền</option>
											<?php foreach (domain() as $key => $dm) {
											
												?>
												<option <?php 
												if (is_array($code_domain)) {
													echo in_array($key, $code_domain) ? 'selected' : '';
												}?>
														value="<?php echo $key; ?>"><?php echo $dm; ?></option>
											<?php } ?>
										</select>
									</div>
								 <div class="col-lg-2">
										<select id="selectize_region" class="form-control" name="code_region[]" multiple="multiple">
											<option value="">Chọn vùng</option>
												<?php foreach (region() as $key => $dm) {
											
												?>
												<option <?php 
												if (is_array($code_region)) {
													echo in_array($key, $code_region) ? 'selected' : '';
												}?>
														value="<?php echo $key; ?>"><?php echo $dm; ?></option>
											<?php } ?>
										</select>
									</div>
								 <div class="col-lg-2">
										<select id="selectize_area" class="form-control" name="code_area[]" multiple="multiple">
											<option value="">Chọn khu vực</option>
											<?php foreach ($areaData as $p) {
												
												?>
												<option <?php 
												if (is_array($code_area)) {
													echo in_array($p->code, $code_area) ? 'selected' : '';
												}?>
														value="<?php echo $p->code; ?>"><?php echo $p->title; ?></option>
											<?php } ?>
										</select>
									</div>
							 <div class="col-lg-2">
										<select id="selectize_store" class="form-control" name="code_store[]" multiple="multiple">
											<option value="">Chọn PGD</option>
											<?php foreach ($storeData as $p) {
												if (!empty($stores) && is_array($stores)) {
													if (!in_array($p->id, $stores))
														continue;
												}
												?>
												<option <?php 
												if (is_array($code_store)) {
													echo in_array($p->id, $code_store) ? 'selected' : '';
												}?>
														value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-2 text-right">
								  <label></label>
								  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
							  </div>
					  
			
				</div>
				  </form>
              </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
          	<div class="col-xs-12">
            <table class="table table-borderless" style="table-layout:fixed">
  <thead>
    <tr>
     
      <td>
        <p>Giải ngân</p>
        <h3 class="m-0 green"><?=number_format($sum_giai_ngan)?> đ</h3>
      </td>
     
      <td>
        <p>Bảo hiểm </p>
        <h3 class="m-0 green"><?=number_format($sum_bao_hiem)?> đ</h3>
      </td>
      
       <td>
        <p>KH mới </p>
        <h3 class="m-0 green"><?=$count_khach_hang_moi?></h3>
      </td>
     
      


    </tr>

  
</thead></table>
          </div>
            <div class="col-xs-12">
              <div class="table-responsive">
              		 
					<?php echo $pagination ?><br>
		 <div><?php echo $result_count; ?></div>
		          
                <table id="" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Miền</th>
                    <th>Vùng</th> 
                      <th>Khu vực</th>
                      <th>Phòng giao dịch</th>
                      
                      <th>Ngày</th>
                     
						<th class="center">Giải ngân</th>
                  <th class="center">Bảo hiểm</th> 
                   <th class="center">Khách hàng mới</th> 
					
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if(!empty($kpiData)){
                       foreach($kpiData as $key => $kpi){
                       	
                    ?>

                      <tr>
                        <td><?php echo $key+1?></td>
                      
						<td><?= !empty($kpi->code_domain) ? domain($kpi->code_domain) : '' ?></td>
						<td><?= !empty($kpi->code_region) ? region($kpi->code_region) : '' ?></td>
						<td><?= !empty($kpi->code_area) ? $kpi->code_area : '' ?></td>
						<td><?= !empty($kpi->store->name) ? $kpi->store->name : '' ?></td>

						<td><?= !empty($kpi->date) ? date("d-m-Y",$kpi->date) : '' ?></td>
						
						<td class="center">Đạt được: <?= !empty($kpi->sum_giai_ngan) ? number_format($kpi->sum_giai_ngan) : '0' ?>
						<br/>Chỉ tiêu: <?= !empty($kpi->kpi->giai_ngan_CT) ? number_format($kpi->kpi->giai_ngan_CT) : '0' ?>
					    </td>
						<td class="center"><?= !empty($kpi->sum_bao_hiem) ? number_format($kpi->sum_bao_hiem) : '0' ?></td>
						<td class="center"><?= !empty($kpi->count_khach_hang_moi) ? $kpi->count_khach_hang_moi : '0' ?></td>
                     
                      </tr>
                    <?php }} ?>

                  </tbody>
                </table>
				  <div class="">
					  <?php echo $pagination ?>
				  </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#selectize_store').selectize({
	create: false,
	valueField: 'code_store',
	labelField: 'name',
	searchField: 'name',
	maxItems: 100,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#selectize_area').selectize({
	create: false,
	valueField: 'code_area',
	labelField: 'name',
	searchField: 'name',
	maxItems: 100,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#selectize_region').selectize({
	create: false,
	valueField: 'code_region',
	labelField: 'name',
	searchField: 'name',
	maxItems: 100,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#selectize_domain').selectize({
	create: false,
	valueField: 'code_domain',
	labelField: 'name',
	searchField: 'name',
	maxItems: 100,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
</script>