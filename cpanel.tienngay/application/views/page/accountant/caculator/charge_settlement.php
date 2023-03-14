<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3>Tính phí tất toán
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Thu hồ
								nơ</a> / <a href="#">Tính phí tất toán</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>


		<div class="col-xs-12">


			<div class="row">
				<div class="x_panel">
					<div class="x_content">
						<form class="form-horizontal form-label-left" id="fetch_results"
							  action="<?php echo base_url("accountant/caculator_charge_settlement") ?>" method="GET"
							  style="width: 100%;" >



							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Mã hợp đồng
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="code_contract_disbursement" class="form-control "
										   value="<?= isset($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "" ?>"
										   placeholder="Nhập mã hợp đồng" >
								</div>
							</div>
							Hoặc
							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Mã phiếu ghi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="code_contract" class="form-control "
										   value="<?= isset($_GET['code_contract']) ? $_GET['code_contract'] : "" ?>"
										   placeholder="Nhập mã phiếu ghi" >
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Ngày tất toán
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" name="date" class="form-control"
										   value="<?= isset($_GET['date']) ? $_GET['date'] : "" ?>">
								</div>
							</div>

						 <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <a class="btn btn-danger  clear">
                     Làm lại
                    </a>
                    <button class="btn btn-success" type="submit">
                      <i class="fa fa-save"></i>
                       Tính tất toán
					</button>
                    </a>
                  
                  </div>
                </div>
						</form>
          
              <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger alert-result">
                  <?= $this->session->flashdata('error') ?>
                </div>
              <?php } ?>
              <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
              <?php } ?>
						<br/>
						<div class="table-responsive">

						</div>

					</div>

					<div class="x_content">
						 <?php $this->load->view('page/accountant/caculator/top_view_tat_toan');?>
            <div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Kỳ</th>
        <th>Ngày đến hạn</th>
        <th>Số ngày</th>
         <th>Số ngày chậm trả</th>
      <th>Tiền phải <br> trả hàng kỳ</th>
        <th>Tiền gốc</th>
        <th>Tiền lãi</th>
        <th>Phí tư vấn quản lý <br>+ thẩm định lưu trữ tài sản</th>
        <!--<th>Phí thẩm định và <br> lưu trữ tài sản</th>-->
        <th>Tổng tiền thanh toán</th>
        <th>Đã thanh toán</th>
        <th>Còn lại chưa trả</th>
        <th>Tình trạng</th>
         <th>Phạt chậm trả</th>
      
      </tr>
    </thead>
        <!--Start body-->
        <?php
				date_default_timezone_set('Asia/Ho_Chi_Minh');
                $data = array();
                $data['contractData'] = $contractData;
                $this->load->view("page/accountant/chi_tiet_thanh_toan", $data);

        ?>
</table>
</div>

					</div>

				</div>


			</div>
		</div>
	</div>

</div>


</div>
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>
<script src="<?php echo base_url();?>assets/js/accountant/caculator.js"></script> 
<script type="text/javascript">
	// detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
 window.setTimeout(function () { 
         $(".alert-danger").alert('close'); 
      }, 4000);    

</script>
