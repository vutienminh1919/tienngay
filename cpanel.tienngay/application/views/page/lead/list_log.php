
<!-- page content -->
<div class="right_col" role="main">
	<?php
	$cdate = !empty($_GET['cdate']) ? $_GET['cdate'] : '';
	$status_sale_fist = !empty($_GET['status_sale_fist']) ? $_GET['status_sale_fist'] : "";
  $utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
  $udate = !empty($_GET['udate']) ? $_GET['udate'] : '';
  $status_sale_last = !empty($_GET['status_sale_last']) ? $_GET['status_sale_last'] : "";
  $utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";

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
          <h3>Danh sách log lead
          <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Danh sách log lead</a>
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
              <div class="row">
				  <form action="<?php echo base_url('lead_custom/list_log')?>" method="get" style="width: 100%;">
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon">Ngày tạo</span>
							  <input type="date" name="cdate" class="form-control" value="<?= !empty($cdate) ?  $cdate : ""?>" >
						  </div>
					  </div>
		          <div class="col-lg-3">
              <label></label>
              <div class="input-group">
                <span class="input-group-addon">Ngày update</span>
                <input type="date" name="udate" class="form-control" value="<?= !empty($udate) ?  $udate : ""?>" >
              </div>
            </div>

					 <div class="col-lg-2"><label>Trạng thái đầu ngày</label>
					  <select id="status_sale_fist" class="form-control" name="status_sale_fist">
						<option value=""><?= $this->lang->line('All')?></option>
						  <?php foreach (lead_status() as $key=> $value) {?>
							  <option <?php echo $status_sale_fist == $key ? 'selected' : ''?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
						  <?php }?>
					  </select>
					</div> 
             <div class="col-lg-2"><label>Trạng thái cuối ngày</label>
            <select id="status_sale_last" class="form-control" name="status_sale_last">
            <option value=""><?= $this->lang->line('All')?></option>
              <?php foreach (lead_status() as $key=> $value) {?>
                <option <?php echo $status_sale_last == $key ? 'selected' : ''?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
              <?php }?>
            </select>
          </div>
		      <div class="col-lg-2">
              <label>UTM SOURCE</label>
              <div class="input-group">
               
          <input type="text" name="utm_source"  class="form-control" value="<?= !empty($utm_source) ?  $utm_source : ""?>" placeholder="Nhập UTM SOURCE" >

              </div>
            </div>
              <div class="col-lg-2">
              <label>UTM CAMPAIGN</label>
              <div class="input-group">
               
          <input type="text" name="utm_campaign"  class="form-control" value="<?= !empty($utm_campaign) ?  $utm_campaign : ""?>" placeholder="Nhập UTM CAMPAIGN" >

              </div>
            </div>
            <div class="col-lg-2">
               <label>Số điện thoại</label>
                  <?php  $phone_number=isset($_GET['phone_number']) ? $_GET['phone_number'] : ''; ?>
                <input name="phone_number" placeholder="Nhập phone number" value="<?= $phone_number?>" class="form-control" type="text">
                  </div> 
					<div class="col-lg-2 text-right">
						<label></label>
					  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
					</div>
				  </form>
              </div>

            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">

              <div class="table-responsive">
                <table class="table table-striped  "  id="datatable-buttons" >
      <thead>
      <tr>
        <th>#</th>
       
         <th>NGUỒN</th>
        <th>HỌ VÀ TÊN</th>
        <th>SỐ ĐIỆN THOẠI</th>
        

        <th>TT ĐẦU NGÀY</th>
         <th>TT CUỐI NGÀY</th>
          <th>UTM SOURCE</th>
        <th>UTM CAMPAIGN</th>
         <th>THAO TÁC</th>
           <th>NGÀY TẠO</th>
           <th>NGƯỜI TẠO</th>
        <th>NGÀY UPDATE</th>
      </tr>
      </thead>
      <tbody name="list_lead">
      <?php 
    
            if(!empty($leadsData)){
              $n=1;
      foreach ($leadsData as $key => $lead) {
       
        $lead_new=($lead->lead_data) ? $lead->lead_data : '';
        $lead_old=($lead->old_data) ? $lead->old_data : '';
        
       ?>
        <tr>
          <td><?php echo $n++ ?></td>
        <!--   <td><?= ($lead->_id->{'$oid'}) ? $lead->_id->{'$oid'} : '' ?></td> -->
          <td><?= ($lead_new->source) ? lead_nguon($lead_new->source) : '' ?></td>
          <td><?= ($lead_new->fullname) ? $lead_new->fullname : '' ?></td>
           <td class="callmodal"
            id="<?= $lead->_id->{'$oid'} ?>"><?= !empty($lead_new->phone_number) ? hide_phone($lead_new->phone_number) : "" ?></td>
            
          <td><?= ($lead_old->status_sale) ? lead_status((int)$lead_old->status_sale,false) : lead_status(0) ?></td>
           <td><?= ($lead_new->status_sale) ? lead_status((int)$lead_new->status_sale,false) : lead_status(0) ?></td>
            <td><?= ($lead_old->utm_source) ? $lead_old->utm_source : "" ?></td>
          <td><?= ($lead_old->utm_campaign) ? $lead_old->utm_campaign : '' ?></td>
        <td><?= ($lead_new->updated_by) ? $lead_new->updated_by : '' ?></td>
         <td><?= !empty($lead_new->created_at) ? date('d/m/Y H:i:s', $lead_new->created_at) :  "" ?></td>
          <td><?= ($lead_old->created_by) ? $lead_old->created_by : '' ?></td>
          <td><?= !empty($lead_new->updated_at) ? date('d/m/Y H:i:s', $lead_new->updated_at) :  "" ?></td>
        </tr>
      <?php }} ?>
      </tbody>
    </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url();?>assets/js/lead/index.js"></script>
<script type="text/javascript">
 
</script>
